<?php
include('config.php');

// Fetch existing appointments
$sql = "SELECT * FROM appointments";
$result = $db->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Counseling Appointments</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Bootstrap JS (Popper.js is required for Bootstrap) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</head>
<body>

<?php 
$currentPage ='DeKUT-IMS-Dasboard';
include('header.php');
include('sidebarnav.php');
?>

<section id="main-content">
    <section class="wrapper">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">List of Appointments</h3>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <!-- Button to toggle the form -->
                    <button type="button" class="btn btn-primary mb-3" id="toggleForm">Add New Appointment</button>

                    <!-- Form container (initially hidden) -->
                    <div id="formContainer" style="display:none;">
                        <!-- Your form here -->
                        <form action="send-reminder.php" method="post">
                            <div class="form-group">
                                <label for="stud_regNo">Student Registration Number:</label>
                                <input type="text" class="form-control" id="stud_regNo" name="stud_regNo" required>
                            </div>
                            <div class="form-group">
                                <label for="couns_issue">Counseling Issue:</label>
                                <input type="text" class="form-control" id="couns_issue" name="couns_issue" required>
                            </div>
                            <div class="form-group">
                                <label for="schedule">Schedule:</label>
                                <input type="datetime-local" class="form-control" id="schedule" name="schedule" required>
                            </div>
                            <div class="form-group">
                                <label for="status">Status:</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="0">Pending</option>
                                    <option value="1">Confirmed</option>
                                    <option value="2">Cancelled</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Appointment</button>
                        </form>
                    </div>

                    <!-- Table and other content -->
                    <table class="table table-bordered table-stripped" id="indi-list">
                        <colgroup>
                            <col width="5%">
                            <col width="5%">
                            <col width="25%">
                            <col width="25%">
                            <col width="20%">
                            <col width="20%">
                        </colgroup>
                        <thead>
                            <tr>
                                <td class="text-center"><div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="selectAll">
                                    </div></td>
                                <th class="text-center">#</th>
                                <th>Name</th>
                                <th>Schedule</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i = 1;
                            $qry = $db->query("SELECT s.stud_fullname,a.date_sched,a.status,a.stud_regNo as aid from `stud_profile` s inner join `appointments` a on s.stud_regNo = a.stud_regNo order by unix_timestamp(a.date_sched) desc ");
                            while($row = $qry->fetch_assoc()):
                            ?>
                            
                                <tr>
                                    <td class="text-center"></td>
                                    <td class="text-center"><?php echo $i++; ?></td>
                                    <td><?php echo $row['stud_fullname'] ?></td>
                                    <td><?php echo date("M d,Y h:i A",strtotime($row['date_sched'])) ?></td>
                                    <td class="text-center">
                                        <?php 
                                        switch($row['status']){ 
                                            case(0): 
                                                echo '<span class="badge badge-primary">Pending</span>';
                                            break; 
                                            case(1): 
                                            echo '<span class="badge badge-success">Confirmed</span>';
                                            break; 
                                            case(2): 
                                                echo '<span class="badge badge-danger">Cancelled</span>';
                                            break; 
                                            default: 
                                                echo '<span class="badge badge-secondary">NA</span>';
                                            } 
                                        ?>
                                    </td>
                                    <td align="center">
                                        <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                            Action
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu">
                                            <a class="dropdown-item view_data" href="javascript:void(0)" data-id="<?php echo $row['aid'] ?>"> View</a>
                                            <div class="divider"></div>
                                            <a class="dropdown-item edit_data" href="javascript:void(0)" data-id="<?php echo $row['aid'] ?>"> Edit</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- JavaScript to toggle the form visibility -->
        <script>
            $(document).ready(function() {
                // Toggle form visibility on button click
                $("#toggleForm").click(function() {
                    $("#formContainer").toggle();
                });
            });
        </script>
    </section>
</section>

</body>
</html>
