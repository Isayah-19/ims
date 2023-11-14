<?php
	session_start();
		include('config.php');

			$studno_ref = $_POST['studno_ref'];
 
			$result  =  mysqli_query($db, "SELECT  *  FROM stud_educ_background  WHERE studNo_reference ='$studno_ref'") or die (mysqli_error($db));
			$num_rows  =  mysqli_num_rows($result);
 
				if  ($num_rows)  
				{
					header("location:  profiling.php?remarks=failed");
				}
				else
				{
					$studno_ref = $_POST['studno_ref'];
					$nature_schooling = $_POST['nature_schooling'];
		 
					mysqli_query($db, "INSERT INTO stud_educ_background (studNo_reference, educ_nature_of_schooling) 
							VALUES ('$studno_ref','$nature_schooling')") or die (mysqli_error($db));
					header("location:  profiling.php?remarks=success");
				}

				mysqli_close($db);
?>