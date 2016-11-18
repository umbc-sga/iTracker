<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="min-height: 775px;">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Are you lost?
    </h1>
    <ol class="breadcrumb">
      <li class="active">404 error</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="error-page col-12 row">
      <h2 class="headline " style="width:650px; text-align:center;">YO<span class="text-yellow">U M</span>UST <span class="text-yellow">B</span>E <span class="text-yellow">C</span>ONFUSED </h2>
      <h2>The page you are looking for does not exist</h2>
     </div>
     <div class="row">
     	<h2 class="content-header">Check out what SGA is up to!</h2>
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
    <!-- /.error-page -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->