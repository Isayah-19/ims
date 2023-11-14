<?php
include("config.php");

$status=$_POST["stud_status"];
$stat_id=$_POST["status_id"];

$sql="UPDATE `stud_profile` SET `stud_status` = '$status' WHERE `stud_profile`.`stud_Id` = '$stat_id'";

$result=mysqli_query($db,$sql);
								if($result == 1) 
								{
									header('Location: profiling.php' . $redirect);
								}
								else 
								{
									echo "<p>Sira!</p>";
								}
?>