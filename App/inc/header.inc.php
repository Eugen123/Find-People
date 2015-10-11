<?php
include ("./inc/connect.inc.php"); 
session_start();
if(isset($_SESSION['user_login'])){
	
$username = $_SESSION['user_login'];
}
else{
	$username="";
}


?>
		<!doctype html>
		<html>
		<head>
			<title> Find Friends</title>	
			<link rel="stylesheet" type="text/css" href="/Licenta/App/css/style.css" />
			<script src="js/main.js" type="text/javascript"></script>
		</head>
		<body>
		<div class="headerMenu">
							<div class="search_box">
					<form action="search.php" method="GET" id="search" class="wrapper">
						<input type="text" name="q" size="60" placeholder="search"/>
					</form>
				</div>	
				<?php
				$get_unread_messages = mysql_query("SELECT opened from private_messages where opened ='no' and user_to = '$username'");
				$unread_numrows = mysql_num_rows($get_unread_messages);
				
				$get_friend_requests = mysql_query("SELECT * from friend_request where user_to = '$username'");
				$friend_requests = mysql_num_rows($get_friend_requests); 

				if($username != ""){
				if ($unread_numrows == 0) {
					$unread_messages = "";
				}
				else{
					$unread_messages = "(".$unread_numrows.")";
				}

				if ($friend_requests == 0) {
					$unanswered_requests = "";
				}
				else{
					$unanswered_requests = "(".$friend_requests.")";
				}
				echo "<div id='menu' > 
						<a href ='home.php' > Home</a> 
						<a href ='profile.php?u=$username'>Profile</a>
				     	<a href ='account_settings.php' > Account Settings</a>
					 	<a href ='MESSAGES.php' > My messages".$unread_messages."</a>
					 	<a href ='friend_requests.php?u=$username'> Requests".$unanswered_requests."</a> 
					 	<a href='logout.php' > Logout</a> 
					 </div>	 
					 ";
				}
				 
				
				else {
				echo	'<div id="menu" > <a href ="#" > Home</a> <a href ="index.php" > 
						 Sign in</a> <a href ="index.php" > Sign up</a> <a href ="#" > About</a>
						 </div>';
				}
				?>
		</div>

		<div id="wrapper">