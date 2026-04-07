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
            --neo-bg-2: #0b1130;
            --neo-panel: #111839;
            --neo-panel-2: #171d43;
            --neo-border: rgba(78, 102, 180, .28);
            --neo-text: #e7efff;
            --neo-text-soft: #95a7d1;
            --neo-cyan: #30e4ea;
            --neo-cyan-2: #45ddbf;
            --neo-warning: #f5c84b;
        }
        .nk-body {
            background: radial-gradient(circle at 20% -20%, #172157 0%, var(--neo-bg) 55%) fixed;
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
            padding-left: .65rem;
            padding-right: .95rem;
        }
        .nk-content {
            padding-top: .95rem;
        }
        .nk-header.is-light,
        .nk-header,
        .nk-header-wrap {
            background: rgba(7, 11, 35, .94) !important;
            border-bottom: 1px solid var(--neo-border);
        }
        .nk-header .user-avatar {
            background: rgba(48, 228, 234, .2);
            color: var(--neo-cyan);
        }
        .nk-header .dropdown-menu {
            background: #0f1535;
            border-color: var(--neo-border);
        }
        .nk-sidebar {
            background: linear-gradient(180deg, #0b1030 0%, #070b24 100%) !important;
            border-right: 1px solid var(--neo-border);
        }
        .nk-sidebar-head {
            border-bottom: 1px solid var(--neo-border);
        }
        .nk-sidebar .nk-menu-text,
        .nk-sidebar .nk-menu-icon {
            color: #a6b5db;
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
            color: #7f93c4;
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
            border: 1px solid rgba(89, 113, 192, .24);
            background: rgba(17, 25, 60, .78);
            color: #c7d6ff;
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
        .nk-sidebar-body[data-simplebar] {
            max-height: calc(100vh - 96px);
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: rgba(90, 115, 199, .65) rgba(9, 13, 40, .7);
        }
        .nk-sidebar-body[data-simplebar]::-webkit-scrollbar { width: 8px; }
        .nk-sidebar-body[data-simplebar]::-webkit-scrollbar-track { background: rgba(9, 13, 40, .7); }
        .nk-sidebar-body[data-simplebar]::-webkit-scrollbar-thumb { background: rgba(90, 115, 199, .65); border-radius: 999px; }
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
            color: #f3f7ff;
            font-weight: 700;
            letter-spacing: -.01em;
        }
        .lead-text, .page-title {
            color: #f8fbff !important;
        }
        .link-primary, a {
            color: var(--neo-cyan);
        }
        .dropdown-inner, .modal-content, .nav-tabs, .form-control, .form-select {
            background-color: #131a3d !important;
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
            border-top: 1px solid rgba(78, 102, 180, .24);
            color: var(--neo-text-soft);
        }
        .neo-mobile-nav {
            position: fixed;
            left: .75rem;
            right: .75rem;
            bottom: .8rem;
            border-radius: 14px;
            background: rgba(10, 13, 38, 0.98);
            border: 1px solid rgba(65, 82, 158, 0.45);
            backdrop-filter: blur(6px);
            z-index: 1030;
            display: none;
            padding: .45rem .35rem;
        }
        .neo-mobile-nav a {
            color: #8e9ac0;
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
            color: #31e4ea;
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
<body class="nk-body npc-cryptlite has-sidebar has-sidebar-fat">
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
