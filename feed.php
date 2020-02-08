<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	include_once("includes/db_conx.php");
	

	session_start();

	//echo "you are logged in as ". $_SESSION['username'];

	$username = $_SESSION['username'];

	
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


	<script
		src="https://code.jquery.com/jquery-3.2.1.min.js"
		integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
		crossorigin="anonymous">
	</script>


	<link rel="stylesheet" type="text/css" href="css/feed.css">

	

</head>
<body>

	<!-- start of the navigation -->

	<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
		<h5 class="my-0 mr-md-auto font-weight-normal">Hello <?php echo $firstName.' '.$lastName; ?></h5>
		<nav class="my-2 my-md-0 mr-md-3">

			<!-- rss feed notification -->
			<a class="p-2 text-dark" href="feed.php"><i class="fas fa-rss-square" data-toggle="tooltip" data-placement="bottom" title="View Feed"></i></a>

			<!-- notifications modal -->
		<a data-toggle="modal" data-target="#exampleModalLong" class="p-2 text-dark" href="#"><i class="far fa-bell"></i></a>

		<!-- link that moves you to friends.php -->
		<a class="p-2 text-dark" href="friends.php?u=<?php echo $_SESSION['username'] ?>"> <i class="fas fa-user-friends" data-toggle="tooltip" data-placement="bottom" title="View friends"></i></a>

		<!-- add status modal: -->
		<a data-toggle="modal" data-target="#addStatusModal" class="p-2 text-dark" href="#">+</a>

		<!-- settings button that lets you  -->
		<!-- <a class="p-2 text-dark" href="#"><i class="fas fa-cog"></i></a> -->
		</nav>

		<a class="btn btn-outline-primary" href="logout.php">Logout</a>
	</div>
	<!-- end of the navigation -->



	<div class="container">
		<h4 class="display-4">This is your page <?php echo $_SESSION['username']; ?></h4>
	</div>



	<div id="mainSection" class="container">

		<?php

			$sql = "SELECT * FROM status ORDER BY uploaddate DESC";
			$query = mysqli_query($db_conx, $sql);
			if(mysqli_num_rows($query) < 1){
				echo "<h5>There are no statuses at yet!</h5>";
			}else{
				while($row = mysqli_fetch_assoc($query)){
					$message = $row['message'];
					$user = $row['uploadedby'];
					$uploaddate = $row['uploaddate'];	


					echo '
						<div class="card">
							<div class="card-header">
								<a  href="user.php?u='.$user.'">'.$user.' </a>  
							</div>

							<div class="card-body">
								<p class="card-text">'.$message.'</p>

								<p class="card-text text-muted">posted on:'.$uploaddate.'</p>
							</div>

							
						</div>
						<br/>
					';
				}	
			}


		?>

	</div>

		

	

	<?php //include_once("templates/footer.php"); ?>
</body>
</html>

