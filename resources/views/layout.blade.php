<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <link href="https://uploads-ssl.webflow.com/62163e8c328ad285342080f0/624966ad8a6e5e1040088926_Favicon%20Konecta.png" rel="shortcut icon" type="image/x-icon"/>
    <link href="https://uploads-ssl.webflow.com/62163e8c328ad285342080f0/624ea2ef1671d94c6893ee64_Favicon%20Konecta%20256x256.png" rel="apple-touch-icon"/>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <title>Cafetería Konecta</title>

</head>

<body>
    <div id="app">
        <v-app id="inspire">
            @yield('components_page')
        </v-app>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>

</body>

</html>