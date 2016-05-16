<!DOCTYPE html>
<html>
<head>
	<?php
	include("web-header.php");
	?>
	<title>All People by Name | UMBC SGA iTracker</title>
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
				<!-- Small boxes (Stat box) -->
				<?php
				$alpha = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z"];

				$people = Basecamp("people.json");
				usort($people, 'compareName');

				$letterCounter = 0;
				$rowTrack = 0;
				?>
				
				<h2><?php echo($alpha[$letterCounter]); ?></h2>
				
				<?php
				for($i=0; $i<sizeof($people); $i++) {
					while ($people[$i]["name"][0] != $alpha[$letterCounter]) {
						$letterCounter++;
				?>
				
						<h2><?php echo($alpha[$letterCounter]); ?></h2>
				
				<?php
					}
						if ( ($rowTrack%3 == 0) || ($people[$i-1]["name"][0] != $alpha[$letterCounter]) ) {
							$rowTrack = 0;
				?>
							<div class="row">
					<?php
						}
					?>
						<div class="col-md-4">
								<!-- Widget: user widget style 1 -->
								<div class="box box-widget widget-user-2">

									<?php
									$name = $people[$i]["name"];
									$email = $people[$i]["email_address"];
									$photo = $people[$i]["avatar_url"];

									$person = Basecamp("people/".$people[$i]["id"].".json");
									$personProjs = Basecamp("people/".$people[$i]["id"]."/projects.json");

									$numActive = 0;
									$numArchived = 0;
									for ($k=0; $k<sizeof($personProjs); $k++) {
										if (($personProjs[$k]["trashed"] == False) && ($personProjs[$k]["template"] == False)) {
											if ($personProjs[$k]["archived"] == False) {
												$numActive++;
											} else {
												$numArchived++;
											}
										}
									}

									$assignedTasks = $person["assigned_todos"]["count"];
									?>

									<!-- Add the bg color to the header using any of the bg-* classes -->
									<div class="widget-user-header bg-blue">
										<div class="widget-user-image">
											<img class="img-circle" src=<?php echo($photo) ?> alt="User Avatar">
										</div><!-- /.widget-user-image -->
										<h3 class="widget-user-username"><?php echo($name); ?></h3>
										<h5 class="widget-user-desc"><!--<a href=<?php echo("mailto:".$email); ?>>--><?php echo($email); ?><!--</a>--></h5>
									</div>
									<div class="box-footer no-padding">
										<ul class="nav nav-stacked">
											<li><a href="#">Projects <span class="pull-right badge bg-blue"><?php echo($numActive); ?></span></a></li>
											<li><a href="#">Tasks <span class="pull-right badge bg-aqua"><?php echo($assignedTasks); ?></span></a></li>
											<li><a href="#">Archived Projects <span class="pull-right badge bg-green"><?php echo($numArchived); ?></span></a></li>
											<!-- <li><a href="#">Followers <span class="pull-right badge bg-red">!!!</span></a></li> -->
										</ul>
									</div>
								</div><!-- /.widget-user -->
							</div><!-- /.col -->
							<?php
                			//  row tag closures
                			if ( ($rowTrack%3 == 2) || ($i == sizeof($people)-1) || ($people[$i+1]["name"][0] != $alpha[$letterCounter]) ) {
								?>
							</div>
							<?php
							}
							$rowTrack++;
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
