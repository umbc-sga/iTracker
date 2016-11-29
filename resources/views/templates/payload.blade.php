@extends('templates.base')

@section('title') UMBC SGA iTracker @endsection

@section('meta')
    <!-- Favicon -->
    <link rel="icon" href="{{asset('favicon.ico')}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}" type="image/x-icon">
@endsection

@section('content')
    <div class="wrapper">
    @include('templates.umbc.header')

    <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="image">
                        <img src="{{asset('media/sga-logo-IT.png')}}" class="img-circle" style="max-width: 100%" alt="User Image">
                    </div>
                </div>
                <!-- search form -->
                <form action="#" method="get" class="sidebar-form">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                    </div>
                </form> <!-- /.search form -->
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu">
                    <li class="header">MAIN NAVIGATION</li>
                    <li class="active">
                        <a href="{{url('/')}}">
                            <i class="fa fa-home"></i> <span>Home</span> <!-- <i class="fa fa-angle-left pull-right"></i> -->
                        </a>
                    </li>
                    <li class="treeview">
                        <a class="no-link">
                            <i class="fa fa-edit"></i>
                            <span>Projects</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{url('/projects')}}"><i class="fa fa-circle-o"></i>Projects By Name</a></li>
                            <li><a href="{{url('/departments')}}"><i class="fa fa-circle-o"></i>Projects By Department</a></li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a class="no-link">
                            <i class="fa fa-users"></i>
                            <span>People</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{url('/people')}}"><i class="fa fa-circle-o"></i>Everyone By Name</a></li>
                            <li><a href="{{url('/departments/people')}}"><i class="fa fa-circle-o"></i>Everyone By Department</a></li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a class="no-link">
                            <i class="fa fa-briefcase"></i>
                            <span>Departments</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li ng-repeat="group in data.groups | orderBy: 'name'">
                                <a href="{{url('/departments')}}/@{{group.name | departmentHref}}/">
                                    <i class="fa fa-circle-o"></i>@{{group.name}}
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="http://sga.umbc.edu/getinvolved/" target="_blank">
                            <i class="fa fa-question"></i>
                            <span>How Do I Get Involved?</span>
                        </a>
                    </li>
                    <li>
                        <a href="https://umbcsga.slack.com/" target="_blank">
                            <i class="fa fa-slack"></i>
                            <span>UMBC SGA on Slack</span>
                        </a>
                    </li>
                    <li>
                        <a href="http://sga.umbc.edu/contact/" target="_blank">
                            <i class="fa fa-phone"></i>
                            <span>Contact Us</span>
                        </a>
                    </li>
                    <li>
                        <a href="http://sga.umbc.edu/" target="_blank">
                            <i class="fa fa-arrow-left"></i>
                            <span>To the UMBC SGA Website</span>
                        </a>
                    </li>
                    <li class="header">SHARE THIS ON SOCIAL MEDIA</li>
                    <li>
                        <a class="no-link" onclick="FacebookShare();">
                            <i class="fa fa-facebook-square"></i>
                            <span>Share On Facebook!</span>
                        </a>
                    </li>
                    <li>
                        <a class="no-link" onclick="TwitterShare();">
                            <i class="fa fa-twitter-square"></i>
                            <span>Share on Twitter!</span>
                        </a>
                    </li>
                </ul>
            </section>  <!-- /.sidebar -->
        </aside>

        <!-- Main content -->
        <div data-ng-view></div>

    @include('templates.umbc.footer')

    <!-- Add the sidebar's background. This div must be placed
    immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->
@endsection

@section('script')

@endsection

@section('head')
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
@endsection