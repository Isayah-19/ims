<?php
include("config.php");

$stud_no = $_POST["stud_regNo"];
$fname = $_POST["stud_fullname"];
$gender = $_POST["stud_gender"];
$course = $_POST["stud_course"];
$stud_yr_lvl = $_POST["stud_yrlevel"];
$stud_bd = $_POST["stud_birth_date"];
$stud_address = $_POST["stud_address"];
$stud_cp_no = $_POST["stud_mobileNo"];
$email = $_POST["stud_email"];
$birthplace = $_POST["stud_birthplace"];
$status = $_POST["stud_display_status"];

//if(!isset($Stud_no))//$Stud_email,$Stud_contact,$Stud_fname,$Stud_lname,$Stud_course,$Stud_year,$Stud_section,$gender,$Stud_bdate,$Stud_status,$Stud_address))
		//{
		//	echo 'You need to fill out all fields<br/><br/>';
		//}
		//else{
			$qry = "call stud_profile_add('$stud_no','$fname','$gender','$course','$stud_yr_lvl','$stud_bd', '$stud_address',  '$stud_cp_no', '$email', '$birthplace', '$status')";

							$res = mysqli_query($db,$qry);
								if($res == 1) 
								{
									header('Location: profiling.php');
								}
								else 
								{
									echo "<p>Sira!</p>";
								}
		//						}
?>