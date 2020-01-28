<?php session_start();

	// set session data to an empty array:
	$_SESSION = array();

	// expire their cookie files:
	if (isset($_COOKIE['$id']) && isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
		setcookie("id", '', strtotime( '-5 days', '/'));
		setcookie("username", '', strtotime( '-5 days', '/'));
		setcookie("password", '', strtotime( '-5 days', '/'));
	}

	// destroy the session variables;
	session_destroy();
	// double check to see if sessions exist:
	if (isset($_SESSION['username'])) {
		header("location: message.php?msg=Error:logout_Failed");
	}else{
		//echo "successfully logged out";
		header("location: login.php");
		exit();
		header("location: login.php");
	}

?>