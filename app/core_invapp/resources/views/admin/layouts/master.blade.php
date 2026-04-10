<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="js">

<head>
    <meta charset="utf-8">
    <meta name="author" content="{{ site_info('author') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="site-token" content="{{ site_token() }}">
    <title>@yield('title') | {{ site_info('name') }}</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/apps-admin.css?ver=111') }}">
@if(sys_settings('ui_theme_skin_admin', 'default') != 'default')
    <link rel="stylesheet" href="{{ asset('assets/css/skins/theme-'.sys_settings('ui_theme_skin_admin').'.css?ver=111') }}">
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

<body class="nk-body npc-cryptlite npc-admin has-sidebar">
<div class="nk-app-root">

    <div class="nk-main ">

        @include('admin.layouts.sidebar')

        <div class="nk-wrap @yield('has-content-sidebar')">

            @include('admin.layouts.header')

            @yield('content-sidebar')

            <div class="nk-content ">
                <div class="container-fluid ">

                    @include('misc.message-admin')
                    @include('misc.notices')

                    @yield('content')

                </div>
            </div>

            @include('admin.layouts.footer')

        </div>
    </div>
</div>

@stack('modal')

<script type="text/javascript">
    const msgwng = "{{ __("Sorry, something went wrong!") }}", msgunp = "{{ __("Unable to process your request.") }}";
</script>
<script src="{{ asset('assets/js/bundle.js?ver=111') }}"></script>
<script src="{{ asset('assets/js/app.js?ver=111') }}"></script>
<script src="{{ asset('assets/js/app.admin.js?ver=111') }}"></script>
@stack('scripts')
@if(sys_settings('footer_code'))
    {{ html_string(sys_settings('footer_code')) }}
@endif

</body>
</html>
