<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $stud_id = $_POST['stud_regNo'];
    $schedule = $_POST['schedule'];
    $couns_issue = $_POST['couns_issue'];
    //$email = $_POST['email'];
    $status = $_POST['status'];

    // Prepare and execute the SQL query to insert the data into the appointments table
    $stmt = $db->prepare("INSERT INTO `appointments`(`stud_regNo`,  `date_sched`, `couns_issue`, `status`, `date_created`) VALUES (?, ?, ?, ?, current_timestamp())");
    $stmt->bind_param('sssi', $stud_id, $schedule, $couns_issue, $status);
    
    if ($stmt->execute()) {
        // You can send a response back to the client if needed
        $response = ['status' => 'success', 'message' => 'Appointment added successfully'];
        echo json_encode($response);
    } else {
        // Return an error response if the query fails
        $response = ['status' => 'error', 'message' => 'Error adding appointment'];
        echo json_encode($response);
    }

    // Close the prepared statement
    $stmt->close();
} else {
    // Return an error response if the request method is not POST
    header('HTTP/1.1 405 Method Not Allowed');
    header('Content-Type: application/json');
    $response = ['status' => 'error', 'message' => 'Method Not Allowed'];
    echo json_encode($response);
}
?>
