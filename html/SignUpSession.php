<?php
	include ("config.php");

		//$userfname = $_POST['USER_FNAME'];
		//$usermname = $_POST['USER_MNAME'];
		//$userlname = $_POST['USER_LNAME'];
		$usrname = $_POST['username'];
		$userpassword = $_POST['user_password'];
		$userrole = $_POST['user_role'];
		//if(!isset($userfname,$usermname,$userlname,$usrname,$userpassword))
		if(!isset($usrname,$userpassword))
		{
			echo 'You need to fill out all fields<br/><br/>';
		}
		else
		{   
			//$checkquery = "SELECT * FROM users WHERE username = '".$usrname."'"; 
			$checkquery = "SELECT * FROM users WHERE username = '".$usrname."' AND user_role ='".$userrole."'"; 
			$checkdb = mysqli_query($db,$checkquery) or die(mysqli_error());
			if  (mysqli_num_rows($checkdb) > 0)
			{
				header('Location:/Fail.php');
				exit;
			}
			else
			{
				//$query = "INSERT INTO R_USER(USER_FNAME,USER_MNAME,USER_LNAME,user_role,username,user_password) 
				//				values('".$userfname."','".$usermname."','".$userlname."','Student Assistant','".$usrname."','".$userpassword."')";
				
				$query = "INSERT INTO users(user_role,username,user_password) 
								values('".$userrole."','".$usrname."','".$userpassword."')";
				$result = mysqli_query($db,$query) or die(mysqli_error());
				if ($result == 1)
				{
					echo
						header('Location: index.php');
				}
				else
				{
					echo   'There is an error in the database<br/><br/>';
					print_r($result);
				}
			}
			
		}
		
?>


