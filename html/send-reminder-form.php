<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Appointment Reminder</title>
</head>
<body>



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
