    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="/initiative-tracker/ver0.3/sga-logo-IT.png" class="img-circle" alt="User Image">
      </div>
            <!-- <div class="pull-left info">
              <p>Alexander Pierce</p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div> -->
          </div>
          <!-- search form -->
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="active">
              <a href="/initiative-tracker/ver0.3/">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span> <!-- <i class="fa fa-angle-left pull-right"></i> -->
              </a>
            </li>

            <li class="treeview">
              <a href="#">
                <i class="fa fa-briefcase"></i>
                <span>Departments</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <?php
                $groupData = Basecamp("groups.json");

                for($i=0; $i<count($groupData); $i++) {
                  $dept_name = $groupData[$i]["name"];
                  $dept_url = str_replace("&", "and", str_replace(" ", "-", (strtolower($groupData[$i]["name"]))));
                  ?>
                  <li><a class="department" href="/initiative-tracker/ver0.3/departments/<?php echo($dept_url);?>/"><i class="fa fa-circle-o"></i><?php echo($dept_name);?> </a></li>
                <?php
                }
                ?>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-users"></i>
                <span>People</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="/initiative-tracker/ver0.3/people/"><i class="fa fa-circle-o"></i>Everyone</a></li>
                <?php
                for($j=0; $j<count($groupData); $j++) {
                  $dept_name = $groupData[$j]["name"];
                  $dept_url = str_replace("&", "and", str_replace(" ", "-", (strtolower($groupData[$j]["name"]))));
                  ?>
                  <li><a href="/initiative-tracker/ver0.3/departments/<?php echo($dept_url); ?>/people/"><i class="fa fa-circle-o"></i><?php echo($dept_name); ?></a></li>
                <?php
                }
                ?>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-archive"></i>
                <span>Archive     </span>
                <!-- <i class="fa fa-angle-left pull-right"></i> -->
                <span><small>(Coming Soon!)</small></span>
              </a>
            </li>
            <li>
              <a href="http://sga.umbc.edu/about/get-involved">
                <i class="fa fa-question"></i>
                <span>How Do I Get Involved?</span>
              </a>
            </li>
            <li>
              <a href="http://sga.umbc.edu">
                <i class="fa fa-arrow-left"></i>
                <span>To the UMBC SGA Website</span>
              </a>
            </li>
            <li class="header">SHARE THIS ON SOCIAL MEDIA</li>
            <li>
              <a href="#">
                <i class="fa fa-facebook-square"></i>
                <span>Share On Facebook!</span>
              </a>
            </li>
            <li>
              <a href="#">
                <i class="fa fa-twitter-square"></i>
                <span>Share on Twitter!</span>
              </a>
            </li>
          </ul>