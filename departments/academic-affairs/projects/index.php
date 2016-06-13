<?php $group = json_decode('{"id":1813626,"name":"Academic Affairs","created_at":"2015-07-03T11:55:04.000-04:00","updated_at":"2016-05-14T16:18:34.000-04:00","memberships":[{"id":11816865,"name":"Joshua Massey","email_address":"joshua.massey@umbc.edu","admin":true,"created_at":"2015-07-03T10:33:55.000-04:00","updated_at":"2016-06-09T10:07:02.000-04:00","trashed":false,"identity_id":11014750,"can_create_projects":true,"avatar_url":"http:\/\/cdn.37img.com\/global\/56e0a6b1288285b75f31eb1a04429f590010\/avatar.gif?r=3","fullsize_avatar_url":"https:\/\/cdn.37img.com\/global\/56e0a6b1288285b75f31eb1a04429f590010\/original.gif?r=3","url":"https:\/\/basecamp.com\/2979808\/api\/v1\/people\/11816865.json","app_url":"https:\/\/basecamp.com\/2979808\/people\/11816865"},{"id":11816860,"name":"Matthew Landen","email_address":"mlanden@umbc.edu","admin":true,"created_at":"2015-07-03T10:32:39.000-04:00","updated_at":"2016-05-15T21:19:34.000-04:00","trashed":false,"identity_id":11467575,"can_create_projects":true,"avatar_url":"http:\/\/cdn.37img.com\/builtin\/default_avatar_v1_0\/avatar.gif?r=3","fullsize_avatar_url":"https:\/\/cdn.37img.com\/builtin\/default_avatar_v1_0\/original.gif?r=3","url":"https:\/\/basecamp.com\/2979808\/api\/v1\/people\/11816860.json","app_url":"https:\/\/basecamp.com\/2979808\/people\/11816860"},{"id":13432682,"name":"l1n Devereaux","email_address":"l1ntransform@gmail.com","admin":false,"created_at":"2016-02-22T11:07:18.000-05:00","updated_at":"2016-06-09T10:03:10.000-04:00","trashed":false,"identity_id":11243765,"can_create_projects":true,"avatar_url":"http:\/\/cdn.37img.com\/global\/2f8e76a44fbb00f320108c510a3f8f3c0010\/avatar.gif?r=3","fullsize_avatar_url":"https:\/\/cdn.37img.com\/global\/2f8e76a44fbb00f320108c510a3f8f3c0010\/original.gif?r=3","url":"https:\/\/basecamp.com\/2979808\/api\/v1\/people\/13432682.json","app_url":"https:\/\/basecamp.com\/2979808\/people\/13432682"}]}'); ?>
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
			include("includes/header.php");
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
					$members = json_decode(file_get_contents("data/departments/" . $groupData[$i]["id"] . "/people.json", FILE_USE_INCLUDE_PATH), true);
					$groupID = str_replace("&", "and", str_replace(" ", "-", strtolower($groupData[$i]["name"])));
					?>

					<h2 id=<?php echo($groupID); ?>><?php echo($groupData[$i]["name"]); ?></h2>
					<?php
					usort($members, 'compareName');

					for ($j=0; $j<sizeof($members); $j++) {
						$person = json_decode(file_get_contents("data/people/" . $members[$j] . "/info.json", FILE_USE_INCLUDE_PATH), true);
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
											<img class="img-circle" src=<?php echo($photo); ?> alt="User Avatar">
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
