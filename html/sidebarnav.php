<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
                <li>
                    <a <?php if($currentPage=='DeKUT-IMS-Dasboard') { echo 'class="active"';} ?> href="index.php">
                        <i class="fa fa-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sub-menu">
                    <a <?php if($currentPage=='DeKUT-IMS-Profiling') { echo 'class="active"';} ?> href="profiling.php">
                        <i class="fa fa-tasks"></i>
                        <span>Profiling</span>
                    </a>
                </li>
                <li class="sub-menu">
                    <a <?php if($currentPage=='DeKUT-IMS-Counseling Services') { echo 'class="active"';} ?> >
                        <i class="fa fa-suitcase"></i>
                        <span>Counseling Services</span>
                    </a>
                   <ul class="sub">
                    <li><a href="counseling_page.php"><i class="fa fa-user"></i>Individual Counseling</a></li>
                    <li><a href="counseling_page_group.php"><i class="fa fa-users"></i>Group Counseling</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a <?php if($currentPage=='DeKUT-IMS-Visits') { echo 'class="active"';} ?> href="visit_logs.php">
                        <i class="fa fa-sign-in"></i>
                        <span>Visit Logs</span>
                    </a>
                </li>
                <li>
                    <a <?php if($currentPage=='DeKUT-IMS-Files') { echo 'class="active"';} ?> href="TypeA_FilesAndDocuments.php">
                        <i class="fa fa-book"></i>
                        <span>Files and Documents </span>
                    </a>
                </li>
                <li>
                    <a <?php if($currentPage=='DeKUT-IMS-Appointment') { echo 'class="active"';} ?> href="app_list.php">
                        <i class="fa fa-calendar"></i>
                        <span>Appointment Scheduling </span>
                    </a>
                </li>
                <li class="sub-menu">
                    <a <?php if($currentPage=='DeKUT-IMS-Reports') { echo 'class="active"';} ?> href="counselingreport.php">
                        <i class="fa fa-bar-chart-o"></i>
                        <span>Reports</span>
                    </a>
                </li>
                
            </ul>            </div>
        <!-- sidebar menu end-->
    </div>
</aside>