<?php
$db = mysqli_connect('localhost', 'root', '', 'imsdb');
// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Fetch data based on couns_date
$sqlCounsDate = "SELECT couns_date, COUNT(*) as case_count FROM counseling GROUP BY couns_date";
$resultCounsDate = $db->query($sqlCounsDate);

$dataCounsDate = [];
if ($resultCounsDate->num_rows > 0) {
    while ($row = $resultCounsDate->fetch_assoc()) {
        $dataCounsDate[] = $row;
    }
}

// Fetch data based on couns_acadYr and nature_of_case
$sqlCounsAcadYr = "SELECT couns_acadYr, nature_of_case, COUNT(*) as case_count FROM counseling GROUP BY couns_acadYr, nature_of_case";
$resultCounsAcadYr = $db->query($sqlCounsAcadYr);

$dataCounsAcadYr = [];
if ($resultCounsAcadYr->num_rows > 0) {
    while ($row = $resultCounsAcadYr->fetch_assoc()) {
        $dataCounsAcadYr[] = $row;
    }
}

echo json_encode(["couns_date" => $dataCounsDate, "couns_acadYr" => $dataCounsAcadYr]);

$db->close();
?>
