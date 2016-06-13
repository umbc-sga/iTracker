<!DOCTYPE html>
<html>
<head>
	<?php
	include("includes/web-header.php");
	?>
	<title>All People by Department | UMBC SGA iTracker</title>
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
					All People By Department
				</h1>
				<ol class="breadcrumb">
					<li><a href="/itracker/"><i class="fa fa-home"></i> Home</a></li>
					<li>People</li>
					<li class="active">By Department</li>
				</ol>
			</section>

			<!-- Main content -->
			
			<section class="content-header">
 				<h6>Jump To: <?php
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
					$memberIDs = json_decode(file_get_contents("data/departments/" . $groupData[$i]["id"] . "/people.json", FILE_USE_INCLUDE_PATH), true);
					$members = [];

					for ($k=0; $k<sizeof($memberIDs); $k++) {
						array_push($members, json_decode(file_get_contents("data/people/" . $memberIDs[$k] . "/info.json", FILE_USE_INCLUDE_PATH), true));
					}

					usort($members, 'compareName');

					for ($j=0; $j<sizeof($members); $j++) {
						$person = $members[$j];

						if ( ($j%3 == 0) ) {
							?>
							<div class="row">
								<?php
							}
							?>
							<div class="col-md-4">
								<!-- Widget: user widget style 1 -->
								<div class="box box-widget widget-user-2">

									<?php
									$name = $person["name"];
									$email = $person["email_address"];
									$photo = $person["avatar_url"];

									$personProjs = json_decode(file_get_contents("data/people/" . $person["id"] . "/projects.json", FILE_USE_INCLUDE_PATH), true);

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
							if ( ($j%3 == 2) || ($j == sizeof($members)-1) ) {
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
