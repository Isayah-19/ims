<?php
include("config.php");

$_id = isset($_POST['_id']) ? $_POST['_id'] : '';
$C_stud_name = $_POST['_name'];
$C_stud_no = $_POST['_no'];
$C_stud_course = $_POST['_course'];
$C_stud_yr = $_POST['_yr'];
$C_stud_email = $_POST['_email'];
$C_stud_add = $_POST['_add'];
$C_stud_cno = $_POST['_cno'];
$C_couns_bg = $_POST['_couns_bg1'];
$C_goals = $_POST['_goals'];
$C_comments = $_POST['_comments'];
$C_recomm = $_POST['_recomm'];
$C_app=$_POST['_app'];
$sql = "INSERT INTO `counseling` ( `stud_regNo`,  `apprcode`,`couns_background`, `couns_goals`,  
                                  `couns_comment`, `couns_recommendation`,`couns_appmnType`, `couns_date`) 
			VALUES ( '$C_stud_no',  '$C_app', '$C_couns_bg', '$C_goals', '$C_comments', '$C_recomm', 'Walk-in', CURRENT_TIMESTAMP)";
		$result=mysqli_query($db,$sql);
								if($result == 1) 
								{
									header('Location: counseling_page.php' . $redirect);
								}
								else 
								{
									echo "<p>Sira!</p>";
								}
?>