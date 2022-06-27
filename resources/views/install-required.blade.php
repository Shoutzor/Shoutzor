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

    <title>{{ config('app.name', 'Shoutz0r') }} - Installation Required</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}"/>

    <!-- Stylesheet -->
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu:wght@300;400;500;600;700&display=swap"
          media="print" onload="this.media='all'"/>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"/>

    <style type="text/css">
        body {
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            -webkit-flex-direction: row;
            -ms-flex-direction: row;
            flex-direction: row;
            -webkit-flex-wrap: nowrap;
            -ms-flex-wrap: nowrap;
            flex-wrap: nowrap;
            -webkit-justify-content: center;
            -ms-flex-pack: center;
            justify-content: center;
            -webkit-align-content: stretch;
            -ms-flex-line-pack: stretch;
            align-content: stretch;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
        }

        #container {
            -webkit-order: 0;
            -ms-flex-order: 0;
            order: 0;
            -webkit-flex: 0 0 auto;
            -ms-flex: 0 0 auto;
            flex: 0 0 auto;
            -webkit-align-self: center;
            -ms-flex-item-align: center;
            align-self: center;
            text-align: center;
        }
    </style>
</head>
<body>
<div id="container">
    <img src="{{ asset('images/shoutzor-logo-header.png') }}" alt="Shoutz0r logo" class="mb-5">

    <h1>Installation Required</h1>
    <p>Shoutz0r is not yet installed, please consult the README for more information.</p>
</div>
</body>
</html>
