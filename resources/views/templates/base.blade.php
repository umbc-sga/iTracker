<!doctype html>
<html ng-app="itracker">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @yield('meta')
        <title>@yield('title')</title>
        @yield('head')

        <link rel="stylesheet" href="{{asset('css/core.css')}}?{{ config('app.debug') ? time() : config('app.version')}}">

    </head>
    <body>
        @yield('content')
    </body>
    @yield('script')

    @if(config('app.debug'))
        <script>window.debug = true;</script>
    @endif
    <script src="{{asset('js/core.js')}}?{{ config('app.debug') ? time() : config('app.version')}}"></script>
</html>