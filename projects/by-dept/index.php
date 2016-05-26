<!DOCTYPE html>
<html>
<head>
	<?php
	include("web-header.php");
	?>
	<title>All Projects by Department | UMBC SGA iTracker</title>
</head>
<body class="hold-transition skin-yellow sidebar-mini">
	<div class="wrapper">

		<header class="main-header">
			<?php
			include("header.php")
			?>
		</header>

		<!-- Left side column. contains the logo and sidebar -->
		<aside class="main-sidebar">
			<!-- sidebar: style can be found in sidebar.less -->
			<section class="sidebar">
				<?php
				include("sidebar.php");
				?>
			</section>
			<!-- /.sidebar -->
		</aside>

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<h1>
					All Projects By Department
				</h1>
				<ol class="breadcrumb">
					<li><a href="/itracker/"><i class="fa fa-home"></i> Home</a></li>
					<li>Projects</li>
					<li class="active">By Department</li>
				</ol>
			</section>

			<section>
				<h6>Jump To:<?php
				for ($m=0; $m<sizeof($groupData); $m++) {
					$groupInfo = Basecamp("groups/".$groupData[$m]["id"].".json");
					$groupID = str_replace(" ", "-", strtolower($groupInfo["name"]));
				?>
					<a href="#<?php echo($groupID); ?>" > <? echo($groupInfo["name"]); ?> | </a>
				<?php
				}
				?>
				</h6>
			</section>

			<!-- Main content -->
			<section class="content">
				<!-- Small boxes (Stat box) -->
				<?php
				for($i=0; $i<sizeof($groupData); $i++) {
					$groupInfo = Basecamp("groups/".$groupData[$i]["id"].".json");
					$groupID = str_replace(" ", "-", strtolower($groupInfo["name"]));
				?>
					<h2 id=<?php echo($groupID); ?>><?php echo($groupInfo["name"]); ?></h2>
					<?php
					$members = $groupInfo["memberships"];
					usort($members, 'compareName');

					$groupProjs = [];

					for ($j=0; $j<sizeof($members); $j++) {
						$personProjs = Basecamp("people/".$members[$j]["id"]."/projects.json");
						for ($k=0; $k<sizeof($personProjs); $k++) {
							if ( (!(in_array($personProjs[$k], $groupProjs))) && ($personProjs[$k]["template"] == False)) {
								array_push($groupProjs, $personProjs[$k]);
							}
						}
					}

					for ($l=0; $l<sizeof($groupProjs); $l++) {
						$project = Basecamp("projects/" . $groupProjs[$l]["id"] . ".json");

						$name = $project["name"];
						$description = $project["description"];
						if ($project["archived"] == True) {
							$status = "Active";
						} else {
							$status = "Archived";
						}
						$creator = $project["creator"]["name"];
						$numEvents = $project["calendar_events"]["count"];
						$numDocs = $project["documents"]["count"];


						if ( ($l%3 == 0) ) {
					?>
							<div class="row">
								<?php
							}
							?>
							<div class="col-md-4">
								<!-- Widget: user widget style 1 -->
								<div class="box box-widget widget-user">

									<!-- Add the bg color to the header using any of the bg-* classes -->
									<div class="widget-user-header bg-blue">
										<!--<div class="widget-user-image">
											<img class="img-circle" src=<?php echo($photo) ?> alt="User Avatar">
										</div><!- /.widget-user-image -->
										<h3 class="widget-user-username"><?php echo($name); ?></h3>
										<h5 class="widget-user-desc"><?php echo($description); ?></h5>
									</div>
									<div class="box-footer no-padding">
										<ul class="nav nav-stacked">
											<li><a href="#">Creator <span class="pull-right badge bg-blue"><?php echo($creator); ?></span></a></li>
											<li><a href="#">Status <span class="pull-right badge bg-aqua"><?php echo($status); ?></span></a></li>
											<li><a href="#">Number of Events <span class="pull-right badge bg-green"><?php echo($numEvents); ?></span></a></li>
											<li><a href="#">Number of Docs <span class="pull-right badge bg-red"><?php echo($numDocs); ?></span></a></li>
										</ul>
									</div>
								</div><!-- /.widget-user -->
							</div><!-- /.col -->
							<?php
                			//  row tag closures
							if ( ($l%3 == 2) || ($l == sizeof($groupProjs)-1) ) {
							?>
								</div>
							<?php
							}
					}
				}
							?>
			</section><!-- /.content -->
		</div><!-- /.content-wrapper -->
		<footer class="main-footer">
			<?php
			include("footer.php");
			?>
		</footer>

		<!-- Control Sidebar -->
		<aside class="control-sidebar control-sidebar-dark">
			<!-- Create the tabs -->
			<ul class="nav nav-tabs nav-justified control-sidebar-tabs">
				<li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
				<li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
			</ul>
			<!-- Tab panes -->
			<div class="tab-content">
				<!-- Home tab content -->
				<div class="tab-pane" id="control-sidebar-home-tab">
					<h3 class="control-sidebar-heading">Recent Activity</h3>
					<ul class="control-sidebar-menu">
						<li>
							<a href="javascript::;">
								<i class="menu-icon fa fa-birthday-cake bg-red"></i>
								<div class="menu-info">
									<h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
									<p>Will be 23 on April 24th</p>
								</div>
							</a>
						</li>
						<li>
							<a href="javascript::;">
								<i class="menu-icon fa fa-user bg-yellow"></i>
								<div class="menu-info">
									<h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>
									<p>New phone +1(800)555-1234</p>
								</div>
							</a>
						</li>
						<li>
							<a href="javascript::;">
								<i class="menu-icon fa fa-envelope-o bg-light-blue"></i>
								<div class="menu-info">
									<h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>
									<p>nora@example.com</p>
								</div>
							</a>
						</li>
						<li>
							<a href="javascript::;">
								<i class="menu-icon fa fa-file-code-o bg-green"></i>
								<div class="menu-info">
									<h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>
									<p>Execution time 5 seconds</p>
								</div>
							</a>
						</li>
					</ul><!-- /.control-sidebar-menu -->

					<h3 class="control-sidebar-heading">Tasks Progress</h3>
					<ul class="control-sidebar-menu">
						<li>
							<a href="javascript::;">
								<h4 class="control-sidebar-subheading">
									Custom Template Design
									<span class="label label-danger pull-right">70%</span>
								</h4>
								<div class="progress progress-xxs">
									<div class="progress-bar progress-bar-danger" style="width: 70%"></div>
								</div>
							</a>
						</li>
						<li>
							<a href="javascript::;">
								<h4 class="control-sidebar-subheading">
									Update Resume
									<span class="label label-success pull-right">95%</span>
								</h4>
								<div class="progress progress-xxs">
									<div class="progress-bar progress-bar-success" style="width: 95%"></div>
								</div>
							</a>
						</li>
						<li>
							<a href="javascript::;">
								<h4 class="control-sidebar-subheading">
									Laravel Integration
									<span class="label label-warning pull-right">50%</span>
								</h4>
								<div class="progress progress-xxs">
									<div class="progress-bar progress-bar-warning" style="width: 50%"></div>
								</div>
							</a>
						</li>
						<li>
							<a href="javascript::;">
								<h4 class="control-sidebar-subheading">
									Back End Framework
									<span class="label label-primary pull-right">68%</span>
								</h4>
								<div class="progress progress-xxs">
									<div class="progress-bar progress-bar-primary" style="width: 68%"></div>
								</div>
							</a>
						</li>
					</ul><!-- /.control-sidebar-menu -->

				</div><!-- /.tab-pane -->
				<!-- Stats tab content -->
				<div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div><!-- /.tab-pane -->
				<!-- Settings tab content -->
				<div class="tab-pane" id="control-sidebar-settings-tab">
					<form method="post">
						<h3 class="control-sidebar-heading">General Settings</h3>
						<div class="form-group">
							<label class="control-sidebar-subheading">
								Report panel usage
								<input type="checkbox" class="pull-right" checked>
							</label>
							<p>
								Some information about this general settings option
							</p>
						</div><!-- /.form-group -->

						<div class="form-group">
							<label class="control-sidebar-subheading">
								Allow mail redirect
								<input type="checkbox" class="pull-right" checked>
							</label>
							<p>
								Other sets of options are available
							</p>
						</div><!-- /.form-group -->

						<div class="form-group">
							<label class="control-sidebar-subheading">
								Expose author name in posts
								<input type="checkbox" class="pull-right" checked>
							</label>
							<p>
								Allow the user to show his name in blog posts
							</p>
						</div><!-- /.form-group -->

						<h3 class="control-sidebar-heading">Chat Settings</h3>

						<div class="form-group">
							<label class="control-sidebar-subheading">
								Show me as online
								<input type="checkbox" class="pull-right" checked>
							</label>
						</div><!-- /.form-group -->

						<div class="form-group">
							<label class="control-sidebar-subheading">
								Turn off notifications
								<input type="checkbox" class="pull-right">
							</label>
						</div><!-- /.form-group -->

						<div class="form-group">
							<label class="control-sidebar-subheading">
								Delete chat history
								<a href="javascript::;" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
							</label>
						</div><!-- /.form-group -->
					</form>
				</div><!-- /.tab-pane -->
			</div>
		</aside><!-- /.control-sidebar -->
      <!-- Add the sidebar's background. This div must be placed
      immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
  </div><!-- ./wrapper -->

  <?php
  include("web-footer.php");
  ?>

</body>
</html>
