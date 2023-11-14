<?php
   $db = mysqli_connect("localhost","root","","imsdb");

    
    //get search term
    $searchTerm = $_GET['term'];

$query = $db->query("SELECT `stud_regNo` FROM `stud_profile` WHERE `stud_regNo`LIKE '%".$searchTerm."%'");
while ($row = $query->fetch_assoc())
{
       $data[] = $row['stud_regNo'];
}
   
    //return json data
    echo json_encode($data);
?>