<?php
$db = mysqli_connect('localhost', 'root', '', 'imsdb');
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$sql = "SELECT stud_regNo, nature_of_case, COUNT(*) as case_count FROM counseling GROUP BY stud_regNo, nature_of_case";
$result = $db->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $stud_regNo = $row['stud_regNo'];
        $course = 'Unknown';
        if (strpos($stud_regNo, 'C025') !== false) {
            $course = 'BIT';
        } elseif (strpos($stud_regNo, 'C026') !== false) {
            $course = 'BSCS';
        } elseif (strpos($stud_regNo, 'C027') !== false) {
            $course = 'BBIT';
        } elseif (strpos($stud_regNo, 'B010') !== false) {
            $course = 'Bcom';
        } elseif (strpos($stud_regNo, 'B011') !== false) {
            $course = 'BPSM';
        } elseif (strpos($stud_regNo, 'B012') !== false) {
            $course = 'BBA';
        }elseif (strpos($stud_regNo, 'E021') !== false) {
            $course = 'EEE';
        }elseif (strpos($stud_regNo, 'E024') !== false) {
            $course = 'BScCiv';
        } elseif (strpos($stud_regNo, 'E033') !== false) {
            $course = 'BEDCiv';
        } elseif (strpos($stud_regNo, 'E034') !== false) {
            $course = 'BScCHEM';
        } elseif (strpos($stud_regNo, 'E022') !== false) {
            $course = 'BScMECH';
        } elseif (strpos($stud_regNo, 'E023') !== false) {
            $course = 'BScMEC';
        }elseif (strpos($stud_regNo, 'E029') !== false) {
            $course = 'BEDMEC';
        }elseif (strpos($stud_regNo, 'E020') !== false) {
            $course = 'BScTIE';
        } elseif (strpos($stud_regNo, 'E028') !== false) {
            $course = 'BEDEE';
        }elseif (strpos($stud_regNo, 'T056') !== false) {
            $course = 'BTEBC';
        }

        $data[] = [
            'course' => $course,
            'nature_of_case' => $row['nature_of_case'],
            'case_count' => $row['case_count']
        ];
    }
}

echo json_encode($data);
$db->close();
?>
