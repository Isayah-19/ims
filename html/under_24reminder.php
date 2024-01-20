<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['student_id'])) {
    require("./config.php");

    $studentId = $_POST['student_id'];

    // Fetch upcoming appointments for the student within a specific time range (e.g., 1 day)
    $result = mysqli_query($db, "SELECT * FROM appointments WHERE student_id='" . $studentId . "' AND appointment_date > NOW() AND appointment_date <= DATE_ADD(NOW(), INTERVAL 1 DAY)");

    while ($row = mysqli_fetch_array($result)) {
        $appointmentDate = $row['appointment_date'];

        // Calculate the time difference in hours
        $timeDifference = strtotime($appointmentDate) - strtotime("now");
        $hoursDifference = floor($timeDifference / 3600);

        // Send reminder only if the appointment is within 24 hours (you can adjust this threshold)
        if ($hoursDifference <= 24) {
            // ... (rest of your PHPMailer configuration)

            $mail->AddAddress($row['student_email'], $row['student_name']);
            $mail->Subject  =  'Upcoming Appointment Reminder';
            $mail->Body    = 'You have an upcoming appointment on ' . $appointmentDate . '.';

            if ($mail->Send()) {
                echo "<p style='text-align:center;'>Reminder email sent successfully</p>";
            } else {
                echo "Mail Error - >" . $mail->ErrorInfo;
            }
        }
    }
}

