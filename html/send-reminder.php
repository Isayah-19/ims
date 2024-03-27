<?php
require 'vendor/autoload.php'; // Include PHPMailer autoloader

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Function to calculate next reminder date based on initial date and interval
function calculateNextReminderDate($initialDate, $interval)
{
    $dateTime = new DateTime($initialDate);
    $dateTime->add(new DateInterval("P{$interval}W"));
    return $dateTime->format('Y-m-d H:i:s');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require("config.php");

    $studentRegNo = $_POST['stud_regNo'];
    $counselingIssue = $_POST['couns_issue'];
    $schedule = $_POST['schedule'];
    $status = $_POST['status'];

    // Insert the appointment details into the database
    $insertQuery = "INSERT INTO appointments (stud_regNo, date_sched, couns_issue, status, date_created) 
                    VALUES ('$studentRegNo', '$schedule', '$counselingIssue', '$status', CURRENT_TIMESTAMP)";

    // Execute the SQL query and check for errors
    if (mysqli_query($db, $insertQuery)) {
        echo "<p style='text-align:center;'>Appointment added successfully</p>";

        // Fetch upcoming appointments for the student along with their profile details
        $query = "SELECT a.*, p.stud_email, p.stud_fullname 
                  FROM appointments a
                  JOIN stud_profile p ON a.stud_regNo = p.stud_regNo
                  WHERE a.stud_regNo = '$studentRegNo' AND a.date_sched > NOW()
                  ORDER BY a.date_sched ASC
                  LIMIT 1";

        $result = mysqli_query($db, $query);
        $row = mysqli_fetch_array($result);

        if ($row) {
            $appointmentDate = $row['date_sched'];
            $mail = new PHPMailer();

            // Configure PHPMailer settings

            $mail->CharSet = "utf-8";
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->Username = "dekutcounseling@gmail.com";  // Set your Gmail email address
            $mail->Password = "duxo efic mxda mtpu"; // Set your Gmail password
            $mail->SMTPSecure = 'tls';
            $mail->Host = "smtp.gmail.com";
            $mail->Port = "587";
            $mail->From = 'dekutcounseling@gmail.com'; // Set your Gmail email address
            $mail->FromName = 'DeKUT Counseling IMS';
            $mail->SMTPDebug = 0; // Set to 2 for detailed debug information

            // Add recipient
            $mail->AddAddress($row['stud_email'], $row['stud_fullname']);

            // Email content
            $mail->Subject = 'Upcoming Appointment Reminder';
            $mail->IsHTML(true);
            $mail->Body = 'Dear ' . $row['stud_fullname'] . ',<br><br>' .
                'I hope this email finds you well. You have an upcoming appointment on ' . $appointmentDate . '.<br><br>' .
                'Kind regards,<br>DeKUT Counseling Department';

            // Send email
            if ($mail->Send()) {
                echo "<p style='text-align:center;'>Reminder email sent successfully</p>";
            } else {
                echo "Mail Error - >" . $mail->ErrorInfo;
            }
        } else {
            echo "Error fetching appointment details.";
        }

        header("refresh:1;url=appointment.php");
    } else {
        echo "Error: " . $insertQuery . "<br>" . mysqli_error($db);
    }
}
?>
