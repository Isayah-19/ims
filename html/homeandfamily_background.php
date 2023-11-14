<?php
	session_start();
		include('config.php');

			$family_parent=$_POST['family_parent'];

			if($family_parent == "Guardian")
			{
				$studno_ref = $_POST['studno_ref'];

				$result  =  mysqli_query($db, "SELECT  *  FROM  stud_guardian  WHERE  studNo='$studno_ref'") or die (mysqli_error($db));
				$num_rows  =  mysqli_num_rows($result);
 
				if  ($num_rows)  
				{
					header("location:  profiling.php?remarks=failed");
				}
				else
				{
					$studno_ref = $_POST['studno_ref'];
					$fam_fname =$_POST['fam_fname'];
					$fam_mname =$_POST['fam_mname'];
					$fam_lname =$_POST['fam_lname'];
					$fam_age =$_POST['fam_age'];
					$relation =$_POST['relation'];
					$fam_lifestats =$_POST['fam_lifestats'];
					$fam_educattain =$_POST['fam_educattain'];
					$fam_occu =$_POST['fam_occu'];
					$fam_employname =$_POST['fam_employname'];
					$fam_employadd =$_POST['fam_employadd'];
										
					mysqli_query($db, "INSERT  INTO  stud_guardian(studNo, guardian_fname, guardian_mname, guardian_lname, guardian_age, stud_guardian_relation, guardian_educ_attainment, guardian_occupation, guardian_employername, guardian_employeraddress)
						VALUES('$studno_ref', '$fam_fname', '$fam_mname', '$fam_lname', '$fam_age', '$fam_lifestats', '$fam_educattain', '$fam_occu', '$fam_employname', '$fam_employadd')");
					header("location:  profiling.php?remarks=success");
				}
			}
			else{
				$family_parent = $_POST['family_parent'];

				$result  =  mysqli_query($db, "SELECT  *  FROM  stud_family_bg_details  WHERE  familybg_info='$family_parent'") or die (mysqli_error($db));
				$num_rows  =  mysqli_num_rows($result);
 
				if  ($num_rows)  
				{
					header("location:  profiling.php?remarks=failed");
				}
				else
				{
					$studno_ref = $_POST['studno_ref'];
					$family_parent = $_POST['family_parent'];
					$fam_fname =$_POST['fam_fname'];
					$fam_mname =$_POST['fam_mname'];
					$fam_lname =$_POST['fam_lname'];
					$fam_age =$_POST['fam_age'];
					$fam_lifestats =$_POST['fam_lifestats'];
					$fam_educattain =$_POST['fam_educattain'];
					$fam_occu =$_POST['fam_occu'];
					$fam_employname =$_POST['fam_employname'];
					$fam_employadd =$_POST['fam_employadd'];
										
					mysqli_query($db, "INSERT  INTO  stud_family_bg_details(studNo_reference, familybg_info, info_fname, info_mname, info_lname, info_age, info_stat, info_educ_attainment,  info_occupation, info_employername,  info_employeraddress)
						VALUES('$studno_ref', '$family_parent', '$fam_fname', '$fam_mname', '$fam_lname', '$fam_age', '$fam_lifestats', '$fam_educattain', '$fam_occu', '$fam_employname', '$fam_employadd')") or die (mysqli_error($db));
					header("location:  profiling.php?remarks=success");
				}
			}
?>