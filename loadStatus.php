<?php

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	include_once("includes/db_conx.php");

	$statusNewCount = $_POST['statusNewCount'];


	$sql = "SELECT * FROM status LIMIT $statusNewCount";
	$query = mysqli_query($db_conx, $sql);
	if(mysqli_num_rows($query) < 1){
		echo "<p>There are no comments</p>";
	}else{
		while($row = mysqli_fetch_assoc($query)){
			echo '
				
				<div class="card-body">
					<p class="card-text">'.$row['message'].'</p>
					<p class="card-text">uploaded on'.$row['uploaddate'].'</p>
					<p>
						<a id="likeStatusIcon" href=""> <i class="fas fa-thumbs-up"> </i> </a>200 &nbsp;&nbsp;
						<a href=""> <i id="deleteStatusIcon" class="fas fa-trash-alt"></i>  </a>
					</p>
				</div>
				<br />		
			';
		}
	}
?>