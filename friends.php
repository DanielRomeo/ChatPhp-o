<?php
	include_once("includes/db_conx.php");
	

	session_start();

	//echo "you are logged in as ". $_SESSION['username'];


	//Make sure the _GET username is set, and sanitize it
	if(isset($_GET["u"])){
		$username = preg_replace('#[^a-z0-9]#i', '', $_GET['u']);
	} else {
	    header("location: login.php");
	    exit();	
	}



	// get the name and info of the page owner:
	// $sql = "SELECT * FROM users WHERE username='$username'  LIMIT 1";
	// $query = mysqli_query($db_conx, $sql);
	// $query = mysqli_fetch_row($query);
	// $profileName = $query[1];
	// $firstName = $query[2];
	// $lastName = $query[3];

?>

<!DOCTYPE html>
<html>
<head>
	<title>macbaseChat:</title>
	<?php include_once("templates/head.php"); ?>
	<link rel="stylesheet" type="text/css" href="css/friends.css">
	<style type="text/css">
		body{
			color: black;
		}
	</style>
</head>
<body>

	<!-- start of the navigation -->

	<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
		<h5 class="my-0 mr-md-auto font-weight-normal">These are your friends, <?php echo $firstName ?></h5>
		<nav class="my-2 my-md-0 mr-md-3">

			<!-- the home button -->
			<a class="p-2 text-dark" href="user.php?u=<?php echo $_SESSION['username'] ?>"> <i class="fas fa-home"></i></a>

			<!-- notifications modal -->
		<a data-toggle="modal" data-target="#exampleModalLong" class="p-2 text-dark" href="#"><i class="far fa-bell"></i></a>

		<!-- link that moves you to friends.php -->
		<a class="p-2 text-dark" href="friends.php?u=<?php echo $_SESSION['username'] ?>"> <i class="fas fa-user-friends"></i></a>

		<!-- settings button that lets you  -->
		<!-- <a class="p-2 text-dark" href="#"><i class="fas fa-cog"></i></a> -->
		</nav>

		<a class="btn btn-outline-primary" href="logout.php">Logout</a>
	</div>
	<!-- end of the navigation -->



	<div id="mainSection" class="container">

		
		
	</div> <!-- end of the main section-->


	<?php //include_once("templates/footer.php"); ?>
</body>
</html>

