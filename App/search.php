 <?php include("./inc/header.inc.php"); ?>
 <?php
 $user_query = $_GET['q'];

 $selectFriends = mysql_query("SELECT * FROM users where username like '%$user_query%'");

 	while ($friends = mysql_fetch_assoc($selectFriends)) {
		//echo "";
			
			$friendUsername = $friends['username'];
			$friendProfilePic = $friends['profile_pic'];
			
			if ($friendProfilePic== "" && $friendUsername != '') {
				echo "<a href= '$friendUsername' style='text-decoration: none;'> 
					<div class = 'newsFeedPost' style= 'font: Helvetica; font-size: 12px;'>
						<h2>$friendUsername<h2><br>
					<img src ='./img/profile.png' title = '$friendUsername' height = '90' width = '90' style='padding-right: 6px;' /> 
					</div>
				     	</a><br /> <br /> <br />";
				
			}
			else
				if($friendUsername != ''){
				echo "<a href= '$friendUsername' style='text-decoration: none;'>
						<div class = 'newsFeedPost'>
						<h2>$friendUsername<h2><br> 
				     	<img src ='userdata/profilepics/$friendProfilePic' title = '$friendUsername' height = '90' width = '90' style='padding-right: 6px;'>
				     	</div>
				     	</a><br /> <br /> <br />";
			}

			echo 
 		"
 		<div>

 		</div>
 		";
		}
 		
 	
 

 ?>