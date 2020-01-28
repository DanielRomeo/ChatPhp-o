<?php session_start();
	/* THIS PAGE IS JUST TO MAKE SURE THAT THERE IS NO CROSS SITE SCRIPTING ATTACkS: */
	include_once("db_conx.php");

	$user_ok = false;
	$log_id = "";
	$log_username = "";
	$log_password = "";

	// user verification function:
	function evalLoggedUser($conx, $id, $u, $p){
		$sql = "SELECT * FROM users WHERE id='$id' AND username='$u' AND activated='1'/*AND password='$p'*/ LIMIT 1";
		$query = mysqli_query($conx, $sql);
		$numrows = mysqli_num_rows($query);
		if ($numrows > 0) {
			return true;
		}
	}

		/* this Block checks if all the sessions are set, if they are then user ok will return true
		after the EvaluateLoggedUser is checked*/
	if (isset($_SESSION['userid']) && isset($_SESSION['username']) && isset($_SESSION['password'])) {
		$log_id = preg_replace('#[^0-9]#', '', $_SESSION['userid']);
		$log_username = preg_replace('#[^a-z0-9]#', '', $_SESSION['username']);
		$log_password  = preg_replace('#[a-z^0-9]#', '', $_SESSION['password']);
		$user_ok = evalLoggedUser($db_conx, $log_id, $log_username ,$log_password); 	// verify the user:

		// th
	}else if (isset($_COOKIE["id"]) && isset($_COOKIE["user"]) && isset($_COOKIE["pass"])) {
		$_SESSION['userid'] = preg_replace('#[^0-9]#', '', $_COOKIE['id']);
		$_SESSION['username'] = preg_replace('#[^a-z0-9]#', '', $_COOKIE['username']);
		$_SESSION['password'] = preg_replace('#[a-z^0-9]#', '', $_COOKIE['password']);

		$log_ok = evalLoggedUser($db_conx, $log_id, $log_username ,$log_password);

		if ($user_ok == true) {
			// update their last login date field:
			$sql = "UPDATE users SET lastlogin=now() WHERE id='$log_id' LIMIT 1";
			$query = mysqli_query($conx, $sql);
		}
	}

	if ($user_ok == true) {  // goal is to make this true:
		//echo " user ok==true </br>";	
	}else{
		echo "user ok ==false </br>";
	}

	if (isset($_SESSION['userid']) && isset($_SESSION['username']) && isset($_SESSION['password'])) {
		# code...
	//	echo "userid is TRUE; </br>";
	}else{
		echo "userid FALSE </br>";
	}

	if (isset($_COOKIE["id"]) && isset($_COOKIE["user"]) && isset($_COOKIE["pass"])) {
		//echo "Cookies are TRUE </br>";
	}else{
		echo "cookies are False <br/>";
	}
?>