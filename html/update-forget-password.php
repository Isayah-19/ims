<?php
if(isset($_POST['passwordreset']) && $_POST['reset_link_token'] && $_POST['user_email'])
{
require 'config.php';
$emailId = $_POST['user_email'];
$token = $_POST['reset_link_token'];
$password = $_POST['passwordreset'];
  
$hashedpassword = password_hash($password, PASSWORD_DEFAULT);

$loginpage = 'http://localhost/ims/html/login.php';
$reset = 'http://localhost/ims/html/reset-password.php';


$query = mysqli_query($db,"SELECT * FROM `users` WHERE `reset_link_token`='".$token."' AND `user_email`='".$emailId."'");
$row = mysqli_num_rows($query);

$exp = "0000-00-00";
if($row){
mysqli_query($db,"UPDATE `users` SET  `user_password`='" . $hashedpassword . "',`reset_link_token`='".NULL."',
 `exp_date`='" .$exp. "' WHERE `user_email`='" . $emailId . "'");
 
echo "<p style='text-align: center; color:green; '>Congratulations! Your password has been updated successfully <a href='$loginpage'></a>Login</p>";
}else{
echo "<h1 style='text-align: center; color:red;  height: 100%;
  width: 100%;
  display: flex;
  position: fixed;
  align-items: center;
  justify-content: center;'><a href='$reset' style='color:red;'> Please try again!! </a></h1>";
}
}
?>