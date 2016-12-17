<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Dashboard
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12 col-md-8">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="featuredProjects" data-projects="data.projects"></div>
                    </div>
                </div>
                <div class="col-xs-12">
                    @include('partials.aboutSGA')
                </div>
            </div>
            <div class="col-xs-12 col-md-4">
                <div class="col-xs-12">
                    @include('partials.aboutiTracker')
                </div>
                @{{ dataService }}
                <div class="col-xs-12">
                    <div class="numberBox"
                         data-color="bg-aqua"
                         data-title="Active Projects"
                         data-str="@{{ data.projects.length }}"
                         data-url="{{url('/projects')}}"
                         data-description="See What We Are Working On!"
                         data-icon="ion ion-compose"></div>
                </div>
                <div class="col-xs-12">
                    <div class="numberBox"
                         data-color="bg-yellow"
                         data-title="Departments"
                         data-str="@{{ data.groups.length }}"
                         data-url="{{url('/departments')}}"
                         data-description="See Departmental Projects!"
                         data-icon="ion ion-briefcase"></div>
                </div>
                <div class="col-xs-12">
                    <div class="numberBox"
                         data-color="bg-red"
                         data-title="Active Members"
                         data-str="@{{ data.people.length }}"
                         data-url="{{url('/people')}}"
                         data-description="See Who Is Who!"
                         data-icon="ion ion-person"></div>
                </div>
            </div>
        </div>
    </section>
</div>
