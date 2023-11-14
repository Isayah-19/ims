<?php
	include('conn.php');
    $data = json_decode(file_get_contents("php://input"));

    $out = array('error' => false);

    $stdid = $data->stdid;

   	$sql = "DELETE FROM stud_profile WHERE stud_Id = '$stdid'";
   	$query = $conn->query($sql);

   	if($query){
   		$out['message'] = 'Student deleted Successfully';
   	}
   	else{
   		$out['error'] = true;
   		$out['message'] = 'Cannot delete Student';
   	}

    echo json_encode($out);
?>