<?php
	include_once("includes/db_conx.php");
	// 
	// $u = "";
	// $sex = "Male";
	// $userlevel = "";
	// $profile_pic = "";
	// $profile_pic_btn = "";
	// $avatar_form = "";
	// $country = "";
	// $joindate = "";
	// $lastsession = "";

	session_start();

	//echo "you are logged in as ". $_SESSION['username'];


	// Make sure the _GET username is set, and sanitize it
	if(isset($_GET["u"])){
		$username = preg_replace('#[^a-z0-9]#i', '', $_GET['u']);
	} else {
	    header("location: login.php");
	    exit();	
	}


	/* security check: make sure the ['u'] username actually does exist incases someone randomly types it:*/
	$sql = "SELECT * FROM users WHERE username='$username' AND activated='1' LIMIT 1";
	$query = mysqli_query($db_conx, $sql);
	// Now make sure that user exists in the table
	$numrows = mysqli_num_rows($query);
	if($numrows < 1){
		echo "That user does not exist or is not yet activated, press back";
	    exit();	
	}

	// get the name and info of the page owner:
	$sql = "SELECT * FROM users WHERE username='$username'  LIMIT 1";
	$query = mysqli_query($db_conx, $sql);
	$query = mysqli_fetch_row($query);
	$profileName = $query[1];
	$firstName = $query[2];
	$lastName = $query[3];

?>

<!DOCTYPE html>
<html>
<head>
	<title>MacbaseChat:</title>
	<?php include_once("templates/head.php"); ?>
	<link rel="stylesheet" type="text/css" href="css/user.css">
</head>
<body>

	<!-- start of the navigation -->
	<nav class="navbar navbar-light bg-light">
	  <a class="navbar-brand" href="#">
	    <img src="images/macbaselogo.png" width="30" height="30" class="d-inline-block align-top" alt="">
	    @<?php echo $username; ?>
	  </a>
	  <li class="nav-item active">
        <a class="nav-link" href="#">Logout <span class="sr-only"></span></a>
      </li>
	</nav>
	<!-- end of the navigation -->

	<div id="mainSection" class="container">

		<div class="jumbotron">

			<div class="mainContainer" class="container">

				<div class="row">

					<div class="col-lg-4 col-md-8 col-sm-12">
						<img class="mb-4" src="images/macbaselogo.png" class="img-thumbnail" width="130" height="130">
					</div>

					<div class="col-lg-8 col-md-8 col-sm-12">
						<h4 class="display-4"><?php echo strtoupper($firstName).' '.strtoupper($lastName) ?></h4>

						<!-- here goes the profile button: -->
						<a id="profileButton" href="" class="btn btn-primary">Edit Profile</a>

						<br /> <br>

						<!-- here goes the bio -->
						<p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
						consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
						cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
						proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
					</div>
				</div> <!-- end of row-->

				

				<hr class="my-4">
				
				<!-- statuses, friends and last login -->
				<div class="row">
					<div class="col-md-4">
						hello
						<!-- number of statuses -->
					</div>	
					<div class="col-md-4">
						hello
						<!-- number of friends -->
					</div>	
					<div class="col-md-4">
						hello
						<!-- last login date: -->
					</div>	
				</div>

			</div> <!-- end of mainContainer-->
		</div><!-- end of jumbotron-->

		
	</div>

	

	<script type="text/javascript" src="js/jquerylibrary.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>

	<?php include_once("templates/footer.php"); ?>
</body>
</html>

