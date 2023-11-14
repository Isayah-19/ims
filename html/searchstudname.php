<?php
   $db = mysqli_connect("localhost","root","","imsdb");

    
    //get search term
    $searchTerm = $_GET['term'];

$query = $db->query("SELECT `stud_fullname`as Name FROM `stud_profile` HAVING Name Like '%".$searchTerm."%'");
while ($row = $query->fetch_assoc())
{
       $data[] = $row['Name'];
}
    //get matched data from skills table
   /* $query = $db->query("SELECT * FROM skills WHERE skill LIKE '%".$searchTerm."%' ORDER BY skill ASC");
    while ($row = $query->fetch_assoc()) {
       
    }*/
    
    //return json data
    echo json_encode($data);
?>