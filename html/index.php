<!DOCTYPE html>
<?php
    session_start();
    if(!$_SESSION['Logged_In'])
    {
        header('Location:login.php');
        exit;
    }
    include ("config.php");
    // session_destroy();
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="images/favicon.png">
    <title>DeKUT-IMS-Dashboard</title>
    <!--Core CSS -->
    <link rel="stylesheet" type="text/css" href="css/custom.css">
    <link href="bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jvectormap/2.0.5/jquery-jvectormap.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">
    <link href="css/clndr.css" rel="stylesheet">
    <!--clock css-->
    <link href="js/css3clock/css/style.css" rel="stylesheet">
    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="js/morris-chart/morris.css">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet"/>
    <!--external css-->
    <link rel="stylesheet" type="text/css" href="js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> 
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</head>
<body>
<!--
<script src="/IMS/html/Highcharts-6.0.7/highcharts.js"></script>
<script src="/IMS/html/Highcharts-6.0.7/data.js"></script>
<script src="/IMS/html/Highcharts-6.0.7/drilldown.js"></script>-->


<?php 
$currentPage ='DeKUT-IMS-Dasboard';
include('header.php');
include('sidebarnav.php');
?>

         
<section id="main-content">
    <section class="wrapper">

        <div class="col-lg-6">
            <div class="mini-stat clearfix tar">
                <span class="mini-stat-icon"  style="background-color: #b7241b;">
                    <i class="fa  fa-calendar"></i>
                </span>
                <div class="mini-stat-info"> 
                    <span class="fontColor">                             
                        <?php
                        /* check connection */
                        if (mysqli_connect_errno()) {
                            printf("Connect failed: %s\n", mysqli_connect_error());
                            exit();
                        }
                        if ($result = mysqli_query($db, "select acadbatch_yr from active_academic_year where isActive = 1 limit 1")) {
                            /* determine number of rows result set */
                            $row = mysqli_fetch_assoc($result);
                            $row_result = $row["acadbatch_yr"];
                            printf("
                                    <span>%s</span>
                                    </div> ", $row_result); 
                            /* close result set */
                            mysqli_free_result($result);
                        }
                        /* close connection */
                        // mysqli_close($db);
                        ?>                             
                    </span> 
                    <label class="fontColor">Current Academic Year</label> 
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="mini-stat clearfix tar">
                <span class="mini-stat-icon"  style="background-color: #b7241b;">
                    <i class="fa  fa-bookmark"></i>
                </span>
                <div class="mini-stat-info"> 
                    <span class="fontColor">                            
                        <?php
                        /* check connection */
                        if (mysqli_connect_errno()) {
                            printf("Connect failed: %s\n", mysqli_connect_error());
                            exit();
                        }
                        if ($result = mysqli_query($db, "select activesem_name from active_semester where sem_isactive = 1 limit 1")) {
                            /* determine number of rows result set */
                            $row = mysqli_fetch_assoc($result);
                            $row_result = $row["activesem_name"];
                            printf("
                                    <span>%s</span>
                                    </div> ", $row_result); 
                            /* close result set */
                            mysqli_free_result($result);
                        }
                        /* close connection */
                        // mysqli_close($db);
                        ?>
                        </span> 
                        <label class="fontColor">Current Semester</label> 
                    </div>
            </div>
        </div>

                
        <!--earning graph start-->
            <div class="col-md-2">                
                <?php
                /* check connection */
                if (mysqli_connect_errno()) {
                    printf("Connect failed: %s\n", mysqli_connect_error());
                    exit();
                }
                if ($result = mysqli_query($db, "select * from `stud_profile` WHERE stud_display_status = 'Active'")) {
                    /* determine number of rows result set */
                    $row_cnt = mysqli_num_rows($result);
                    printf("<section class='panel'> 
                    <div class='panel-body'>
                            <div class='leftMargin'>
                                <span class='mini-stat-icon' style='background-color: #96b60b;'>
                                    <i class='fa fa-smile-o'></i>
                                </span>
                            </div>
                            <div class='mini-stat-info'>
                                <br><br><br><br>
                                <span class='alignment'>%d</span>
                                <br>
                                <p class='alignment'>Students on Record</p>
                            </div>
                        </div>
                    </section>
                ", $row_cnt); 
                    /* close result set */
                    mysqli_free_result($result);
                }
                /* close connection */
                // mysqli_close($db);
                ?>  
            </div>

            <div class="col-md-2">
                <?php
                /* check connection */
                if (mysqli_connect_errno()) {
                    printf("Connect failed: %s\n", mysqli_connect_error());
                    exit();
                }
                if ($result = mysqli_query($db, "select * from stud_visit")) {
                    /* determine number of rows result set */
                    $row_cnt = mysqli_num_rows($result);
                    printf("
                    <section class='panel'> 
                    <div class='panel-body'>
                            <div class='leftMargin'>
                                <span class='mini-stat-icon orange'>
                                    <i class='fa fa-tags'></i>
                                </span>
                            </div>
                            <div class='mini-stat-info'>
                                <br><br><br><br>
                                <span class='alignment'>%d</span>
                                <br>
                                <p class='alignment'>Number of Visits<p>
                            </div>
                        </div>
                    </section>
                ", $row_cnt); 
                    /* close result set */
                    mysqli_free_result($result);
                }
                /* close connection */
                // mysqli_close($db);
                ?>
            </div>

            <div class="col-md-2">
                <?php
                /* check connection */
                if (mysqli_connect_errno()) {
                    printf("Connect failed: %s\n", mysqli_connect_error());
                    exit();
                }
                if ($result = mysqli_query($db, "SELECT * FROM `counseling`")) {
                    /* determine number of rows result set */
                    $row_cnt = mysqli_num_rows($result);
                    printf(" 
                    <section class='panel'> 
                    <div class='panel-body' >
                            <div class='leftMargin'>
                                <span class='mini-stat-icon pink'>
                                    <i class='fa fa-user'></i>
                                </span>
                            </div>
                            <div class='mini-stat-info'>
                                <br><br><br><br>
                                <span class='alignment'>%d</span>
                                <br>
                                <p class='alignment'>Individual Counseling</p>
                            </div>
                        </div>
                    </section>
                ", $row_cnt); 
                    /* close result set */
                    mysqli_free_result($result);
                }
                /* close connection */
                // mysqli_close($db);
                ?>
            </div>

            <div class="col-md-2">
                <?php
                /* check connection */
                if (mysqli_connect_errno()) {
                    printf("Connect failed: %s\n", mysqli_connect_error());
                    exit();
                }
                if ($result = mysqli_query($db, "SELECT * FROM stud_visit where visit_purpose = 'Signing of Clearance'")) {
                    /* determine number of rows result set */
                    $row_cnt = mysqli_num_rows($result);
                    printf("
                    <section class='panel'> 
                    <div class='panel-body' >
                            <div class='leftMargin'>
                                <span class='mini-stat-icon yellow-b'>
                                    <i class='fa fa-edit'></i>
                                </span>
                            </div>
                            <div class='mini-stat-info'>
                                <br><br><br><br>
                                <span class='alignment'>%d</span>
                                <br><p class='alignment'>Signed Clearance</p>
                            </div>
                        </div>
                    </section>
                ", $row_cnt); 
                    /* close result set */
                    mysqli_free_result($result);
                }
                /* close connection */
                // mysqli_close($db);
                ?>
            </div>
                
            <div class="col-md-2">
                <?php
                /* check connection */
                if (mysqli_connect_errno()) {
                    printf("Connect failed: %s\n", mysqli_connect_error());
                    exit();
                }
                if ($result = mysqli_query($db, "SELECT * FROM `counseling_group`")) {
                    /* determine number of rows result set */
                    $row_cnt = mysqli_num_rows($result);
                    printf(" 
                    <section class='panel'> 
                    <div class='panel-body' >
                            <div class='leftMargin'>
                                <span class='mini-stat-icon' style='background-color: #eb7bcd;'>
                                    <i class='fa fa-users'></i>
                                </span>
                            </div>
                            <div class='mini-stat-info'>
                                <br><br><br><br>
                                <span class='alignment'>%d</span>
                                <br><p class='alignment'>Group Counseling</p>
                            </div>
                        </div>
                    </section>
                ", $row_cnt); 
                    /* close result set */
                    mysqli_free_result($result);
                }
                /* close connection */
                // mysqli_close($db);
                ?>
            </div>
            
            <div class="col-md-2">
                <?php
                /* check connection */
                if (mysqli_connect_errno()) {
                    printf("Connect failed: %s\n", mysqli_connect_error());
                    exit();
                }
                if ($result = mysqli_query($db, "SELECT * FROM stud_visit where visit_purpose = 'Excuse Letter'")) {
                    /* determine number of rows result set */
                    $row_cnt = mysqli_num_rows($result);
                    printf("
                    <section class='panel'> 
                    <div class='panel-body' >
                            <div class='leftMargin'>
                                <span class='mini-stat-icon' style='background-color: #009dd2;'>
                                    <i class='fa fa-folder'></i>
                                </span>
                            </div>
                            <div class='mini-stat-info'>
                                <br><br><br><br>
                                <span class='alignment'>%d</span>
                                <br><p class='alignment'>Excuse Letter</p>
                            </div>
                        </section>
                ", $row_cnt); 
                    /* close result set */
                    mysqli_free_result($result);
                }
                /* close connection */
                // mysqli_close($db);
                ?>
            </div>

        <center>
            <div class="col-md-12" >
                <div class="event-calendar clearfix">
                    <div class="col-lg-7 calendar-block">
                        <div class="cal1 ">
                        </div>
                    </div>
                    <div class="col-lg-5 event-list-block">
                        <div class="cal-day">
                            <span>Today</span>
                            <?php echo date('D')?>
                        </div>
                        <ul class="event-list">

                        </ul>
                    </div>
                </div>
            </div>
        </center>
    </section>

<!--<div class="col-md-12">-->
<section class="panel">

<div class="panel-body">
    <div class="row">
        <div class="col-md-6">
            <div id="case-chart" class="col-md-6">
                <?php
                $qcaseall = "select count(couns_appr) as Case_all from couns_approach;";
                $result = mysqli_query($db, $qcaseall);
                while($row = mysqli_fetch_array($result))
                {
                   $Caseall = $row["Case_all"];
                }
                $qcaseBehavior = "select count(couns_appr) as Behavior from couns_approach where couns_appr = 'Behavior Theraphy'";
                $result = mysqli_query($db, $qcaseBehavior);
                while($row = mysqli_fetch_array($result))
                {
                   $CaseBehavior = $row["Behavior"];
                }
                $qcaseCognitive = "select count(couns_appr) as Cognitive from couns_approach where couns_appr = 'Cognitive Theraphy'";
                $result = mysqli_query($db, $qcaseCognitive);
                while($row = mysqli_fetch_array($result))
                {
                   $CaseCognitive = $row["Cognitive"];
                }
                $qcaseEducational = "select count(couns_appr) as Educational from couns_approach where couns_appr = 'Educational Theraphy'";
                $result = mysqli_query($db, $qcaseEducational);
                while($row = mysqli_fetch_array($result))
                {
                   $CaseEducational = $row["Educational"];
                }
                $qcaseHolistic = "select count(couns_appr) as Holistic from couns_approach where couns_appr = 'Holistic Theraphy'";
                $result = mysqli_query($db, $qcaseHolistic);
                while($row = mysqli_fetch_array($result))
                {
                   $CaseHolistic = $row["Holistic"];
                }
                $qcaseMentalHealth = "select count(couns_appr) as Mental_Health_Counseling from couns_approach where couns_appr = 'Mental Health Counseling'";
                $result = mysqli_query($db, $qcaseMentalHealth);
                while($row = mysqli_fetch_array($result))
                {
                   $CaseMentalHealth = $row["Mental_Health_Counseling"];
                }
                ?>
            </div>
            <script type="text/javascript">
                        // Create the chart
            Highcharts.chart('case-chart',{
                chart: {
                    type: 'column',
                    width: 300
                },
                title: {
                    text: 'Counseling Cases'
                },
                subtitle: {
                    text: ''
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title: {
                        text: 'Overall case'
                    }
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y}'
                        }
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b>Cases<br/>'
                },
                series: [{
                    name: 'CaseDeKUT',
                    colorByPoint: true,
                    data: [{
                        name: 'Cases DeKUT',
                        y: <?php echo  $Caseall ;?>,
                        drilldown: 'DeKUT'
                
                    }]
                }],
                drilldown: {
                    series: [{
                        name: 'DeKUT',
                        id: 'DeKUT',
                        data: [
                            [
                                'Behavior Therapy',
                                <?php echo $CaseBehavior; ?>
                            ],
                            [
                                'Educational Counseling',
                                <?php echo $CaseEducational; ?>
                            ],
                            [
                                'Holistic Therapy',
                                <?php echo $CaseHolistic; ?>
                            ],
                            [
                                'Mental Health Counseling',
                                <?php echo $CaseMentalHealth; ?>
                            ],
                            [
                                'Cognitive Counseling',
                                <?php echo $CaseCognitive; ?>
                            ]
                            
                        ]
                    
                    }]
                }
            });
            </script>
        </div>
    <!--mini statistics end-->
        <div class="col-md-6">
            <div id="case-chart" class="col-md-6" style="padding:0px 70px">
                <?php
                $qvisitall = "select count(visit_purpose) as visitall from stud_visit";
                $result = mysqli_query($db, $qvisitall);
                while($row = mysqli_fetch_array($result))
                {
                   $visitall = $row["visitall"];
                }
                $qvisitCoC = "select count(visit_purpose) as CoC from stud_visit where visit_purpose = 'CoC'";
                $result = mysqli_query($db, $qvisitCoC);
                while($row = mysqli_fetch_array($result))
                {
                   $visitCoC = $row["CoC"];
                }
                $qvisitExcuse  = "select count(visit_purpose) as Excuse from stud_visit where visit_purpose = 'Excuse Letter'";
                $result = mysqli_query($db, $qvisitExcuse);
                while($row = mysqli_fetch_array($result))
                {
                   $visitExcuse = $row["Excuse"];
                }
                $qvisitClearance  = "select count(visit_purpose) as Clearance from stud_visit where visit_purpose = 'Signing of Clearance'";
                $result = mysqli_query($db, $qvisitClearance);
                while($row = mysqli_fetch_array($result))
                {
                   $visitClearance = $row["Clearance"];
                }
                ?>
                <div id="visit-chart"></div>

                <script type="text/javascript">
                    // Create the chart
                    Highcharts.chart('visit-chart',{
                        chart: {
                            type: 'column',
                            width: 300
                        },
                        title: {
                            text: 'Visits'
                        },
                        subtitle: {
                            text: ''
                        },
                        xAxis: {
                            type: 'category'
                        },
                        yAxis: {
                            title: {
                                text: 'Overall case'
                            }
                        },
                        legend: {
                            enabled: false
                        },
                        plotOptions: {
                            series: {
                                borderWidth: 0,
                                dataLabels: {
                                    enabled: true,
                                    format: '{point.y}'
                                }
                            }
                        },
                        tooltip: {
                            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b>Cases<br/>'
                        },
                        series: [{
                            name: 'CaseDeKUT',
                            colorByPoint: true,
                            data: [{
                                name: 'Total Visits',
                                y: <?php echo  $visitall ;?>,
                                drilldown: 'QCVisits'
                                
                            }]
                        }],
                        drilldown: {
                            series: [{
                                name: 'QCVisits',
                                id: 'QCVisits',
                                data: [
                                    [
                                        'C.O.C',
                                        <?php echo $visitCoC; ?>
                                    ],
                                    [
                                        'Excuse',
                                        <?php echo $visitExcuse; ?>
                                    ],
                                    [
                                        'Clearance',
                                        <?php echo $visitClearance; ?>
                                    ]
                                    
                                    
                                ]
                            
                            }]
                        }
                        
                    });
                </script>
            </div>
        </div>
    </div>
<!--right sidebar end-->
</section>
 

<!-- Placed js at the end of the document so the pages load faster -->
<!--Core js-->
<?php include('footer.php'); ?>

<!--script for this page-->
<!--script for this page-->
<!--Core js-->
<script src="js/jquery.js"></script>


<script>
    $(document).ready(function(){

        function load_unseen_notification(view = '')
        {
            $.ajax({
                url:"NotifLoad.php",
                method:"POST",
                data:{view:view},
                dataType:"json",
                success:function(data)
                {
                    $('.dropdown-menu').html(data.Notification);

                    if(data.NotificationCount > 0)
                    {
                        $('.count').html(data.NotificationCount);
                    }
                }
            });
        }

        load_unseen_notification();

        $(document).on('click','.dropdown-toggle', function(){
        $('.count').html('');
        load_unseen_notification('read');
        });

        setInterval(function(){
            load_unseen_notification();  
        }, 5000);
        
    });

</script>


<!-- <script src="js/jquery-1.8.3.min.js"></script> -->
<!-- <script src="bs3/js/bootstrap.min.js"></script> -->
<script src="js/jquery.dcjqaccordion.2.7.js"></script>
<script src="js/jquery.scrollTo.min.js"></script>
<script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
<script src="js/jquery.nicescroll.js"></script>
<!-- Easy Pie Chart -->
<!-- <script src="js/easypiechart/jquery.easypiechart.js"></script>  -->
<!--Sparkline Chart-->
<!-- <script src="js/sparkline/jquery.sparkline.js"></script> -->
<!--jQuery Flot Chart-->
<!-- <script src="js/flot-chart/jquery.flot.js"></script>
<script src="js/flot-chart/jquery.flot.tooltip.min.js"></script>
<script src="js/flot-chart/jquery.flot.resize.js"></script>
<script src="js/flot-chart/jquery.flot.pie.resize.js"></script> -->
<script src="js/calendar/clndr.js"></script>
<script src="js/calendar/moment-2.2.1.js"></script>
<script src="js/evnt.calendar.init.js"></script>
<!--common script init for all pages-->
<!-- <script src="js/scripts.js"></script> -->
<script src="js/gritter.js" type="text/javascript"></script>

</body>
</html>