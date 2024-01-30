<!DOCTYPE html>

<?php
    session_start();
    if(!$_SESSION['Logged_In'])
    {
        header('Location:LogIn.php');
        exit;
    }
    include ("config.php");
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Counseling Modal</title>
</head>
<body>
<?php 
$currentPage ='DeKUT-IMS-Counseling Services';
include('header.php');
include('sidebarnav.php');


if(isset($_POST['search']))
{
    $valueToSearch = $_POST['filter'];
    // search in all table columns
    // using concat mysql function
    $query = "SELECT `batch_id`,`batch_approach`,`batch_bg`,`batch_goals`,`batch_comments`,batch_date,`batch_recomm`
FROM batch_group 
WHERE batch_approach = '$valueToSearch'
ORDER BY `batch_date` DESC";
    $search_result = filterTable($query);
    
}
 else {
    $query = "SELECT `batch_id`,`batch_approach`,`batch_bg`,`batch_goals`,`batch_comments`,batch_date,`batch_recomm`
FROM `batch_group` 
ORDER BY `batch_date` DESC";
    $search_result = filterTable($query);
} 
function filterTable($query)
{
    $db = mysqli_connect('localhost','root','','imsdb');
    $filter_Result = mysqli_query($db, $query);
    return $filter_Result;
}
?>
<section id="main-content">
        <section class="wrapper">
        <!-- page start-->
        <!-- page start-->
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumbs-alt">
                        <li>
                            <a href="index.php"><i class="fa fa-home"></i> Home</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-edit"></i> Counseling Services</a>
                        </li>
                        <li>
                            <a class="current" href="counseling_page_group.php"><i class="fa fa-users"></i> Group Counseling Records</a>
                        </li>
                    </ul>
                </div>
            </div>
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Group Counseling Records
                    </header>
                    <div class="panel-body">
                       

<div>
    <a href="#combinedModal" data-toggle="modal" class="btn btn-primary">Start Counseling</a>
</div><br>
                    <div class="col-md-6" style="padding-left:0px">
                    <form action="counseling_page_group.php" method="POST">
                        <div class="row">
                        <div class="col-md-6">
                        <select name="filter" class="form-control input-sm m-bot4">
                            <option value="Behavior Therapy">Behavior Therapy</option>
                                        <option value="Cognitive Therapy">Cognitive Therapy</option>
                                        <option value="Educational Counseling">Educational Counseling</option>
                                        <option value="Holistic Therapy">Holistic Therapy</option>
                                        <option value="Mental Health Counseling">Mental Health Counseling</option>
                        </select>
                        </div>
                        <button class="btn btn-info btn-sm" name="search"><i class="fa fa-mail-forward"></i></button>
                        </div>
                    </form></div>
                    <div class="adv-table">
                    <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                    <!--<table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">-->
                    <thead>
                    <tr>
                        <th>Group Number</th>
                        <th class="hidden-phone">Counseling approach</th>
                        <th class="hidden-phone">Counseling Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
include('config.php');

  /*$sql= "SELECT `batch_id`,`batch_approach`,`batch_bg`,`batch_goals`,`batch_comments`,`batch_date`,`batch_recomm`,`grp_COUNSELING_id`,
  `grp_stud_regno`,`grp_stud_name`,`grp_id`
FROM `batch_group` 
INNER JOIN counseling_group On grp_id = batch_id
ORDER BY `batch_date` DESC";*/
$sql= "SELECT `batch_id`,`batch_approach`,`batch_bg`,`batch_goals`,`batch_comments`,`batch_date`,`batch_recomm`
FROM `batch_group` 
ORDER BY `batch_date` DESC";

$query = mysqli_query($db, $sql);

if (!$query) {
    die ('SQL Error: ' . mysqli_error($db));
}

    /* fetch object array */
    while ($row = mysqli_fetch_assoc($search_result)) 
        {       $batch_id=$row['batch_id']; 
                $app=$row['batch_approach'];
                $bg=$row['batch_bg'];
                $goals=$row['batch_goals'];
                $comments=$row['batch_comments'];
                $recomm=$row['batch_recomm'];
                $date=$row['batch_date'];
               // $name=$row["grp_stud_name"];
    ?>
      <tr>
                    <td><?php echo $batch_id; ?></td>
                    <td><?php echo $app; ?></td>
                    <td><?php echo $date; ?></td>
                    <td><button class="btn btn-primary" name="view" value="View" id="" data-toggle="modal" href="#Viewmodal<?php echo $batch_id; ?>"
                    <i class="fa fa-eye"> View</i></button></td>
               </tr>
                    </tfoot>
                    </div>
                    </div>
                </section>
            </div>
        </div>
        <!--Second-->
        
        <!-- page end-->
        </section>
    </section>
    <?php }  ?>

<!-- Combined Modal -->
<div class="modal fade" id="combinedModal" tabindex="-1" role="dialog" aria-labelledby="combinedModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="combinedModalLabel">Counseling Options</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group" id="selectType" style="text-align:center; padding:20px 0px">
                    <button type="button" class="btn btn-primary" onclick="ShowInput()">
                        <i class="fa fa-user"></i> Individual Counseling
                    </button>
                    <button type="button" class="btn btn-primary" onclick="document.location.href='counseling_services_group.php'">
                        <i class="fa fa-users"></i> Group Counseling
                    </button>
                </div>
                <form method="POST" action="counseling_services.php">
                    <div id="input" style="display:none">
                        <p>Input student's number and student's name before proceeding</p><br/>
                        <div class="form-group">
                            <label for="studentnumber">Student Number</label><br/><br/>
                            <input type="text" class="form-control" name="student_no" placeholder="20XX-XXXXX-CM-0">
                            <div id="studnt_no_list"></div>
                        </div>
                        <div class="form-group">
                            <label for="studentname">Name</label><br/><br/>
                            <input type="text" class="form-control" name="student_name" placeholder="Fullname">
                            <div id="studnt_no_list"></div>
                        </div>
                        <button type="submit" class="btn btn-success">Submit</button>
                        <button type="button" onclick="ShowPrev()" class="btn btn-cancel" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function startCounseling() {
        // Handle your logic here if needed
        // Close the modal if needed
        $('#combinedModal').modal('show');
    }

    function ShowInput() {
        $('#combinedModal').modal('hide');
        $('#input').show();
    }

    function ShowPrev() {
        $('#input').hide();
        $('#combinedModal').modal('show');
    }
</script>

</body>
</html>
