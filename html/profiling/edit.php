<?php
	include('conn.php');
    $data = json_decode(file_get_contents("php://input"));

    $out = array('error' => false);

    $stud_no = $data->stud_regNo;
    $stud_firstname = $data->stud_fullName;
   // $stud_lastname = $data->stud_lastname;
    $stud_course = $data->stud_course;
    $stud_yr_lvl = $data->stud_yrlevel;
    $stud_section = $data->stud_section;
    $stdid = $data->stud_Id;

   	$sql = "UPDATE stud_profile SET stud_regNo = '$stud_no', stud_fullName = '$stud_firstname',  
                          stud_course = '$stud_course', stud_yrlevel = '$stud_yr_lvl' WHERE stud_Id = '$stdid'";
   	$query = $conn->query($sql);

   	if($query){
   		$out['message'] = 'Student updated Successfully';
   	}
   	else{
   		$out['error'] = true;
   		$out['message'] = 'Cannot update Student';
   	}

    echo json_encode($out);
?>