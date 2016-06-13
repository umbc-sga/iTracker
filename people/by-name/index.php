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

				$people = json_decode(file_get_contents("data/people/00-all.json", FILE_USE_INCLUDE_PATH), true);

				$peopleArray = [];

				for ($l=0; $l<sizeof($people); $l++) {
					array_push($peopleArray, json_decode(file_get_contents("data/people/" . $people[$l] . "/info.json", FILE_USE_INCLUDE_PATH), true));
				}

				usort($peopleArray, 'compareName');

				$letterCounter = 0;
				$rowTrack = 0;
				?>
				
				<h2><?php echo($alpha[$letterCounter]); ?></h2>
				
				<?php
				for($i=0; $i<sizeof($peopleArray); $i++) {
					$person = $peopleArray[$i];

					while ($person["name"][0] != $alpha[$letterCounter]) {
						$letterCounter++;
						?>
						
						<h2><?php echo($alpha[$letterCounter]); ?></h2>
						
						<?php
					}
					if ( ($rowTrack%3 == 0) || ($peopleArray[$i-1]["name"][0] != $alpha[$letterCounter]) ) {
						$rowTrack = 0;
						?>
						<div class="row">
							<?php
						}

						$name = $person["name"];
						$email = $person["email_address"];
						$photo = $person["avatar_url"];

						$personProjs = json_decode(file_get_contents("data/people/".$person["id"]."/projects.json", FILE_USE_INCLUDE_PATH), true);

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
						<div class="col-md-4">
							<!-- Widget: user widget style 1 -->
							<div class="box box-widget widget-user-2">


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
						if ( ($rowTrack%3 == 2) || ($i == sizeof($peopleArray)-1) || ($peopleArray[$i+1]["name"][0] != $alpha[$letterCounter]) ) {
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
