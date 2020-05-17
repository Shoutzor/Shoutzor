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

<body class="antialiased">
<div class="page">
    <header class="navbar navbar-expand-md navbar-light">
        <div class="container-xl">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a href="." class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pr-0 pr-md-3">
                <img src="{{ asset('images/shoutzor-logo-header.png') }}" alt="Shoutz0r logo" class="navbar-brand-image">
            </a>
            <div class="navbar-nav flex-row order-md-last">
                <div class="nav-item d-md-flex mr-3">
                    <a href="/admin" class="btn btn-sm btn-outline-primary">Admin panel</a>
                </div>
                <div class="nav-item dropdown d-none d-md-flex mr-3">
                    <a href="#" class="nav-link px-0" data-toggle="dropdown" tabindex="-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z"/>
                            <path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                            <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
                        </svg>
                        <span class="badge bg-red"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-card">
                        <div class="card">
                            <div class="card-body">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus ad amet consectetur exercitationem fugiat in ipsa ipsum, natus odio quidem quod repudiandae sapiente. Amet debitis et magni maxime necessitatibus ullam.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-toggle="dropdown">
                        <div class="d-xl-block pl-2">
                            <div>Xorinzor</div>
                            <div class="mt-1 small text-muted">Administrator</div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#">
                            Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">
                            Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="navbar-expand-md">
        <div class="navbar collapse navbar-collapse navbar-light" id="navbar-menu">
            <div class="container-xl">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="./index.html" >
                  <span class="nav-link-title">
                    Home
                  </span>
                        </a>
                    </li>
                </ul>
                <div class="my-2 my-md-0 flex-grow-1 flex-md-grow-0 order-first order-md-last">
                    <form action="." method="get">
                        <div class="input-icon">
                            <span class="input-icon-addon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z"/>
                                    <circle cx="10" cy="10" r="7" />
                                    <line x1="21" y1="21" x2="15" y2="15" />
                                </svg>
                            </span>
                            <input type="text" class="form-control" placeholder="Search…">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-xl">
            @yield('content')
        </div>
        <footer class="footer">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12 col-lg-auto mt-3 mt-lg-0 text-center">
                        Powered by <a href="https://github.com/xorinzor/shoutz0r">Shoutz0r</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
