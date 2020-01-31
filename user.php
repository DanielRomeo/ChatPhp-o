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

	echo "you are logged in as ". $_SESSION['username'];


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
	$profileName = mysqli_fetch_row($query);
	$profileName = $profileName[1];

?>

<!DOCTYPE html>
<html>
<head>
	<title>MacbaseChat:</title>
	<?php include_once("templates/head.php"); ?>
	<link rel="stylesheet" type="text/css" href="css/user.css">
</head>
<body>

	<!-- <h3>hello</h3>

	<h4>Page of </h4>
	<a href="logout.php" class="btn btn-default">Logout</a> -->

	<!-- Image and text -->
	<nav class="navbar navbar-light bg-light">
	  <a class="navbar-brand" href="#">
	    <img src="images/macbaselogo.png" width="30" height="30" class="d-inline-block align-top" alt="">
	    Bootstrap
	  </a>
	  <li class="nav-item active">
        <a class="nav-link" href="#">Logout <span class="sr-only"></span></a>
      </li>
	</nav>

	<div id="mainSection">



		<div id="mainContainer" class="container">
		
			<div class="row">

				<div class="col-lg-4">
					<img class="mb-4" src="images/macbaselogo.png" class="img-thumbnail" width="130" height="130">
				</div>

				<div>
					<h4><?php echo strtoupper($profileName) ?></h4>
				</div>
			</div>

		</div>
	</div>

	

	<script type="text/javascript" src="js/jquerylibrary.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>

	<?php include_once("templates/footer.php"); ?>
</body>
</html>

