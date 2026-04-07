<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="js">
<head>
    <meta charset="utf-8">
    <meta name="author" content="{{ site_info('author') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="site-token" content="{{ site_token() }}">
    <title>@yield('title', 'Dashboard') | {{ site_info('name') }}</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/apps.css?ver=111') }}">
    @stack('styles')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap');
        :root {
            --neo-bg: #060a24;
            --neo-bg-glow: #172157;
            --neo-bg-2: #0b1130;
            --neo-panel: #111839;
            --neo-panel-2: #171d43;
            --neo-border: rgba(78, 102, 180, .28);
            --neo-text: #e7efff;
            --neo-text-soft: #a5b4d7;
            --neo-cyan: #30e4ea;
            --neo-cyan-2: #45ddbf;
            --neo-warning: #f5c84b;
            --neo-heading: #f3f7ff;
            --neo-page-title: #f8fbff;
            --neo-header-bg: rgba(7, 11, 35, .94);
            --neo-header-dropdown-bg: #0f1535;
            --neo-sidebar-bg-start: #0b1030;
            --neo-sidebar-bg-end: #070b24;
            --neo-sidebar-text: #a6b5db;
            --neo-overline: #7f93c4;
            --neo-action-border: rgba(89, 113, 192, .24);
            --neo-action-bg: rgba(17, 25, 60, .78);
            --neo-action-text: #c7d6ff;
            --neo-scrollbar-track: rgba(9, 13, 40, .7);
            --neo-scrollbar-thumb: rgba(90, 115, 199, .65);
            --neo-input-bg: #131a3d;
            --neo-footer-border: rgba(78, 102, 180, .24);
            --neo-mobile-nav-bg: rgba(10, 13, 38, 0.98);
            --neo-mobile-nav-border: rgba(65, 82, 158, 0.45);
            --neo-mobile-nav-text: #8e9ac0;
            --neo-mobile-nav-text-active: #31e4ea;
            --neo-card-shadow: 0 10px 28px rgba(0, 0, 0, 0.25);
            --neo-sidebar-widget-surface: linear-gradient(135deg, rgba(48, 228, 234, .16), rgba(31, 39, 80, .4));
            --neo-sidebar-widget-border: rgba(48, 228, 234, .25);
            --neo-sidebar-widget-title: var(--neo-cyan);
        }
        .nk-body {
            background: radial-gradient(circle at 20% -20%, var(--neo-bg-glow) 0%, var(--neo-bg) 55%) fixed;
            color: var(--neo-text);
            font-family: "Manrope", "Segoe UI", Tahoma, sans-serif;
            font-size: 15px;
            line-height: 1.5;
        }
        .nk-main, .nk-wrap, .nk-content, .container-xl.wide-lg {
            background: transparent !important;
        }
        .container-xl.wide-lg {
            max-width: 1620px;
            padding-left: .32rem;
            padding-right: .95rem;
        }
        .nk-content {
            padding-top: .95rem;
        }
        .nk-header.is-light,
        .nk-header,
        .nk-header-wrap {
            background: var(--neo-header-bg) !important;
            border-bottom: 1px solid var(--neo-border);
        }
        .nk-header .user-avatar {
            background: rgba(48, 228, 234, .2);
            color: var(--neo-cyan);
        }
        .nk-header .dropdown-menu {
            background: var(--neo-header-dropdown-bg);
            border-color: var(--neo-border);
        }
        .nk-sidebar {
            background: linear-gradient(180deg, var(--neo-sidebar-bg-start) 0%, var(--neo-sidebar-bg-end) 100%) !important;
            border-right: 1px solid var(--neo-border);
        }
        .nk-sidebar-head {
            border-bottom: 1px solid var(--neo-border);
        }
        .nk-sidebar .nk-menu-text,
        .nk-sidebar .nk-menu-icon {
            color: var(--neo-sidebar-text);
            font-weight: 600;
        }
        .nk-sidebar .nk-menu-item {
            margin-bottom: .08rem;
        }
        .nk-sidebar .nk-menu-link {
            padding: .42rem .68rem;
            border-radius: 9px;
        }
        .nk-sidebar .nk-menu-icon {
            width: 1.65rem;
            font-size: .94rem;
        }
        .nk-sidebar .nk-menu-text {
            font-size: .92rem;
            line-height: 1.2;
        }
        .nk-sidebar .nk-menu-link:hover .nk-menu-text,
        .nk-sidebar .nk-menu-link:hover .nk-menu-icon,
        .nk-sidebar .nk-menu-item.active > .nk-menu-link .nk-menu-text,
        .nk-sidebar .nk-menu-item.active > .nk-menu-link .nk-menu-icon {
            color: var(--neo-cyan);
        }
        .nk-sidebar .nk-menu-item.active > .nk-menu-link {
            background: rgba(48, 228, 234, .12);
            border-radius: 10px;
        }
        .nk-sidebar-footer,
        .nk-sidebar-content,
        .nk-sidebar-body,
        .nk-sidebar-widget {
            background: transparent !important;
        }
        .nk-sidebar .overline-title {
            color: var(--neo-overline);
            letter-spacing: .08em;
            font-size: .68rem;
            font-weight: 700;
        }
        .neo-side-actions {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: .45rem;
        }
        .neo-side-action {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .4rem;
            padding: .55rem .5rem;
            border-radius: 10px;
            border: 1px solid var(--neo-action-border);
            background: var(--neo-action-bg);
            color: var(--neo-action-text);
            text-decoration: none;
            transition: all .2s ease;
            font-weight: 600;
            font-size: .83rem;
            line-height: 1.12;
            white-space: nowrap;
        }
        .neo-side-action:hover,
        .neo-side-action.active {
            border-color: rgba(48, 228, 234, .42);
            color: var(--neo-cyan);
            background: rgba(48, 228, 234, .09);
        }
        .neo-side-action em {
            color: inherit;
            font-size: 1rem;
        }
        .nk-sidebar.nk-sidebar-fixed {
            top: 0;
            bottom: 0;
        }
        .nk-sidebar-body,
        .nk-sidebar-body[data-simplebar] {
            height: calc(100vh - 96px);
            max-height: calc(100vh - 96px);
            overflow-y: auto !important;
            scrollbar-width: thin;
            scrollbar-color: var(--neo-scrollbar-thumb) var(--neo-scrollbar-track);
        }
        .nk-sidebar-body[data-simplebar] .simplebar-content-wrapper {
            max-height: calc(100vh - 96px);
            overflow-y: auto !important;
        }
        .nk-sidebar .nk-sidebar-menu {
            margin-bottom: .2rem;
        }
        .nk-sidebar .nk-sidebar-menu + .nk-sidebar-widget {
            margin-top: .45rem !important;
        }
        .nk-sidebar-content {
            padding-bottom: .45rem;
        }
        .nk-sidebar-body[data-simplebar]::-webkit-scrollbar { width: 8px; }
        .nk-sidebar-body[data-simplebar]::-webkit-scrollbar-track { background: var(--neo-scrollbar-track); }
        .nk-sidebar-body[data-simplebar]::-webkit-scrollbar-thumb { background: var(--neo-scrollbar-thumb); border-radius: 999px; }
        .card, .card-bordered, .block-head, .nk-odr-list {
            background: linear-gradient(145deg, var(--neo-panel) 0%, var(--neo-panel-2) 100%) !important;
            border-color: var(--neo-border) !important;
            color: var(--neo-text);
        }
        .btn.btn-primary, .btn.btn-secondary {
            border: 0;
            background: linear-gradient(90deg, var(--neo-cyan) 0%, var(--neo-cyan-2) 100%);
            color: #07142e;
            font-weight: 700;
        }
        .btn.btn-warning {
            background: linear-gradient(90deg, #ffc955 0%, #f5b43a 100%);
            border: 0;
            color: #2f2300;
        }
        .table th, .table td {
            border-color: rgba(77, 101, 178, .25) !important;
            color: var(--neo-text);
        }
        .text-soft, .sub-text, .form-note, .nk-block-des p {
            color: var(--neo-text-soft) !important;
        }
        h1, h2, h3, h4, h5, h6 {
            color: var(--neo-heading);
            font-weight: 700;
            letter-spacing: -.01em;
        }
        .lead-text, .page-title {
            color: var(--neo-page-title) !important;
        }
        .link-primary, a {
            color: var(--neo-cyan);
        }
        .dropdown-inner, .modal-content, .nav-tabs, .form-control, .form-select {
            background-color: var(--neo-input-bg) !important;
            border-color: var(--neo-border) !important;
            color: var(--neo-text) !important;
        }
        .form-control:focus, .form-select:focus {
            border-color: rgba(48, 228, 234, .45) !important;
            box-shadow: 0 0 0 .2rem rgba(48, 228, 234, .12) !important;
        }
        .nk-footer,
        .nk-footer-wrap,
        .nk-footer .container-fluid,
        .nk-footer .container {
            background: transparent !important;
        }
        .nk-footer {
            border-top: 1px solid var(--neo-footer-border);
            color: var(--neo-text-soft);
        }
        .neo-mobile-nav {
            position: fixed;
            left: .75rem;
            right: .75rem;
            bottom: .8rem;
            border-radius: 14px;
            background: var(--neo-mobile-nav-bg);
            border: 1px solid var(--neo-mobile-nav-border);
            backdrop-filter: blur(6px);
            z-index: 1030;
            display: none;
            padding: .45rem .35rem;
        }
        .neo-mobile-nav a {
            color: var(--neo-mobile-nav-text);
            font-size: .74rem;
            text-decoration: none;
            text-align: center;
            flex: 1;
        }
        .neo-mobile-nav a i {
            display: block;
            font-size: 1rem;
            margin-bottom: .2rem;
        }
        .neo-mobile-nav a.active {
            color: var(--neo-mobile-nav-text-active);
        }
        .nk-sidebar-widget .neo-skin-callout {
            background: var(--neo-sidebar-widget-surface) !important;
            border: 1px solid var(--neo-sidebar-widget-border) !important;
            overflow: visible;
        }
        .nk-sidebar-widget .neo-skin-callout h6 {
            color: var(--neo-sidebar-widget-title) !important;
            white-space: normal;
            overflow: visible;
            text-overflow: clip;
            line-height: 1.38;
            word-break: break-word;
            margin-bottom: .4rem !important;
            font-weight: 700;
        }
        .nk-sidebar-widget .neo-skin-callout p {
            white-space: normal;
            line-height: 1.45;
        }
        .neo-skin-jade {
            --neo-bg: #eef2f6;
            --neo-bg-glow: #d6e3ee;
            --neo-bg-2: #e7edf5;
            --neo-panel: #ffffff;
            --neo-panel-2: #f7fafc;
            --neo-border: rgba(148, 163, 184, .26);
            --neo-text: #1e293b;
            --neo-text-soft: #4b5f78;
            --neo-cyan: #16a34a;
            --neo-cyan-2: #2fbf71;
            --neo-heading: #0f172a;
            --neo-page-title: #0f172a;
            --neo-header-bg: #f9fbfd;
            --neo-header-dropdown-bg: #ffffff;
            --neo-sidebar-bg-start: #ffffff;
            --neo-sidebar-bg-end: #f8fbff;
            --neo-sidebar-text: #123253;
            --neo-overline: #5f7490;
            --neo-action-border: rgba(148, 163, 184, .35);
            --neo-action-bg: #f8fbff;
            --neo-action-text: #123253;
            --neo-scrollbar-track: rgba(226, 232, 240, .9);
            --neo-scrollbar-thumb: rgba(148, 163, 184, .8);
            --neo-input-bg: #ffffff;
            --neo-footer-border: rgba(148, 163, 184, .35);
            --neo-mobile-nav-bg: rgba(255, 255, 255, 0.97);
            --neo-mobile-nav-border: rgba(148, 163, 184, .34);
            --neo-mobile-nav-text: #5f6f83;
            --neo-mobile-nav-text-active: #15803d;
            --neo-card-shadow: 0 10px 20px rgba(2, 6, 23, 0.06);
            --neo-sidebar-widget-surface: linear-gradient(135deg, rgba(22, 163, 74, .16), rgba(34, 197, 94, .08));
            --neo-sidebar-widget-border: rgba(22, 163, 74, .25);
            --neo-sidebar-widget-title: #166534;
        }
        .neo-skin-jade .card,
        .neo-skin-jade .card-bordered,
        .neo-skin-jade .block-head,
        .neo-skin-jade .nk-odr-list {
            box-shadow: var(--neo-card-shadow);
        }
        .neo-skin-jade .nk-header .user-avatar {
            background: rgba(22, 163, 74, .16);
        }
        .neo-skin-jade .nk-sidebar .nk-menu-link:hover .nk-menu-text,
        .neo-skin-jade .nk-sidebar .nk-menu-link:hover .nk-menu-icon,
        .neo-skin-jade .nk-sidebar .nk-menu-item.active > .nk-menu-link .nk-menu-text,
        .neo-skin-jade .nk-sidebar .nk-menu-item.active > .nk-menu-link .nk-menu-icon {
            color: #15803d;
        }
        .neo-skin-jade .nk-sidebar .nk-menu-item.active > .nk-menu-link {
            background: #e8f0fb;
        }
        .neo-skin-jade .nk-sidebar .text-white {
            color: #123253 !important;
        }
        .neo-skin-jade .nk-content .text-white,
        .neo-skin-jade .nk-content .text-light,
        .neo-skin-jade .nk-content .text-base,
        .neo-skin-jade .nk-content .amount,
        .neo-skin-jade .nk-content .tb-lead,
        .neo-skin-jade .nk-content .title,
        .neo-skin-jade .nk-content .nk-iv-wg2-title {
            color: var(--neo-text) !important;
        }
        .neo-skin-jade .nk-content .text-soft,
        .neo-skin-jade .nk-content .sub-text,
        .neo-skin-jade .nk-content .tb-sub,
        .neo-skin-jade .nk-content .nk-iv-wg2-sub {
            color: var(--neo-text-soft) !important;
        }
        .neo-skin-jade .neo-mobile-nav a.active {
            text-shadow: 0 0 0.01px currentColor;
        }
        .neo-skin-jade .neo-card {
            background: linear-gradient(145deg, #ffffff 0%, #f7fafc 100%);
            border: 1px solid rgba(148, 163, 184, .25);
            box-shadow: var(--neo-card-shadow);
        }
        .neo-skin-jade .neo-hero {
            background: linear-gradient(135deg, #0f5e19 0%, #1f985d 55%, #28b07f 100%) !important;
            border-color: rgba(15, 118, 50, .45) !important;
            box-shadow: 0 14px 26px rgba(15, 118, 50, .22);
        }
        .neo-skin-jade .neo-hero .neo-sub,
        .neo-skin-jade .neo-hero h3,
        .neo-skin-jade .neo-hero .neo-hello,
        .neo-skin-jade .neo-hero .neo-lock {
            color: #f0fdf4;
        }
        .neo-skin-jade .neo-mini {
            background: rgba(240, 253, 244, .62);
            border-color: rgba(74, 222, 128, .35);
            color: #11421f;
        }
        .neo-skin-jade .neo-mini .amount {
            color: #0f172a;
        }
        .neo-skin-jade .neo-mini i {
            background: rgba(22, 163, 74, .2);
            color: #15803d;
        }
        .neo-skin-jade .neo-pillset {
            background: #edf2fa;
        }
        .neo-skin-jade .neo-pill {
            color: #5e6f84;
        }
        .neo-skin-jade .neo-pill.active {
            color: #0f2a4a;
            background: linear-gradient(90deg, #bfd8f5 0%, #c7e0ff 100%);
        }
        .neo-skin-jade .neo-asset,
        .neo-skin-jade .neo-quick,
        .neo-skin-jade .neo-mini-section,
        .neo-skin-jade .neo-chart {
            background: #ffffff;
            border-color: rgba(148, 163, 184, .3);
        }
        .neo-skin-jade .neo-lock {
            color: #fde68a;
        }
        .neo-skin-jade .neo-state {
            background: #f8fafc;
            color: #64748b;
            border-color: rgba(148, 163, 184, .45);
        }
        .neo-skin-jade .neo-progress {
            background: #e2e8f0;
        }
        .neo-skin-jade .neo-chart-canvas {
            background:
                linear-gradient(transparent 97%, rgba(148, 163, 184, 0.22) 100%),
                linear-gradient(90deg, transparent 97%, rgba(148, 163, 184, 0.22) 100%);
            background-size: 100% 28px, 60px 100%;
        }
        .neo-skin-jade .neo-recent-table th,
        .neo-skin-jade .neo-recent-table td {
            border-bottom-color: rgba(148, 163, 184, .32);
        }
        .neo-skin-jade .neo-title,
        .neo-skin-jade .neo-trend strong,
        .neo-skin-jade .neo-trend .text-soft,
        .neo-skin-jade .neo-trend .ml-auto,
        .neo-skin-jade .neo-trend span,
        .neo-skin-jade .neo-trending .neo-state {
            color: #0f172a !important;
        }
        .neo-skin-jade .neo-trending .neo-trend {
            background: #ffffff !important;
            border-color: rgba(148, 163, 184, .32) !important;
        }
        .neo-skin-jade .neo-trending .neo-trend *,
        .neo-skin-jade .neo-trending .neo-trend div,
        .neo-skin-jade .neo-trending .neo-trend span,
        .neo-skin-jade .neo-trending .neo-trend strong {
            color: #0f172a !important;
            opacity: 1 !important;
        }
        .neo-skin-jade .neo-trending .neo-trend .text-soft {
            color: #4b5f78 !important;
        }
        .neo-skin-jade .neo-trending .neo-trend .neo-change-pos {
            color: #15803d !important;
        }
        .neo-skin-jade .neo-trending .neo-trend .neo-change-neg {
            color: #be123c !important;
        }
        @media (max-width: 1199.98px) {
            .container-xl.wide-lg {
                max-width: 100%;
                padding-left: .9rem;
                padding-right: .9rem;
            }
            .neo-side-actions {
                grid-template-columns: 1fr;
            }
            .nk-body {
                font-size: 14px;
            }
        }
        @media (max-width: 991.98px) {
            .nk-header-wrap {
                min-height: 60px;
            }
            .nk-content {
                padding-top: .9rem;
            }
            .nk-table tr td,
            .table tr td {
                white-space: normal;
            }
        }
        @media (max-width: 767.98px) {
            .container-xl.wide-lg {
                padding-left: .72rem;
                padding-right: .72rem;
            }
            .nk-content {
                padding-bottom: 86px;
            }
            .neo-mobile-nav {
                display: flex;
                gap: .15rem;
            }
            .nk-footer-wrap {
                flex-direction: column;
                gap: .35rem;
                text-align: center;
            }
        }
    </style>
@if(sys_settings('ui_theme_skin', 'default')!='default')
    <link rel="stylesheet" href="{{ asset('assets/css/skins/theme-'.sys_settings('ui_theme_skin').'.css?ver=111') }}">
@endif
@if(sys_settings('google_track_id'))
<script async src="https://www.googletagmanager.com/gtag/js?id={{ sys_settings('google_track_id') }}"></script>
<script>
    window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', "{{ sys_settings('google_track_id') }}");
</script>
@endif
@if(sys_settings('header_code'))
    {{ html_string(sys_settings('header_code')) }}
@endif

</head>
@php
    $activeUserSkin = strtolower((string) sys_settings('ui_theme_skin', 'default'));
    $safeSkinClass = preg_replace('/[^a-z0-9\-]/', '', $activeUserSkin);
@endphp
<body class="nk-body npc-cryptlite has-sidebar has-sidebar-fat neo-skin-{{ $safeSkinClass }}">
@php
    $supportSlug = sys_settings('page_contact') ? get_page_slug(sys_settings('page_contact')) : null;
    $supportUrl = ($supportSlug && has_route('show.page')) ? route('show.page', $supportSlug) : route('dashboard');
@endphp
<div class="nk-app-root">
    <div class="nk-main">

        @include('user.layouts.sidebar')

        <div class="nk-wrap">

            @include('user.layouts.header')

            <div class="nk-content nk-content-fluid">
                <div class="container-xl wide-lg">
                    
                    @include('misc.notices')

                    @yield('content')

                </div>
            </div>

            <nav class="neo-mobile-nav">
                <a href="{{ route('transaction.list') }}" class="{{ request()->routeIs('transaction.*') ? 'active' : '' }}"><i class="icon ni ni-tranx"></i>{{ __('History') }}</a>
                <a href="{{ route('deposit') }}" class="{{ request()->routeIs('deposit*') ? 'active' : '' }}"><i class="icon ni ni-arrow-down-left"></i>{{ __('Deposit') }}</a>
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"><i class="icon ni ni-home"></i>{{ __('Home') }}</a>
                <a href="{{ route('withdraw') }}" class="{{ request()->routeIs('withdraw*') ? 'active' : '' }}"><i class="icon ni ni-arrow-up-right"></i>{{ __('Withdraw') }}</a>
                <a href="{{ $supportUrl }}" class="{{ request()->fullUrlIs($supportUrl) ? 'active' : '' }}"><i class="icon ni ni-menu"></i>{{ __('Menu') }}</a>
            </nav>

            @include('user.layouts.footer')

        </div>
    </div>
</div>

@stack('modal')
@if(sys_settings('custom_stylesheet')=='on')
    <link rel="stylesheet" href="{{ asset('/css/custom.css') }}">
@endif
<script type="text/javascript">
    const updateSetting = "{{ route('update.setting') }}", getTnxDetails = "{{ route('transaction.details') }}", msgwng = "{{ __("Sorry, something went wrong!") }}", msgunp = "{{ __("Unable to process your request.") }}";
</script>
<script src="{{ asset('/assets/js/bundle.js?ver=111') }}"></script>
<script src="{{ asset('/assets/js/app.js?ver=111') }}"></script>
<script src="{{ asset('/assets/js/charts.js?ver=111') }}"></script>
@stack('scripts')
@if(sys_settings('tawk_api_key'))
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date(); (function(){ var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0]; s1.async=true; s1.src='https://embed.tawk.to/{{ str_replace(['https://tawk.to/chat/', 'http://tawk.to/chat/'], '', sys_settings('tawk_api_key')) }}'; s1.charset='UTF-8'; s1.setAttribute('crossorigin','*'); s0.parentNode.insertBefore(s1,s0); })();
</script>
@endif
@if(sys_settings('footer_code'))
    {{ html_string(sys_settings('footer_code')) }}
@endif
</body>
</html>
