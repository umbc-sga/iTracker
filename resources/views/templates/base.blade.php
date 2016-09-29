<!doctype html>
<html ng-app="itracker">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @yield('meta')
        <title>@yield('title')</title>
        @yield('head')

        <link href="{{asset('css/core.css')}}" rel="stylesheet">

    </head>
    <body>
        @yield('content')
    </body>
    @yield('script')

    <script src="{{asset('js/core.js')}}"></script>
</html>