<?php
	include ("config.php");
			
	
		$uname = $_POST['username'];
		$userpassword = $_POST['user_password'];
		
		if(empty($uname) === true || empty($userpassword) === true)
		{
			echo 'You need to enter a username and password<br/><br/>';
		}
		else
		{
				
			$query = "CALL `login_check`('$uname', '$userpassword')";
			$result = mysqli_query($db,$query) or die(mysqli_error());
			if (mysqli_num_rows($result) > 0)
			{
				while($row = mysqli_fetch_assoc($result))
				{
					$ID = $row['userId'];
					$userid = $row['user_referenced'];
					/*$userfname = $_POST['USER_FNAME'];
					$userlname = $_POST['USER_LNAME'];*/
					$userrole = $row['user_role'];
				}
				echo 'OK!';
				session_start();
				$_SESSION['ID'] = $ID;
				$_SESSION['Logged_In'] = $uname;
				$_SESSION['userId'] = $userid;
				$user = $_SESSION['userId'];
				$loginname = $_SESSION['Logged_In'];
				// $_SESSION['USER_FNAME'] = $userfname;
				// $_SESSION['USER_LNAME'] = $userlname;
				$_SESSION['user_role'] = $userrole;
				$redirect = '';
				if ($userrole == 'System Administrator') {
					//$redirect = 'TypeS_UserManagement.php?user='.$loginname.'';
					$redirect = 'TypeS_UserRoles.php?user='.$loginname.'';
				} else if ($userrole == 'Peer counselor') {
					$redirect = 'TypeB_Index.php?user='.$loginname.'';
				} else if ($userrole == 'Guidance Counselor') {
					$redirect = 'index.php?user='.$loginname.'';
				}
				
				header('Location: ' . $redirect);
			}
			else
			{
				header('Location:login.php?trial=failed');
			}
		}
		// print_r($result);
