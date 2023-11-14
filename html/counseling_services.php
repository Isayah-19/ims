<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="images/favicon.png">

    <title>Counseling Services</title>

    <!--Core CSS -->
    <link href="bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
   
    <link rel="stylesheet" href="css/bootstrap-switch.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-fileupload/bootstrap-fileupload.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-timepicker/compiled/timepicker.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-colorpicker/css/colorpicker.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-datetimepicker/css/datetimepicker.css" />
    <link rel="stylesheet" type="text/css" href="js/jquery-multi-select/css/multi-select.css" />
    <link rel="stylesheet" type="text/css" href="js/jquery-tags-input/jquery.tagsinput.css" />

    <link rel="stylesheet" type="text/css" href="js/select2/select2.css" />

    <!--icheck-->
    <link href="js/iCheck/skins/minimal/minimal.css" rel="stylesheet">
    <link href="js/iCheck/skins/minimal/red.css" rel="stylesheet">
    <link href="js/iCheck/skins/minimal/green.css" rel="stylesheet">
    <link href="js/iCheck/skins/minimal/blue.css" rel="stylesheet">
    <link href="js/iCheck/skins/minimal/yellow.css" rel="stylesheet">
    <link href="js/iCheck/skins/minimal/purple.css" rel="stylesheet">

    <!--dynamic table-->
    <link href="js/advanced-datatable/css/demo_page.css" rel="stylesheet" />
    <link href="js/advanced-datatable/css/demo_table.css" rel="stylesheet" />
    <link rel="stylesheet" href="js/data-tables/DT_bootstrap.css" />

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]>
    <script src="js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> 
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
<?php 
$currentPage ='DeKUT-IMS-Counseling Services';
include('header.php');
include('sidebarnav.php');
?>
<!--sidebar end-->
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
        <!-- page start-->
        <style>
            .twt-feeds {
    border-radius:4px 4px 0 0;
    -webkit-border-radius:4px 4px 0 0;
    color:#FFFFFF;
    padding:40px 10px 10px;
    position:relative;
    min-height:220px;
    height: 60px;
}
        </style>
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumbs-alt">
                        <li>
                            <a href="index.php"><i class="fa fa-home"></i> Home</a>
                        </li><li>
                            <a href="counseling_page.php"><i class="fa fa-edit"></i> Counseling Services</a>
                        </li>
                        <li>
                            <a class="current" href="#"><i class="fa fa-user"></i> Individual Counseling</a>
                        </li>
                    </ul>
                </div>
            </div>
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Counseling
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                         </span>
                    </header>
                    <div class="panel-body">
                    <div  style="padding:10px; padding-left:0px;">
                    <div class="col-sm-12">
                    <div class="twt-feeds" style="background-color:#07847d; padding:5px; height:20px; color:#FFF">
                            <div class="col-md-6">
                        <blockquote style="padding-left:10px">
                            <?php
                    include("config.php");
                        $stud_no = isset($_POST['student_no']) ? $_POST['student_no'] : '';
                        
                        

                        $sql="SELECT r.stud_Id, r.stud_regNo, r.stud_fullname, r.stud_yrlevel,
                                        CONCAT(r.stud_course,' ',r.stud_yrlevel) AS course,
                                        r.stud_address, r.stud_mobileNo,r.stud_email
                                        FROM stud_profile AS r
                                        where r.stud_regNo = '$stud_no'";

                        /*"SELECT r.stud_Id, r.STUD_NO, CONCAT(r.STUD_FNAME,' ', r.STUD_LNAME) AS FULLNAME,r.STUD_YR_LVL,r.STUD_SECTION,
                                        CONCAT(r.STUD_COURSE,' ',r.STUD_YR_LVL,'-',r.STUD_SECTION) AS COURSE,
                                        r.STUD_ADDRESS,r.STUD_CONTACT_NO,r.STUD_EMAIL, t.stud_Id, t.COUNSELING_TYPE_CODE, t.COUNS_APPROACH, t.COUNS_DATE,
                                         a.COUNS_APPROACH_CODE, a.COUNS_APPROACH_NAME
                                        FROM r_stud_profile r
                                        INNER JOIN t_counseling t ON r.stud_Id = t.stud_Id
                                        INNER JOIN R_COUNS_APPROACH a on t.COUNS_APPROACH = a.COUNS_APPROACH_CODE
                                        where r.stud_no = '$stud_no' 
                                        OR CONCAT(r.STUD_FNAME,' ', r.STUD_LNAME)='$stud_name'";*/

                        $query=mysqli_query($db,$sql);

                         if (!$query) {
                            die ('SQL Error: ' . mysqli_error($db));
                        }

                       $row=mysqli_fetch_array($query,MYSQLI_ASSOC);
                    
                    ?>
                            <strong><h2 id="C_stud_name" name="C_stud_name"><?php echo''.$row['stud_fullname'].''?></h2></strong>
                            <h5 id="C_stud_no" name="C_stud_no"><?php echo''.$row['stud_regNo'].''?></h4>
                            <h5 id="C_stud_course" name="C_stud_course"><?php echo''.$row['course'].''?></h4>
                            <h5 id="C_stud_cno" name="C_stud_cno"><?php echo''.$row['stud_mobileNo'].''?></h4>
                            <h5 id="C_stud_email" name="C_stud_email"><?php echo''.$row['stud_email'].''?></h4>
                            <h5 id="C_stud_add" name="C_stud_add"><?php echo''.$row['stud_address'].''?></h4>
                            </div>
                            <div class="col-md-6">
                                <blockquote>
                                    <h4>Recent Counseling</h4>
                                <?php
                    /*include("config.php");
                        $stud_no2 = $_POST["student_no"];
                        $stud_name2=$_POST["student_name"];

                        $sql2="SELECT r.stud_Id, r.STUD_NO, CONCAT(r.STUD_FNAME,' ', r.STUD_LNAME) AS FULLNAME, t.stud_Id, t.COUNSELING_TYPE_CODE, 
                                        t.COUNS_APPROACH, t.COUNS_DATE, a.COUNS_APPROACH_CODE, a.COUNS_APPROACH_NAME
                                        FROM r_stud_profile r
                                        INNER JOIN t_counseling t ON r.stud_Id = t.stud_Id
                                        INNER JOIN R_COUNS_APPROACH a on t.COUNS_APPROACH = a.COUNS_APPROACH_CODE
                                        where r.stud_no = '$stud_no2' 
                                        OR CONCAT(r.STUD_FNAME,' ', r.STUD_LNAME)='$stud_name2'";

                        $query2=mysqli_query($db,$sql2);

                         if (!$query2) {
                            die ('SQL Error: ' . mysqli_error($db));
                        }

                       while($row2=mysqli_fetch_array($query2,MYSQLI_ASSOC))
                    {
                    ?>
                                    <h6><?php echo''.$row['COUNS_APPROACH_NAME'].''?></h6>
                                    <h6><?php echo''.$row['COUNS_DATE'].''?></h6>
                                </blockquote> <?php } ?>*/?>
                            </div>

                            <div class="col-md-6">
                                <blockquote>
                                    <button class="btn btn-success" name="view" value="View" data-toggle="modal" data-target="#myModal<?php echo $row['stud_Id']; ?>">
                                        <i class="fa fa-eye"></i> More Profile Details
                                    </button>
                                    <button class="btn btn-success" name="view" value="View" data-toggle="modal" data-target="#myModalC<?php echo $row['stud_Id']; ?>">
                                        <i class="fa fa-eye"></i> Counseling History
                                    </button>
                                </blockquote>
                            </div>

                    </div>
                    <form action="add_counseling.php" method="POST">
                        <div id="wysiwyg" name="wysiwyg" style=" padding-left:3px">
                                <div class="form-group">
                                    <BR/>
                                    <h5 style=" padding-left:17px"><strong>I.&nbsp&nbsp&nbsp&nbspBackground of the Case:</strong></h5>
                                    <div class="col-md-10">
                                        <textarea name="C_couns_bg" id="C_couns_bg" class="wysihtml5 form-control" rows="9"></textarea>
                                    </div>
                                </div>
                        </div>
                    
                        <!--MULTISELECT-->
                        <div class="form-group col-md-12" style="padding-top:20px">
                            <h5 style=" padding-left:20px"><strong>II.&nbsp&nbsp&nbsp&nbspCounseling Plan:</strong></h5><br/>
                                    <label class="col-lg-3 control-label" style="font-size:14px">&nbsp&nbsp&nbsp&nbsp&nbspa.&nbsp&nbsp&nbspCounseling Approach(es):</label>
                                    <div class="col-lg-6">
                                        <select multiple name="C_approach" id="e9" style="width:400px" class="populate" required="">
                                        <!--<?php
                                        //include("config.php");

                                        //$sql="SELECT `COUNS_APPROACH_CODE`,`COUNS_APPROACH_NAME` AS NAME FROM R_COUNS_APPROACH";
                                        //$result=mysqli_query($db,$sql);

                                        //while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
                                        //   echo '<option name="C_approach" id="C_approach" value='.$row['COUNS_APPROACH_CODE'].'>'.$row['NAME'].'</option>';
                                        //}

                                        ?>-->
                                            <option value="Academic and Career Counseling">Academic and Career Counseling</option>
                                            <option value="Trauma-Informed Therapy">Trauma-Informed Therapy</option>
                                            <option value="Person-Centered Therapy">Person-Centered Therapy</option>
                                            <option value="Cognitive-Behavioral Therapy">Cognitive-Behavioral Therapy</option>
                                        </select>
                                    </div>
                                    <br/><br/><br/><br/>
                                    <div class="col-md-10">
                                    <h5><strong>&nbsp&nbsp&nbsp&nbsp&nbspb.&nbsp&nbsp&nbspCounseling Goals:</strong></h5>
                                        <textarea name="C_goals" id="C_goals" class="wysihtml5 form-control" rows="9"></textarea>
                                    <br/><br/>
                                    </div>
                                    <div class="col-md-10">
                                        <h5><strong>IV.&nbsp&nbsp&nbsp&nbspComments:</strong></h5>
                                            <textarea name="C_comments" id="C_comments" class="wysihtml5 form-control" rows="9"></textarea>
                                        <br/><br/>
                                    </div>
                                    <div class="col-md-10">
                                        <h5><strong>V.&nbsp&nbsp&nbsp&nbspRecommendations:</strong></h5>
                                            <textarea name="C_recomm" id="C_recomm" class="wysihtml5 form-control" rows="9"></textarea>
                                        <br/><br/>
                                    </div>
                        </div>
                                </div>
                                <!--RADIO
                                <h5 style="padding-left:40px"><strong>Please Check:</strong></h5>
                                <div class="minimal-blue single-row" style="padding-left:100px">
                                    <label>
                                        <input type="radio" name="C_walkin" id="C_walkin" value="Voluntary/walk-in" checked>
                                        Voluntary/walk-in
                                    </label>
                                </div>
                                <div class="radio" style="padding-left:100px">
                                    <label>
                                        <input type="radio" name="C_initiated" id="C_initiated" value="Counselor Initiated">
                                        Counselor Initiated
                                    </label>
                                </div>-->
                               <!-- <div class="input-group col-md-6" style="padding-left:67px">
                                              <span class="input-group-addon">
                                                <input type="radio">
                                              </span>
                                <input type="text" class="form-control" placeholder="Referred (if so, name of person making referral)">
                                </div>
                                <div class=" col-md-4">
                                <input type="text" class="form-control" id="exampleInputEmail2" placeholder="Name of person making referral">
                                </div>-->
                                <!--RADIO END-->
                                </div>
                        <?php
                            include("config.php");
                                $stud_no = isset($_POST['student_no']) ? $_POST['student_no'] : '';

                                $sql="SELECT `stud_Id`, `stud_regNo`, `stud_fullname`,`stud_yrlevel`, `stud_course`,
                                                CONCAT(`stud_course`,' ',`stud_yrlevel`) AS course,
                                                `stud_address`,`stud_mobileNo`,`stud_email` FROM stud_profile where stud_regNo = '$stud_no'";

                                $query=mysqli_query($db,$sql);

                                if (!$query) {
                                    die ('SQL Error: ' . mysqli_error($db));
                                }

                                $row=mysqli_fetch_array($query,MYSQLI_ASSOC);
                        ?>
                                            <div class="form-group" style="display:none">
                                                <input type="text" class="form-control" name="_id" value="<?php echo $row['stud_Id']?>"> </div>
                                            <div class="form-group" style="display:none">
                                                <input type="text" class="form-control" name="_no" value="<?php echo$row['stud_regNo']?>"> </div>
                                            <div class="form-group" style="display:none">
                                                <input type="text" class="form-control" name="_name" value="<?php echo $row['stud_fullname']?>"> </div>
                                            <div class="form-group" style="display:none">
                                                <input type="text" class="form-control" name="_course" value="<?php echo $row['stud_course']?>"> </div>
                                            <div class="form-group" style="display:none">
                                                <input type="text" class="form-control" name="_yr" value="<?php echo $row['stud_yrlevel']?>"> </div>
                                            <div class="form-group" style="display:none">
                                                <input type="text" class="form-control" name="_email" value="<?php echo$row['stud_email']?>"> </div>
                                            <div class="form-group" style="display:none">
                                                <input type="text" class="form-control" name="_add" value="<?php echo$row['stud_address']?>"> </div>
                                            <div class="form-group" style="display:none">
                                                <input type="text" class="form-control" name="_cno" value="<?php echo$row['stud_mobileNo']?>"> </div>
                                <div style="text-align:center">
                                    <a data-toggle="modal" name="insert" class="btnInsert btn btn-primary" href="#Continue" type="submit">Save</a>
                                    <button data-dismiss="modal" class="btn btn-cancel" type="button">Cancel</button>
                                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="Continue" class="modal fade">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header"style="background-color:#07847d; color:white">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                    <h5>Save Individual Counseling</h5>
                                                                </div>
                                                                <h5 style="padding-top:20px; text-align: center;">
                                                                Your Counseling is done. Proceed now?</h5>
                                                                <br>
                                                                <div class="panel" style="height: 50%; width: 100%; text-align: center;">
                                                                    <br>
                                                                    <button type="submit" class="btn btn-primary btn-lg" name="insertonly">
                                                                    <i class="fa fa-check"></i>   Yes   </button> &nbsp&nbsp&nbsp&nbsp
                                                                    <button data-dismiss="modal" class="btn btn-error btn-lg">
                                                                    <i class="fa fa-ban"></i>   Not yet</button>
                                                                </div>
                                                                <br>
                                                            </div>
                                                        </div>
                                    </div>
                                </div>
                                </div>
                            <!--END-->
                    </form>
                    </div>
        </div>
                </section>
            </div>
        </div>
        <!-- page end-->
        </section>
    </section>
    <!--main content end-->
    <!-- Modal -->
                            <div class="modal fade" id="myModal<?php echo ''.$row['stud_Id'].'' ?>" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color:#07847d; color:#fff">
                                                <div class="col-11">
                                                    <h4 class="modal-title">Student Details</h4>
                                                </div>
                                                <div class="col-1 text-right">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color:#fff">&times;</button>
                                                </div>
                                        </div>
                                        <div class="modal-body">
                                        <div class='twt-feed' style="background-color:#07847d; padding:15px;">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <img src="images\user.ico" style=" height:140px;padding-left:10px; padding-top:10px;"></img>
                                                <h3><span id="FULLNAME">  <?php echo ''.$row['stud_fullname'].''?></span></h3>
                                                <h5> <?php echo ''.$row['stud_regNo'].'' ?> </h5>
                                                <h5> <?php echo ''.$row['course'].'' ?> </h5>
                                            </div>
                                        <div class="col-md-8">
                                           <!-- <blockquote style="background-color:#03605b; height:100px;">
                                                <h4>Sanction:</h4>
                                                <span class="label label-warning"><i class="fa fa-exclamation"></i> Warning: 18hrs</span>
                                            </blockquote>-->
                                            <blockquote style="background-color:#03605b; height:150px">
                                                <h4>Recent Counseling Remarks:</h4>
                                                <h5 id="remarkstxt" name="remarkstxt">Follow Up</h5>
                                                <br/>
                                                </blockquote>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="panel-group" id="accordion">
                                          
                                        <div class="panel panel-default" style=" padding-top:5px;">
                                            <div class="panel-heading" style="background-color:#07847d">
                                              <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse3" style="color:#FFF">
                                                Educational Background</a>
                                              </h4>
                                            </div>
                                            <div id="collapse3" class="panel-collapse collapse">
                                              <div class="panel-body">
                                                <h4 class="text-info">Primary:</h4>
                                                    <p>Peacemaker International Christian Academy Branch</p>
                                                <h4 class="text-info">Secondary:</h4>
                                                    <p>Peacemaker International Christian Academy Main</p>
                                                <h4 class="text-info">Tertiary:</h4>
                                                    <p>Polytechnic University of the Philippines Quezon City</p>
                                                <h4 class="text-info">Others:</h4>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="panel panel-default" style=" padding-top:5px;">
                                            <div class="panel-heading" style="background-color:#07847d">
                                              <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse2" style="color:#FFF">
                                                Home and Family Background</a>
                                              </h4>
                                            </div>
                                            <div id="collapse2" class="panel-collapse collapse">
                                              <div class="panel-body">
                                                  
                                              </div>
                                            </div>
                                          </div>
                                          <div class="panel panel-default" style=" padding-top:5px;">
                                            <div class="panel-heading" style="background-color:#07847d">
                                              <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse2" style="color:#FFF">
                                                Health Background</a>
                                              </h4>
                                            </div>
                                            <div id="collapse2" class="panel-collapse collapse">
                                              <div class="panel-body">
                                                <h4 class="text-info">Physical Health:</h4>
                                                <h4 class="text-info">Psychological Health:</h4>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button data-dismiss="modal" class="btn btn-success" type="button">OK</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                       </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="myModalC<?php echo ''.$row['stud_Id'].'' ?>" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color:#07847d; color:#fff">
                                                <div class="col-11">
                                                    <h4 class="modal-title">Counseling History</h4>
                                                </div>
                                                <div class="col-1 text-right">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color:#fff">&times;</button>
                                                </div>
                                        </div>
                                        <div class="modal-body">
                                            <div class='twt-feed' style="background-color:#07847d; padding:15px;">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <img src="images\user.ico" style=" height:140px;padding-left:10px; padding-top:10px;"></img>
                                                        <h3><span id="FULLNAME">  <?php echo ''.$row['stud_fullname'].''?></span></h3>
                                                        <h5> <?php echo ''.$row['stud_regNo'].'' ?> </h5>
                                                        <h5> <?php echo ''.$row['course'].'' ?> </h5>
                                                    </div>
                                                    <div class="col-md-8">
                                                    <!--<blockquote style="background-color:#03605b; height:100px;">
                                                        <h4>Sanction:</h4>
                                                        <span class="label label-warning"><i class="fa fa-exclamation"></i> Warning: 18hrs</span>
                                                    </blockquote>-->
                                                    
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="adv-table">
                                                    <table  class="display table table-bordered table-striped" id="dynamic-table">
                                                    <!--<table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">-->
                                                    <thead>
                                                    <tr>
                                                        <th class="hidden-phone">Counseling Type</th>
                                                        <th>Date of Counseling</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    <tbody>
                                                    <?php
                                                        include('config.php');


                                                        $sql= "SELECT  t.couns_Id, t.couns_code,t.stud_regNo,  t.apprcode, t.counseling_type, t.couns_background, t.couns_goals, 
                                                        t.couns_comment, t.couns_recommendation, t.couns_appmnType, DATE_FORMAT(t.couns_date,'%W %M %e %Y') AS couns_date, s.stud_Id, s.stud_regNo,
                                                        s.stud_fullname, s.stud_course, s.stud_yrlevel, r.appr_id, r.couns_appr
                                                        FROM `counseling` AS t
                                                        INNER JOIN `couns_approach` as r ON t.apprcode = r.appr_id
                                                        INNER JOIN `stud_profile` as s ON t.stud_regNo = s.stud_regNo
                                                        WHERE s.stud_Id =".$row['stud_Id']."
                                                        ORDER BY t.couns_date DESC";


                                                        $query = mysqli_query($db, $sql);

                                                        if (!$query) {
                                                            die ('SQL Error: ' . mysqli_error($db));
                                                        }

                                                            /* fetch object array */
                                                            while ($row = mysqli_fetch_assoc($query)) 
                                                                {       $ID=$row['couns_Id']; 
                                                                        $no=$row['stud_regNo'];
                                                                        $name=$row['stud_fullname'];
                                                                        $app=$row['counseling_type'];
                                                                        $bg=$row['couns_background'];
                                                                        $goals=$row['couns_goals'];
                                                                        $comments=$row['couns_comment'];
                                                                        $recomm=$row['couns_recommendation'];
                                                                        $apptype=$row['couns_appmnType'];
                                                                        $date=$row['couns_date'];
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $app; ?></td>
                                                        <td><?php echo $date; ?></td>
                                                        <td><button class="btn btn-primary" name="view" value="View" id="" data-toggle="modal" href="#Viewmodal<?php echo $ID; ?>"
                                                        <i class="fa fa-eye"> View</i></button></td>
                                                    </tr>
                                                </tfoot>
                                            </div>
                                        
                                        </div>
                                  </div>
                             </div>
                        
                </div>
                </div>
            </div>
        </div>
    </div>
<!--right sidebar start-->
<!--right sidebar end-->

</section><?php } ?>

<!-- Placed js at the end of the document so the pages load faster -->

<!--Core js-->
<script>
    function ShowDiv() {
    document.getElementById("optTypes").style.display = "";
}
    function Hide(){
        document.getElementById("optTypes").style.display="none"
        document.getElementById("btn_CT").style.display="none";
        document.getElementById("wysiwyg").style.display="";
    }
    function multiSelect() {
        var length=document.formCT.optCT.length;
        var $result="";
        for (var i = 0; i < length; i++) {
            var selected = document.formCT.optCT[i].selected;
            if(selected){
                $result += document.formCT.optCT[i].value+"<br/>";
            }
          }
          var display = $result;
          document.getElementById('counseling').innerHTML = display;
    }
</script>

<script src="js/jquery.js"></script>
<script src="bs3/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
<script src="js/jquery.scrollTo.min.js"></script>
<script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
<script src="js/jquery.nicescroll.js"></script>
<script src="js/jquery-1.8.3.min.js"></script>
<script src="js/jquery-ui-1.9.2.custom.min.js"></script>
<script src="js/easypiechart/jquery.easypiechart.js"></script>

<script src="js/bootstrap-switch.js"></script>

<script type="text/javascript" src="js/fuelux/js/spinner.min.js"></script>
<script type="text/javascript" src="js/bootstrap-fileupload/bootstrap-fileupload.js"></script>
<script type="text/javascript" src="js/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src="js/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
<script type="text/javascript" src="js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="js/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="js/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
<script type="text/javascript" src="js/jquery-multi-select/js/jquery.multi-select.js"></script>
<script type="text/javascript" src="js/jquery-multi-select/js/jquery.quicksearch.js"></script>

<script type="text/javascript" src="js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>

<script src="js/iCheck/jquery.icheck.js"></script>


<script src="js/jquery-tags-input/jquery.tagsinput.js"></script>

<script src="js/select2/select2.js"></script>
<script src="js/select-init.js"></script>
<!--Easy Pie Chart-->
<script src="js/easypiechart/jquery.easypiechart.js"></script>
<!--Sparkline Chart-->
<script src="js/sparkline/jquery.sparkline.js"></script>
<!--jQuery Flot Chart-->
<script src="js/flot-chart/jquery.flot.js"></script>
<script src="js/flot-chart/jquery.flot.tooltip.min.js"></script>
<script src="js/flot-chart/jquery.flot.resize.js"></script>
<script src="js/flot-chart/jquery.flot.pie.resize.js"></script>

<!--dynamic table-->
<script type="text/javascript" language="javascript" src="js/advanced-datatable/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="js/data-tables/DT_bootstrap.js"></script>
<!--common script init for all pages-->
<script src="js/scripts.js"></script>

<!--dynamic table initialization -->
<script src="js/dynamic_table_init.js"></script>

<script src="js/advanced-form.js"></script>
<script src="js/toggle-init.js"></script>
<!--icheck init -->
<script src="js/icheck-init.js"></script>

</body>
</html>
