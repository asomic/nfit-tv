<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">

        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>NFIT - Admin</title>

        <link rel="icon" href="{{ asset('img/mini.png') }}" type="image/x-icon">

        <!-- GLOBAL MAINLY STYLES-->
        <link href="{{ asset('/tenant/css/bootstrap.min.css') }}" rel="stylesheet" />

        <link href="{{ asset('/tenant/css/font-awesome.min.css') }}" rel="stylesheet" />

        <!-- PLUGINS STYLES-->

        <!-- PAGE CSS-->
        @yield('tenantCss')

        <!-- THEME STYLES-->
        <link href="{{ asset('/tenant/css/main.min.css') }}" rel="stylesheet" />

        <link href="{{ asset('/tenant/css/nfit.css') }}" rel="stylesheet" />

        <!-- Fonts -->
        <link rel="dns-prefetch" href="https://fonts.gstatic.com">

        <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    </head>

    <body class="fixed-navbar">

        <div class="page-wrapper">
            @include('tenant.layouts.header')

            @include('tenant.partials.navigation')

            <div class="wrapper content-wrapper">
                <div class="page-content">
                    @yield('tenantContent')
                </div>
            </div>
        </div>

        <!-- CORE PLUGINS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.5/umd/popper.min.js"></script>

        <script src="{{ asset('/tenant/js/jquery.min.js') }}"></script>

        <script src="{{ asset('/tenant/js/bootstrap.min.js') }}"></script>

        <script src="{{ asset('/tenant/js/moment.min.js') }}"></script>

        <!-- PAGE LEVEL PLUGINS-->

        <!-- CORE SCRIPTS-->
        <script src="{{ asset('/tenant/js/app.min.js') }}"></script>

        <!-- PAGE LEVEL SCRIPTS-->

        <!-- PAGE SCRIPT-->
        @yield('tenantScripts')

        {{-- @include('tenant.layouts.alert') --}}
    </body>
</html>
