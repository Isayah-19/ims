<?php
include("config.php");

// Retrieve values from the form
$studNo = $_POST["V_s_no"];
$purpose = $_POST["txtcode"];
$details = $_POST["txtdetails"];

// Check if the purpose is "Signing of Clearance"
if ($purpose == "Signing of Clearance") {
    // Process the visit addition
    $sqlAddVisit = "CALL stud_visit_add('$studNo', '$purpose', '$details')";

    if ($result = mysqli_query($db, $sqlAddVisit)) {
        // Redirect to visit_logs.php
        header('Location: visit_logs.php');
        exit(); // Stop further execution
    } else {
        // Visit addition failed
        if (mysqli_errno($db) == 1062) { // MySQL error code for duplicate entry
            echo "<p>Duplicate entry for visitCode. Please try again.</p>";
        } else {
            echo "<p>Error: " . mysqli_error($db) . "</p>";
        }
    }
}

// If the purpose is not "Signing of Clearance," proceed to counseling_services.php
$sqlAddVisit = "CALL stud_visit_add('$studNo', '$purpose', '$details')";

if ($result = mysqli_query($db, $sqlAddVisit)) {
    // Visit addition successful, retrieve student details for redirection
    $sqlGetStudentDetails = "SELECT r.stud_Id, r.stud_regNo, r.stud_fullname, r.stud_yrlevel,
                                    CONCAT(r.stud_course, ' ', r.stud_yrlevel) AS course,
                                    r.stud_address, r.stud_mobileNo, r.stud_email
                                FROM stud_profile AS r
                                WHERE r.stud_regNo = '$studNo'";

    $query = mysqli_query($db, $sqlGetStudentDetails);

    if (!$query) {
        die('SQL Error: ' . mysqli_error($db));
    }

    $row = mysqli_fetch_array($query, MYSQLI_ASSOC);

    // Check if student details were retrieved
    if ($row) {
        // Redirect to counseling_services.php with student details in the URL
        header('Location: counseling_service.php?' . http_build_query($row));
    } else {
        // Student details not found
        echo "<p>Student details not found.</p>";
    }
} else {
    // Visit addition failed
    if (mysqli_errno($db) == 1062) { // MySQL error code for duplicate entry
        echo "<p>Duplicate entry for visitCode. Please try again.</p>";
    } else {
        echo "<p>Error: " . mysqli_error($db) . "</p>";
    }
}
?>
