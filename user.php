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
</head>
<body>

	<h3>hello</h3>

	<h4>Page of <?php echo $profileName ?></h4>
	<a href="logout.php" class="btn btn-default">Logout</a>

</body>
</html>

