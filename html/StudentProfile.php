<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    

    <title>GSMS</title>

    <!--Core JS -->
	<script src="js/scripts.js"></script>
	<script src="js/toggle-init.js"></script>
	<script src="js/advanced-form.js"></script>
     <!--Core CSS -->
    <link href="bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/bootstrap-switch.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-fileupload/bootstrap-fileupload.css" />
	<link rel="icon" href="images/PUPlogo.png">
    <link rel="stylesheet" type="text/css" href="js/select2/select2.css" />

    <!--responsive table-->
    <link href="css/table-responsive.css" rel="stylesheet" />

    

    <!-- Custom styles for this template -->
	<link href="css/customstyle.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />
</head>

<body>
<section id="container" >
<!--header start-->
<header class="header fixed-top clearfix">
<!--logo start-->
<div class="brand">

    <a href="Home.php" class="logo">
        <img src="images/pup200.png" alt="">
    </a>
    <div class="sidebar-toggle-box">
        <div class="fa fa-bars"></div>
    </div>
</div>
<!--logo end-->

<div class="nav notify-row" id="top_menu">
    <!--  notification start -->
    <ul class="nav top-menu">
        <!-- settings start -->
        <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <i class="fa fa-tasks"></i>
                <span class="badge bg-success">8</span>
            </a>
            <ul class="dropdown-menu extended tasks-bar">
                <li>
                    <p class="">You have 8 pending tasks</p>
                </li>
                <li>
                    <a href="#">
                        <div class="task-info clearfix">
                            <div class="desc pull-left">
                                <h5>Target Sell</h5>
                                <p>25% , Deadline  12 June’13</p>
                            </div>
                                    <span class="notification-pie-chart pull-right" data-percent="45">
                            <span class="percent"></span>
                            </span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="task-info clearfix">
                            <div class="desc pull-left">
                                <h5>Product Delivery</h5>
                                <p>45% , Deadline  12 June’13</p>
                            </div>
                                    <span class="notification-pie-chart pull-right" data-percent="78">
                            <span class="percent"></span>
                            </span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="task-info clearfix">
                            <div class="desc pull-left">
                                <h5>Payment collection</h5>
                                <p>87% , Deadline  12 June’13</p>
                            </div>
                                    <span class="notification-pie-chart pull-right" data-percent="60">
                            <span class="percent"></span>
                            </span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="task-info clearfix">
                            <div class="desc pull-left">
                                <h5>Target Sell</h5>
                                <p>33% , Deadline  12 June’13</p>
                            </div>
                                    <span class="notification-pie-chart pull-right" data-percent="90">
                            <span class="percent"></span>
                            </span>
                        </div>
                    </a>
                </li>

                <li class="external">
                    <a href="#">See All Tasks</a>
                </li>
            </ul>
        </li>
        <!-- settings end -->
        
        <!-- notification dropdown start-->
        <li id="header_notification_bar" class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">

                <i class="fa fa-bell-o"></i>
                <span class="badge bg-warning">3</span>
            </a>
            <ul class="dropdown-menu extended notification">
                <li>
                    <p>Notifications</p>
                </li>
                <li>
                    <div class="alert alert-info clearfix">
                        <span class="alert-icon"><i class="fa fa-bolt"></i></span>
                        <div class="noti-info">
                            <a href="#"> Server #1 overloaded.</a>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="alert alert-danger clearfix">
                        <span class="alert-icon"><i class="fa fa-bolt"></i></span>
                        <div class="noti-info">
                            <a href="#"> Server #2 overloaded.</a>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="alert alert-success clearfix">
                        <span class="alert-icon"><i class="fa fa-bolt"></i></span>
                        <div class="noti-info">
                            <a href="#"> Server #3 overloaded.</a>
                        </div>
                    </div>
                </li>

            </ul>
        </li>
        <!-- notification dropdown end -->
    </ul>
    <!--  notification end -->
</div>
<div class="top-nav clearfix">
    <!--search & user info start-->
    <ul class="nav pull-right top-menu">
        <li>
            <input type="text" class="form-control search" placeholder=" Search">
        </li>
        <!-- user login dropdown start-->
        <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <img alt="" src="images/avatar1_small.jpg">
                <span class="username">Melanie Bactasa</span>
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu extended logout">
                <li><a href="#"><i class=" fa fa-suitcase"></i>Profile</a></li>
                <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>
                <li><a href="login.php"><i class="fa fa-key"></i> Log Out</a></li>
            </ul>
        </li>
        <!-- user login dropdown end -->
        <li>
            <div class="toggle-right-box">
                <div class="fa fa-bars"></div>
            </div>
        </li>
    </ul>
    <!--search & user info end-->
</div>
</header>
<!--header end-->
<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
                <li>
                    <a href="index.php">
                        <i class="fa fa-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sub-menu">
                    <a class="active" href="profiling.php">
                        <i class="fa fa-users"></i>
                        <span>Profiling</span>
                    </a>
                </li>
                <li class="sub-menu">
                    <a href="counseling1.php">
                        <i class="fa fa-suitcase"></i>
                        <span>Counseling Services</span>
                    </a>
                   
                </li>
                <li>
                    <a href="filesanddocuments.php">
                        <i class="fa fa-book"></i>
                        <span>Files and Documents </span>
                    </a>
                </li>
                <li class="sub-menu">
                    <a href="reports.php">
                        <i class="fa fa-bar-chart-o"></i>
                        <span>Reports</span>
                    </a>
                </li>
                <li class="sub-menu">
                    <a href="sysconfig.php">
                        <i class="fa fa-cog"></i>
                        <span>System COnfiguration</span>
                    </a>
                </li>
            </ul>            </div>
        <!-- sidebar menu end-->
    </div>
</aside>

<!--sidebar end-->
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
        <div class="row">
            <div class="col-sm-12">
		   <!--Start of  Add Modal-->
           <section class="panel">
           <header class="panel-heading">
                        Student Information
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                         </span>
                    </header>
                    <div class="panel-body">
                        <div class="adv-table editable-table ">
                            <div class="clearfix">
                <div class="panel-body">     
                    <div class="JustifyLeft">
                        <div class="JustifyLeft">
                            <a href="#myModal" data-toggle="modal" class="btn btn-success"><i class =" fa fa-plus-square"></i>   Add New Student</a> <div class="col-sm-6">
                        </div>
                    </div>
                </div>
                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade" method="Post">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                <h4 class="modal-title">Add student</h4>
                            </div>
                            <div class="modal-body">
                                 <form role="form" action="StudentProfile.php" method="post">
								 <div class="form-group">
                                        <label>Student Registration Number</label>
                                        <input type="text" class="form-control" placeholder="Student Number" name="stud_num">
                                    </div>
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <input type="text" class="form-control" placeholder="Full Name" name="f_name">
                                    </div>
									<label>Courses</label>
									<select class="form-control" style="width: 500px" id="source" name = "courses">
									<option value="BBA">BBA</option>
                                            <option value="BBIT">BBIT</option>
                                            <option value="BIT">BIT</option>
											<option value="EEE">EEE</option>
                                            <option value="BsCS">BsCS</option>
											<option value="BsCE">BsCE </option>
									</select>
									
									<label>Year Level</label>
									<select class="form-control" style="width: 100px" id="source" name = "yer_lvl">
									<option value="1">1st year</option>
                                    <option value="2">2nd year</option>
									<option value="3">3rd year</option>
                                    <option value="4">4th year</option>
									</select>
									<label>Gender</label>
									<select class="form-control" style="width: 300px" id="source" name = "gender">
									<option value="Male">Male</option>
                                    <option value="Female">Female</option>
									</select>
									<div>
								<div class="form-group">
                                        <label>Email</label>
                                        <input type="text" class="form-control" placeholder="Email" name="email">
                                    </div>
									<div class="form-group">
                                        <label>Contact Number</label>
                                        <input type="text" class="form-control" placeholder="Contact Number" name="Number">
                                    </div>
								<div class="form-group">
								<label>Birthday:</label>
								<input type="date" name="bday">
								</div>
								<div class="form-group">
                                        <label>BirthPalce</label>
                                        <input type="text" class="form-control" placeholder="BirthPalce" name="Birth_Palce">
                                    </div>
								<div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control" placeholder="Address" name="Address">
                                    </div>
									<div>
								<label>Status</label>
									<select class="form-control" style="width: 250px" name = "status">
									<option value="Regular">Active</option>
                                    <option value="Irregular">Inactive</option>
									<option value="Alumni">Alumni</option>
								</select>
								</div>								
								<?php
                                $mysqli = new mysqli("localhost", "root", "", "imsdb");
                                

                                if($mysqli === false){
                                    die("ERROR: Could not connect. " . $mysqli->connect_error);
                                }
                                

                                if(isset($_POST['add']))
                                {
                                $StudentNum = $mysqli->real_escape_string($_REQUEST['stud_num']);
                                $FirstName = $mysqli->real_escape_string($_REQUEST['f_name']);
                                $Courses = $mysqli->real_escape_string($_REQUEST['courses']);
                                $YearLevel = $mysqli->real_escape_string($_REQUEST['yer_lvl']);
                                $Gender= $mysqli->real_escape_string($_REQUEST['gender']);
                                $Email= $mysqli->real_escape_string($_REQUEST['email']);
                                $Number= $mysqli->real_escape_string($_REQUEST['Number']);
                                $bdy= $mysqli->real_escape_string($_REQUEST['bday']);
                                $BirthPalce= $mysqli->real_escape_string($_REQUEST['Birth_Palce']);
                                $Address= $mysqli->real_escape_string($_REQUEST['Address']);
                                $Conbday = date("Y-M-D",strtotime($bdy));
                                $status= $mysqli->real_escape_string($_REQUEST['status']);

                                

                                $sql = "INSERT INTO `stud_profile`(`stud_regNo`, `stud_fullname`, `stud_course`, `stud_yrlevel`,  `stud_gender`, `stud_email`, `stud_mobileNo`, `stud_birth_date`, `stud_birthplace`, `stud_address`, `stud_display_status` ) 
                                VALUES ('$StudentNum' ,'$FirstName','$Courses','$YearLevel','$Gender','$Email','$Number','$Conbday','$BirthPalce','$Address','$status')";
                                if($mysqli->query($sql) === true){
                                    echo "<script type='text/javascript'>alert('submitted successfully!')</script>";
                                } else{
                                    echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
                                }
                                }

                                $mysqli->close();
                                ?>
                                <button type="submit" class="btn btn-default" name="add">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
				</div>
                <!--end of  add modal-->
        <!-- page start-->
			<?php $db = mysqli_connect("localhost", "root", "", "imsdb");
 
					$results = mysqli_query($db, "  SELECT `stud_Id`, `stud_regNo`, `stud_fullname`, `stud_course`, `stud_yrlevel`, 
                                                         `stud_gender`, `stud_email`, `stud_mobileNo`, `stud_birth_date`, `stud_birthplace`, 
                                                        `stud_address`, `stud_display_status` FROM `stud_profile` WHERE 'stud_display_status' != 'Inactive'"); ?>
						
			<div class="panel-body">
                 <section id="unseen">
                     <table class="table table-striped table-hover table-bordered" id="editable-sample" >
                        <thead>
                            <tr>
                                <th>Student Number</th>
                                <th>First Name</th>
                                <th>Courses</th>
                                <th>Year Level</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
	
                        <?php while ($row = mysqli_fetch_array($results)) { ?>
                            <tbody id="studenttbl">
                            <tr>
                                <td class="hide"><?php echo $row['stud_Id']; ?></td>
                                <td><?php echo $row['stud_regNo']; ?></td>
                                <td><?php echo $row['stud_fullname']; ?></td>
                                <td><?php echo $row['stud_course']; ?></td>
                                <td><?php echo $row['stud_yrlevel']; ?></td>
                                <td>
                                <a href="StudentProfile.php?edit=<?php echo $row['stud_Id']; ?>" class="edit_btn"><i class = "fa fa-pencil"></i></a>
                                </td>
                                <td>
                                    <a href="StudentProfile.php?del=<?php echo $row['stud_Id']; ?>" class="del_btn"><i class="fa  fa-trash-o"></i></a>
                                </td>	
                            </tr>
                        <?php }?>
	                    </tbody>
                    </table>

        <?php 

	    if (isset($_REQUEST['edit'])) {
                $id = $_REQUEST['edit'];
                $update = true;
                $record = mysqli_query($db, "SELECT  `stud_regNo`, `stud_fullname`, `stud_yrlevel` FROM `stud_profile` 
                                            WHERE `stud_Id` = '$id'");
                
                
                $fetchRow = mysqli_fetch_assoc($record);
                $studno = $fetchRow['stud_regNo'];
                $studfname = $fetchRow['stud_fullname'];
                $studyrlvl = $fetchRow['stud_yrlevel'];

                
                
                echo"<h3>Edit Post</h3>
                <form action='StudentProfile.php' method='post' class='col-sm-6'>
                    <div >
                    <label>Student Number</label>
                    <input type='text' name='stud_regNo'  value='$studno' class='form-control'>
                    </div>
                    <div>
                    <label>First Name</label>
                    <input type='text' name='first_name'  value='$studfname' class='form-control'>
                    </div>
                    <div>
                    <label>Year Level</label>
                    <input type='text' name='year_level'  value='$studyrlvl' class='form-control'>
                    </div>
                    </div>
                    
                    
                    <button type='submit' name='update'>Submit</button>
                </form>
        </div> ";

	  }
                $mysqli = new mysqli("localhost", "root", "", "imsdb");
                

                if($mysqli === false){
                    die("ERROR: Could not connect. " . $mysqli->connect_error);
                }	
                if(isset($_POST['update']))
                {
                $Studentid = $mysqli->real_escape_string($_REQUEST['stud_Id']);
                $StudentNum = $mysqli->real_escape_string($_REQUEST['stud_regNo']);
                $FullName = $mysqli->real_escape_string($_REQUEST['fname']);
                //$MiddleName = $mysqli->real_escape_string($_REQUEST['middle_mname']);
                //$LastName = $mysqli->real_escape_string($_REQUEST['last_name']);


                $sql = "UPDATE `stud_profile` SET `stud_regNo`= '$StudentNum',`stud_fullname`= '$FullName' WHERE `stud_Id` = '$Studentid'";
                if($mysqli->query($sql) === true)
                {
                    echo "<script type='text/javascript'>alert('submitted successfully!')</script>";
                } else{
                    echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
                }
                }
                if (isset($_REQUEST['del']))
                {
                    
                $id = $_REQUEST['del'];
                $sql= "UPDATE `stud_profile` SET `stud_display_status` = 'archived' WHERE `stud_Id` = '$id'";
                if($mysqli->query($sql) === true)
                {
                    echo "<script type='text/javascript'>alert('submitted successfully!')</script>";
                } 
                else{
                    echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
                }
                }

                $mysqli->close();
                    
                ?>



<!--Start of  Edit Modal-->

		<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModaledit" class="modal fade" method="Post">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                             <div class="container">
	
													
								<button type="submit" class="btn btn-default" name="update">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
				</div>




  <!--end of  Edit modal-->                                   
        <!-- page end-->
		</section>
        </section>
    </section>
    <!--main content end-->
<!--right sidebar start-->
<div class="right-sidebar">
<div class="search-row">
    <input type="text" placeholder="Search" class="form-control">
</div>
<div class="right-stat-bar">
<ul class="right-side-accordion">
<li class="widget-collapsible">
    <a href="#" class="head widget-head red-bg active clearfix">
        <span class="pull-left">work progress (5)</span>
        <span class="pull-right widget-collapse"><i class="ico-minus"></i></span>
    </a>
    <ul class="widget-container">
        <li>
            <div class="prog-row side-mini-stat clearfix">
                <div class="side-graph-info">
                    <h4>Target sell</h4>
                    <p>
                        25%, Deadline 12 june 13
                    </p>
                </div>
                <div class="side-mini-graph">
                    <div class="target-sell">
                    </div>
                </div>
            </div>
            <div class="prog-row side-mini-stat">
                <div class="side-graph-info">
                    <h4>product delivery</h4>
                    <p>
                        55%, Deadline 12 june 13
                    </p>
                </div>
                <div class="side-mini-graph">
                    <div class="p-delivery">
                        <div class="sparkline" data-type="bar" data-resize="true" data-height="30" data-width="90%" data-bar-color="#39b7ab" data-bar-width="5" data-data="[200,135,667,333,526,996,564,123,890,564,455]">
                        </div>
                    </div>
                </div>
            </div>
            <div class="prog-row side-mini-stat">
                <div class="side-graph-info payment-info">
                    <h4>payment collection</h4>
                    <p>
                        25%, Deadline 12 june 13
                    </p>
                </div>
                <div class="side-mini-graph">
                    <div class="p-collection">
						<span class="pc-epie-chart" data-percent="45">
						<span class="percent"></span>
						</span>
                    </div>
                </div>
            </div>
            <div class="prog-row side-mini-stat">
                <div class="side-graph-info">
                    <h4>delivery pending</h4>
                    <p>
                        44%, Deadline 12 june 13
                    </p>
                </div>
                <div class="side-mini-graph">
                    <div class="d-pending">
                    </div>
                </div>
            </div>
            <div class="prog-row side-mini-stat">
                <div class="col-md-12">
                    <h4>total progress</h4>
                    <p>
                        50%, Deadline 12 june 13
                    </p>
                    <div class="progress progress-xs mtop10">
                        <div style="width: 50%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="20" role="progressbar" class="progress-bar progress-bar-info">
                            <span class="sr-only">50% Complete</span>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</li>
<li class="widget-collapsible">
    <a href="#" class="head widget-head terques-bg active clearfix">
        <span class="pull-left">contact online (5)</span>
        <span class="pull-right widget-collapse"><i class="ico-minus"></i></span>
    </a>
    <ul class="widget-container">
        <li>
            <div class="prog-row">
                <div class="user-thumb">
                    <a href="#"><img src="images/avatar1_small.jpg" alt=""></a>
                </div>
                <div class="user-details">
                    <h4><a href="#">Jonathan Smith</a></h4>
                    <p>
                        Work for fun
                    </p>
                </div>
                <div class="user-status text-danger">
                    <i class="fa fa-comments-o"></i>
                </div>
            </div>
            <div class="prog-row">
                <div class="user-thumb">
                    <a href="#"><img src="images/avatar1.jpg" alt=""></a>
                </div>
                <div class="user-details">
                    <h4><a href="#">Anjelina Joe</a></h4>
                    <p>
                        Available
                    </p>
                </div>
                <div class="user-status text-success">
                    <i class="fa fa-comments-o"></i>
                </div>
            </div>
            <div class="prog-row">
                <div class="user-thumb">
                    <a href="#"><img src="images/chat-avatar2.jpg" alt=""></a>
                </div>
                <div class="user-details">
                    <h4><a href="#">John Doe</a></h4>
                    <p>
                        Away from Desk
                    </p>
                </div>
                <div class="user-status text-warning">
                    <i class="fa fa-comments-o"></i>
                </div>
            </div>
            <div class="prog-row">
                <div class="user-thumb">
                    <a href="#"><img src="images/avatar1_small.jpg" alt=""></a>
                </div>
                <div class="user-details">
                    <h4><a href="#">Mark Henry</a></h4>
                    <p>
                        working
                    </p>
                </div>
                <div class="user-status text-info">
                    <i class="fa fa-comments-o"></i>
                </div>
            </div>
            <div class="prog-row">
                <div class="user-thumb">
                    <a href="#"><img src="images/avatar1.jpg" alt=""></a>
                </div>
                <div class="user-details">
                    <h4><a href="#">Shila Jones</a></h4>
                    <p>
                        Work for fun
                    </p>
                </div>
                <div class="user-status text-danger">
                    <i class="fa fa-comments-o"></i>
                </div>
            </div>
            <p class="text-center">
                <a href="#" class="view-btn">View all Contacts</a>
            </p>
        </li>
    </ul>
</li>
<li class="widget-collapsible">
    <a href="#" class="head widget-head purple-bg active">
        <span class="pull-left"> recent activity (3)</span>
        <span class="pull-right widget-collapse"><i class="ico-minus"></i></span>
    </a>
    <ul class="widget-container">
        <li>
            <div class="prog-row">
                <div class="user-thumb rsn-activity">
                    <i class="fa fa-clock-o"></i>
                </div>
                <div class="rsn-details ">
                    <p class="text-muted">
                        just now
                    </p>
                    <p>
                        <a href="#">Jim Doe </a>Purchased new equipments for zonal office setup
                    </p>
                </div>
            </div>
            <div class="prog-row">
                <div class="user-thumb rsn-activity">
                    <i class="fa fa-clock-o"></i>
                </div>
                <div class="rsn-details ">
                    <p class="text-muted">
                        2 min ago
                    </p>
                    <p>
                        <a href="#">Jane Doe </a>Purchased new equipments for zonal office setup
                    </p>
                </div>
            </div>
            <div class="prog-row">
                <div class="user-thumb rsn-activity">
                    <i class="fa fa-clock-o"></i>
                </div>
                <div class="rsn-details ">
                    <p class="text-muted">
                        1 day ago
                    </p>
                    <p>
                        <a href="#">Jim Doe </a>Purchased new equipments for zonal office setup
                    </p>
                </div>
            </div>
        </li>
    </ul>
</li>
<li class="widget-collapsible">
    <a href="#" class="head widget-head yellow-bg active">
        <span class="pull-left"> shipment status</span>
        <span class="pull-right widget-collapse"><i class="ico-minus"></i></span>
    </a>
    <ul class="widget-container">
        <li>
            <div class="col-md-12">
                <div class="prog-row">
                    <p>
                        Full sleeve baby wear (SL: 17665)
                    </p>
                    <div class="progress progress-xs mtop10">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                            <span class="sr-only">40% Complete</span>
                        </div>
                    </div>
                </div>
                <div class="prog-row">
                    <p>
                        Full sleeve baby wear (SL: 17665)
                    </p>
                    <div class="progress progress-xs mtop10">
                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 70%">
                            <span class="sr-only">70% Completed</span>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</li>
</ul>
</div>
</div>
<!--right sidebar end-->
</section>
    <!-- Placed js at the end of the document so the pages load faster -->
    <!--Core js-->
<script src="js/jquery.js"></script>
<script src="js/jquery-1.8.3.min.js"></script>
<script src="bs3/js/bootstrap.min.js"></script>
<script src="js/jquery-ui-1.9.2.custom.min.js"></script>
<script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
<script src="js/jquery.scrollTo.min.js"></script>
<script src="js/easypiechart/jquery.easypiechart.js"></script>
<script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
<script src="js/jquery.nicescroll.js"></script>
<script src="js/jquery.nicescroll.js"></script>

<script src="js/bootstrap-switch.js"></script>

<script type="text/javascript" src="js/fuelux/js/spinner.min.js"></script>
<script type="text/javascript" src="js/bootstrap-fileupload/bootstrap-fileupload.js"></script>

<script type="text/javascript" src="js/jquery-multi-select/js/jquery.quicksearch.js"></script>

<script type="text/javascript" src="js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>

<script src="js/jquery-tags-input/jquery.tagsinput.js"></script>

<script src="js/select2/select2.js"></script>
<script src="js/select-init.js"></script>


<!--common script init for all pages-->
<script src="js/scripts.js"></script>

<script src="js/toggle-init.js"></script>

<script src="js/advanced-form.js"></script>
<!--Easy Pie Chart-->
<script src="js/easypiechart/jquery.easypiechart.js"></script>
<!--Sparkline Chart-->
<script src="js/sparkline/jquery.sparkline.js"></script>
<!--jQuery Flot Chart-->
<script src="js/flot-chart/jquery.flot.js"></script>
<script src="js/flot-chart/jquery.flot.tooltip.min.js"></script>
<script src="js/flot-chart/jquery.flot.resize.js"></script>
<script src="js/flot-chart/jquery.flot.pie.resize.js"></script>


</body>
</html>
