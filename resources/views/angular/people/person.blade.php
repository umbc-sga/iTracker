<div class="loader smallLoader" data-ng-show="!loaded"></div>

<div class="row" data-ng-show="loaded && person.id == null">
    <div class="genericError" data-error="404"
         data-message="The person you are looking for does not exist"></div>
</div>

<div class="row" data-ng-show="loaded && person.id != null">
    <div class="col-md-3">
        <div class="box box-primary">
            <div class="box-body box-profile">
                <img class="profile-user-img img-responsive img-circle" data-ng-src="@{{person.avatar_url}}" alt="User profile picture">
                <h3 class="profile-username text-center">@{{person.name}}</h3>
                <p class="text-muted text-center">@{{person.position}}</p>
                <ul class="list-group list-group-unbordered" style="">
                    <li class="list-group-item" data-ng-show="depts.length > 0" style="border-bottom:0px;">
                        <b data-ng-show="depts.length == 1">Department</b>
                        <b data-ng-show="depts.length > 1">Departments</b>
                        <br/>
                        <a data-ng-href="{{url('/departments')}}/@{{dept.href}}" data-ng-repeat="dept in depts">@{{dept.name}}<br></a>
                    </li>
                    <li class="list-group-item">
                        <b>E-Mail Address</b><br/>
                        <a class="mailto:@{{person.email_address}}">@{{person.email_address}}</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">About Me</h3>
            </div>
            <div class="box-body">
                <strong><i class="fa fa-user"></i> Bio</strong>
                <p class="text-muted">
                    @{{person.bio}}
                </p>
                <hr>
                <strong><i class="fa fa-book margin-r-5"></i> Major and Class Standing</strong>
                <p class="text-muted">
                    @{{person.classStanding}}, @{{person.major}}
                </p>
                <hr>
                <strong><i class="fa fa-map-marker margin-r-5"></i> Hometown</strong>
                <p class="text-muted">@{{person.hometown}}</p>
                <hr>
                <strong><i class="fa fa-question-circle"></i> One thing I really want to share with the world is...</strong>
                <p class="text-muted">@{{person.fact}}</p>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Projects </h3>
            </div>
            <div class="box-body">
                <div class="box-group" id="accordion">
                    <h4 data-ng-show="person.projects.length == 0">This person is not on any projects...YET!</h4>
                    <div class="projectsAtAGlance" data-projects="person.projects" data-read-more="true"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4" id="timeline">
        <ul class="timeline timeline-inverse" >
            <li class="time-label" data-ng-repeat="event in events | limitTo: limit ">
						<span class="bg-red" data-ng-show ='event.created_at.length > 0'>
							@{{event.created_at}}
						</span>
                <i data-ng-class="{timeline_afterDate: event.created_at.length > 0, timeline_otherwise: event.created_at.length == 0}" class="fa fa-user bg-blue"></i>

                <div class="timeline-item" style="margin-top:10px;">
                    <h3 class="timeline-header">
                        @{{person.name}} <span data-ng-bind-html="event.summary"></span>
                    </h3>
                </div>
            </li>
            <li>
                <button type="button"
                        class="btn btn-primary"
                        data-ng-hide="!more"
                        data-ng-click="limit = limit + 5; getEventSet()">
                    <i class="fa fa-clock-o"></i> Show Previous Events
                </button>
            </li>
        </ul>
    </div>
</div>