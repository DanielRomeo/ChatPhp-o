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
				$date = date('Y/m/d H:i:s');
				$username = $_SESSION['username'];

				$sql = "UPDATE users SET  lastlogin='$date' WHERE username='$username'  ";
				$query = mysqli_query($db_conx, $sql);

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
	<title>macbaseChat</title>
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
							location.reload();
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


	<!-- Beginning of form-->

	<form id="loginform" name="loginform" class="form-signin" onsubmit="return false;">

		<img class="mb-4" src="images/macbaselogo.png" alt="" width="130" height="130">

		<h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>

		<span id="status"></span>

		<label for="inputEmail" class="sr-only">Email address</label>
		<input id="email" onfocus="emptyElement('status')" type="text" class="form-control" placeholder="Email" maxlength="88" required autofocus>

		<label for="inputPassword" class="sr-only">Password</label>
		<input id="password" onfocus="emptyElement('status')" type="password" class="form-control" placeholder="Password" maxlength="100" required>

		<div class="checkbox mb-3">
			<label>
				<input type="checkbox" value="remember-me"> Remember me
			</label>
		</div>

		<button id="loginbtn" onclick="login();" class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
		<p class="mt-5 mb-3 text-muted">&copy; 2019</p>
		<br>
		<p>Please refresh the page after logging in.(Its a bug, ill fix it soon)</p>
	</form>
		

		

		

	<script type="text/javascript" src="js/jquerylibrary.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
</body>
</html>