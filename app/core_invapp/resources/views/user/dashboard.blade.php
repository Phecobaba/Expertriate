@extends('user.layouts.master')

@section('title', __('Dashboard'))

@push('styles')
<style>
    .neo-grid {
        display: grid;
        grid-template-columns: minmax(300px, .95fr) minmax(430px, 1.45fr);
        gap: .82rem;
    }
    .neo-card {
        background: linear-gradient(145deg, #13193a 0%, #0a0f2d 100%);
        border: 1px solid rgba(70, 95, 170, 0.25);
        border-radius: 16px;
        box-shadow: 0 10px 28px rgba(0, 0, 0, 0.25);
    }
    .neo-hero {
        padding: 1rem;
        display: flex;
        flex-direction: column;
        gap: 0.45rem;
    }
    .neo-hello {
        font-size: 1.7rem;
        line-height: 1;
        color: #35e5ea;
        font-weight: 800;
        margin: 0;
    }
    .neo-sub {
        color: #97a8d2;
        margin: 0;
    }
    .neo-balance-toggle {
        border: 0;
        background: transparent;
        color: #8ea0cb;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border-radius: 999px;
        transition: all .2s ease;
    }
    .neo-balance-toggle:hover {
        color: #31e4ea;
        background: rgba(48, 228, 234, 0.12);
    }
    .neo-balance-hidden {
        letter-spacing: .08em;
    }
    .neo-lock {
        color: #f5c84b;
        font-weight: 700;
    }
    .neo-mini-grid {
        margin-top: .8rem;
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: .72rem;
    }
    .neo-mini {
        display: block;
        text-decoration: none;
        padding: .88rem;
        border-radius: 14px;
        background: #171a3a;
        border: 1px solid rgba(87, 106, 189, 0.28);
        color: #d2defb;
        transition: transform .2s ease, border-color .2s ease;
    }
    .neo-mini:hover {
        color: #e9f6ff;
        transform: translateY(-2px);
        border-color: rgba(53, 229, 234, 0.5);
    }
    .neo-mini i {
        width: 2rem;
        height: 2rem;
        border-radius: 10px;
        background: rgba(53, 229, 234, 0.15);
        color: #35e5ea;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: .6rem;
    }
    .neo-mini .amount {
        margin-top: .38rem;
        font-size: clamp(1.2rem, 1.9vw, 1.58rem);
        font-weight: 700;
        line-height: 1.15;
        color: #eef2ff;
        overflow-wrap: anywhere;
    }
    .neo-cta {
        margin-top: .82rem;
    }
    .neo-cta .btn {
        border: 0;
        border-radius: 12px;
        height: 48px;
        font-size: 1.03rem;
        font-weight: 700;
        color: #02122f;
        background: linear-gradient(90deg, #2de5e9 0%, #4ddfbc 100%);
    }
    .neo-market {
        padding: .95rem;
    }
    .neo-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: .9rem;
    }
    .neo-head h3 {
        margin: 0;
        font-size: 1.55rem;
    }
    .neo-pillset {
        display: inline-flex;
        gap: .3rem;
        background: #161437;
        border-radius: 999px;
        padding: .25rem;
    }
    .neo-pill {
        border: 0;
        border-radius: 999px;
        padding: .27rem .8rem;
        color: #aab6d8;
        font-size: .82rem;
        background: transparent;
    }
    .neo-pill.active {
        background: linear-gradient(90deg, #29e5ea 0%, #47ddbc 100%);
        color: #05203b;
        font-weight: 700;
    }
    .neo-market-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: .68rem;
    }
    .neo-asset {
        background: #191a3d;
        border-radius: 12px;
        border: 1px solid rgba(87, 106, 189, 0.2);
        padding: .68rem;
        min-width: 0;
    }
    .neo-asset .price {
        font-size: clamp(1.1rem, 1.8vw, 1.5rem);
        font-weight: 700;
        line-height: 1.2;
        overflow-wrap: anywhere;
    }
    .neo-change-pos { color: #34d67f; }
    .neo-change-neg { color: #f06579; }
    .neo-chart {
        margin-top: .82rem;
        border-radius: 14px;
        background: #171538;
        border: 1px solid rgba(87, 106, 189, 0.22);
        padding: .85rem;
    }
    .neo-chart-head {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        margin-bottom: .8rem;
    }
    .neo-chart-canvas {
        width: 100%;
        height: 206px;
        border-radius: 10px;
        background:
            linear-gradient(transparent 97%, rgba(126, 152, 230, 0.09) 100%),
            linear-gradient(90deg, transparent 97%, rgba(126, 152, 230, 0.09) 100%);
        background-size: 100% 28px, 60px 100%;
    }
    .neo-lower {
        margin-top: .82rem;
    }
    .neo-lower-grid {
        display: grid;
        grid-template-columns: minmax(300px, .95fr) minmax(430px, 1.45fr);
        gap: .82rem;
    }
    .neo-section {
        padding: .85rem;
    }
    .neo-title {
        font-size: 1.35rem;
        margin-bottom: .72rem;
    }
    .neo-quick-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: .68rem;
    }
    .neo-quick {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        height: 96px;
        border-radius: 14px;
        background: #191a3d;
        border: 1px solid rgba(87, 106, 189, 0.22);
        color: #d3dfff;
        font-weight: 600;
        font-size: .94rem;
        min-width: 0;
    }
    .neo-quick i {
        color: #35e5ea;
        font-size: 1.1rem;
        margin-bottom: .45rem;
    }
    .neo-split {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: .68rem;
    }
    .neo-mini-section {
        padding: .82rem;
        border-radius: 14px;
        background: #191a3d;
        border: 1px solid rgba(87, 106, 189, 0.22);
        min-width: 0;
    }
    .neo-progress {
        margin-top: .6rem;
        height: 8px;
        border-radius: 999px;
        background: #0e1230;
        overflow: hidden;
    }
    .neo-progress span {
        display: block;
        height: 100%;
        border-radius: 999px;
        background: linear-gradient(90deg, #ff5757 0%, #f5c84b 48%, #2ee58f 100%);
    }
    .neo-trending {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: .66rem;
    }
    .neo-trend {
        display: flex;
        align-items: center;
        gap: .6rem;
        border-radius: 12px;
        border: 1px solid rgba(87, 106, 189, 0.2);
        background: #17193b;
        padding: .62rem;
        min-width: 0;
    }
    .neo-recent-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }
    .neo-recent-table th,
    .neo-recent-table td {
        padding: .64rem .4rem;
        border-bottom: 1px solid rgba(87, 106, 189, 0.2);
        font-size: .88rem;
        overflow-wrap: anywhere;
    }
    .neo-state {
        border-radius: 12px;
        border: 1px dashed rgba(87, 106, 189, 0.35);
        padding: .95rem .85rem;
        text-align: center;
        color: #97a8d2;
        background: rgba(16, 20, 52, 0.45);
    }
    .neo-market-note {
        margin-top: .66rem;
        font-size: .76rem;
    }
    .neo-grid > div,
    .neo-lower-grid > div,
    .neo-chart-head > * {
        min-width: 0;
    }
    .neo-chart-head h4,
    .neo-trend strong,
    .neo-trend .text-soft {
        overflow-wrap: anywhere;
    }
    .neo-sub,
    .neo-lock,
    .neo-asset span,
    .neo-quick,
    .neo-mini,
    .neo-mini-section,
    .neo-market-note {
        font-size: .9rem;
    }
    @media (max-width: 1199.98px) {
        .neo-grid,
        .neo-lower-grid {
            grid-template-columns: 1fr;
        }
        .neo-market-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }
    @media (max-width: 767.98px) {
        .neo-hero { padding: .95rem; }
        .neo-hello { font-size: 1.5rem; }
        .neo-mini .amount { font-size: 1.3rem; }
        .neo-market-grid { grid-template-columns: 1fr 1fr; }
        .neo-quick-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .neo-split { grid-template-columns: 1fr; }
        .neo-trending { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
@php
    $displayName = auth()->user()->display_name ?: auth()->user()->name;
    $currencySymbol = strtoupper($baseCurrency) === 'USD' ? '$' : strtoupper($baseCurrency) . ' ';
    $chartData = implode(',', $chartSeries);
    $supportSlug = sys_settings('page_contact') ? get_page_slug(sys_settings('page_contact')) : null;
    $supportUrl = $supportSlug ? route('show.page', $supportSlug) : route('dashboard');
@endphp
<div class="nk-content-body neo-dash">
    <div class="neo-grid">
        <div>
            <div class="neo-card neo-hero">
                <div class="d-flex justify-between align-items-start">
                    <div>
                        <p class="neo-sub mb-1">{{ __('Account Overview') }}</p>
                        <h3 class="mb-0">{{ __('Hello :name!', ['name' => $displayName]) }}</h3>
                    </div>
                    <button type="button" id="neoBalanceToggle" class="neo-balance-toggle" aria-label="{{ __('Toggle balance visibility') }}">
                        <em id="neoBalanceToggleIcon" class="icon ni ni-eye-off"></em>
                    </button>
                </div>
                <p class="neo-sub">{{ __('Available Balance') }}</p>
                <h2 class="neo-hello">
                    <span class="neo-balance-sensitive" data-balance-text="{{ $currencySymbol }}{{ number_format((float) $availableBalance, 2) }}">{{ $currencySymbol }}{{ number_format((float) $availableBalance, 2) }}</span>
                </h2>
                <div class="neo-lock"><em class="icon ni ni-lock-alt"></em> {{ __('Locked Balance') }} {{ $currencySymbol }}{{ number_format((float) $lockedBalance, 2) }}</div>
            </div>

            <div class="neo-mini-grid">
                @foreach($quickCards as $card)
                    <a class="neo-mini" href="{{ $card['route'] }}">
                        <i class="icon {{ $card['icon'] }}"></i>
                        <div>{{ $card['label'] }}</div>
                        <div class="amount">{{ $currencySymbol }}{{ number_format((float) $card['amount'], 2) }}</div>
                    </a>
                @endforeach
            </div>

            <div class="neo-cta">
                <a href="{{ has_route('user.investment.plans') ? route('user.investment.plans') : route('dashboard') }}" class="btn btn-block">{{ __('Trade Now') }}</a>
            </div>
        </div>

        <div class="neo-card neo-market">
            <div class="neo-head">
                <h3><em class="icon ni ni-bar-chart-alt text-primary"></em> {{ __('Market Overview') }}</h3>
                <div class="d-flex align-items-center">
                    <span class="badge badge-dim {{ data_get($marketMeta, 'live') ? 'badge-outline-success' : 'badge-outline-warning' }}">
                        {{ data_get($marketMeta, 'live') ? __('Live') : __('Fallback') }}: {{ ucfirst((string) data_get($marketMeta, 'provider', 'seed')) }}
                    </span>
                    <div class="neo-pillset ml-2">
                        <button type="button" class="neo-pill active">24h</button>
                        <button type="button" class="neo-pill">7d</button>
                        <button type="button" class="neo-pill">30d</button>
                    </div>
                </div>
            </div>

            @if($marketCards->isNotEmpty())
                <div class="neo-market-grid">
                    @foreach($marketCards as $asset)
                        <div class="neo-asset">
                            <div class="d-flex justify-between align-items-center mb-1">
                                <span>{{ $asset['symbol'] }}/{{ strtoupper($baseCurrency) }}</span>
                                <span class="{{ $asset['change'] >= 0 ? 'neo-change-pos' : 'neo-change-neg' }}">
                                    {{ $asset['change'] >= 0 ? '+' : '' }}{{ number_format((float) $asset['change'], 2) }}%
                                </span>
                            </div>
                            <div class="price">{{ $currencySymbol }}{{ number_format((float) $asset['price'], 2) }}</div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="neo-state">{{ __('Market cards are temporarily unavailable.') }}</div>
            @endif

            @if($selectedMarket && !empty($chartSeries))
            <div class="neo-chart">
                <div class="neo-chart-head">
                    <h4 class="mb-0">{{ $selectedMarket['name'] }} {{ $currencySymbol }}{{ number_format((float) $selectedMarket['price'], 2) }}</h4>
                    <span class="{{ $selectedMarket['change'] >= 0 ? 'neo-change-pos' : 'neo-change-neg' }}">
                        {{ $selectedMarket['change'] >= 0 ? '+' : '' }}{{ number_format((float) $selectedMarket['change'], 2) }}%
                    </span>
                </div>
                <canvas id="neoChart" class="neo-chart-canvas" data-series="{{ $chartData }}"></canvas>
            </div>
            @else
            <div class="neo-chart mt-3">
                <div class="neo-state">{{ __('Chart data is currently unavailable.') }}</div>
            </div>
            @endif
            <div class="neo-market-note text-soft">{{ data_get($marketMeta, 'message') }}</div>
        </div>
    </div>

    <div class="neo-lower">
        <div class="neo-lower-grid">
            <div>
                <div class="neo-card neo-section">
                    <h4 class="neo-title"><em class="icon ni ni-bolt"></em> {{ __('Quick Actions') }}</h4>
                    <div class="neo-quick-grid">
                        <a class="neo-quick" href="{{ route('deposit') }}"><i class="icon ni ni-arrow-down-left"></i>{{ __('Deposit') }}</a>
                        <a class="neo-quick" href="{{ route('withdraw') }}"><i class="icon ni ni-arrow-up-right"></i>{{ __('Withdraw') }}</a>
                        <a class="neo-quick" href="{{ route('transaction.list') }}"><i class="icon ni ni-tranx"></i>{{ __('Transactions') }}</a>
                        <a class="neo-quick" href="{{ has_route('user.investment.plans') ? route('user.investment.plans') : route('dashboard') }}"><i class="icon ni ni-invest"></i>{{ __('Trade') }}</a>
                        <a class="neo-quick" href="{{ has_route('user.investment.dashboard') ? route('user.investment.dashboard') : route('dashboard') }}"><i class="icon ni ni-swap-v"></i>{{ __('Swap') }}</a>
                        <a class="neo-quick" href="{{ $supportUrl }}"><i class="icon ni ni-headphone"></i>{{ __('Support') }}</a>
                    </div>
                </div>

                <div class="neo-card neo-section mt-3">
                    <div class="d-flex justify-between align-items-center mb-2">
                        <h4 class="neo-title mb-0">{{ __('Active Plan(s)') }}</h4>
                        @if(has_route('user.investment.history'))
                            <a href="{{ route('user.investment.history') }}" class="link link-primary">{{ __('View All') }}</a>
                        @endif
                    </div>
                    @forelse($activePlans as $plan)
                        <div class="neo-mini-section mb-2">
                            <div class="d-flex justify-between">
                                <strong>{{ data_get($plan, 'scheme.name', __('Investment Plan')) }}</strong>
                                <span class="badge badge-dim badge-outline-success">{{ strtoupper($plan->status) }}</span>
                            </div>
                            <div class="mt-1">{{ $currencySymbol }}{{ number_format((float) $plan->amount, 2) }}</div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-soft">
                            <em class="icon ni ni-briefcase fs-24px d-block mb-1 text-primary"></em>
                            {{ __('No Active Plans') }}
                        </div>
                    @endforelse
                </div>
            </div>

            <div>
                <div class="neo-split">
                    <div class="neo-mini-section">
                        <div class="d-flex justify-between align-items-center mb-1">
                            <strong>{{ __('Market Sentiment') }}</strong>
                            <span class="badge badge-dim badge-outline-info">{{ $sentimentLabel }}</span>
                        </div>
                        <div class="d-flex justify-between text-soft mb-1">
                            <span>{{ __('Fear & Greed Index') }}</span>
                            <span>{{ $sentimentScore }}/100</span>
                        </div>
                        <div class="neo-progress"><span style="width: {{ $sentimentScore }}%"></span></div>
                    </div>

                    <div class="neo-mini-section">
                        <strong>{{ __('Top Movers') }}</strong>
                        @forelse($topMovers as $mover)
                            <div class="d-flex justify-between mt-2">
                                <span>{{ $mover['symbol'] }}</span>
                                <span class="{{ $mover['change'] >= 0 ? 'neo-change-pos' : 'neo-change-neg' }}">
                                    {{ $mover['change'] >= 0 ? '+' : '' }}{{ number_format((float) $mover['change'], 1) }}%
                                </span>
                            </div>
                        @empty
                            <div class="neo-state mt-2">{{ __('No movers data right now.') }}</div>
                        @endforelse
                    </div>
                </div>

                <div class="neo-card neo-section mt-3">
                    <h4 class="neo-title">{{ __('Trending Assets') }}</h4>
                    <div class="neo-trending">
                        @forelse($trendingAssets as $asset)
                            <div class="neo-trend">
                                <div class="user-avatar sq bg-primary"><span>{{ $asset['icon'] }}</span></div>
                                <div>
                                    <div><strong>{{ $asset['symbol'] }}</strong></div>
                                    <div class="text-soft">{{ $currencySymbol }}{{ number_format((float) $asset['price'], 2) }}</div>
                                </div>
                                <div class="ml-auto {{ $asset['change'] >= 0 ? 'neo-change-pos' : 'neo-change-neg' }}">
                                    {{ $asset['change'] >= 0 ? '+' : '' }}{{ number_format((float) $asset['change'], 2) }}%
                                </div>
                            </div>
                        @empty
                            <div class="neo-state">{{ __('No trending assets available.') }}</div>
                        @endforelse
                    </div>
                </div>

                <div class="neo-card neo-section mt-3">
                    <div class="d-flex justify-between align-items-center mb-2">
                        <h4 class="neo-title mb-0">{{ __('Recent Transactions') }}</h4>
                        <a href="{{ route('transaction.list') }}" class="link link-primary">{{ __('View All') }}</a>
                    </div>
                    <div class="table-responsive">
                        <table class="neo-recent-table">
                            <thead>
                            <tr>
                                <th>{{ __('Amount') }}</th>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('Type') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($recentTransactions as $transaction)
                                <tr>
                                    <td>{{ $currencySymbol }}{{ number_format((float) $transaction->amount, 2) }}</td>
                                    <td>{{ show_date($transaction->created_at, true) }}</td>
                                    <td>{{ ucfirst($transaction->type) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-soft py-4">{{ __('No recent transactions') }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    (function() {
        var toggle = document.getElementById('neoBalanceToggle');
        var toggleIcon = document.getElementById('neoBalanceToggleIcon');
        var balanceNodes = document.querySelectorAll('.neo-balance-sensitive');
        var storageKey = 'neo_balance_hidden';
        var currentHidden = false;
        var setHidden = function(hidden) {
            currentHidden = hidden;
            Array.prototype.forEach.call(balanceNodes, function(node) {
                var original = node.getAttribute('data-balance-text') || node.textContent;
                if (!node.getAttribute('data-balance-text')) {
                    node.setAttribute('data-balance-text', original);
                }
                if (hidden) {
                    node.textContent = '******';
                    node.classList.add('neo-balance-hidden');
                } else {
                    node.textContent = node.getAttribute('data-balance-text');
                    node.classList.remove('neo-balance-hidden');
                }
            });
            if (toggleIcon) {
                toggleIcon.className = hidden ? 'icon ni ni-eye' : 'icon ni ni-eye-off';
            }
            try {
                localStorage.setItem(storageKey, hidden ? '1' : '0');
            } catch (err) {}
        };
        if (toggle) {
            var startHidden = false;
            try {
                startHidden = localStorage.getItem(storageKey) === '1';
            } catch (err) {}
            setHidden(startHidden);
            toggle.addEventListener('click', function() {
                setHidden(!currentHidden);
            });
        }

        var canvas = document.getElementById('neoChart');
        if (!canvas) return;
        var raw = canvas.getAttribute('data-series') || '';
        var points = raw.split(',').map(function(v){ return Number(v.trim()); }).filter(function(v){ return !isNaN(v); });
        if (!points.length) return;
        var ctx = canvas.getContext('2d');
        var ratio = window.devicePixelRatio || 1;
        var width = canvas.clientWidth;
        var height = canvas.clientHeight;
        canvas.width = width * ratio;
        canvas.height = height * ratio;
        ctx.scale(ratio, ratio);
        var min = Math.min.apply(Math, points);
        var max = Math.max.apply(Math, points);
        var range = (max - min) || 1;
        var padX = 8, padY = 10;
        ctx.clearRect(0, 0, width, height);
        ctx.strokeStyle = '#2de5e9';
        ctx.lineWidth = 2.2;
        ctx.beginPath();
        points.forEach(function(value, index) {
            var x = padX + ((width - (padX * 2)) * index / (points.length - 1));
            var y = padY + (height - (padY * 2)) * (1 - ((value - min) / range));
            if (index === 0) {
                ctx.moveTo(x, y);
            } else {
                ctx.lineTo(x, y);
            }
        });
        ctx.stroke();
    })();
</script>
@endpush
