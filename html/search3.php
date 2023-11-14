<?php  
 include("config.php");
 if(isset($_POST["query"]))  
 {  
      $output = '';
      if($_POST["query"] != '')
      {
        $query = "SELECT * FROM stud_profile WHERE stud_regNo LIKE '%".$_POST["query"]."%'";  
        $result = mysqli_query($db, $query);  
        $output = '<ul class="list-unstyled">';  
        if(mysqli_num_rows($result) > 0)  
        {  
             while($row = mysqli_fetch_array($result))  
             {  
               $output .= '<li class="search-item-name">'.$row["stud_fullname"].'<small class="hide student-no-hide">'.$row["stud_regNo"].'</small></li>';    
               // $output .= '<li class="search-item-name">'.$row["Stud_FNAME"].' '.$row["Stud_MNAME"].' '.$row["Stud_LNAME"].'<small class="hide student-no-hide">'.$row["stud_regNo"].'</small></li>';  
             }  
        }  
        else  
        {  
             $output .= '<li>No Existing Name</li>';  
        }  
        $output .= '</ul>';
      }
      else
      {
        $output = '<ul class="list-unstyled">';
        $output .= '<li>No Existing Name</li>';
        $output .= '</ul>';
      }
        
      echo $output;  
      }
  

?>
