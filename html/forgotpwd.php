<?php
session_start();
require 'config.php';

// IF USER LOGGED IN
if(isset($_SESSION['user_email'])){
header('Location: index.php');
exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DEKUT IMS</title>
    <link rel="stylesheet" href="/html/css/style.css" media="all" type="text/css">
    
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
    background-color: #065a07;
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

    <form action="password-reset-token.php" method="post">
        <h2>Password Reset</h2>

        <div class="container">
            <label for="email"><b>Email</b></label>
            <input type="email" placeholder="Enter email" id="email" name="user_email" required>
        </div>
 
        <div class="container" style="background-color:#f1f1f1">
            <input type="submit" name="password-reset-token" class="Regbtn">
        </div>
    </form>
</body>

</html>