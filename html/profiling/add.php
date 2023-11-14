<?php
    include('conn.php');
    $data = json_decode(file_get_contents("php://input"));

    $out = array('error' => false, 'stud_regNo'=> false, 'stud_fullName' => false);

    $stud_no = $data->stud_regNo;
    $stud_firstname = $data->stud_fullName;
   // $stud_lastname = $data->stud_lastname;
    $stud_course = $data->stud_course;
    $stud_yr_lvl = $data->stud_yrlevel;
    $stud_gender = $data->stud_gender;
    $stud_email = $data->stud_email;
    $stud_contact_no = $data->stud_mobileNo;
    $stud_birthplace = $data->stud_birthplace;
    $stud_birthdate = $data->stud_birth_date;
    $address = $data->stud_address;
    $stud_status = $data->stud_status;

    if(empty($stud_firstname)){
        $out['firstname'] = true;
        $out['message'] = 'Firstname is required'; 
    } 
    /*elseif(empty($lastname)){
        $out['lastname'] = true;
        $out['message'] = 'Lastname is required'; 
    }
    elseif(empty($address)){
        $out['address'] = true;
        $out['message'] = 'Address is required'; 
    }*/
    else{
        $sql = "INSERT INTO stud_profile (stud_regNo,stud_fullName,stud_course,stud_yrlevel, stud_gender,stud_email,stud_mobileNo,stud_birth_date,stud_birthplace,stud_address,stud_status) 
                            VALUES ('$stud_no','$stud_firstname','$stud_course','$stud_yr_lvl','$stud_section','$stud_gender','$stud_email','$stud_contact_no',NULL,NULL,'$address','$stud_status')";
        $query = $conn->query($sql);

        if($query){
            $out['message'] = 'Student Added Successfully';
        }
        else{
            $out['error'] = true;
            $out['message'] = 'Cannot Add Student';
        }
    }
        
    echo json_encode($out);
?>