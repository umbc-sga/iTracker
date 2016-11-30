<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        @{{department.name}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a></li>
        <li>Departments</li>
        <li class="active">@{{department.name}}</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="loader smallLoader" ng-show="!loaded"></div>

    <div class="row" ng-show="loaded">
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        About this Department
                    </h3>
                </div>
                <div class="box-body">
                    @{{ department.description.length > 0 ? department.description : 'No description :(' }}
                </div>
            </div>
            <div class="meetTheTeam" data-members="department.memberships" data-team-title="Meet the Team"></div>
        </div>
        <div class="col-md-5">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Departmental Projects
                    </h3>
                </div>
                <div class="box-body">
                    <div ng-show="department.project.count == 0">This department does not have any active projects...YET!</div>
                    <div class="projectsAtAGlance" data-projects="department.projects"></div>
                </div>
            </div>
        </div> <!-- /.col -->
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Departmental Timeline
                    </h3>
                </div>
                <div class="box-body">
                    Coming soon!
                </div>
            </div>
        </div>
    </div>
</section>