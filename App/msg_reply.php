  <?php include("./inc/header.inc.php"); ?>

 <?php

 if(isset($_GET['u'])){
 	$user = mysql_real_escape_string($_GET['u']);
 	if(ctype_alnum($user)) {
 		$check = mysql_query("SELECT username FROM users WHERE username='$user'");
 		if(mysql_num_rows($check) === 1){
 			$get = mysql_fetch_assoc($check);
 			$user = $get['username'];

 			//Check user isn't sending a private message

 			if($user != $username){
 				if (isset($_POST['submit'])) {
 					$msg_body = strip_tags(@$_POST['msg_body']);
 					$date = date('Y-m-d');
 					$opened = "no";
 					
 					$send_msg = mysql_query("INSERT INTO private_messages VALUES('','$username', '$user', '$msg_body', '$date','$opened')");
 					echo "Your message is sent!";
 					echo mysql_error();
 					
 				}
 				echo "
 					<form action ='send_msg.php?u=$user' method ='POST'>
 					<h2>COmpose a message: </h2>
 					<textarea cols ='40' rows = '20' name='msg_body'>Enter some text</textarea>	
 					<input type='submit' name = 'submit' value = 'Send a message'> 
 					</form>
 				";
 			}
 			else{
 				header("Location: $username");
 			}
 		}
 	}
}
 		
?>