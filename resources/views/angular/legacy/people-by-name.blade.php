<div ng-controller='PeopleByNameController'>
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				All People By Name
			</h1>
			<ol class="breadcrumb">
				<li><a href="/itracker/"><i class="fa fa-home"></i> Home</a></li>
				<li>People</li>
				<li class="active">By Name</li>
			</ol>
		</section>
		<!-- Main content -->
		<section class="content">
			<input type="text" ng-model="search.name" class="form-control" placeholder="Filter by person name" />
			<div class="row" style="margin-top:20px">
				<div class="col-md-4" ng-repeat="person in people | filter: search | orderBy : 'name'">
					<div class="box box-widget widget-user-2">
						<a href="/itracker/people/@{{person.id}}/">
							<div class="widget-user-header bg-blue">
								<div class="widget-user-image">
									<img class="img-circle" src="@{{person.avatar_url}}" alt="User Avatar">
								</div><!-- /.widget-user-image -->
								<h3 class="widget-user-username">@{{person.name}}</h3>
								<h4 class="widget-user-desc">@{{person.position}}</h4>
								<h5 class="widget-user-desc">@{{person.email}}</h5>
							</div>
						</a>
						<div class="box-footer no-padding">
							<ul class="nav nav-stacked">
								<li><a>Projects <span class="pull-right badge bg-blue">@{{person.active}}</span></a></li>
								<li><a>Assigned Tasks <span class="pull-right badge bg-aqua"> @{{person.todoCount}}</span></a></li>
								<li><a>Events Created <span class="pull-right badge bg-green">@{{person.eventCount}}</span></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>