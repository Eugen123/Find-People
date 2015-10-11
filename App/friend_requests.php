 <?php include("./inc/header.inc.php") ?>
 <?php

 	$friendRequests = mysql_query("SELECT * FROM friend_request WHERE user_to = '$username' "); 
 	$numrows = mysql_num_rows($friendRequests);
 	if ($numrows == 0) {

		echo '<br>';
 		echo "<div class='newsFeedPost' style='font-family: Arial; font-size:16px;'>You don't have any friend request.</div>";
 		$user_from = '';	
 	}
 	else {
 		while ($get_row = mysql_fetch_assoc($friendRequests)) {

 			$id = $get_row['id'];
 			$user_to = $get_row['user_to'];
 			$user_from = $get_row['user_from'];
 			echo '<br>';
 			echo "<div class='newsFeedPost' style='font-family: Arial; font-size:16px;'>".ucfirst($user_from).' want to be your friend.</div>'.
 			'<br> <br>';
 ?>

<?php

if (isset($_POST['acceptrequest'.$user_from.''])) {
	
		echo $user_from;
		$insert_friend = mysql_query("INSERT INTO friends values('', '$username', '$user_from')");
		
		$insert_friend = mysql_query("INSERT INTO friends values('', '$user_from', '$username')");	
		
		
		if(!isset($id))
     		$id='';	
		$delete_accepted_request = mysql_query("DELETE FROM friend_request WHERE user_to = '$user_to' and user_from = '$user_from'");


		echo "Acum esti prieten cu ".ucfirst($user_from);
		header("Location: friend_requests.php");
	}

if(isset($_POST['ignorerequest'.$user_from])){
     if(!isset($id))
     	$id='';
	$delete_accepted_request = mysql_query("DELETE FROM friend_request WHERE user_to = '$user_to' and user_from = '$user_from'");
	header("Location: friend_requests.php");
}
?>

 <form action="friend_requests.php" method="POST">
	<input type="submit" name="acceptrequest<?php echo $user_from ?>" value="Accept">
	<input type="submit" name="ignorerequest<?php echo $user_from ?>" value="Ignore">
</form>
 
<br> <br>

<?php
}
}
?>			 