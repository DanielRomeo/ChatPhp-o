<?php
ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
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
	<title>macbaseChat</title>
	<?php include_once("templates/head.php"); ?>


	<script
		src="https://code.jquery.com/jquery-3.2.1.min.js"
		integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
		crossorigin="anonymous">
	</script>


	<link rel="stylesheet" type="text/css" href="css/user.css">

	<script type="text/javascript">
		
		$(document).ready(function(){
			var statusCount = 3;
			$('#buttonLoadComments').on('click', function(){
				statusCount = statusCount+2;
				$('#status').load("loadStatus.php", {
					statusNewCount: statusCount
				});
			});
		});
	</script>

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

						<?php
							// render the profile button but make sure the right button is rendered

							if($_SESSION['username'] == $_GET['u']){
								echo '<a id="profileButton" href="" class="btn btn-primary">Edit Profile</a>';
							}else if($_SESSION['username'] != $_GET['u']){ /* if its not a friend but some random person*/
								echo '<a id="profileButton" href="" class="btn btn-outline-dark">Send Friend Request</a>';
							}
						?>
						

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
				<div id="statusesFriendsLastLogin" class="row">
					<div class="col-md-4">
						<p>STATUSES</p>	
						<p class="jumbotronNumber">119</p>
					</div>	
					<!-- <div class="col-md-4">
						<p>FRIENDS</p>	
						<p class="jumbotronNumber">119</p>
					</div>	 -->
					<div class="col-md-4">
						<p>LAST LOGIN</p>	
						<p class="jumbotronNumber">2020/08/03</p>
					</div>	
				</div>

			</div> <!-- end of mainContainer-->
		</div><!-- end of jumbotron-->

		<div class="container">
			<h1 class="display-6">STATUSES</h1>
				<div style="margin-bottom:10px;" id="status" class="card">
			

					<?php

						$sql = "SELECT * FROM status LIMIT 3";
						$query = mysqli_query($db_conx, $sql);
						if(mysqli_num_rows($query) < 1){
							echo "<p>There are no comments</p>";
						}else{
							while($row = mysqli_fetch_assoc($query)){

								// check if user owns page and show delete button. else dont show it.
								if($_SESSION['username'] == $_GET['u']){
									echo '
									
										<div class="card-body">
											<p class="card-text">'.$row['message'].'</p>
											<p class="card-text">uploaded on'.$row['uploaddate'].'</p>
											<p>
												<a href="deleteStatus.php?s='.$row['id'].'"> <i id="deleteStatusIcon" class="fas fa-trash-alt"></i>  </a>
											</p>
										</div>	
									';
								}else{
									echo '
									
										<div class="card-body">
											<p class="card-text">'.$row['message'].'</p>
											<p class="card-text">uploaded on'.$row['uploaddate'].'</p>
										</div>	
									';
								}

								
							}
						}
					?>
				</div>
					
			</div>

			<br>

			<button  id="buttonLoadComments" class="btn btn-dark">Load more comments</button>

			<hr>
			
			<div class="container" style="width:800px;">
				<form name="statusForm" method="POST" action="status.php">
					<div class="col-md-8">
						<textarea name="status" class="form-control"></textarea>	
					</div>
					<br />
					<div class="col-md-4">
						<button name="submitStatus" type="submit" class="btn btn-outline-primary btn-sm">Submit</button>
					</div>
				</form>
			</div>
		</div>

		

		
	</div>

	<!-- Modal__________________________________________________________ -->

	<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLongTitle">Your Notifications</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>

	      <div class="modal-body">
	        <div class="container-fluid">

	        	<?php

	        		echo "Notifications for ".$_SESSION['username'];

	        	?>


	        	<p>
	        		<a href="">Sam</a> Sent you a friend request <a href="">Accept</a> or <a href="">Reject</a>
	        	</p>

	        	<p>
	        		<a href="">Sam</a> Uploaded a new status 
	        	</p>

	        	<p>
	        		<a href="">Sam</a> Sent you a new <a href="">Message</a>
	        	</p>
	        	<p>
	        		<a href="">Sam</a> Sent you a new <a href="">SEEE</a>
	        	</p>
	        </div>
	      </div>

	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close Modal</button>
	      </div>
	    </div>
	  </div>
	</div>
	<!-- end of Modal ------------------------------------------------------------------------ -->


	

	

	<?php //include_once("templates/footer.php"); ?>
</body>
</html>

