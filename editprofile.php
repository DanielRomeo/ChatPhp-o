<?php 
	
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	include_once("includes/db_conx.php");
	
	session_start();

	//echo "you are logged in as ". $_SESSION['username'];

	// Make sure the _GET username is set, and sanitize it
	// if(isset($_GET["u"])){
	// 	$username = preg_replace('#[^a-z0-9]#i', '', $_GET['u']);
	// } else {
	//     header("location: login.php");
	//     exit();	
	// }
	// $userToEdit = preg_replace('#[^a-z0-9]#i', '', $_GET['u']);

	// if($_SESSION['username'] != $userToEdit){
	// 	header("Location : login.php");
	// }

	if(!isset($_SESSION['username'])){
		header("Location : login.php");
	}else{
		$username = $_SESSION['username'];
	}	




	if(isset($_POST['submit'])){

		//echo "lit";
		$bio = $_POST['bio'];

		$sql = "UPDATE users SET bio='$bio' WHERE username = '$username' ";
		$query = mysqli_query($db_conx, $sql);

		header('Location: login.php');

	}
?>




<!DOCTYPE html>
<html>
	<head>
		<title>macbaseChat</title>
		
		<?php include_once("templates/head.php"); ?>
		<style type="text/css">
			body{
				background: #ededed;
			}
		</style>
	</head>

	<body>

		<!-- mini header -->
		<div class="container" align="center">
			<h3 class="display-6">Edit Your Profile</h3>	
			
		</div>

		

		<!--myBody content-->
		<div id="mainContainer" class="container">

			<form action=editprofile.php class="form-horizontal" name="bioform" method="POST" >
				
				<textarea class="form-control" id="" name="bio" rows="5" cols="5"></textarea>

				<br/>

				<button name="submit" type="submit" class="btn btn-primary">Submit bio</button>

			</form>
		</div>
	</body>
</html>