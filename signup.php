<?php 
	
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

?>


<?php 
session_start();
	# if user logged then send them to their page
	if (isset($_SESSION["username"])) {
		// header("location: user.php?=".$_SESSION['username']."");
		// exit();
	}
?>

<?php
 	// ajax calls this (NAME CHECK) ;
 	if (isset($_POST["usernamecheck"])) {
 		include_once("includes/db_conx.php");
 		$username = preg_replace('#[^a-z0-9]#i', '', $_POST['usernamecheck']);
 		$sql = "SELECT id FROM users WHERE username = '$username' LIMIT 1";
 		$query = mysqli_query($db_conx, $sql);
 		$uname_check = mysqli_num_rows($query);

 		if (strlen($username) < 3 || strlen($username) > 16) {
 			echo '<strong style ="color:#F00">3 - 16 charectors please </strong>';
 			exit();
 		}
 		if (is_numeric($username[0])) {
 			echo '<strong style ="color:#F00"> Username must Begin with a Letter </strong>';
 			exit();
 		}
 		if ($uname_check < 1) {
 			echo '<strong style ="color:#009900">'. $username . ' is okay</strong>';
 			exit();
 		}else{
 			echo '<strong style ="color:#F00">'. $username . ' is taken</strong>';
 			exit();
 		}
 	}
?>

<?php
	// ajax calls this password check:
	if (isset($_POST["checkpassword"])) {
 		include_once("includes/db_conx.php");
 		$password = preg_replace('#[^a-z0-9]#i', '', $_POST['checkpassword']);
 		
 		if (strlen($password) < 4 ) {
 			echo '<strong style ="color:#F00">Password cannot be less than 4 charectors long </strong>';
 			exit();
 		}else{
 			echo '<strong style ="color:#009900"> Password is okay</strong>';
 			exit();
 		}
 	}

 	// ajax calls this password check:
	if (isset($_POST["checkconfirmpassword"])) {
 		include_once("includes/db_conx.php");
 		$confirmpassword = preg_replace('#[^a-z0-9]#i', '', $_POST['checkconfirmpassword']);
 		
 		if (isset($_POST["checkpassword"]) == $_POST["checkconfirmpassword"] ) {
 			echo '<strong style ="color:#009900"> Password matches</strong>';
 			echo $confirmpassword. ' '. $password;
 			exit();
 		}else{
 			
 			echo '<strong style ="color:#F00">Passwords do not match </strong>';
 			//exit();
 		}
 	}
 ?>

<?php 
 	// ajax calls this REGISTRATION CODE:
 	if (isset($_POST["u"])) {
 		//echo "everything is running smoothly";
 		include_once("includes/db_conx.php");
 		// Gather posted data into the local variable:
 		$fn = preg_replace('#[^a-z0-9]#i', '', $_POST['fn']);
 		$ln = preg_replace('#[^a-z0-9]#i', '', $_POST['ln']);

 		$u = preg_replace('#[^a-z0-9]#i', '', $_POST['u']);
 		$e = $_POST['e'];
 		$p = $_POST['p'];
 		$g = preg_replace('#[^a-z]#', '', $_POST['g']);
 		$c = preg_replace('#[^a-z]#i', '', $_POST['c']);
 		//Get user Ip address:
 		$ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));

 		// get the last login in datetime:
 		$date = date('Y/m/d H:i:s');
 		$ll = $date;


 		//check whether the email or username they selected already exists or not:::
 		$sql = "SELECT id FROM users WHERE username = '$u' LIMIT 1";
 		$query = mysqli_query($db_conx, $sql);
 		$u_check = mysqli_num_rows($query);
 		$sql = "SELECT id FROM users WHERE email = '$e' LIMIT 1";
 		$query = mysqli_query($db_conx, $sql);
 		$e_check = mysqli_num_rows($query);


 		
		if ($u_check > 0) {
			echo "The Username you entered is already taken, try anoter one.";
			exit();
		}else if ($e_check > 0) {
			echo "That email address is already in the system.";
			exit();	
		}else if (strlen($u)< 3 || strlen($u) > 16) {
			echo "Username must be between 3 and 16 charectors";
			exit();
		}else if (is_numeric($u[0])) {
			echo "Username cannot begin with a number";
			exit();	
		}else {
			
			// Begin inserting into the database:
			//$p_hash = md5($p);

			//echo $fn.' '.$ln.' '.$u.' '.$e.' '.$p.' '. $g. ' '.$c .'   ';

			// Add user info into the database for the main site table:
			$sql = "INSERT INTO users (firstname, lastname, username, email, password, gender, country, activated, lastlogin) VALUES('$fn', '$ln', '$u','$e','$p','$g','$c', '1', '$ll')";

			$query = mysqli_query($db_conx, $sql);

			// sql error message response:
			if($query == TRUE){
				//
			}else{
	      		echo("Error description: " . mysqli_error($db_conx));
			}

			// everything is good and the user has been added to the database, therfore:
			$sql = "SELECT id, username, password FROM users WHERE email ='$e' AND activated = '1' LIMIT 1";
			$query = mysqli_query($db_conx, $sql);
			$row = mysqli_fetch_row($query);
			$db_id = $row[0];
			$db_username = $row[1];
			$db_pass_str = $row[2];

			// Create their sessions and cookies:
			$_SESSION['id'] = $db_id;
			$_SESSION['username'] = $db_username;
			$_SESSION['password'] = $db_pass_str;
			setcookie('id', $db_id, strtotime( '+30 days' ), "/", "", "", TRUE);
			setcookie('username', $db_username, strtotime( '+30 days' ), "/", "", "", TRUE);
			setcookie('password', $db_pass_str, strtotime( '+30 days' ), "/", "", "", TRUE);

			
			// Create a Directory(folder) to hold each users files:
			// i still have to give php permisssions to be able to create and write to directories:
			// if (!file_exists("user/$u")) {
			// 	mkdir("user/$u", 0755, true);
			// }


			echo "<h3 style='color: purple;'>Signup successful, now <a href='login.php'>Click here</a> to login </h3>";
			header('Location, users.php');

			// cleaar the signup form:
			


			exit();

		}	
		//exit();
		//header('Location: login.php');
 	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>macbaseChat</title>
	<link rel="stylesheet" type="text/css" href="css/signup.css">
	<script type="text/javascript" src="js/signup.js"></script>
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
		<h3 class="display-6">Signup</h3>	
		<p>If you already have an account, you can login <a href="login.php">here</a></p>
	</div>

	

	<!--myBody content-->
	<div id="mainContainer" class="container">

		<form id="signupform" class="form-horizontal" name="signupform" onsubmit="return false;">
			<!--Username-->
			<div class="form-group">
				<div class="col-md-12">Username: </div>
				<div class="col-md-12">
					<input type="text" value="tumi" class="form-control" id="username" onblur="checkusername()" onkeyup="restrict('username')" maxlength="16"/>
				</div>
				<span class="col-md-12" id="unamestatus"></span>
			</div>	

			<!--First Name-->
			<div class="form-group">
				<div class="col-md-12">First Name: </div>
				<div class="col-md-12">
					<input type="text" value="tumi" class="form-control" id="firstname" maxlength="16"/>
				</div>
			</div>

			<!--Last Name-->
			<div class="form-group">
				<div class="col-md-12">Last Name: </div>
				<div class="col-md-12">
					<input type="text" value="tumi" class="form-control" id="lastname" maxlength="16"/>
				</div>
			</div>

			<!--email-->
			<div class="form-group">
				<div class="col-md-12">EmailAddress: </div>
				<div class="col-md-12">
					<input type="text" value="tumi@gmail.com" class="form-control" id="email" onfocus="emptyElement('status')"  onkeyup="restrict('email')" maxlength="80">
				</div>
			</div>

			<!--create password-->
			<div class="form-group">
				<div class="col-md-12">Password: </div>
				<div class="col-md-12">
					<input type="password" value="tumimapheto" class="form-control" id="pass1" onfocus="emptyElement('status')" onblur="checkpassword()" maxlength="16">
				</div>
				<span class="col-md-12" id="createpasswordStatus"></span>
			</div>

			<!-- confirm passwrod -->
			<!--
			<div class="form-group">
				<div class="col-md-2">Confirm Password: </div>
				<div class="col-md-4">
					<input type="password" value="tumimapheto" class="form-control" id="pass2" onfocus="emptyElement('status')"  onblur="checkconfirmpassword()" maxlength="16">
				</div>
				<span class="col-md-3" id="confirmpasswordStatus"></span>
			</div> -->

			<!--Gender-->
			<div class="form-group">
				<div class="col-md-12">Gender: </div>
				<div class="col-md-12">
				<select id="gender" value="M" class="form-control" onfocus="emptyElement('status')">
					<option></option>
					<option value="m">Male</option>
					<option value="f">Female</option>
				</select>
				</div>
			</div>

			<!--country-->
			<div class="form-group">
				<div class="col-md-12">Select Country: </div>
				<div class="col-md-12">
					<select id="country" value="RSA" class="form-control" onfocus="emptyElement('status')">
						<option></option>
						<option value="South Africa">South Africa</option>
						<option value="Zimbabwe">Zimbabwe</option>
						<option value="Mozambique">Mozambique</option>
					</select>
				</div>
			</div>

			<!--Button-->
			<button style="background: purple;" id="signupbtn" class="btn btn-success" onclick="signup()"> Sign Up</button>

			<br />
			<br />
			
			<!--The status where data will be displayed-->
			<span id="status"></span>
		</form>
	</div>



	<?php include_once("templates/footer.php"); ?>	
</body>
</html>