<?php
include("config.php");

$stud_id=$_GET["stud_Id"];

$result=mysqli_query($db,"SELECT * FROM `stud_profile` where `stud_Id`='$stud_id'");

$student=mysqli_fetch_object($result);
echo json_encode($student);

?>