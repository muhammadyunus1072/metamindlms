<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ env('APP_NAME') }}</title>

    <!-- Prevent the demo from appearing in search engines -->
    <meta name="robots" content="noindex">

    <link href="https://fonts.googleapis.com/css?family=Lato:400,700%7CRoboto:400,500%7CExo+2:600&display=swap"
        rel="stylesheet">

    <link href="{{ asset('/assets/vendor/spinkit.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/vendor/perfect-scrollbar.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/css/material-icons.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/css/fontawesome.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/css/preloader.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/css/app.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">

    @stack('css')
</head>

<body class="@yield('body-class')">

    @yield('content')

    <script src="{{ asset('/assets/vendor/jquery.min.js') }}"></script>
    <script src="{{ asset('/assets/vendor/popper.min.js') }}"></script>
    <script src="{{ asset('/assets/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/assets/vendor/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('/assets/vendor/dom-factory.js') }}"></script>
    <script src="{{ asset('/assets/vendor/material-design-kit.js') }}"></script>
    <script src="{{ asset('/assets/js/app.js') }}"></script>
    <script src="{{ asset('/assets/js/preloader.js') }}"></script>
    <script src="{{ asset('/assets/js/hljs.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
    </script>
    <script src="{{ asset('/js/main.js') }}"></script>
    <script src="{{ asset('/js/sweetalert2.all.min.js') }}"></script>

    @stack('js')
</body>
