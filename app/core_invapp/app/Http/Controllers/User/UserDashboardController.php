<?php


namespace App\Http\Controllers\User;

use App\Enums\TransactionType;
use App\Enums\TransactionStatus;
use App\Enums\PaymentMethodStatus;
use App\Enums\InvestmentStatus;

use App\Models\Transaction;
use App\Models\PaymentMethod;
use App\Models\IvInvest;
use App\Models\IvProfit;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class UserDashboardController extends Controller
{
    private const MARKET_SYMBOLS = [
        'BTC' => ['name' => 'Bitcoin', 'icon' => 'B', 'coingecko' => 'bitcoin', 'logo' => 'https://assets.coingecko.com/coins/images/1/small/bitcoin.png'],
        'ETH' => ['name' => 'Ethereum', 'icon' => 'E', 'coingecko' => 'ethereum', 'logo' => 'https://assets.coingecko.com/coins/images/279/small/ethereum.png'],
        'SOL' => ['name' => 'Solana', 'icon' => 'S', 'coingecko' => 'solana', 'logo' => 'https://assets.coingecko.com/coins/images/4128/small/solana.png'],
        'XRP' => ['name' => 'Ripple', 'icon' => 'X', 'coingecko' => 'ripple', 'logo' => 'https://assets.coingecko.com/coins/images/44/small/xrp-symbol-white-128.png'],
    ];

    private const MARKET_SEED = [
        ['symbol' => 'BTC', 'name' => 'Bitcoin', 'price_usd' => 67946.88, 'change' => 2.02, 'icon' => 'B', 'coingecko' => 'bitcoin', 'logo_url' => 'https://assets.coingecko.com/coins/images/1/small/bitcoin.png'],
        ['symbol' => 'ETH', 'name' => 'Ethereum', 'price_usd' => 2100.72, 'change' => 3.90, 'icon' => 'E', 'coingecko' => 'ethereum', 'logo_url' => 'https://assets.coingecko.com/coins/images/279/small/ethereum.png'],
        ['symbol' => 'SOL', 'name' => 'Solana', 'price_usd' => 82.72, 'change' => -0.02, 'icon' => 'S', 'coingecko' => 'solana', 'logo_url' => 'https://assets.coingecko.com/coins/images/4128/small/solana.png'],
        ['symbol' => 'XRP', 'name' => 'Ripple', 'price_usd' => 1.35, 'change' => 1.47, 'icon' => 'X', 'coingecko' => 'ripple', 'logo_url' => 'https://assets.coingecko.com/coins/images/44/small/xrp-symbol-white-128.png'],
    ];

    public function index()
    {
        try {
            $user = auth()->user();
            $baseCurrency = base_currency();
            $secondaryCurrency = secondary_currency();
            $chartRange = strtolower((string) request()->query('range', '24h'));
            if (!in_array($chartRange, ['24h', '7d', '30d'], true)) {
                $chartRange = '24h';
            }

            $paymentMethods = PaymentMethod::where('status', PaymentMethodStatus::ACTIVE)
                ->get()->keyBy('slug')->toArray();

            $recentTransactions = Transaction::with(['ledger'])
                ->whereIn('status', [TransactionStatus::ONHOLD, TransactionStatus::CONFIRMED, TransactionStatus::COMPLETED])
                ->whereNotIn('type', [TransactionType::REFERRAL])
                ->where('user_id', $user->id)
                ->orderBy('id', 'desc')
                ->limit(5)->get();

            $activePlans = IvInvest::where('user_id', $user->id)
                ->where('status', InvestmentStatus::ACTIVE)
                ->orderBy('id', 'desc')
                ->limit(3)
                ->get();

            $availableBalance = (float) $user->balance(AccType('main'));
            $activeInvest = (float) $user->balance('active_invest');
            $interestEarned = (float) $user->balance(AccType('invest'));
            $totalDeposit = (float) $user->tnx_amounts('deposit');
            $totalWithdrawal = (float) $user->tnx_amounts('withdraw');
            $pendingInvest = (float) IvInvest::where('user_id', $user->id)
                ->where('status', InvestmentStatus::PENDING)
                ->sum('amount');
            $pendingProfit = (float) IvProfit::where('user_id', $user->id)
                ->whereNull('payout')
                ->sum('amount');
            $lockedBalance = $activeInvest + $pendingInvest + $pendingProfit;

            $quickCards = [
                [
                    'label' => __('Auto Trade'),
                    'icon' => 'ni ni-invest',
                    'amount' => $activeInvest,
                    'amount_display' => compact_amount($activeInvest),
                    'route' => has_route('user.investment.plans') ? route('user.investment.plans') : route('dashboard'),
                ],
                [
                    'label' => __('Interest Earned'),
                    'icon' => 'ni ni-percent',
                    'amount' => $interestEarned,
                    'amount_display' => compact_amount($interestEarned),
                    'route' => has_route('user.investment.dashboard') ? route('user.investment.dashboard') : route('dashboard'),
                ],
                [
                    'label' => __('Total Deposit'),
                    'icon' => 'ni ni-arrow-down-left',
                    'amount' => $totalDeposit,
                    'amount_display' => compact_amount($totalDeposit),
                    'route' => route('deposit'),
                ],
                [
                    'label' => __('Total Withdrawal'),
                    'icon' => 'ni ni-arrow-up-right',
                    'amount' => $totalWithdrawal,
                    'amount_display' => compact_amount($totalWithdrawal),
                    'route' => route('withdraw'),
                ],
            ];

            [$marketCards, $marketMeta] = $this->resolveMarketCards($baseCurrency);

            $selectedMarket = $marketCards->first();
            $chartSeries = $this->buildChartSeries($selectedMarket, $chartRange, $baseCurrency, (bool) data_get($marketMeta, 'live'));

            $avgChange = (float) $marketCards->avg('change');
            $sentimentScore = max(1, min(100, (int) round(55 + ($avgChange * 5))));
            $sentimentLabel = __('Neutral');
            $sentimentTone = 'neutral';
            if ($sentimentScore >= 70) {
                $sentimentLabel = __('Extreme Greed');
                $sentimentTone = 'greed';
            } elseif ($sentimentScore <= 30) {
                $sentimentLabel = __('Extreme Fear');
                $sentimentTone = 'fear';
            }

            $topMovers = $marketCards
                ->map(function ($asset) {
                    return [
                        'name' => $asset['name'],
                        'symbol' => $asset['symbol'],
                        'logo_url' => data_get($asset, 'logo_url'),
                        'change' => (float) $asset['change'],
                        'sort' => abs((float) $asset['change']),
                    ];
                })
                ->sortByDesc('sort')
                ->take(3)
                ->values()
                ->map(function ($asset) {
                    unset($asset['sort']);
                    return $asset;
                });

            $trendingAssets = $marketCards->take(3)->values();

            return view('user.dashboard', compact(
                'paymentMethods',
                'recentTransactions',
                'activePlans',
                'availableBalance',
                'lockedBalance',
                'quickCards',
                'marketCards',
                'selectedMarket',
                'chartSeries',
                'sentimentScore',
                'sentimentLabel',
                'sentimentTone',
                'topMovers',
                'trendingAssets',
                'marketMeta',
                'chartRange',
                'baseCurrency',
                'secondaryCurrency'
            ));
        } catch (Throwable $e) {
            Log::error('user.dashboard_render_failed', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            $baseCurrency = base_currency();
            $secondaryCurrency = secondary_currency();
            $marketCards = collect(self::MARKET_SEED);
            $selectedMarket = $marketCards->first();

            return view('user.dashboard', [
                'paymentMethods' => [],
                'recentTransactions' => collect(),
                'activePlans' => collect(),
                'availableBalance' => 0.0,
                'lockedBalance' => 0.0,
                'quickCards' => [],
                'marketCards' => $marketCards,
                'selectedMarket' => $selectedMarket,
                'chartSeries' => $this->buildChartSeries($selectedMarket, '24h', $baseCurrency, false),
                'sentimentScore' => 50,
                'sentimentLabel' => __('Neutral'),
                'sentimentTone' => 'neutral',
                'topMovers' => collect(),
                'trendingAssets' => $marketCards->take(3)->values(),
                'marketMeta' => [
                    'provider' => 'fallback',
                    'live' => false,
                    'message' => __('Dashboard loaded with fallback data.'),
                ],
                'chartRange' => '24h',
                'baseCurrency' => $baseCurrency,
                'secondaryCurrency' => $secondaryCurrency,
            ]);
        }
    }

    private function resolveMarketCards(string $baseCurrency): array
    {
        $provider = strtolower((string) sys_settings('market_data_provider', 'coingecko'));
        $providerCards = collect();
        $error = null;

        try {
            if ($provider === 'coinmarketcap') {
                $providerCards = $this->fetchFromCoinMarketCap();
            } elseif ($provider === 'cryptocompare') {
                $providerCards = $this->fetchFromCryptoCompare();
            } elseif ($provider === 'coinapi') {
                $providerCards = $this->fetchFromCoinApi();
            } else {
                $providerCards = $this->fetchFromCoinGecko();
                $provider = 'coingecko';
            }
        } catch (Throwable $e) {
            $error = $e->getMessage();
            Log::warning('dashboard.market_provider_failed', ['provider' => $provider, 'error' => $e->getMessage()]);
        }

        $usedFallback = $providerCards->isEmpty();
        $cards = $usedFallback ? collect(self::MARKET_SEED) : $providerCards;
        $marketCards = $this->toBaseCurrency($cards, $baseCurrency);

        $statusMessage = $usedFallback
            ? __('Fallback market feed active.')
            : __('Live market feed active.');
        if ($usedFallback && !empty($error)) {
            $statusMessage = $statusMessage . ' ' . Str::limit($error, 120);
        }

        upss('market_data_error_msg', $usedFallback ? ($error ?: 'fallback_seed') : null);

        return [$marketCards, [
            'provider' => $provider,
            'live' => !$usedFallback,
            'message' => $statusMessage,
        ]];
    }

    private function fetchFromCoinGecko()
    {
        $ids = collect(self::MARKET_SYMBOLS)->pluck('coingecko')->implode(',');
        $response = Http::timeout(4)->acceptJson()->get(
            'https://api.coingecko.com/api/v3/coins/markets',
            [
                'ids' => $ids,
                'vs_currency' => 'usd',
                'price_change_percentage' => '24h',
                'sparkline' => 'false',
            ]
        );

        if (!$response->ok() || !is_array($response->json())) {
            return collect();
        }

        $payload = collect($response->json())->keyBy('id');

        return collect(self::MARKET_SYMBOLS)->map(function ($meta, $symbol) use ($payload) {
            $id = $meta['coingecko'];
            $row = $payload->get($id);
            $price = (float) data_get($row, 'current_price', 0);
            if ($price <= 0) {
                return null;
            }

            return [
                'symbol' => $symbol,
                'name' => $meta['name'],
                'icon' => $meta['icon'],
                'coingecko' => $id,
                'logo_url' => (string) data_get($row, 'image', $meta['logo']),
                'price_usd' => $price,
                'change' => (float) data_get($row, 'price_change_percentage_24h', 0),
            ];
        })->filter()->values();
    }

    private function fetchFromCoinMarketCap()
    {
        $apiKey = trim((string) sys_settings('market_data_api_key'));
        if ($apiKey === '') {
            return collect();
        }

        $baseUrl = $this->resolveProviderBaseUrl('coinmarketcap', 'https://pro-api.coinmarketcap.com');
        $response = Http::timeout(4)->acceptJson()->withHeaders([
            'X-CMC_PRO_API_KEY' => $apiKey,
        ])->get($baseUrl . '/v1/cryptocurrency/quotes/latest', [
            'symbol' => implode(',', array_keys(self::MARKET_SYMBOLS)),
            'convert' => 'USD',
        ]);

        if (!$response->ok() || !is_array($response->json('data'))) {
            return collect();
        }

        $data = $response->json('data');
        return collect(self::MARKET_SYMBOLS)->map(function ($meta, $symbol) use ($data) {
            $price = (float) data_get($data, $symbol . '.quote.USD.price', 0);
            if ($price <= 0) {
                return null;
            }

            return [
                'symbol' => $symbol,
                'name' => $meta['name'],
                'icon' => $meta['icon'],
                'coingecko' => $meta['coingecko'],
                'logo_url' => $meta['logo'],
                'price_usd' => $price,
                'change' => (float) data_get($data, $symbol . '.quote.USD.percent_change_24h', 0),
            ];
        })->filter()->values();
    }

    private function fetchFromCryptoCompare()
    {
        $apiKey = trim((string) sys_settings('market_data_api_key'));
        $headers = [];
        if ($apiKey !== '') {
            $headers['authorization'] = 'Apikey ' . $apiKey;
        }

        $baseUrl = $this->resolveProviderBaseUrl('cryptocompare', 'https://min-api.cryptocompare.com');
        $response = Http::timeout(4)->acceptJson()->withHeaders($headers)->get(
            $baseUrl . '/data/pricemultifull',
            [
                'fsyms' => implode(',', array_keys(self::MARKET_SYMBOLS)),
                'tsyms' => 'USD',
            ]
        );

        if (!$response->ok() || !is_array($response->json('RAW'))) {
            return collect();
        }

        $raw = $response->json('RAW');
        return collect(self::MARKET_SYMBOLS)->map(function ($meta, $symbol) use ($raw) {
            $price = (float) data_get($raw, $symbol . '.USD.PRICE', 0);
            if ($price <= 0) {
                return null;
            }

            return [
                'symbol' => $symbol,
                'name' => $meta['name'],
                'icon' => $meta['icon'],
                'coingecko' => $meta['coingecko'],
                'logo_url' => $meta['logo'],
                'price_usd' => $price,
                'change' => (float) data_get($raw, $symbol . '.USD.CHANGEPCT24HOUR', 0),
            ];
        })->filter()->values();
    }

    private function fetchFromCoinApi()
    {
        $apiKey = trim((string) sys_settings('market_data_api_key'));
        if ($apiKey === '') {
            return collect();
        }

        $baseUrl = $this->resolveProviderBaseUrl('coinapi', 'https://rest.coinapi.io');
        $response = Http::timeout(5)->acceptJson()->withHeaders([
            'X-CoinAPI-Key' => $apiKey,
        ])->get($baseUrl . '/v1/exchangerate/USD');

        $rates = $response->json('rates');
        if (!$response->ok() || !is_array($rates)) {
            return collect();
        }

        $ratesByQuote = collect($rates)->keyBy(function ($row) {
            return data_get($row, 'asset_id_quote');
        });

        return collect(self::MARKET_SYMBOLS)->map(function ($meta, $symbol) use ($ratesByQuote) {
            $rateRow = $ratesByQuote->get($symbol);
            $usdPerAsset = (float) data_get($rateRow, 'rate', 0);
            if ($usdPerAsset <= 0) {
                return null;
            }

            $priceUsd = 1 / $usdPerAsset;

            return [
                'symbol' => $symbol,
                'name' => $meta['name'],
                'icon' => $meta['icon'],
                'coingecko' => $meta['coingecko'],
                'logo_url' => $meta['logo'],
                'price_usd' => $priceUsd,
                'change' => 0.0,
            ];
        })->filter()->values();
    }

    private function toBaseCurrency($cards, string $baseCurrency)
    {
        return $cards->map(function ($asset) use ($baseCurrency) {
            $converted = (strtoupper($baseCurrency) === 'USD')
                ? (float) $asset['price_usd']
                : (float) get_fx_rate('USD', $baseCurrency, $asset['price_usd']);

            if ($converted <= 0) {
                $converted = (float) $asset['price_usd'];
            }

            $asset['price'] = $converted;
            $asset['logo_url'] = (string) data_get($asset, 'logo_url', data_get(self::MARKET_SYMBOLS, data_get($asset, 'symbol') . '.logo', ''));
            $asset['coingecko'] = (string) data_get($asset, 'coingecko', data_get(self::MARKET_SYMBOLS, data_get($asset, 'symbol') . '.coingecko', ''));
            return $asset;
        })->values();
    }

    private function buildChartSeries($selectedMarket, string $chartRange, string $baseCurrency, bool $isLive): array
    {
        if (blank($selectedMarket) || (float) data_get($selectedMarket, 'price', 0) <= 0) {
            return [];
        }

        $historicalSeries = $this->fetchHistoricalSeries($selectedMarket, $chartRange, $baseCurrency, $isLive);
        if (!empty($historicalSeries)) {
            return $historicalSeries;
        }

        $price = (float) data_get($selectedMarket, 'price', 0);
        $change = (float) data_get($selectedMarket, 'change', 0);
        $swing = max($price * 0.0125, 1);
        $trend = $change / 100;

        return [
            $price - ($swing * 1.6),
            $price - ($swing * 1.2),
            $price - ($swing * 1.35),
            $price - ($swing * 0.8),
            $price - ($swing * 0.15),
            $price + ($swing * 0.25),
            $price + ($swing * (0.45 + $trend)),
            $price + ($swing * (0.2 + ($trend / 2))),
            $price + ($swing * (0.6 + $trend)),
            $price + ($swing * (0.75 + ($trend * 1.4))),
            $price + ($swing * (0.55 + $trend)),
            $price + ($swing * (0.95 + ($trend * 1.6))),
        ];
    }

    private function fetchHistoricalSeries($selectedMarket, string $chartRange, string $baseCurrency, bool $isLive): array
    {
        if (!$isLive) {
            return [];
        }

        $coinId = (string) data_get($selectedMarket, 'coingecko', '');
        if ($coinId === '') {
            return [];
        }

        $days = ['24h' => 1, '7d' => 7, '30d' => 30][$chartRange] ?? 1;
        $interval = $days <= 1 ? 'hourly' : 'daily';

        try {
            $response = Http::timeout(6)->acceptJson()->get(
                'https://api.coingecko.com/api/v3/coins/' . $coinId . '/market_chart',
                [
                    'vs_currency' => 'usd',
                    'days' => $days,
                    'interval' => $interval,
                ]
            );

            $prices = $response->json('prices');
            if (!$response->ok() || !is_array($prices) || count($prices) < 4) {
                return [];
            }

            $fxRate = 1.0;
            if (strtoupper($baseCurrency) !== 'USD') {
                $fxRate = (float) get_fx_rate('USD', $baseCurrency, 1);
                if ($fxRate <= 0) {
                    $fxRate = 1.0;
                }
            }

            $series = collect($prices)
                ->map(function ($point) use ($fxRate) {
                    return (float) data_get($point, '1', 0) * $fxRate;
                })
                ->filter(function ($value) {
                    return $value > 0;
                })
                ->values();

            if ($series->count() > 72) {
                $totalCount = $series->count();
                $stride = (int) ceil($totalCount / 72);
                $series = $series->filter(function ($value, $index) use ($stride, $totalCount) {
                    return $index % $stride === 0 || $index === $totalCount - 1;
                })->values();
            }

            return $series->all();
        } catch (Throwable $e) {
            Log::warning('dashboard.market_chart_failed', [
                'coin' => $coinId,
                'range' => $chartRange,
                'error' => $e->getMessage(),
            ]);
            return [];
        }
    }

    private function resolveProviderBaseUrl(string $provider, string $default): string
    {
        $raw = trim((string) sys_settings('market_data_base_url', ''));
        if ($raw === '') {
            return $default;
        }

        $parts = @parse_url($raw);
        $hasScheme = is_array($parts) && !empty($parts['scheme']);
        $hasHost = is_array($parts) && !empty($parts['host']);

        if (!$hasScheme || !$hasHost) {
            Log::warning('dashboard.market_provider_invalid_base_url', [
                'provider' => $provider,
                'invalid_base_url' => $raw,
            ]);
            return $default;
        }

        return rtrim($raw, '/');
    }
}
