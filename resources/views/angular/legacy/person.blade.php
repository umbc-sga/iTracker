<div ng-controller="PersonController">

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				@{{person.name}}'s Profile
			</h1>
			<ol class="breadcrumb">
				<li><a href="/itracker/"><i class="fa fa-home"></i> Home</a></li>
				<li><a href="/itracker/people/by-name/">People</a></li>
				<li class="active">@{{person.name}}</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">

			<div class="row">
				<div class="col-md-3">

					<!-- Profile Image -->
					<div class="box box-primary">
						<div class="box-body box-profile">
							<img class="profile-user-img img-responsive img-circle" src="@{{person.avatar_url}}" alt="User profile picture">
							<h3 class="profile-username text-center">@{{person.name}}</h3>
							<p class="text-muted text-center">@{{person.position}}</p>
							<ul class="list-group list-group-unbordered" style="">
								<li class="list-group-item" ng-show="depts.length > 0" style="border-bottom:0px;">
									<b ng-show="depts.length == 1">Department</b>
									<b ng-show="depts.length > 1">Departments</b>
									<br/>
									<a href="/itracker/departments/@{{dept.href}}" ng-repeat="dept in depts">@{{dept.name}}<br></a>
								</li>
								<li class="list-group-item">
									<b>E-Mail Address</b><br/>
									<a class="mailto:@{{person.email_address}}">@{{person.email_address}}</a>
								</li>
							</ul>
							<!-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> -->
						</div>	<!-- /.box-body -->
					</div>	<!-- /.box -->

					<!-- About Me Box -->
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">About Me</h3>
						</div>	<!-- /.box-header -->
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
						</div>	<!-- /.box-body -->
					</div>	<!-- /.box -->
				</div>	<!-- /.col -->
				<div class="col-md-5">
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Projects </h3>
						</div>
						<div class="box-body">
							<div class="box-group" id="accordion">
								<!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
								<h4 ng-show="projs.length == 0">This person is not on any projects...YET!</h4>
								<div class="box box-warning box-solid" ng-repeat="project in projs | orderBy: 'name'" style="margin-bottom:20px;">
									<a data-toggle="collapse" data-parent="#accordion" href="#projectCollapse-@{{project.id}}" target="_self" style="text-decoration:none; color:black;">
						                <div class="box-header with-border">
						                	<h4 class="box-title">
					                    		@{{project.name}}
						                    </h4>
						                </div>
						            </a>
									<div id="projectCollapse-@{{project.id}}" class="panel-collapse collapse">
										<div class="box-body no-padding">
											<table class="table table-responsive table-condensed">
												<tbody>
													<tr>
														<td style="width:150px;" align="right">Name</td>
														<td>@{{project.name}}</td>
													</tr>
													<tr>
														<td style="width:150px;" align="right">Description</td>
														<td>@{{project.description}}</td>
													</tr>
													<tr>
														<td style="width:150px;" align="right">Created By</td>
														<td>@{{project.creator.name}}</td>
													</tr>
													<tr>
														<td style="width:150px;" align="right">Created At</td>
														<td>@{{project.created_at | date}}</td>
													</tr>
													<tr>
														<td style="width:150px;" align="right">Last Updated</td>
														<td>@{{project.updated_at | date}}</td>
													</tr>
													<tr>
														<td style="width:150px;" align="right"># of Topics</td>
														<td>@{{project.topics.count}}</td>
													</tr>
													<tr>
														<td style="width:150px;" align="right">Completed To-Do Lists</td>
														<td>@{{project.todolists.completed_count}}</td>
													</tr>
													<tr>
														<td style="width:150px;" align="right">Outstanding To-Do Lists</td>
														<td>@{{project.todolists.remaining_count}}</td>
													</tr>
													<tr>
														<td style="width:150px;" align="right"># of People</td>
														<td>@{{project.accesses.count}}</td>
													</tr>
													<tr>
														<td style="width:150px;" align="right"># of Documents</td>
														<td>@{{project.documents.attachments + project.attachments.count}}</td>
													</tr>
													<tr>
														<td style="width:150px;" align="right"># of Events</td>
														<td>@{{project.calendar_events.count}}</td>
													</tr>				
												</tbody>
											</table>
										</div>
										<div class="box-footer">
											<a href="/itracker/projects/@{{project.id}}"><button type="button" class="btn btn-primary btn-block btn-flat">Read More!</button></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div> <!-- /.col -->
				<div class="col-md-4" id="timeline">
					<!-- The timeline -->
					<ul class="timeline timeline-inverse" >
						<li class="time-label" ng-repeat="event in events | limitTo: limit ">
							<span class="bg-red" ng-show ='event.created_at.length > 0'> 
								@{{event.created_at}}
							</span>
							<i ng-class="{timeline_afterDate: event.created_at.length > 0, timeline_otherwise: event.created_at.length == 0}" class="fa fa-user bg-blue"></i>

							<div class="timeline-item" style="margin-top:10px;">
								<h3 class="timeline-header">
									@{{person.name}} <span ng-bind-html="event.summary"></span>
								</h3>
							</div>
						</li>
						<li>
							<button type="button" class="btn btn-primary" ng-hide = "!more"  ng-click = "limit = limit + 5; getEventSet()"><i class="fa fa-clock-o"></i> Show Previous Events</button>
						</li>
					</ul>
				</div>	<!-- /.col -->
			</div>	<!-- /.row -->
		</section>	<!-- /.content -->
	</div>	<!-- /.content-wrapper -->
</div>