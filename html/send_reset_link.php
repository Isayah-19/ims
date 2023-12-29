<?php
$db = mysqli_connect('localhost','root','','imsdb');

// Check for errors
if ($db->connect_errno) {
  die("Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error);
}

// Get the email address from the POST request
$email = $_POST["email"];

// Check if the email address exists in the database
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = $db->query($sql);

if ($result->num_rows > 0) {
  // Generate a unique password reset token
  $token = bin2hex(random_bytes(32));

  // Update the user's password reset token in the database
  $sql = "UPDATE users SET password_reset_token = '$token' WHERE email = '$email'";
  $db->query($sql);

  // Send an email with the password reset link
  $link = "http://your-website.com/reset-password?token=" . $token;
  mail($email, "Password Reset", "Click here to reset your password: $link");

  echo "success"; // Indicate success to the AJAX request
} else {
  echo "error"; // Indicate invalid email address to the AJAX request
}

$db->close();
?>