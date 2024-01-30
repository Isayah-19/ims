<!DOCTYPE html>
<?php
	session_start();
	if($_SESSION != array())
	{
		header('Location:index.php');
		exit;
	}
  if (isset($_GET['trial']) && $_GET['trial']='failed') {
        echo '<script>alert("That username/password is incorrect");</script>';
  }
?>
<html lang="en">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="images/favicon.png">

    <title>Login</title>

    <!--Core CSS -->
    <link href="bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />

</head>

  <body class="login-body">

    <div class="container">

        <div class="form-signin">
            <h2 class="form-signin-heading">sign in now</h2>
            <div class="login-wrap">
            <form  action="LogInSession.php" method="POST" name="login">
                <div class="user-login-info">
                    <input type="text" name="username" class="form-control" placeholder="Username" required="required" autofocus>
                    <input type="password" name="user_password" class="form-control" placeholder="Password" required="required">
                </div>
                <label class="checkbox">
                    <input type="checkbox" value="remember-me"> Remember me
                    <small class="link">
                    <a href="forgotpwd.php" style="text-decoration: none; cursor: pointer;">forgot password?</a>
                    </small>
                </label>
                <button class="btn btn-lg btn-login btn-block" type="submit">Sign in</button>

                 <div class="registration">
                    Don't have an account yet?
                    <a class="" href="registration.php">
                        Create an account
                    </a>
                </div> 
                
            </form>
            
            </div>
        </div>


      </form>

    </div>


    <!--Core js-->
    <script src="js/jquery.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>

  </body>
</html>