<!doctype html>
<html ng-app="itracker">
    <head>
        <base href="{{asset('/')}}">
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @yield('meta')
        <title>@yield('title')</title>
        @yield('head')

        @if(count($errors) > 0)
            <script> window.errs = {!! json_encode($errors->all()) !!};</script>
        @endif
        <link rel="stylesheet" href="{{asset('css/core.css')}}?{{ config('app.debug') ? time() : config('app.version')}}">
    </head>
    <body class="hold-transition skin-yellow sidebar-mini" data-ng-controller="MainController" data-ng-init="bootstrap()">
        @yield('content')
    </body>
    @if(config('app.debug'))
        <script>window.debug = true;</script>
    @endif
    <script src="{{asset('js/core.js')}}?{{ config('app.debug') ? time() : config('app.version')}}"></script>

    @yield('script')

    @include('partials.social')
</html>