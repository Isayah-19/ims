<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
                <li>
                    <a <?php if($currentPage=='DeKUT_IMS-Dasboard') { echo 'class="active"';} ?> href="TypeB_Index.php">
                        <i class="fa fa-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sub-menu">
                    <a <?php if($currentPage=='DeKUT_IMS-Profiling') { echo 'class="active"';} ?> href="TypeB_Profiling.php">
                        <i class="fa fa-tasks"></i>
                        <span>Profiling</span>
                    </a>
                </li>
                <li class="sub-menu">
                    <a <?php if($currentPage=='DeKUT_IMS-Visits') { echo 'class="active"';} ?> href="TypeB_VisitLogs.php">
                        <i class="fa fa-sign-in"></i>
                        <span>Visit Logs</span>
                    </a>
                </li>
                <li class="sub-menu">
                    <a <?php if($currentPage=='DeKUT-IMS-Counseling Services') { echo 'class="active"';} ?> >
                        <i class="fa fa-suitcase"></i>
                        <span>Counseling Services</span>
                    </a>
                   <ul class="sub">
                    <li><a href="typeb_counseling_page.php"><i class="fa fa-user"></i>Individual Counseling</a></li>
                    <li><a href="typeb_counseling_page_group.php"><i class="fa fa-users"></i>Group Counseling</a></li>
                    </ul>
                </li>
                <li>
                    <a <?php if($currentPage=='DeKUT_IMS-Files') { echo 'class="active"';} ?> href="typeb_counselingreport.php">
                        <i class="fa fa-book"></i>
                        <span>Reports </span>
                    </a>
                </li>
                
            </ul>            
        </div>
        <!-- sidebar menu end-->
    </div>
</aside>