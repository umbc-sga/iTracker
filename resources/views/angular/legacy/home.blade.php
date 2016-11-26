<div ng-controller="HomeController">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Dashboard
            </h1>
            <ol class="breadcrumb">
                <li><a href="/itracker/"><i class="fa fa-home"></i> Home</a></li>
                <li class="active">Dashboard</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3>
                                    @{{main.projects.length}}
                                </h3>
                                <p>Active Projects</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-compose"></i>
                            </div>
                            <a href="/itracker/projects/by-name/" class="small-box-footer">See What We Are Working On! <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div><!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-green">
                            <div class="inner">
                                <h3>
                                    &#9888;
                                </h3>
                                <p>Archived Projects</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-ios-box"></i>
                            </div>
                            <a href="#" class="small-box-footer">[This is being worked on...]<!-- See What We Have Finished! --> <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div><!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-yellow">
                            <div class="inner">
                                <h3>
                                    @{{main.groups.length}}
                                </h3>
                                <p>Departments</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-briefcase"></i>
                            </div>
                            <a href="/itracker/projects/by-dept/" class="small-box-footer">See Departmental Projects! <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div><!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-red">
                            <div class="inner">
                                <h3>
                                    @{{main.people.length}}
                                </h3>
                                <p>Active Members</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person"></i>
                            </div>
                            <a href="/itracker/people/by-dept/" class="small-box-footer">See Who Is Who! <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div><!-- ./col -->
                </div><!-- /.row -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="box">
                        <div id="featured-carousel" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#featured-carousel" data-slide-to="0" class="active"></li>
                                <li data-target="#featured-carousel" data-slide-to="@{{$index+1}}" class="" ng-repeat="project in featuredProjs"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="item active">
                                    <img src="http://placehold.it/900x500/3c8dbc/ffffff&text=Welcome+To+The+UMBC+SGA+iTracker" alt="">
                                    <div class="carousel-caption">
                                        Welcome To The UMBC SGA iTracker
                                    </div>
                                </div>
                                <div class="item" ng-repeat="project in featuredProjs">
                                    <img src="http://placehold.it/900x500/39CCCC/ffffff&text=Featured:+@{{project.name}}" alt="@{{project.name}}">
                                    <div class="carousel-caption">
                                        @{{ project.name }}
                                    </div>
                                </div>
                            </div>
                            <a class="left carousel-control" target="_self" href="#featured-carousel" data-slide="prev">
                                <span class="fa fa-angle-left"></span>
                            </a>
                            <a class="right carousel-control" target="_self" href="#featured-carousel" data-slide="next">
                                <span class="fa fa-angle-right"></span>
                            </a>
                        </div>
                        </div>
                    </div>  <!-- /.col -->
                    <div class="col-md-6">
                    	<div class="box box-warning">
                    		<div class="box-header with-border">
                    			<h3 class="box-title">
                    				About the UMBC Student Government Association
                    			</h3>
                    		</div> <!-- /.box-header -->
                    		<div class="box-body">
                    			The UMBC Student Government Association (SGA) is the voice of the undergraduate students at UMBC. Serving as one of the governing bodies at UMBC, the SGA meets with key administrators, organizes and empowers the undergraduate student body, and approves campus-wide policies in support of an active, academically enriched, social student environment. The SGA has an Executive Branch, Senate, Finance Board, and Election Board. The entire undergraduate population makes up the foundation of the SGA.<br/><br/>
								Every undergraduate student at UMBC is a member of the SGA. Elected officers and many appointed officers run programs, services and advocacy efforts with all undergraduates. SGA’s purpose is to organize and support undergraduate students in creating distinctive community, co-curricular and academic experiences; identify and voice students’ hopes and concerns; engage students in campus activities and decision-making; build mutually beneficial partnerships with individuals and organizations on and off campus and promote and defend students’ welfare.
							</div>
                    		<div class="box-footer">
                    			<a href="http://sga.umbc.edu/about" class="btn btn-warning" role="button">Read More!</a>
                    		</div>
                    	</div> <!-- /.box-warning -->
                    </div> <!-- /.col -->
                </div> <!-- /.row -->
                <div class="row">
                	<div class="col-md-6">
                    	<div class="box box-success">
                    		<div class="box-header with-border">
                    			<h3 class="box-title">
                    				About the SGA iTracker
                    			</h3>
                    		</div> <!-- /.box-header -->
                    		<div class="box-body">
                    			The SGA Initiative Tracker is the place where the UMBC community and general public can educate themselves about the work being done by active members of the UMBC Student Government Association on behalf of the undergraduate student body.<br/><br/>
                                Envisioned in Fall 2014 by Justin Chavez '17 as a project to educate the average student about how their student fees are being used, the project vision grew from a simple website to a dynamic application that shows updated information on all project-based activities of the organization.  Joining with fellow students Matthew Landen '17 and Josh Massey '18, the team worked on and <a href="http://devpost.com/software/sga-initiative-tracker">submitted an early version as part of HackUMBC</a>, UMBC's annual hackathon competiton, in the Fall 2014 semester.  Although it was not selected as a finalist for a prize, this initial version received much attention from the SGA administration.  Much work was done to improve both the public website and the behind-the-scenes work of the tool before a fully-functional public version was released in the Fall 2016 semester.  The Tracker is currently being put to a beta test with multiple scheduled improvements over the Fall semester and into the Spring.
							</div>
                    		<div class="box-footer">
                    			<a href="/itracker/projects/9793947/" class="btn btn-success" role="button">View this Project!</a>
                    		</div>
                    	</div> <!-- /.box-success -->
                    </div> <!-- /.col -->
                    <div class="col-md-6">
                    	<!-- Calendar -->
                    	<div class="box box-solid bg-green-gradient">
				            <div class="box-header">
				              	<i class="fa fa-calendar"></i>
								<h3 class="box-title">Calendar</h3>
				              	<!-- tools box -->
				              	<div class="pull-right box-tools">
					                <!-- button with a dropdown ->
					                <div class="btn-group">
						                <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
						                	<i class="fa fa-bars"></i>
						                </button>
						                <ul class="dropdown-menu pull-right" role="menu">
						                	<li><a href="#">Add new event</a></li>
						                    <li><a href="#">Clear events</a></li>
						                    <li class="divider"></li>
						                    <li><a href="#">View calendar</a></li>
						                </ul>
					                </div>
					                <button type="button" class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
					                </button>
					                <button type="button" class="btn btn-success btn-sm" data-widget="remove"><i class="fa fa-times"></i>
					                </button> -->
					            </div>	<!-- /. tools -->
				            </div>	<!-- /.box-header -->
				            <div class="box-body no-padding">
					            <!--The calendar -->
					            <div id="calendar" style="width: 100%"></div>
				            </div>
				            <!-- /.box-body -->
				            <div class="box-footer text-black">
				              	<div class="row">
				                	<div class="col-sm-6">
				                  		<!-- Progress bars -->
				                  		<div class="clearfix">
				                    		<span class="pull-left">Project #1</span>
				                    		<small class="pull-right">90%</small>
				                  		</div>
					                  	<div class="progress xs">
					                    	<div class="progress-bar progress-bar-green" style="width: 90%;"></div>
					                  	</div>

					                  	<div class="clearfix">
					                    	<span class="pull-left">Project #2</span>
					                    	<small class="pull-right">70%</small>
					                  	</div>
					                  	<div class="progress xs">
					                    	<div class="progress-bar progress-bar-green" style="width: 70%;"></div>
					                  	</div>
				                	</div>	<!-- /.col -->
				                	<div class="col-sm-6">
				                  		<div class="clearfix">
				                    		<span class="pull-left">Project #3</span>
				                    		<small class="pull-right">60%</small>
				                  		</div>
				                  		<div class="progress xs">
				                    		<div class="progress-bar progress-bar-green" style="width: 60%;"></div>
				                  		</div>
				                  		<div class="clearfix">
				                    		<span class="pull-left">Project #4</span>
				                    		<small class="pull-right">40%</small>
				                  		</div>
				                  		<div class="progress xs">
				                    		<div class="progress-bar progress-bar-green" style="width: 40%;"></div>
				                  		</div>
				                	</div>	<!-- /.col -->
				              	</div>	<!-- /.row -->
				            </div>
				        </div>	<!-- /.box -->
                    </div> <!-- /.col -->
                </div> <!-- /.row -->
        </section>
    </div> <!-- /.content-wrapper -->
</div>
