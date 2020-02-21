<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	include_once("includes/db_conx.php");

	if(isset($_GET["s"])){
		$status = $_GET['s'];

		// delete it:
		$sql = "DELETE FROM status WHERE id='$status'";
		$query = mysqli_query($db_conx, $sql);
		if($query == TRUE){
			//echo $responseMessage = "Successfully added a status";
		}else{
			echo $responseMessage = "Couldn't delete status!";
      		echo("Error description: " . mysqli_error($db_conx));
		}
	} 
	header('Location: login.php');

?>