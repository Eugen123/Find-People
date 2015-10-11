
<?php include("./inc/header.inc.php"); ?>

<div class="newsFeed">
<h2> Newsfeed </h2>
</div>
<p />  <p />
<?php
if (!isset($_SESSION['user_login'])) {
 	echo "<meta http-equiv=\"refresh\" content=\"0; url=http://localhost/Licenta/App/index.php\">" ;
 } 
 else{


$getposts = mysql_query("SELECT * FROM posts order by id desc") or die(mysql_error());
	while($row = mysql_fetch_assoc(($getposts))){
		$id= $row['id'];
		$body = $row['body'];
		$added_by = $row['added_by'];
		
		$date_added = $row['date_added'];
	$today = date("Y-m-d");
		
		$today_day = date_create($today);
		$added_day = date_create($date_added);
		$passed_days = date_diff( $today_day, $added_day);
		$passed_days_from = $passed_days->format("%R%a days");
		$absolute_days = abs($passed_days_from);
		if ($absolute_days == 0) {
			$passed_days_text = "today";
		}
		else if ($absolute_days == 1) {
				$passed_days_text = $absolute_days." day ago";
			}
			else{
				$passed_days_text = $absolute_days. " days ago";
			}

		$user_posted_to = $row['user_posted_to'];
		
		$get_user_info = mysql_query("SELECT * from users where username ='$added_by'");
		$get_info = mysql_fetch_assoc($get_user_info);
		$profilepic = $get_info['profile_pic'];

	if ($profilepic == null) {
			$img_path = "./img/profile.png";
		}
		else $img_path = "./userdata/profilepics/".$profilepic;

		echo "<p />
				<div style='float:left;' class='newsFeedPost'>
					<div class='newsfeedPostOptions'>
						<a href='#' onclick='javascript:toggle(id)' style='text-decoration: none;'id=$id> Show comments </a>
					</div>
					<img src= '$img_path' height='40'/>
				
					<br/> 
					<div class='posted_by' >
			   		 <a href= '$added_by' > $added_by </a> > <a href='$user_posted_to'> $user_posted_to </a>  ".$passed_days_text."
			    	</div>
			    	<div style='max-width:800px'>
			    		&nbsp;&nbsp;&nbsp;&nbsp;$body <br /> <br /> <br /> 
			    		<p />
			    	</div>";
			    

				echo "
						<div class ='toggleComment_$id' style='display: none;'>
			    			<iframe src='./comment_frame.php?id=$id' frameborder = '0' style = 'max-height: 150px; height: auto; width: 100%; min-heigth: 10px;'>
			   				</iframe> 
			   			</div>
					";
		

		echo "</div>";

	}

if (isset($_POST['sendmsg'])) {
	
	header("Location: send_msg.php?u=$user");
}

$error_message="";

	if(isset($_POST['addfriend'])){

		$friend_request = $_POST['addfriend'];

		$user_to = $user; 
		$user_from = $username;  

		if($user_to == $username){
			$error_message = "You can't send a friend request to yourself!";
		
		}
		else
		{
			
			$create_request = mysql_query("INSERT INTO friend_request VALUES('', '$user_from', '$user_to')");
			$error_message = "The request was sent!";
		}
	}
}

?>


 <script language = "javascript">
function toggle(id){
	  
	  var comment_div = "toggleComment_";
	  var comment_id = comment_div.concat(id);
	  var div = document.getElementsByClassName(comment_id);
	  for (var i = div.length - 1; i >= 0; i--) {
	  	
	  		if(div[i].style.display == "block"){
	  			div[i].style.display = "none";
			
	  		}
	  		else{
	 			div[i].style.display = "block";
			}
	  	};

}
 </script>




