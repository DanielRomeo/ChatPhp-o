<?php
session_start();

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	include_once("includes/db_conx.php");
		
	// current logged in user:
	$loggedUser = $_SESSION['username'];	
	$date = date('Y/m/d H:i:s');

	if (isset($_POST['submitStatus']) && isset($_POST['status'])) {
		# code...
		$statusmessage = $_POST['status'];


		$sql = "INSERT INTO status(message, uploadedby, uploaddate) VALUES('$statusmessage', '$loggedUser', '$date')";
		$query = mysqli_query($db_conx, $sql);
		if($query == TRUE){
			//echo $responseMessage = "Successfully added a status";

		}else{
			echo $responseMessage = "Couldn't Add a post!";
      		echo("Error description: " . mysqli_error($db_conx));
		}
		echo "oo";
		header("Location: login.php");
	}

	header("Location: login.php");

?>