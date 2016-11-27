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
        <div class="row">
            <div class="col-xs-12 col-md-8">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="featuredProjects"></div>
                    </div>
                </div>  <!-- /.col -->
                <div class="col-xs-12">
                    @include('partials.aboutSGA')
                </div> <!-- /.col -->
            </div>
            <div class="col-xs-12 col-md-4">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                About the SGA iTracker
                            </h3>
                        </div>
                        <div class="box-footer">
                            <a href="{{url('/projects/9793947')}}" class="btn btn-success btn-block" role="button">View this Project!</a>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="numberBox"
                         data-color="bg-aqua"
                         data-title="Active Projects"
                         data-str="@{{ main.projects.length }}"
                         data-url="{{url('projects/by-name')}}"
                         data-description="See What We Are Working On!"
                         data-icon="ion ion-compose"></div>
                </div>
                <div class="col-xs-12">
                    <div class="numberBox"
                         data-color="bg-yellow"
                         data-title="Departments"
                         data-str="@{{ main.groups.length }}"
                         data-url="{{url('projects/by-dept')}}"
                         data-description="See Departmental Projects!"
                         data-icon="ion ion-briefcase"></div>
                </div>
                <div class="col-xs-12">
                    <div class="numberBox"
                         data-color="bg-red"
                         data-title="Active Members"
                         data-str="@{{ main.people.length }}"
                         data-url="{{url('projects/by-name')}}"
                         data-description="See Who Is Who!"
                         data-icon="ion ion-person"></div>
                </div>
            </div>
        </div>
    </section>
</div> <!-- /.content-wrapper -->
