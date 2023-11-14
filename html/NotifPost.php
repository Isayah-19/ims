<?php
session_start();
include("config.php");

	$NotifUser = $_SESSION['ID'];
	$NotifDetail = mysqli_real_escape_string($db, $_POST['NotifDetail']);

	// echo($NotifUser);
	// echo($NotifDetail);
	$NotifPostSQL = 'INSERT INTO notification(notif_user,notif_details) VALUES ('.$NotifUser.',"'.$NotifDetail.'")';
	$NotifPostQuery = mysqli_query($db,$NotifPostSQL) or die (mysqli_error($db));
?>