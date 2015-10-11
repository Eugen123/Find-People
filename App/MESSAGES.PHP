 <?php include("./inc/header.inc.php"); ?>


<h2> My Unread Messages: </h2>
 <?php

//grab the messages fo logged in user
 $grab_messages = mysql_query("SELECT * from private_messages where user_to = '$username' and opened='no'");
$numrows_read = mysql_num_rows($grab_messages);
if ($numrows_read !=0) {
	while ($get_msg = mysql_fetch_assoc($grab_messages)) {
		$id = $get_msg['id'];
		$user_from =$get_msg['user_from'];
		$user_to = $get_msg['user_to'];
		$msg_body = $get_msg['msg_body'];
		$date = $get_msg['date'];
		$opened = $get_msg['opened'];

	if(strlen($msg_body) == 0){

	}
	else {
				echo "</b> 
	 		<form method='POST' action ='MESSAGES.php' name ='$msg_body'>
	 			<div class = 'newsFeedPost' style= 'font: Helvetica; font-size: 12px;'>
	 				<h3><a href='$user_from'>$user_from</a></h3>
	 				<h3>$msg_body<h3>
		 			<input type = 'submit' name='setopened_$id' value='Set as read' style='text-decoration: none;'>
		 		</div>
	 		</form>
	 
	 	<div id ='unread_$id' style='display: none;'>
	 		$msg_body;
	 	</div>
	 	 <hr />";
			}
			if (@$_POST['setopened_'.$id.'']) {
				//Update the private message 
				$setopened = mysql_query("UPDATE private_messages SET opened = 'yes' where msg_body='$msg_body'");
				header("Location: MESSAGES.PHP");
	 		}

	 	 	}
			
		}

else 
	echo "You don't have unread messages!";

?>
<h2> My Read Messages: </h2>
<?php
//grab the messages fo logged in user
 $grab_messages = mysql_query("SELECT * from private_messages where user_to = '$username' and opened='yes'");
$numrows_read = mysql_num_rows($grab_messages);
if ($numrows_read !=0) {
	while ($get_msg = mysql_fetch_assoc($grab_messages)) {
		$id = $get_msg['id'];
		$user_from =$get_msg['user_from'];
		$user_to = $get_msg['user_to'];
		$msg_body = $get_msg['msg_body'];
		$date = $get_msg['date'];
		$opened = $get_msg['opened'];

	if(strlen($msg_body) == 0){

	}
	else {
				echo "</b> 
	 		<form method='POST' action ='MESSAGES.php' name ='$msg_body'>
	 			<div class = 'newsFeedPost' style= 'font: Helvetica; font-size: 12px;'>
	 				<h3><a href='$user_from'>$user_from</a></h3>
	 				$msg_body
		 			
		 		</div>
	 		</form>
	  <hr />";
		
			}
			if (@$_POST['setopened_'.$id.'']) {
				//Update the private message 
				$setopened = mysql_query("UPDATE private_messages SET opened = 'yes' where msg_body='$msg_body'");
				header("Location: MESSAGES.PHP");
	 		}

	 	 	}
			
		}

?>


<h2> My Sent Messages: </h2>
<?php
//grab the messages fo logged in user
 $grab_messages = mysql_query("SELECT * from private_messages where user_from = '$username'");
$numrows_read = mysql_num_rows($grab_messages);
if ($numrows_read !=0) {
	while ($get_msg = mysql_fetch_assoc($grab_messages)) {
		$id = $get_msg['id'];
		$user_from =$get_msg['user_from'];
		$user_to = $get_msg['user_to'];
		$msg_body = $get_msg['msg_body'];
		$date = $get_msg['date'];
		$opened = $get_msg['opened'];

	if(strlen($msg_body) == 0){

	}
	else {
				echo "</b> 
	 		<form method='POST' action ='MESSAGES.php' name ='$msg_body'>
	 			<div class = 'newsFeedPost' style= 'font: Helvetica; font-size: 12px;'>
	 				<h3><a href='$user_from'>$user_from</a> > <a href='$user_to'>$user_to</a>
	 				$msg_body
		 			<br /> <br />
		 		</div>
	 		</form>
	  <hr />";
		
			}
			
	 		}
			
		}
?>
