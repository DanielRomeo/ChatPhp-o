<?php
	include_once("includes/db_conx.php");
	

	session_start();

	//echo "you are logged in as ". $_SESSION['username'];


	//Make sure the _GET username is set, and sanitize it
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
	<link rel="stylesheet" type="text/css" href="css/friends.css">
	<style type="text/css">
		body{
			color: black;
		}
	</style>
</head>
<body>

	<!-- start of the navigation -->

	 <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
      <h5 class="my-0 mr-md-auto font-weight-normal">These are your friends, <?php echo $firstName ?></h5>
      <nav class="my-2 my-md-0 mr-md-3">

      	<!-- the home button -->
      	<a class="p-2 text-dark" href="user.php?u=<?php echo $_SESSION['username'] ?>"> <i class="fas fa-home"></i></a>

      	<!-- notifications modal -->
        <a data-toggle="modal" data-target="#exampleModalLong" class="p-2 text-dark" href="#"><i class="far fa-bell"></i></a>

        <!-- link that moves you to friends.php -->
        <a class="p-2 text-dark" href="friends.php?u=<?php echo $_SESSION['username'] ?>"> <i class="fas fa-user-friends"></i></a>

        <!-- settings button that lets you  -->
        <!-- <a class="p-2 text-dark" href="#"><i class="fas fa-cog"></i></a> -->
      </nav>

      <a class="btn btn-outline-primary" href="logout.php">Logout</a>

    </div>
	<!-- end of the navigation -->



	<div id="mainSection" class="container">

		
		<div class="card text-center ">

			<div style="background: white; border: 0px;" class="card-header">
				<ul class="nav nav-tabs" id="myTab" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">FRIENDS</a>
					</li>

					<li class="nav-item">
						<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">OTHER USERS</a>
					</li>
				</ul>
			</div>

			<!-- _________________________________________________________________________ -->

			<div class="card-body tab-content" id="myTabContent">
				
				<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

					 <div class="row">
				          <div class="col-lg-4">
				            <img class="rounded-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="140" height="140">

				            <h2>Username</h2>

				            <p><a style="width:100%; border-radius: 0%;" href="" class="btn btn-success">ONLINE</a></p>
				            <p><a href="" class="btn btn-outline-dark"><i class="fas fa-comment"></i> Send Message</a></p>
				            <p><a href="" class="btn btn-outline-dark">View Profile</a></p>
				          </div><!-- /.col-lg-4 -->

				          <!--  -->

				          <div class="col-lg-4">
				            <img class="rounded-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="140" height="140">

				            <h2>Username</h2>

				            <p><a style="width:100%; border-radius: 0%;" href="" class="btn btn-danger">OFFLINE</a></p>
				            <p><a href="" class="btn btn-outline-dark"><i class="fas fa-comment"></i> Send Message</a></p>
				            <p><a href="" class="btn btn-outline-dark">View Profile</a></p>
				          </div><!-- /.col-lg-4 -->


				        </div><!-- /.row -->
				</div> <!-- end of the tab pane-->

				<!-- ______________________________________________________________ -->

				<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
					<div class="row">


				         <div class="col-lg-4">
				            <img class="rounded-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="140" height="140">

				            <h2>Username</h2>

				            <p><a style="width:100%; border-radius: 0%;" href="" class="btn btn-danger">OFFLINE</a></p>
				            <p><a href="" class="btn btn-outline-dark"><i class="fas fa-comment"></i> Send Friend Request</a></p>
				            <p><a href="" class="btn btn-outline-dark">View Profile</a></p>
				          </div><!-- /.col-lg-4 -->

				          <!--  -->

				          


				        </div><!-- /.row -->
				</div> <!-- end of the tab-pane-->
			</div> <!-- end of the card body-->	
		</div>
	</div> <!-- end of the main section-->


	<?php //include_once("templates/footer.php"); ?>
</body>
</html>

