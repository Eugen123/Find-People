 <?php
 	include("./inc/connect.inc.php");

 	$post = $_POST['post'];
 	if($post != "") {
 		$date_added = date("Y-m-d");
 		$added_by = $username;
 		$user_posted_to = $user;
 		$sqlCommand = "INSERT INTO 	posts VALUES ('', '$post', '$date_added', '$added_by', '$user_posted_to')";
 		$query = mysql_query($sqlCommand) or die(mysql_error());
 	}
 	else{
 		echo "You must enter something in the post field...";
 	}

 ?>