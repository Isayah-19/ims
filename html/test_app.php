<?php
include('config.php');

$sql = "SELECT * FROM appointments";
$result = $db->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Counseling Appointments</title>


    <!--Core CSS -->
    <link href="bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
    
<link href="css/reset.css" rel="stylesheet" type="text/css">
<link href="css/style.css" rel="stylesheet" type="text/css">
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>-->

    <link rel="stylesheet" type="text/css" href="js/select2/select2.css" />

<!--dynamic table-->
    <link href="js/advanced-datatable/css/demo_page.css" rel="stylesheet" />
    <link href="js/advanced-datatable/css/demo_table.css" rel="stylesheet" />
    <link rel="stylesheet" href="js/data-tables/DT_bootstrap.css" />
    <link rel="stylesheet" href="css/jquery.steps.css?1">

    <!-- Custom styles for this template -->
    <link href="css/style-responsive.css" rel="stylesheet" />

    <!--Intellisence-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
           
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> 
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
		<div class="card-tools">
			<a href="#" id="create_new" class="btn btn-flat btn-primary"><span class="fa fa-plus"></span>  Create New</a>
           <button data-toggle="modal" data-target="#create_new" class="btn btn-primary">
                                        <i class="fa fa-plus"></i> Add</button>
										 <!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#appointmentModal">Add</button>	-->
		</div>
		

	</div>
	<div class="card-body">
        <div class="container-fluid">
			<div class="row" style="display:none" id="selected_opt">
				<div class="w-100 d-flex">
					<div class="col-2">
						<label for="" class="controllabel"> With Selected:</label>
					</div>
					<div class="col-3">
						<select id="w_selected" class="custom-select select" >
							<option value="pending">Mark as Pending</option>
							<option value="confirmed">Mark as Confirmed</option>
							<option value="cancelled">Mark as Cancelled</option>
							<option value="delete">Delete</option>
						</select>
					</div>
					<div class="col">
						<button class="btn btn-primary" type="button" id="selected_go">Go</button>
					</div>
				</div>
			</div>
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
                    $qry = $db->query("SELECT s.stud_fullname,a.date_sched,a.status,a.id as aid from `stud_profile` s inner join `appointments` a on s.stud_Id = a.stud_id order by unix_timestamp(a.date_sched) desc ");
                    while($row = $qry->fetch_assoc()):
					?>
					
						<tr>
							<td class="text-center">
							<!--<div class="form-check">
								<input type="checkbox" class="form-check-input invCheck" value="<?php echo $row['stud_id'] ?>">
							</div>-->
							</td>
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


<div class="modal fade" id="create_new_modal" tabindex="-1" role="dialog" aria-labelledby="create_new_modal_label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
	<div class="modal-header" style="background-color:#07847d; color:#fff">
                <div class="col-11">
                    <h4 class="modal-title">Create New Appointment</h4>
                </div>
                <div class="col-1 text-right">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color:#fff">&times;</button>
                </div>
            </div>
      <div class="modal-body">
        <form id="create_appointment_form">
          <div class="form-group">
            <label for="stud_id">Student Registration Number:</label>
            <input type="text" class="form-control" id="stud_regNo" name="stud_regNo" required>
          </div>
         <!-- <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" class="form-control" id="email" name="email" required>
          </div>-->
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
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    // Show the modal when the "Create New" button is clicked
    $('#create_new').on('click', function() {
      $('#create_new_modal').modal('show');

    });

    // Handle form submission
    $('#create_appointment_form').submit(function(event) {
      event.preventDefault();

      // Serialize form data
      var formData = $(this).serializeArray();

      // Send AJAX request
      $.ajax({
        url: 'appointment_endpoint.php', 
        type: 'POST',
        data: formData,
        success: function(response) {
          console.log('Server response:', response);

          // Close the modal after a successful submission
          $('#create_new_modal').modal('hide');
        },
        error: function(error) {
          console.error('Error:', error);
          // Handle errors as needed
        }
      });
    });
  });
</script>
</body>
</html>
