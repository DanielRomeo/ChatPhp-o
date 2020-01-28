<?php 
	session_start();
	
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

?>


<?php 
	// if user is already logged in: header them away:
	if (isset($_SESSION["username"])) {
		header("location: user.php?u=".$_SESSION["username"]);
		exit();
	}
?>
<?php
	
	// Ajax calls this login code to execute:
	if (isset($_POST["e"])) {

		//connect to database:
		include_once("includes/db_conx.php");

		/*
			gather posted data into a variable:

			but first i need to get the username from the database:
		*/

		//$username = mysqli_real_escape_string($db_conx, $_POST['u']);
		$email = mysqli_real_escape_string($db_conx, $_POST['e']);
		//$password = md5($_POST['p']);
		$password = $_POST['p'];

		// Get user ip address:
		$ip = preg_replace('#[^a-z0-9]#i', '', getenv('REMOTE_ADDR'));
		// form data error handling:
		if ($email == "" || $password == "") {
			echo "login_failed";
			exit();
		}else{
			// end the form data error handling:
			
			//echo $e;

			$sql = "SELECT id, username, password FROM users WHERE email ='$email' AND activated = '1' LIMIT 1";
			$query = mysqli_query($db_conx, $sql);

			echo $email;
			echo $password;

			$row = mysqli_fetch_row($query);
			$db_id = $row[0];
			$db_username = $row[1];
			$db_pass_str = $row[2];
			if ($password != $db_pass_str) {
				echo "login_failed";
				exit();
			}else{
				// Create their sessions and cookies:
				$_SESSION['id'] = $db_id;
				$_SESSION['username'] = $db_username;
				$_SESSION['password'] = $db_pass_str;
				setcookie('id', $db_id, strtotime( '+30 days' ), "/", "", "", TRUE);
				setcookie('username', $db_username, strtotime( '+30 days' ), "/", "", "", TRUE);
				setcookie('password', $db_pass_str, strtotime( '+30 days' ), "/", "", "", TRUE);

				//update their ip and last login times:
				// $sql = "UPDATE users SET ip='$ip', lastlogin=now(), WHERE username='$db_username'  ";
				// $query = mysqli_query($db_conx, $sql);
				$username = $_SESSION['username'];
				header('Location, users.php?u=." $username" ');

				exit();
				header('Location: login.php');
			}
		}
		exit();

		if (!file_exists("user/$u")) {
			mkdir("user/$u", 0755, true);
		}
		header('Location: login.php');
	}
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>MacBaseCHat-Login</title>
	<!---->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript" src="js/ajax.js"></script>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/login.css">
	<link rel="stylesheet" type="text/css" href="fontawesome/css/font-awesome.min.css"> 
	<script type="text/javascript" src="js/jquerylibrary.js"></script>
	<script type="text/javascript">
		
		function _(x){
			return document.getElementById(x);
		}


		function login(){
			var e = _("email").value;
			var p = _("password").value;
			if (e == "" || p == "") {
				_("status").innerHTML = "Please fill up the form";
			}else{
				_("loginbtn").style.display = "none";
				_("status").innerHTML = "Please wait...";
				var ajax = ajaxObj("POST", "login.php");
				ajax.onreadystatechange = function(){
					if (ajaxReturn(ajax) == true) {
						if (ajax.responseText == "login_failed") {
							_("status").innerHTML = "Your Username or Password is incorrect, Please try again";
							_("loginbtn").style.display = "block";
						}else{
							console.log(ajax.responseText);
							//window.location = "user.php?u="+ajax.responseText;
						}
					}
				}
				ajax.send("e="+e+"&p="+p);
			}
		}

		function emptyElement(x){
			_(x).innerHTML = "";
		}
	</script>
</head>
<body>
	<!-- Beginning of Body-->

		<!--Navigation-->
		<div id="thenavbartop" class="navbar navbar-inverse navbar-static-top">
			<div class="container">
				
				<a class="navbar-brand navbar-pull-left" href="#">MacBaseChat</a>
			</div>
		</div>
		<!--End Navigation-->

		<!--Beginning of jumbotron/section-->
		<div class="container">

			<h2>Login to MACBASECHAT</h2>

			<form id="loginform" class="form-horizontal" name="loginform" onsubmit="return false;">

				<!--Username-->
				<div class="form-group">			
					<label for="" class="col-md-2 control-label">Enter Email:</label>
					<div class="col-md-6">
						<input id="email" onfocus="emptyElement('status')" type="text" class="form-control" placeholder="Email" maxlength="88" />	
					</div>		
				</div>	

				<div class="form-group">			
					<label for="requestquote-name" class="col-md-2 control-label">Enter Password:</label>
					<div class="col-md-6">
						<input id="password" onfocus="emptyElement('status')" type="password" class="form-control" placeholder="Password" maxlength="100" />	
					</div>		
				</div>	

				<a id="loginbtn" onclick="login()" class="btn btn-success">Login</a>
				
				<a href="signup.php" class="btn btn-default">Create new account</a>
				<p id="status"></p>

				<a href="Forgot_pass.php" class="btn btn-info"> Forgot Your Password? Click Me</a>

				<span id="status"></span>
			</form>
		</div>

		<!--Beginning of Footer-->
		<div id="thenavbarbottom" class="navbar navbar-inverse navbar-fixed-bottom">

		<div class="container">
			<h2 class="navbar-brand navbar pull-right">MacBaseChat</h2>
			<!--<a class="navbar-btn btn-danger btn pull-right" id="navbb" href="#">Subscribe to my Youtube Channel</a>-->
			<div class="navbar-text pull-left">
				<p>Website designed and Written by <a href="#">Daniel Mamphekgo</a></p>
			</div>	
		</div>	
	
	<!--End of Footer-->
	<!--End of body-->	

	<script type="text/javascript" src="js/jquerylibrary.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
</body>
</html>