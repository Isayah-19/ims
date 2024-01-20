<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Counseling Modal</title>
</head>
<body>

<div>
    <a href="#counselingModal" data-toggle="modal" class="btn btn-primary">Start Counseling</a>
</div>

<!-- Counseling Modal -->
<div class="modal fade" id="counselingModal" tabindex="-1" role="dialog" aria-labelledby="counselingModalLabel" aria-hidden="true">
<div class="modal-dialog">
                                <div class="modal-content" >
                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        <h4>Type of Counseling:</h4>
                                    </div>
                                    <div class="modal-body">
                                    <div class="form-group" id="selectType" style="text-align:center; padding:20px 0px">
                                            <button type="" class="btn btn-primary" onclick="ShowInput()">
                                            <i class="fa fa-user"></i> Individual Counseling</button>
                                            <button type="" class="btn btn-primary" onclick="document.location.href='counseling_services_group.php'">
                                            <i class="fa fa-users"></i> Group Counseling</button>
                                    </div>
                                    <form method="POST" action="counseling_services.php">
                                    <div id="input"style="display:none">
                                    <p>Input student's number and student's name before proceeding</p><br/>
                                        <form role="form" action="">
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
                                        </form>
                                            <button type="submit" onclick="ShowPrev()" class="btn btn-cancel" >Cancel</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
</div>

<script>
    function startCounseling() {
        // Get values from the form
        var counselingType = document.getElementById("counselingType").value;
        var studentNumber = document.getElementById("studentNumber").value;
        var studentName = document.getElementById("studentName").value;

        // You can use the values as needed, for example:
        console.log("Counseling Type: " + counselingType);
        console.log("Student Number: " + studentNumber);
        console.log("Student Name: " + studentName);

        // Close the modal if needed
        $('#counselingModal').modal('hide');
    }
</script>

</body>
</html>
