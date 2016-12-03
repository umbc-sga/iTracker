<header class="main-header">
    <a href="{{url('/')}}" class="logo">
        <span class="logo-mini"><b>i</b>Tr</span>
        <span class="logo-lg"><b>Initiative</b>Tracker</span>
    </a>
    <nav class="navbar navbar-static-top" role="navigation" style="height:50px;">
        <a class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="hidden-xs">
                    <a href="http://50.umbc.edu/"><small>UMBC50</small></a>
                </li>
                <li class="hidden-xs">
                    <a href="http://umbc.edu/go/umbc-azindex"><small>A-Z Index</small></a>
                </li>
                <li class="hidden-xs">
                    <a href="http://my.umbc.edu/"><small>myUMBC</small></a>
                </li>
                <li class="hidden-xs">
                    <a href="http://my.umbc.edu/events"><small>Events</small></a>
                </li>
                <li class="hidden-xs">
                    <a href="http://umbc.edu/go/directory"><small>Directory</small></a>
                </li>
                <li class="hidden-xs">
                    <a href="http://umbc.edu/go/maps"><small>Maps</small></a>
                </li>
                <li class="hidden-xs">
                    <a href="http://umbc.edu/search"><small>Search</small></a>
                </li>
                <li>
                    @if(auth()->guest())
                        <a href="{{route('auth.login')}}" target="_self"><small>Login</small></a>
                    @else
                        <a href="{{route('auth.logout')}}" target="_self"><small>Logout</small></a>
                    @endif
                </li>
            </ul>
        </div>
    </nav>
</header>