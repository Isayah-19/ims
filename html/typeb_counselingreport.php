<!DOCTYPE html>

<?php
    session_start();
    if (!$_SESSION['Logged_In']) {
        header('Location:login.php');
        exit;
    }
    include("config.php");
// Filter function
$acadOpt = '';
$semOpt = '';
$monthOpt = '';
$dayOpt = '';
$courseOpt = '';
$visitOpt = '';

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$indivTab = '';
$groupTab = '';
$visitTab = '';

if (isset($_POST['indivFilter'])) {
    $acadOpt = $_POST['acadOpt'];
    $semOpt = $_POST['semOpt'];
    $monthOpt = $_POST['monthOpt'];
    $dayOpt = $_POST['dayOpt'];
    $courseOpt = $_POST['courseOpt'];

    $actualQuery = "SELECT
  `c`.`couns_code` AS `COUNSELING_CODE`,
  DATE_FORMAT(`c`.`couns_date`, '%W %M %d %Y') AS `COUNSELING_DATE`,
  `c`.`counseling_type` AS `COUNSELING_TYPE`,
  `c`.`couns_appmnType` AS `APPOINTMENT_TYPE`,
  `s`.`stud_regNo` AS `STUD_NO`,
  `s`.`stud_fullname` AS `stud_name`,
  CONCAT(
    `s`.`stud_course`,
    ' ',
    `s`.`stud_yrlevel`
  ) AS `COURSE`,
  (
    SELECT
      GROUP_CONCAT(`a`.`couns_appr` SEPARATOR ', ')
    FROM
      `couns_approach` `a`
    WHERE
      (
        `a`.`appr_id` = `c`.`apprcode`
      )
  ) AS `COUNSELING_APPROACH`,
  `c`.`couns_background` AS `COUNSELING_BG`,
  `c`.`couns_goals` AS `GOALS`,
  `c`.`couns_comment` AS `COUNS_COMMENT`,
  `c`.`couns_recommendation` AS `RECOMMENDATION`
FROM
  `counseling` `c`
  
  JOIN `stud_profile` `s` ON `s`.`stud_regNo` = `c`.`stud_regNo`
  JOIN `courses` `cr` ON `s`.`stud_course` = `cr`.`course_code`
  JOIN `semester` sem ON `c`.`couns_sem` = `sem`.`sem_name`";

    $conditions = array();

    if ($acadOpt != 'All') {
        $conditions[] = "cr.course_curyr = '$acadOpt'";
    }

    if ($semOpt != 'All') {
        $conditions[] = "c.couns_sem =  '$semOpt'";
    }

    if ($monthOpt != 'All') {
        $conditions[] = "MONTH(c.couns_date) = '$monthOpt'";
    }

    if ($dayOpt != 'All') {
        $conditions[] = "DAY(c.couns_date) = '$dayOpt'";
    }

    if ($courseOpt != 'All') {
        $conditions[] = "s.stud_course = '$courseOpt'";
    }

    $query = $actualQuery;
    if (count($conditions)>0) {
        $query .= " WHERE ". implode(' AND ', $conditions) ." ORDER BY `c`.`couns_date` DESC"  ;
    }

    $resultIndiv = mysqli_query($db, $query);
    $indivTab = 'active';
} else {
    $actualQuery = "SELECT
    `c`.`couns_code` AS `COUNSELING_CODE`,
    DATE_FORMAT(`c`.`couns_date`, '%W %M %d %Y') AS `COUNSELING_DATE`,
    `c`.`counseling_type` AS `COUNSELING_TYPE`,
    `c`.`couns_appmnType` AS `APPOINTMENT_TYPE`,
    `s`.`stud_regNo` AS `STUD_NO`,
  `s`.`stud_fullname` AS `stud_name`,
  CONCAT(
    `s`.`stud_course`,
    ' ',
    `s`.`stud_yrlevel`
  ) AS `COURSE`,
  (
    SELECT
      GROUP_CONCAT(`a`.`couns_appr` SEPARATOR ', ')
    FROM
      `couns_approach` `a`
    WHERE
      (
        `a`.`appr_id` = `c`.`apprcode`
      )
  ) AS `COUNSELING_APPROACH`,
  `c`.`couns_background` AS `COUNSELING_BG`,
  `c`.`couns_goals` AS `GOALS`,
  `c`.`couns_comment` AS `COUNS_COMMENT`,
  `c`.`couns_recommendation` AS `RECOMMENDATION`
FROM
  `counseling` `c`
  
  JOIN `stud_profile` `s` ON `s`.`stud_regNo` = `c`.`stud_regNo`
  JOIN `courses` `cr` ON `s`.`stud_course` = `cr`.`course_code`
  JOIN `semester` sem ON `c`.`couns_sem` = `sem`.`sem_name` ORDER BY `c`.`couns_date` DESC";

    $resultIndiv = mysqli_query($db, $actualQuery);
    $indivTab = 'active';
}

if (isset($_POST['groupFilter'])) {
    $acadOpt = $_POST['acadOpt'];
    $semOpt = $_POST['semOpt'];
    $monthOpt = $_POST['monthOpt'];
    $dayOpt = $_POST['dayOpt'];

    $actualQuery = "";
    
    $conditions = array();


    if ($acadOpt != 'All') {
        $conditions[] = "cr.course_curyr = '$acadOpt'";
    }

    if ($semOpt != 'All') {
        $conditions[] = "c.couns_sem =  '$semOpt'";
    }

    if ($monthOpt != 'All') {
        $conditions[] = "MONTH(c.couns_date) = '$monthOpt'";
    }

    if ($dayOpt != 'All') {
        $conditions[] = "DAY(c.couns_date) = '$dayOpt'";
    }

    if ($courseOpt != 'All') {
        $conditions[] = "s.stud_course = '$courseOpt'";
    }

    $query = $actualQuery;
    if (count($conditions)>0) {
        $query .= " WHERE ". implode(' AND ', $conditions) ." ORDER BY `c`.`couns_date` DESC"  ;
    }

    $resultGroup = mysqli_query($db, $actualQuery);
    $groupTab = 'active';
    $indivTab ='';
} else {
    $actualQuery = "";
    //$resultIndiv = mysqli_query($db, $actualQuery);
}

if (isset($_POST['visitFilter'])) {
    $visitOpt = $_POST['visitOpt'];
    $acadOpt = $_POST['acadOpt'];
    $semOpt = $_POST['semOpt'];
    $monthOpt = $_POST['monthOpt'];
    $dayOpt = $_POST['dayOpt'];
    $courseOpt = $_POST['courseOpt'];

    $actualQuery = " SELECT
  `v`.`visitcode` AS `visitcode`,
  `v`.`visitdate` AS `visitdate`,
  `s`.`stud_regNo` AS `Stud_NO`,
 `s`.`stud_fullname` AS `STUDENT`,
 CONCAT(
    `s`.`stud_course`,
    ' ',
    `s`.`stud_yrlevel`
  ) AS `COURSE`,
  `v`.`visit_purpose` AS `visit_purpose`,
  `v`.`visit_details` AS `visit_details`
FROM
`stud_visit` `v`
    JOIN `stud_profile` `s` ON `s`.`stud_regNo` = `v`.`stud_regno`
    JOIN `semester` `sem` ON `v`.`Visit_SEMESTER` = `sem`.`sem_name`
    JOIN `batch_details` `btch` ON `v`.`Visit_ACADEMIC_YEAR` = `btch`.`batch_yr` ";


    $conditions = array();

    if ($visitOpt != 'All'){
        $conditions[] = "v.visit_purpose = '$visitOpt'";
    }

    if ($acadOpt != 'All') {
        $conditions[] = "btch.batch_yr = '$acadOpt'";
    }

    if ($semOpt != 'All') {
        $conditions[] = "sem.sem_name =  '$semOpt'";
    }

    if ($monthOpt != 'All') {
        $conditions[] = "MONTH(v.visitdate) = '$monthOpt'";
    }

    if ($dayOpt != 'All') {
        $conditions[] = "DAY(v.visitdate) = '$dayOpt'";
    }

    if ($courseOpt != 'All') {
        $conditions[] = "s.stud_course = '$courseOpt'";
    }

    $query = $actualQuery;
    if (count($conditions)>0) {
        $query .= " WHERE ". implode(' AND ', $conditions) ." ORDER BY `v`.`visitdate` DESC"  ;
    }

    $resultVisit = mysqli_query($db,$query);
    $visitTab = 'active';
    $indivTab = '';
} else {
    $actualQuery = "SELECT
  `v`.`visitcode` AS `visitcode`,
  `v`.`visitdate` AS `visitdate`,
  `s`.`stud_regNo` AS `Stud_NO`,
  `s`.`stud_fullname` AS `stud_name`,
  CONCAT(
    `s`.`stud_course`,
    ' ',
    `s`.`stud_yrlevel`
  ) AS `COURSE`,
  `v`.`visit_purpose` AS `visit_purpose`,
  `v`.`visit_details` AS `visit_details`
FROM
  (
    `stud_visit` `v`
    JOIN `stud_profile` `s` ON ((`s`.`stud_regNo` = `v`.`stud_regno`))
  )
ORDER BY
  `v`.`visitdate` DESC ";
  $resultVisit = mysqli_query($db, $actualQuery);
}
//Data for select input
$sqlAY = mysqli_query($db, "SELECT batchId,batch_yr FROM `imsdb`.`batch_details` WHERE batch_display_stat = 'Active' ");
$optionAY = '';
while ($row = mysqli_fetch_assoc($sqlAY)) {
    $optionAY .='<option value = "'.$row['batch_yr'].'">'.$row['batch_yr'].'</option>';
}

$sqlSem = mysqli_query($db, "SELECT sem_id, sem_name FROM `semester` WHERE sem_display_stat = 'Active' ");
$optionSem = '';
while ($row = mysqli_fetch_assoc($sqlSem)) {
    $optionSem .='<option value = "'.$row['sem_name'].'">'.$row['sem_name'].'</option>';
}

$sqlCourse = mysqli_query($db, "SELECT course_id, course_code FROM `courses` WHERE course_display_stat = 'Active' ");
$optionCourse = '';
while ($row = mysqli_fetch_assoc($sqlCourse)) {
    $optionCourse .='<option value = "'.$row['course_code'].'">'.$row['course_code'].'</option>';
}

$sqlVisit = mysqli_query($db, "SELECT visit_type FROM visit WHERE visitype_stat = 'Active'");
$optionVisit = '';
while ($row = mysqli_fetch_assoc($sqlVisit)) {
    $optionVisit .='<option value="'.$row['visit_type'].'">'.$row['visit_type'].'</option>';
}
?>
<html lang="en">

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="images/favicon.png">

    <title>DeKUT-IMS-Reports</title>

    <!--Core CSS -->
    <link href="bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />

    <link href="css/reset.css" rel="stylesheet" type="text/css">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>-->

    <!--dynamic table-->
    <link href="js/advanced-datatable/css/demo_page.css" rel="stylesheet" />
    <link href="js/advanced-datatable/css/demo_table.css" rel="stylesheet" />
    <link rel="stylesheet" href="js/data-tables/DT_bootstrap.css" />
    <link rel="stylesheet" href="css/jquery.steps.css?1">

    <!-- Custom styles for this template -->
    <link href="css/style-responsive.css" rel="stylesheet" />

</head>

<body>
    <?php
$currentPage ='DeKUT-IMS-Reports';
include('header.php');
include('TypeB_SideBar.php');
?>
    <!--sidebar end-->
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumbs-alt">
                        <li>
                            <a href="#">
                                <i class="fa fa-home"></i> Home</a>
                        </li>
                        <li>
                            <a class="current" href="#">
                                <i class="fa fa-bar-chart-o"></i> Reports</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading tab-bg-dark-navy-blue ">
                            <ul class="nav nav-tabs">
                                <li class="<?php echo $indivTab;?>">
                                    <a data-toggle="tab" href="#Indiv">Individual Counsel</a>
                                </li>
                                <li class="<?php echo $groupTab; ?>">
                                    <a data-toggle="tab" href="#Grouped">Group Counsel</a>
                                </li>
                                <li class="<?php echo $visitTab; ?>">
                                    <a data-toggle="tab" href="#Visits">Visit Reports</a>
                                </li>
                            </ul>
                        </header>
                        <div class="panel-body">
                            <div class="tab-content">
                                <div id="Indiv" class="tab-pane <?php echo $indivTab;?>">
                                    <div class="col-lg-12" style="padding-left:0px">
                                        <form action="counselingreport.php" method="POST">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <select name="acadOpt" class="form-control input-sm m-bot4" placeholder="Academic Year">
                                                        <option value="All" selected>--Select Academic Year--</option>
                                                        <?php echo $optionAY; ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <select name="semOpt" class="form-control input-sm m-bot4" placeholder="Semester">
                                                        <option value="All">--Select Semester--</option>
                                                        <?php echo $optionSem; ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <select name="monthOpt" class="form-control input-sm m-bot4" placeholder="Month">
                                                        <option value="All">--Select Month--</option>
                                                        <?php for ($m=1; $m<=12; ++$m) {
    $month_label = date('F', mktime(0, 0, 0, $m, 1)); ?>
                                                        <option value="<?php echo $m; ?>">
                                                            <?php echo $month_label; ?>
                                                        </option>
                                                        <?php
} ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <select name="dayOpt" class="form-control input-sm m-bot4" placeholder="Day">
                                                        <option value="All">--Select Date--</option>
                                                        <?php 
          $start_date = 1;
          $end_date   = 31;
          for ($j=$start_date; $j<=$end_date; $j++) {
              echo '<option value='.$j.'>'.$j.'</option>';
          }
        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <select name="courseOpt" class="form-control input-sm m-bot4" placeholder="Programme/Course">
                                                        <option value="All">--Select Programme/Course--</option>
                                                        <?php echo $optionCourse; ?>
                                                    </select>
                                                </div>
                                            </div>
                                    </div>
                                    <br>
                                    </br>
                                    <button class="btn btn-info btn-sm" type="submit" name="indivFilter">
                                        <i class="fa fa-search"></i>
                                        Search
                                    </button>
                                    </form>
                                    &nbsp
                                    <button class="btn btn-sm btn-success" onclick="location.href='print_record_all.php?view=set&acadOpt=<?php echo $acadOpt; ?>&semOpt=<?php echo $semOpt; ?>&monthOpt=<?php echo $monthOpt; ?>&dayOpt=<?php echo $dayOpt; ?>&courseOpt=<?php echo $courseOpt;?>'">
                                        <i class="fa fa-print"></i> Print</button>
                                    <br></br>
                                    <section id="unseen">
                                        <table class=" display table table-bordered table-striped table-condensed" id="dynamic-table">
                                            <thead>
                                                <tr>
                                                    <th hidden>Couseling ID</th>
                                                    <th>Student Number</th>
                                                    <th>Student Name</th>
                                                    <th>Date</th>
                                                    <th id="thview">View</th>
                                                </tr>
                                            </thead>
                                            <!-- page start-->
                                            <?php while ($row = mysqli_fetch_array($resultIndiv)) {
            ?>
                                            <tbody>
                                                <tr>
                                                    <td hidden>
                                                        <?php echo $row['COUNSELING_CODE']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['STUD_NO']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['stud_name']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['COUNSELING_DATE']; ?>
                                                    </td>

                                                    <td>
                                                        <a href="counseling_report_review.php?view=<?php echo $row['COUNSELING_CODE']; ?>"
                                                            id="viewbutton" type="button" class="btn btn-success">
                                                            <i class="fa fa-eye"></i> View</a>
                                                    </td>
                                                </tr>
                                                <?php
        }?>
                                            </tbody>
                                        </table>
                                        <!-- page end-->
                                    </section>
                                </div>
                                <div id="Grouped" class="tab-pane <?php echo $groupTab;?>">
                                <p class="text-muted">
                                    Working In Progress, Please be patient for final release.
                                </p>
                                <div class="progress progress-striped active progress-sm">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
                                        <span class="sr-only">53% Complete</span>
                                    </div>
                                </div>
                                <div class="hide">
                                    <div class="col-lg-12" style="padding-left:0px">
                                        <form action="counselingreport.php" method="POST">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <select name="AOption" class="form-control input-sm m-bot4" placeholder="Academic Year">
                                                        <option value="">--Select Academic Year--</option>
                                                        <?php echo $optionAY; ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <select name="SemOption" class="form-control input-sm m-bot4" placeholder="Semester">
                                                        <option value="">--Select Semester--</option>
                                                        <?php echo $optionSem; ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <select name="MonthOpt" class="form-control input-sm m-bot4" placeholder="Month">
                                                        <option value="">--Select Month--</option>
                                                        <?php for ($m=1; $m<=12; ++$m) {
            $month_label = date('F', mktime(0, 0, 0, $m, 1)); ?>
                                                        <option value="<?php echo $m; ?>">
                                                            <?php echo $month_label; ?>
                                                        </option>
                                                        <?php
        } ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <select name="DayOpt" class="form-control input-sm m-bot4" placeholder="Day">
                                                        <option value="">--Select Date--</option>
                                                        <?php 
          $start_date = 1;
          $end_date   = 31;
          for ($j=$start_date; $j<=$end_date; $j++) {
              echo '<option value='.$j.'>'.$j.'</option>';
          }
        ?>
                                                    </select>
                                                </div>

                                            </div>
                                    </div>
                                    </br>
                                    </br>
                                    <button class="btn btn-info btn-sm" name="groupFilter">
                                        <i class="fa fa-search"></i> Search</button>
                                    </form>
                                    &nbsp
                                    <button class="btn btn-sm btn-success" onclick="location.href='print_record_all.php?view=set&acadOpt=<?php echo $acadOpt; ?>&semOpt=<?php echo $semOpt; ?>&monthOpt=<?php echo $monthOpt; ?>&dayOpt=<?php echo $dayOpt; ?>&courseOpt=<?php echo $courseOpt;?>'">
                                        <i class="fa fa-print"></i> Print</button>
                                    </br>
                                    </br>
                                    <section id="unseen">
                                        <table class=" display table table-bordered table-striped table-condensed" id="dynamic-table">
                                            <thead>
                                                <tr>
                                                    <th hidden>Couseling ID</th>
                                                    <th>Student Number</th>
                                                    <th>Name of Students</th>
                                                    <th>Date</th>
                                                    <th id="thview">View</th>
                                                </tr>
                                            </thead>
                                            <!-- page start-->

                                            <?php while ($row = mysqli_fetch_array($result)) {
            ?>
                                            <tbody>
                                                <tr>
                                                    <td hidden>
                                                        <?php echo $row['COUNSELING_CODE']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['STUD_NO']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['stud_name']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['COUNSELING_DATE']; ?>
                                                    </td>

                                                    <td>
                                                        <a href="counseling_report_review.php?view=<?php echo $row['COUNSELING_CODE']; ?>"
                                                            id="viewbutton" type="button" class="btn btn-success">
                                                            <i class="fa fa-eye"></i> View</a>
                                                    </td>
                                                </tr>
                                                <?php
        }?>
                                            </tbody>
                                        </table>
                                        <!-- page end-->
                                    </section>
                                    </div>
                                </div>
                                <div id="Visits" class="tab-pane <?php echo $visitTab;?>">

                                    <div class="col-lg-12 " style="padding-left:0px">
                                        <form action="counselingreport.php" method="POST">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <select name="visitOpt" class="form-control input-sm m-bot4">
                                                        <option value="All">All Records</option>
                                                        <?php echo $optionVisit; ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <select name="acadOpt" class="form-control input-sm m-bot4" placeholder="Academic Year">
                                                        <option value="All" selected>All Academic Years</option>
                                                        <?php echo $optionAY; ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <select name="semOpt" class="form-control input-sm m-bot4" placeholder="Semester">
                                                        <option value="All">All Semesters</option>
                                                        <?php echo $optionSem; ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <select name="monthOpt" class="form-control input-sm m-bot4" placeholder="Month">
                                                        <option value="All">All Months</option>
                                                        <?php for ($m=1; $m<=12; ++$m) {
            $month_label = date('F', mktime(0, 0, 0, $m, 1)); ?>
                                                        <option value="<?php echo $m; ?>">
                                                            <?php echo $month_label; ?>
                                                        </option>
                                                        <?php
        } ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <select name="dayOpt" class="form-control input-sm m-bot4" placeholder="Day">
                                                        <option value="All">All Dates</option>
                                                        <?php 
          $start_date = 1;
          $end_date   = 31;
          for ($j=$start_date; $j<=$end_date; $j++) {
              echo '<option value='.$j.'>'.$j.'</option>';
          }
        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <select name="courseOpt" class="form-control input-sm m-bot4" placeholder="Programme/Course">
                                                        <option value="All">All Programme/Course</option>
                                                        <?php echo $optionCourse; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <br>
                                            <button class="btn btn-info btn-sm" name="visitFilter">
                                                <i class="fa fa-search"></i> Search</button>
                                        </form>
                                        </br>
                                        <button class="btn btn-sm btn-success" onclick="location.href='print_visit.php?view=set&visitOpt=<?php echo $visitOpt; ?>&acadOpt=<?php echo $acadOpt; ?>&semOpt=<?php echo $semOpt; ?>&monthOpt=<?php echo $monthOpt; ?>&dayOpt=<?php echo $dayOpt; ?>&courseOpt=<?php echo $courseOpt;?>'">
                                            <i class="fa fa-print"></i> Print</button>
                                            <br><br>
                                    </div>
                                    <br>
                                    <br>
                                    <br>
                                    <div class="adv-table">
                                        <table class="display table table-bordered table-striped" id="dynamic-table">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <strong>Visit Purpose</th>
                                                    <th>Student Number</th>
                                                    <th>Student Name</th>
                                                    <th>Course/Year/Section</th>
                                                    <th>Date and Time</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                while ($row = mysqli_fetch_assoc($resultVisit)) {?>
                                                <tr>
                                                    <td>
                                                        <strong>
                                                            <?php echo $row['visit_purpose']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['Stud_NO']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['STUDENT']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['COURSE']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['visitdate']; ?>
                                                    </td>
                                                </tr>
                                                <?php
                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                    </section>
                    </div>
                    </div>
                </div>

        </section>
        <!-- page start-->
    </section>
    <!--main content end-->
    </section>
    <?php include('footer.php'); ?>
    <!-- Placed js at the end of the document so the pages load faster -->

    <!--Core js-->
    <script src="js/jquery.js"></script>

    <script>
        $(document).ready(function() {

            function load_unseen_notification(view = '') {
                $.ajax({
                    url: "NotifLoad.php",
                    method: "POST",
                    data: {
                        view: view
                    },
                    dataType: "json",
                    success: function(data) {
                        $('.dropdown-menu').html(data.Notification);

                        if (data.NotificationCount > 0) {
                            $('.count').html(data.NotificationCount);
                        }
                    }
                });
            }

            load_unseen_notification();

            $(document).on('click', '.dropdown-toggle', function() {
                $('.count').html('');
                load_unseen_notification('read');
            });

            setInterval(function() {
                load_unseen_notification();
            }, 5000);

        });
    </script>
    <!--     <script src="bs3/js/bootstrap.min.js"></script> -->
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>

    <script src="js/jquery-steps/jquery.steps.js"></script>
    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

    <!--icheck init -->
    <script src="js/icheck-init.js"></script>

    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>
    <!--dynamic table-->
    <script type="text/javascript" language="javascript" src="js/advanced-datatable/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="js/data-tables/DT_bootstrap.js"></script>

    <!--dynamic table initialization -->
    <script src="js/dynamic_table_init.js"></script>


</body>

</html>