<!DOCTYPE html>
<html ng-app="basecamp">
<head>
    <meta charset="utf-8">
    <?php include("includes/web-header.php"); ?>
    <title>Home | UMBC SGA iTracker</title>
    <script>document.write('<base href="' + document.location + '" />');</script>
    <link rel="stylesheet" href="css/bootstrap.css">
    <!-- <link rel="stylesheet" href="css/style.css"> -->
    <script src="components/angular/angular.js"></script>
    <script src="js/app.js"></script>
</head>
<body class="hold-transition skin-yellow sidebar-mini" ng-controller="MainController">
    <div class="wrapper">
        <header class="main-header">
            <?php include("includes/header.php"); ?>
        </header>

        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <?php include("includes/sidebar.php"); ?>
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

            <div class="container">
                <div ng-view></div>
            </div>

        </div><!-- /.content-wrapper -->
        <footer class="main-footer">
            <?php include("includes/footer.php"); ?>
        </footer>
        
        <!-- Add the sidebar's background. This div must be placed
        immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    <?php include("includes/web-footer.php"); ?>

</body>
</html>