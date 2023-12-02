<?php
$db = mysqli_connect('localhost', 'root', '', 'imsdb');
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$sql = "SELECT stud_birth_date FROM stud_profile"; // Adjust query to fetch birthdate data
$result = $db->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'stud_birth_date' => $row['stud_birth_date']
        ];
    }
}

echo json_encode($data);
$db->close();
?>
