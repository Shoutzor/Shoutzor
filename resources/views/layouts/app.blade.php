<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="en"/>
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="theme-color" content="#4188c9">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Shoutz0r') }}</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}"/>

    <!-- Stylesheet -->
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu:wght@300;400;500;600;700&display=swap"
          media="print" onload="this.media='all'"/>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"/>

    <script type="text/javascript">
        window.Laravel = {
            APP_DEBUG: <?php echo config('app.debug') ? 'true' : 'false'; ?>,
            APP_ENV: '<?php echo config('app.env'); ?>',
            APP_URL: '<?php echo config('app.url'); ?>',
            APP_BASE_URL: '<?php echo parse_url(config('app.url'), PHP_URL_HOST); ?>',
            BROADCAST_URL: 'https://dash.akamaized.net/akamai/bbb_30fps/bbb_30fps.mpd'
        };
    </script>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" async></script>
</head>

<body class="antialiased theme-dark fixed-header">
<div id="shoutzor" v-cloak>
    <div id="app-loader">
        <img src="{{ asset('images/shoutzor-logo-large.png') }}" alt="Shoutz0r logo">
        <div class="spinner-border mt-5 text-gray" role="status"></div>
    </div>
</div>
</body>
</html>
