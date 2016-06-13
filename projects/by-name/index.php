<!DOCTYPE html>
<html>
<head>
	<?php
	include("includes/web-header.php");
	?>
	<title>All People by Name | UMBC SGA iTracker</title>
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
					All Projects By Name
				</h1>
				<ol class="breadcrumb">
					<li><a href="/itracker/"><i class="fa fa-home"></i> Home</a></li>
					<li>Projects</li>
					<li class="active">By Name</li>
				</ol>
			</section>

			<!-- Main content -->
			<section class="content">
				<!-- Small boxes (Stat box) -->
				<?php
				$alpha = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z"];

				$projects = json_decode(file_get_contents("data/projects/00-all.json", FILE_USE_INCLUDE_PATH), true);

				$projectArray = [];

				for ($l=0; $l<sizeof($projects); $l++) {
					array_push($projectArray, json_decode(file_get_contents("data/projects/" . $projects[$l] . ".json", FILE_USE_INCLUDE_PATH), true));
				}

				usort($projectArray, 'compareName');

				$letterCounter = 0;
				$rowTrack = 0;
				?>
				
				<h2><?php echo($alpha[$letterCounter]); ?></h2>
				
				<?php
				for($i=0; $i<sizeof($projectArray); $i++) {
					$project = $projectArray[$i];

					while ($project["name"][0] != $alpha[$letterCounter]) {
						$letterCounter++;
						?>

						<h2><?php echo($alpha[$letterCounter]); ?></h2>

						<?php
					}
					if ( ($rowTrack%3 == 0) || ($projectArray[$i-1]["name"][0] != $alpha[$letterCounter]) ) {
						$rowTrack = 0;
						?>
						<div class="row">
							<?php
						}
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


						?>
						<div class="col-md-4">
							<!-- Widget: user widget style 1 -->
							<div class="box box-widget widget-user">

								<!-- Add the bg color to the header using any of the bg-* classes -->
								<div class="widget-user-header bg-blue">
										<!--<div class="widget-user-image">
										<img class="img-circle" src= alt="User Avatar">
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
						if ( ($rowTrack%3 == 2) || ($i == sizeof($projectArray)-1) || ($projectArray[$i+1]["name"][0] != $alpha[$letterCounter]) ) {
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
