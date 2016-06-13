<!DOCTYPE html>
<html>
<head>
	<?php
	include("includes/web-header.php");
	?>
	<title>All Projects by Department | UMBC SGA iTracker</title>
</head>
<body class="hold-transition skin-yellow sidebar-mini">
	<div class="wrapper">

		<header class="main-header">
			<?php
			include("includes/header.php")
			?>
		</header>

		<!-- Left side column. contains the logo and sidebar -->
		<aside class="main-sidebar">
			<!-- sidebar: style can be found in sidebar.less -->
			<section class="sidebar">
				<?php
				include("includes/sidebar.php");
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

			<!-- Main content -->

			<section class="content-header">
				<h6>Jump To:<?php
					for ($m=0; $m<sizeof($groupData); $m++) {
						$groupID = str_replace("&", "and", str_replace(" ", "-", strtolower($groupData[$m]["name"])));
						?>
						<a href="#<?php echo($groupID); ?>" > <? echo($groupData[$m]["name"]); ?> | </a>
						<?php
					}
					?>
				</h6>
			</section>

			<section class="content">
				<!-- Small boxes (Stat box) -->
				<?php
				for($i=0; $i<sizeof($groupData); $i++) {
					$groupID = str_replace("&", "and", str_replace(" ", "-", strtolower($groupData[$i]["name"])));
					?>
					<h2 id=<?php echo($groupID); ?>><?php echo($groupData[$i]["name"]); ?></h2>
					<?php
					$groupProjs = json_decode(file_get_contents("data/departments/" . $groupData[$i]["id"] . "/projects.json", FILE_USE_INCLUDE_PATH), true);

					for ($l=0; $l<sizeof($groupProjs); $l++) {
						$project = json_decode(file_get_contents("data/projects/" . $groupProjs[$l] . ".json", FILE_USE_INCLUDE_PATH), true);

						$name = $project["name"];
						$description = $project["description"];
						if ($project["archived"] == False) {
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
		include("includes/footer.php");
		?>
	</footer>

      <!-- Add the sidebar's background. This div must be placed
      immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
  </div><!-- ./wrapper -->

  <?php
  include("includes/web-footer.php");
  ?>

</body>
</html>
