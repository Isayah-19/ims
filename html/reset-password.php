<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" media="all" type="text/css">
    <title>Document</title>

    <style>

body {
    padding: 5px;
    margin: 0;
    background-color: #FFF;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
}

h2 {
    text-align: center;
    text-transform: uppercase;
    letter-spacing: 6px;
}

form {
    border: 3px solid #f1f1f1;
    max-width: 600px;
    margin: 0 auto;
}

input[type=text], input[type=email], input[type=password], select {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
}


button {
    background-color: #1761eb;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
}

button:hover {
    opacity: 0.8;
}

.Regbtn {
    width: auto;
    padding: 10px 18px;
    background-color: #0077c8;
}

.error_message {
    color: red;
    padding-bottom: 10px;
    text-align: center;
    font-weight: bold;
}

.success_message {
    color: green;
    padding-bottom: 10px;
    text-align: center;
    font-weight: bold;
}

.container {
    padding: 16px;
}


@media screen and (max-width: 300px) {
    span.psw {
        display: block;
        float: none;
    }
    .Regbtn {
        width: 100%;
    }
}
    </style>
</head>

<body>
    <?php
         if($_GET['key'] && $_GET['token'])
                            {
                             require("config.php");
                             $email = $_GET['key'];
                             $token = $_GET['token'];
                             $query = mysqli_query($db,
                             "SELECT * FROM `users` WHERE `reset_link_token`='".$token."' and `user_email`='".$email."';"
                             );
                             $curDate = date("Y-m-d H:i:s");
                              if (mysqli_num_rows($query) > 0) {
                                $row= mysqli_fetch_array($query);
                                 if($row['exp_date'] >= $curDate){ ?>
    <form action="update-forget-password.php" method="post">
        <h2>Reset Password Now!!</h2>

        <div class="container">
            <input type="hidden" name="user_email" value="<?php echo $email;?>">
            <input type="hidden" name="reset_link_token" value="<?php echo $token;?>">

            <label for="password"><b>Password</b></label>
            <input type="password" placeholder="Enter password" id="password" name="passwordreset" required>

            <label for="password"><b>Confirm Password</b></label>
            <input type="password" placeholder="Enter password" id="password-confirm" name="passwordconf" required>

            <button type="submit">Submit</button>

        </div>

    </form>
    <?php } 
                                 } else{
                                  echo "<div style='success_message;'>This reset link has expired</div>";
                                 }
                            }
                              ?>
</body>

</html>