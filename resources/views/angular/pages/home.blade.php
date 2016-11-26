<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <div class="numberBox"
                         data-color="bg-aqua"
                         data-title="Active Projects"
                         data-str="@{{ main.projects.length }}"
                         data-url="{{url('projects/by-name')}}"
                         data-description="See What We Are Working On!"
                         data-icon="ion ion-compose"></div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <div class="numberBox"
                         data-color="bg-green"
                         data-title="Archived Projects"
                         data-str="&#9888;"
                         data-url="#"
                         data-description="What have we accomplished?"
                         data-icon="ion ion-ios-box"></div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <div class="numberBox"
                         data-color="bg-yellow"
                         data-title="Departments"
                         data-str="@{{main.groups.length}}"
                         data-url="{{url('projects/by-dept')}}"
                         data-description="See Departmental Projects!"
                         data-icon="ion ion-briefcase"></div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <div class="numberBox"
                         data-color="bg-red"
                         data-title="Active Members"
                         data-str="@{{main.people.length}}"
                         data-url="{{url('projects/by-name')}}"
                         data-description="See Who Is Who!"
                         data-icon="ion ion-person"></div>
                </div>
            </div><!-- /.row -->
            <div class="row">
                <div class="col-md-6">
                    <div class="box">
                        <div class="featuredProjects"></div>
                    </div>
                </div>  <!-- /.col -->
                <div class="col-md-6">
                    @include('partials.aboutSGA')
                </div> <!-- /.col -->
            </div> <!-- /.row -->
            <div class="row">
                <div class="col-md-6">
                    @include('partials.aboutiTracker')
                </div>
                <div class="col-md-6">
                    @include('legacy.calendar')
                </div> <!-- /.col -->
            </div> <!-- /.row -->
    </section>
</div> <!-- /.content-wrapper -->
