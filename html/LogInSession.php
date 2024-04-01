<?php
	include ("config.php");
	session_start(); 

	
	if(isset($_POST['username']) && isset($_POST['user_password'])) {
		$uname = $_POST['username'];
		$userpassword = $_POST['user_password'];
		
		if(empty($uname) || empty($userpassword)) {
			echo 'You need to enter a username and password<br/><br/>';
		} else {
			$query = "CALL `login_check`('$uname', '$userpassword')";
			$result = mysqli_query($db,$query) or die(mysqli_error());
			
			if (mysqli_num_rows($result) > 0) {
				while($row = mysqli_fetch_assoc($result)) {
					$ID = $row['userId'];
					$userid = $row['user_referenced'];
					$userfname = $row['user_fname']; 
					$userlname = $row['user_lname'];
					$userrole = $row['user_role'];
				}
				echo 'OK!';
				$_SESSION['ID'] = $ID;
				$_SESSION['Logged_In'] = $uname;
				$_SESSION['userId'] = $userid;
				$_SESSION['user_fname'] = $userfname;
				$_SESSION['user_lname'] = $userlname;
				$_SESSION['user_role'] = $userrole;
				$redirect = '';
				if ($userrole == 'System Administrator') {
					$redirect = 'TypeS_UserRoles.php?user='.$uname;
				} else if ($userrole == 'Peer counselor') {
					$redirect = 'TypeB_Index.php?user='.$uname;
				} else if ($userrole == 'Guidance Counselor') {
					$redirect = 'index.php?user='.$uname;
				}
				
				header('Location: ' . $redirect);
				exit; // Stop script execution after redirection
			} else {
				header('Location:login.php?trial=failed');
				exit; // Stop script execution after redirection
			}
		}
	}

	// Output the Counselor ID from session if available
	if(isset($_SESSION['ID'])) {
		echo "Counselor ID from session: " . $_SESSION['ID'];
	} else {
		echo "Session ID not available";
	}

