<?php
	/* This page will be included on every page as the Databse Connection */
	#Database Connection

	// declare database variables:
	$Server = "localhost";
	$User_name = "root";
	$password = "5308danielromeo";
	$database = "chat";
	$db_conx = mysqli_connect($Server, $User_name, $password, $database);

	if (mysqli_connect_errno()){
		echo mysqli_connect_error().' incorrect';
		exit();
	}else{
		echo "";
	};
?>