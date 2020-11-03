<!doctype html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<html lang="en" dir="ltr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta http-equiv="Content-Language" content="en" />
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
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />

        <!-- Stylesheet -->
        <link rel="dns-prefetch" href="//fonts.googleapis.com">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu:wght@300;400;500;600;700&display=swap" media="print" onload="this.media='all'" />
        <link rel="stylesheet" href="{{ asset('css/app.css') }}" />

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" async></script>
    </head>

    <body class="antialiased theme-dark fixed-header">
        <div id="shoutzor" v-cloak>
            <app></app>

            <div id="app-loader">
                <img src="{{ asset('images/shoutzor-logo-large.png') }}" alt="Shoutz0r logo">
                <div class="spinner-border mt-5 text-gray" role="status"></div>
            </div>
        </div>

        <style type="text/css">
            #shoutzor:not([v-cloak]) > #app-loader {
                -webkit-animation: fadeinout 0.5s linear forwards;
                animation: fadeinout 0.5s linear forwards;
            }

            #app-loader {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: black;
                z-index: 99999;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }

            #app-loader img {
                display: block;
                max-width: 25%;
                max-height: 25%;
            }

            #app-loader .spinner-border {
                display: block;
                width: 6rem;
                height: 6rem;
            }

            @keyframes fadeinout {
                0% {
                    opacity: 1;
                }

                50% {
                    opacity: 1;
                }

                100% {
                    opacity: 0;
                    z-index: -1;
                }
            }
        </style>
    </body>
</html>
