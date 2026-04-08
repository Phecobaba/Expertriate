@extends('user.layouts.master')

@section('title', __('Dashboard'))

@push('styles')
<style>
    .neo-grid {
        display: grid;
        grid-template-columns: minmax(280px, .82fr) minmax(560px, 1.68fr);
        gap: .7rem;
    }
    .neo-card {
        background: linear-gradient(145deg, var(--neo-panel) 0%, var(--neo-panel-2) 100%);
        border: 1px solid var(--neo-border);
        border-radius: 16px;
        box-shadow: var(--neo-card-shadow);
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
        color: var(--neo-cyan);
        font-weight: 800;
        margin: 0;
    }
    .neo-sub {
        color: var(--neo-text-soft);
        margin: 0;
        font-weight: 600;
    }
    .neo-balance-toggle {
        border: 0;
        background: transparent;
        color: rgba(236, 255, 245, 0.98);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border-radius: 999px;
        transition: all .2s ease;
    }
    .neo-balance-toggle:hover {
        color: #ffffff;
        background: rgba(240, 253, 244, 0.24);
    }
    .neo-balance-hidden {
        letter-spacing: .08em;
    }
    .neo-lock {
        color: var(--neo-warning);
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
        background: var(--neo-panel);
        border: 1px solid var(--neo-border);
        color: var(--neo-text);
        transition: transform .2s ease, border-color .2s ease;
    }
    .neo-mini:hover {
        color: var(--neo-text);
        transform: translateY(-2px);
        border-color: var(--neo-cyan);
    }
    .neo-mini i {
        width: 2rem;
        height: 2rem;
        border-radius: 10px;
        background: rgba(53, 229, 234, 0.15);
        color: var(--neo-cyan);
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
        color: var(--neo-text);
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
        background: linear-gradient(90deg, var(--neo-cyan) 0%, var(--neo-cyan-2) 100%);
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
        color: var(--neo-text);
    }
    .neo-pillset {
        display: inline-flex;
        gap: .3rem;
        background: var(--neo-panel);
        border-radius: 999px;
        padding: .25rem;
    }
    .neo-pill {
        border: 0;
        border-radius: 999px;
        padding: .27rem .8rem;
        color: var(--neo-text-soft);
        font-size: .82rem;
        font-weight: 700;
        background: transparent;
    }
    .neo-pill.active {
        background: linear-gradient(90deg, var(--neo-cyan) 0%, var(--neo-cyan-2) 100%);
        color: #05203b;
        font-weight: 700;
    }
    .neo-market-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: .68rem;
    }
    .neo-asset {
        background: var(--neo-panel);
        border-radius: 12px;
        border: 1px solid var(--neo-border);
        padding: .68rem;
        min-width: 0;
        color: var(--neo-text);
    }
    .neo-asset span {
        color: var(--neo-text-soft);
        font-weight: 600;
    }
    .neo-asset .price {
        font-size: clamp(1.1rem, 1.8vw, 1.5rem);
        font-weight: 700;
        line-height: 1.2;
        overflow-wrap: anywhere;
    }
    .neo-change-pos { color: var(--neo-success); }
    .neo-change-neg { color: var(--neo-danger); }
    .neo-chart {
        margin-top: .82rem;
        border-radius: 14px;
        background: var(--neo-panel);
        border: 1px solid var(--neo-border);
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
        color: var(--neo-text);
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
        background: var(--neo-panel);
        border: 1px solid var(--neo-border);
        color: var(--neo-text);
        font-weight: 700;
        font-size: .94rem;
        min-width: 0;
    }
    .neo-quick i {
        color: var(--neo-cyan);
        font-size: 1.1rem;
        margin-bottom: .45rem;
    }
    .neo-split {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: .6rem;
    }
    .neo-mini-section {
        padding: .82rem;
        border-radius: 14px;
        background: var(--neo-panel);
        border: 1px solid var(--neo-border);
        min-width: 0;
        color: var(--neo-text);
    }
    .neo-progress {
        margin-top: .6rem;
        height: 8px;
        border-radius: 999px;
        background: rgba(148, 163, 184, 0.28);
        overflow: hidden;
    }
    .neo-progress span {
        display: block;
        height: 100%;
        border-radius: 999px;
        background: linear-gradient(90deg, var(--neo-danger) 0%, var(--neo-warning) 48%, var(--neo-success) 100%);
    }
    .neo-trending {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: .5rem;
    }
    .neo-trend {
        display: flex;
        align-items: flex-start;
        gap: .48rem;
        border-radius: 12px;
        border: 1px solid var(--neo-border);
        background: var(--neo-panel);
        padding: .5rem .58rem;
        min-width: 0;
        color: var(--neo-text);
        min-height: 64px;
    }
    .neo-trend .user-avatar {
        width: 2.1rem;
        height: 2.1rem;
        font-size: .8rem;
        flex: 0 0 auto;
    }
    .neo-trend-body {
        min-width: 0;
        flex: 1 1 auto;
        display: flex;
        flex-direction: column;
        gap: .12rem;
    }
    .neo-trend-price {
        color: var(--neo-text);
        font-size: .92rem;
        font-weight: 700;
        line-height: 1.2;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .neo-trend-meta {
        min-width: 0;
        display: flex;
        align-items: center;
        gap: .2rem;
        line-height: 1.2;
    }
    .neo-trend-symbol {
        display: inline-block;
        color: var(--neo-text-soft);
        font-size: .78rem;
        font-weight: 700;
        letter-spacing: .02em;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .neo-trend-change {
        white-space: nowrap;
        font-weight: 700;
        font-size: .86rem;
        line-height: 1.15;
    }
    .neo-recent-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }
    .neo-recent-table th,
    .neo-recent-table td {
        padding: .64rem .4rem;
        border-bottom: 1px solid var(--neo-border);
        font-size: .88rem;
        overflow-wrap: anywhere;
    }
    .neo-state {
        border-radius: 12px;
        border: 1px dashed rgba(148, 163, 184, 0.48);
        padding: .95rem .85rem;
        text-align: center;
        color: var(--neo-text-soft);
        background: var(--neo-panel);
    }
    .neo-market-note {
        margin-top: .66rem;
        font-size: .76rem;
        color: var(--neo-text-soft) !important;
        font-weight: 600;
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
    .neo-head .badge,
    .neo-market .text-soft,
    .neo-mini-section .text-soft,
    .neo-trend .text-soft,
    .neo-recent-table th {
        color: var(--neo-text-soft) !important;
        font-weight: 600;
    }
    .neo-recent-table td,
    .neo-mini-section strong,
    .neo-trend strong {
        color: var(--neo-text);
        font-weight: 700;
    }
    .neo-trend .text-soft {
        color: var(--neo-text-soft) !important;
    }
    .neo-sentiment-pill {
        border-radius: 999px;
        padding: .22rem .62rem;
        font-size: .74rem;
        font-weight: 700;
        line-height: 1.1;
    }
    .neo-sentiment-pill.neo-fear {
        background: rgba(239, 68, 68, 0.18);
        color: #ef4444;
    }
    .neo-sentiment-pill.neo-neutral {
        background: rgba(245, 158, 11, 0.18);
        color: #f59e0b;
    }
    .neo-sentiment-pill.neo-greed {
        background: rgba(34, 197, 94, 0.18);
        color: #22c55e;
    }
    .neo-sentiment-scale {
        margin-top: .45rem;
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: .3rem;
        font-size: .77rem;
        color: var(--neo-text-soft);
    }
    .neo-sentiment-scale span:nth-child(2) {
        text-align: center;
    }
    .neo-sentiment-scale span:nth-child(3) {
        text-align: right;
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
                            <span class="neo-sentiment-pill {{ $sentimentTone === 'fear' ? 'neo-fear' : ($sentimentTone === 'greed' ? 'neo-greed' : 'neo-neutral') }}">{{ $sentimentLabel }}</span>
                        </div>
                        <div class="d-flex justify-between text-soft mb-1">
                            <span>{{ __('Fear & Greed Index') }}</span>
                            <span>{{ $sentimentScore }}/100</span>
                        </div>
                        <div class="neo-progress"><span style="width: {{ $sentimentScore }}%"></span></div>
                        <div class="neo-sentiment-scale">
                            <span>{{ __('Extreme Fear') }}</span>
                            <span>{{ __('Neutral') }}</span>
                            <span>{{ __('Extreme Greed') }}</span>
                        </div>
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
                                <div class="neo-trend-body">
                                    <div class="neo-trend-price">{{ $currencySymbol }}{{ number_format((float) $asset['price'], 2) }}</div>
                                    <div class="neo-trend-meta">
                                        <span class="neo-trend-symbol">{{ $asset['symbol'] }}</span>
                                    </div>
                                    <div class="neo-trend-change {{ $asset['change'] >= 0 ? 'neo-change-pos' : 'neo-change-neg' }}">
                                        {{ $asset['change'] >= 0 ? '+' : '' }}{{ number_format((float) $asset['change'], 2) }}%
                                    </div>
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
        var lineColor = '#2de5e9';
        try {
            var computed = window.getComputedStyle(document.body).getPropertyValue('--neo-cyan');
            if (computed && computed.trim()) {
                lineColor = computed.trim();
            }
        } catch (err) {}
        ctx.strokeStyle = lineColor;
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
