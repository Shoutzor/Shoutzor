<html>
<head>
    <title>{{ config('app.name', 'Shoutz0r') }} - Installation Required</title>

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
