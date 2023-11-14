<?php

	session_start();
		include('config.php');

		$educ_level = $_POST['educ_level'];
		$educ_id_ref = $_POST['educ_id_ref'];
 
			$result  =  mysqli_query($db, "SELECT  *  FROM  stud_educ_background WHERE educ_bg_id='$educ_id_ref'") or die (mysqli_error($db));
			$num_rows  =  mysqli_num_rows($result);
 
				if  ($num_rows)  
				{
					$result2  =  mysqli_query($db, "SELECT  *  FROM  stud_educ_bg_details WHERE educ_lvl='$educ_level'") or die (mysqli_error($db));
					$num_rows2  =  mysqli_num_rows($result2);
		 
						if  ($num_rows2)  
						{
							header("location:  profiling.php?remarks=failed");
						}
						else
						{
							$educ_id_ref = $_POST['educ_id_ref'];
							$educ_level = $_POST['educ_level'];
							$schoolgrad = $_POST['schoolgrad'];
							$schooladd = $_POST['schooladd'];
							$schooltype = $_POST['schooltype'];
							$datesofattendance = $_POST['datesofattendance'];
							$awards = $_POST['awards'];

							mysqli_query($db, "INSERT INTO stud_educ_bg_details (educ_bg_id, educ_lvl, educ_sch_graduated, educ_sch_address, educ_sch_type, educ_dates_of_attendance, received_awards_desc) 
							VALUES ('$educ_id_ref','$educ_level', '$schoolgrad','$schooladd','$schooltype','$datesofattendance', '$awards')") or die (mysqli_error($db));
							header("location:  profiling.php?remarks=success");
						}
				}
				else
				{
					header("location:  profiling.php?remarks=failed2");
				}

				mysqli_close($db);
?>