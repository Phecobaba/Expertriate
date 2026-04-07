<?php


namespace App\Http\Controllers\User;

use App\Enums\TransactionType;
use App\Enums\TransactionStatus;
use App\Enums\PaymentMethodStatus;
use App\Enums\InvestmentStatus;

use App\Models\Transaction;
use App\Models\PaymentMethod;
use App\Models\IvInvest;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class UserDashboardController extends Controller
{
    private const MARKET_SYMBOLS = [
        'BTC' => ['name' => 'Bitcoin', 'icon' => 'B', 'coingecko' => 'bitcoin'],
        'ETH' => ['name' => 'Ethereum', 'icon' => 'E', 'coingecko' => 'ethereum'],
        'SOL' => ['name' => 'Solana', 'icon' => 'S', 'coingecko' => 'solana'],
        'XRP' => ['name' => 'Ripple', 'icon' => 'X', 'coingecko' => 'ripple'],
    ];

    private const MARKET_SEED = [
        ['symbol' => 'BTC', 'name' => 'Bitcoin', 'price_usd' => 67946.88, 'change' => 2.02, 'icon' => 'B'],
        ['symbol' => 'ETH', 'name' => 'Ethereum', 'price_usd' => 2100.72, 'change' => 3.90, 'icon' => 'E'],
        ['symbol' => 'SOL', 'name' => 'Solana', 'price_usd' => 82.72, 'change' => -0.02, 'icon' => 'S'],
        ['symbol' => 'XRP', 'name' => 'Ripple', 'price_usd' => 1.35, 'change' => 1.47, 'icon' => 'X'],
    ];

    public function index()
    {
        try {
            $user = auth()->user();
            $baseCurrency = base_currency();
            $secondaryCurrency = secondary_currency();

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
            $lockedBalance = (float) $user->balance('locked_amount');
            $activeInvest = (float) $user->balance('active_invest');

            $quickCards = [
                [
                    'label' => __('Auto Trade'),
                    'icon' => 'ni ni-invest',
                    'amount' => $activeInvest,
                    'route' => has_route('user.investment.plans') ? route('user.investment.plans') : route('dashboard'),
                ],
                [
                    'label' => __('Interest Wallet'),
                    'icon' => 'ni ni-percent',
                    'amount' => max($availableBalance - $activeInvest, 0),
                    'route' => has_route('user.investment.dashboard') ? route('user.investment.dashboard') : route('dashboard'),
                ],
                [
                    'label' => __('Deposit'),
                    'icon' => 'ni ni-arrow-down-left',
                    'amount' => (float) $user->tnx_amounts('deposit'),
                    'route' => route('deposit'),
                ],
                [
                    'label' => __('Withdrawal'),
                    'icon' => 'ni ni-arrow-up-right',
                    'amount' => (float) $user->tnx_amounts('withdraw'),
                    'route' => route('withdraw'),
                ],
            ];

            [$marketCards, $marketMeta] = $this->resolveMarketCards($baseCurrency);

            $selectedMarket = $marketCards->first();
            $chartSeries = $this->buildChartSeries($selectedMarket);

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
                        'symbol' => $asset['symbol'],
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
                'chartSeries' => $this->buildChartSeries($selectedMarket),
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
            'https://api.coingecko.com/api/v3/simple/price',
            [
                'ids' => $ids,
                'vs_currencies' => 'usd',
                'include_24hr_change' => 'true',
            ]
        );

        if (!$response->ok() || !is_array($response->json())) {
            return collect();
        }

        $payload = $response->json();

        return collect(self::MARKET_SYMBOLS)->map(function ($meta, $symbol) use ($payload) {
            $id = $meta['coingecko'];
            $price = (float) data_get($payload, $id . '.usd', 0);
            if ($price <= 0) {
                return null;
            }

            return [
                'symbol' => $symbol,
                'name' => $meta['name'],
                'icon' => $meta['icon'],
                'price_usd' => $price,
                'change' => (float) data_get($payload, $id . '.usd_24h_change', 0),
            ];
        })->filter()->values();
    }

    private function fetchFromCoinMarketCap()
    {
        $apiKey = trim((string) sys_settings('market_data_api_key'));
        if ($apiKey === '') {
            return collect();
        }

        $baseUrl = rtrim((string) sys_settings('market_data_base_url', 'https://pro-api.coinmarketcap.com'), '/');
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

        $baseUrl = rtrim((string) sys_settings('market_data_base_url', 'https://min-api.cryptocompare.com'), '/');
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
                'price_usd' => $price,
                'change' => (float) data_get($raw, $symbol . '.USD.CHANGEPCT24HOUR', 0),
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
            return $asset;
        })->values();
    }

    private function buildChartSeries($selectedMarket): array
    {
        if (blank($selectedMarket) || (float) data_get($selectedMarket, 'price', 0) <= 0) {
            return [];
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
}
