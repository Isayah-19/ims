<?php
$db = mysqli_connect('localhost', 'root', '', 'imsdb');
// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Fetch data based on gender
$sqlGender = "SELECT sp.stud_gender, COUNT(c.couns_Id) as case_count 
              FROM counseling c
              INNER JOIN stud_profile sp ON c.stud_regNo = sp.stud_regNo 
              GROUP BY sp.stud_gender";
$resultGender = $db->query($sqlGender);

$dataGender = [];
if ($resultGender->num_rows > 0) {
    while ($row = $resultGender->fetch_assoc()) {
        $dataGender[] = $row;
    }
}

echo json_encode(["gender_data" => $dataGender]);

$db->close();
?>
