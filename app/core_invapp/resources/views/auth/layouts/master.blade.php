<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="js">
<head>
    <meta charset="utf-8">
    <meta name="author" content="{{ site_info('author') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="site-token" content="{{ site_token() }}">
    <title>@yield('title', 'Welcome') | {{ site_info('name') }}</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/apps.css?ver=111') }}">
@if(sys_settings('ui_theme_skin', 'default')!='default')
    <link rel="stylesheet" href="{{ asset('assets/css/skins/theme-'.sys_settings('ui_theme_skin').'.css?ver=111') }}">
@endif
@if (!empty(global_meta_content('seo')))
    {!! global_meta_content('seo') !!}
@endif
@if (!empty(global_meta_content('share')))
    {!! global_meta_content('share') !!}
@endif
@if(sys_settings('google_track_id'))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ sys_settings('google_track_id') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', "{{ sys_settings('google_track_id') }}");
    </script>
@endif
@if(has_recaptcha())
    <script src="https://www.google.com/recaptcha/api.js?render={{recaptcha_key('site')}}"></script>
    
@endif
@if(sys_settings('header_code'))
    {{ html_string(sys_settings('header_code')) }}
@endif
</head>
<body class="nk-body npc-cryptlite pg-auth{{ (gui('skin', 'auth')=='dark') ? ' is-dark' : '' }}">
<div class="nk-app-root">
    <div class="nk-wrap">
        <div class="nk-block nk-block-middle nk-auth-body wide-xs">

            {{ site_branding('header', ['panel' => 'auth', 'size' => 'lg', 'class' => 'pb-4']) }}

            @yield('content')

            {!! Panel::socials('any', ['class' => 'icon-list justify-center pt-4',  'parent' => true ]) !!}

        </div>

        @include('auth.layouts.footer')
    </div>
</div>
<script src="{{ asset('/assets/js/bundle.js?ver=111') }}"></script>
<script src="{{ asset('/assets/js/app.js?ver=111') }}"></script>
<script type="text/javascript">
    const msgwng = "{{ __("Sorry, something went wrong!") }}", msgunp = "{{ __("Unable to process your request.") }}";
    (function () {
        var logoLink = document.querySelector('.brand-logo .logo-link');
        if (!logoLink) return;
        try {
            var configured = "{{ rtrim((string) config('app.url', ''), '/') }}";
            var target = configured ? new URL(configured) : new URL(window.location.href);
            logoLink.setAttribute('href', target.origin + '/');
        } catch (err) {
            logoLink.setAttribute('href', '/');
        }
    })();
</script>
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
