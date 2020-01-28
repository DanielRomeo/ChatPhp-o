<?php 
	//include_once("xPHP_INCLUDES/db_conx.php");

	// declare database variables:
	$Server = "localhost";
	$User_name = "root";
	$password = "5308danielromeo";
	$database = "macbasechat";
	$db_conx = mysqli_connect($Server, $User_name, $password, $database);

	if (mysqli_connect_errno()){
		echo mysqli_connect_error().' incorrect';
		exit();
	}else{
		echo "";
	};


	// $tbl_users = "CREATE TABLE IF NOT EXISTS users(
	// 	id INT(11) NOT NULL AUTO_INCREMENT,
	// 	username VARCHAR(16) NOT NULL,
	// 	email VARCHAR(255) NOT NULL,
	// 	PRIMARY KEY(id),
	// 	UNIQUE KEY username (username, email)
	// 	)";


	// $query = mysqli_query($db_conx, $tbl_users);	
	// if ($query === TRUE) {
	// 	echo "USERS TABLE Created  TRUE </br>";
	// }else{
	// 	echo "USERS TABLE NOT CREATED FALSE";
	// }

	// _______ end of databases:

	$p = "danielromeo";
	$p_hash = md5($p);

	$u = 'sam';
	$e = 'sam@gmail.com';
	$g = 'm';
	$w = 'macbase';

	$c = 'mzansi';
	$ul = 'a';

	$ip = '13668.2368';
	$signup = date_default_timezone_set('Africa/Johannesburg');

	$now = DateTime();
	echo $now->format('Y-m-d H:i:s');
	
	//echo 'its : '.date($signup);



	// $sql = "INSERT INTO users (username, email, password, gender, website,  country, userlevel, ip, signup, lastlogin, notescheck, activated) VALUES('$u','$e','$p_hash','$g', 'w', $c', $ul', $ip','$signup', '$signup', '1', '1')";
	// $query = mysqli_query($db_conx, $sql);
	// if ($query === TRUE) {
	// 	echo "Successfully created </br>";
	// }else{
	// 	echo "Unsuccessful";
	// }
	// mysqli_close($db_conx);


	
	
?>