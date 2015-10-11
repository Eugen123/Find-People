 <?php include("./inc/header.inc.php"); ?>
 <?php

 if(isset($_GET['u'])){
 	$user = mysql_real_escape_string($_GET['u']);
 	if(ctype_alnum($user)) {
 		$check = mysql_query("SELECT username, first_name FROM users WHERE username='$user'");
 		if(mysql_num_rows($check) === 1){
 			$get = mysql_fetch_assoc($check);
 			$user = $get['username'];
 			$firstname = $get['first_name'];
 		}
 		else 
 		{
 			echo "<meta http-equiv=\"refresh\" content=\"0; url=http://localhost/Licenta/App/index.php\">" ;
 			exit();
 		}
 	}
 }

$post = @$_POST['pst'];
 	if($post != "") {
 		$date_added = date("Y-m-d");
 		$added_by = $username;
 		$user_posted_to = $user;
 		
 		$query = mysql_query("INSERT INTO 	posts VALUES ('', '$post', '$date_added', '$added_by', '$user_posted_to')");
 		
 		$query = mysql_query("SELECT id from posts WHERE 1 order by id desc");
 		$max_id = mysql_fetch_assoc($query);
		$id = $max_id['id'];
 		
 		$query = mysql_query("INSERT INTO 	post_comments VALUES ('', null, null, null, '$id')");
 	}
 	

//check if the user has uploaded a photo
$check_pic = mysql_query("SELECT profile_pic from users where username = '$user'");
$get_pic_row = mysql_fetch_assoc($check_pic);
$profile_pic_db = $get_pic_row['profile_pic'];
if($profile_pic_db == ""){
$profile_pic = "img/profile.png";
}

else{
	$profile_pic = "userdata/profilepics/".$profile_pic_db;
}


 ?>
<div class="postForm" >
<form action="<?php echo $user; ?>" method="POST">

<div	id="status">
</div>
		<textarea id="post" name="pst" rows="4" cols="78"> </textarea>
		<input type="submit"  name="send" value="Post" style="bacground-color: #dce5ee; float: right; border: 1px solid #666; "> 

</form>	
</div>
<div class="profilePosts" >
<?php
$getposts = mysql_query("SELECT * FROM posts WHERE user_posted_to = '$user' order by id desc") or die(mysql_error());
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

	echo 
	"<div style='float:left;''>
	<div style='width:580px'>
	<img src= '$img_path' height='40'/>
	
	
	<div class='posted_by' >
    <a href= '$added_by' > $added_by: </a>  ".$passed_days_text."
    </div>
    <div style='max-width:800px'> <br />
    $body <br /> <br /> <hr />
    </div> 
    </div>
    </div>";
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
			$error_message = "<br />The request was sent!";
		}
	}


?>
 </div>
<img src="<?php echo $profile_pic; ?>" height="250" width="200" alt="<?php echo $user; ?>'s Profile" title="<? echo $user; ?>'s Profile" />
<br />

<form action = "<?php echo $user; ?>" method = "POST">
<?php

$countFriends = "";

$selectFriends = mysql_query("SELECT user_friends FROM friends WHERE user = '$user'");
$countFriends = mysql_num_rows($selectFriends);
	
if (strcmp($user, $username) != 0) {

	$check_if_friend = mysql_query("SELECT user_friends from friends where user='$username' && user_friends = '$user'");
	$fetch = "";
	$friend_user = "";

	if (mysql_num_rows($check_if_friend)!=0) {
		$fetch = mysql_fetch_assoc($check_if_friend);	
		$friend_user = $fetch['user_friends'];
	}


	if ($friend_user == $user) {
		$addAsFriend = '<input type = "submit" name="removeFriend" value="Unfriend">';
	}
	else{
		$addAsFriend = '<input type = "submit" name="addfriend" value="Add as Friend ">';
	}
	
	echo $addAsFriend;
}


if (@$_POST['removeFriend']) {
	$delete =mysql_query(("DELETE from friends where username = '$username' && user_friends == '$user'"));
	$delete = mysql_query(("DELETE from friends where username = '$user' && user_friends == '$username'"));
	//friend array for user who owns the profile
	echo "Friend Removed"; 
	header("Location: $user");
}



?>
	<?php

	echo $error_message;
	echo "<br />";
	if (strcmp($user, $username)) {
		echo'<input type="submit" name="sendmsg" value="Send Message" />';
}
		?>

</form>





<div class="textHeader"> 
	<?php 
		if (strcmp($user, $username) != 0) {
			echo $user."'s";
		}
		else{
			echo "Your";
		}	
	?> profile </div>
<div class="profileLeftSideContent">
<?php
	$about_query = mysql_query("SELECT bio from users where username = '$user'");
	$get_result = mysql_fetch_assoc($about_query);
	$about_the_user = $get_result['bio'];
	echo $about_the_user;

?>
</div>
<div clas="textHeader" > 
	<?php 
		if (strcmp($user, $username) != 0) {
			echo $user. "'s";
			} 
		else{
			echo "Your ";
		}	
	?> friends </div>
<div class="profileLeftSideContent"> 
	<?php 
	
	if($countFriends != 0){
		while ($friends = mysql_fetch_assoc($selectFriends)) {
			
			$friend = $friends['user_friends'];	
		
			$getFriendQuery = mysql_query("SELECT * from users where username = '$friend' LIMIT 2");
			$getFriendRow = mysql_fetch_assoc($getFriendQuery);
			$friendUsername = $getFriendRow['username'];
			$friendProfilePic = $getFriendRow['profile_pic'];

			if ($friendProfilePic== "" && $friendUsername != '') {
				echo "<a href= '$friendUsername'><h2> $friendUsername </h2> <img src ='./img/profile.png' title = '$friendUsername' height = '90' width = '90' style='padding-right: 6px;' /> </a>";
				
			}
			else
				if($friendUsername != ''){
				echo "$friendUsername<br>'<img src ='userdata/profilepics/$friendProfilePic' title = '$friendUsername' height = '50' width = '40' style='padding-right: 6px;'></a>";
			}
		}
	}

	else
		if (strcmp($user, $username) != 0) {
			echo $user. " has no friends";
		}
		else{
			echo "You have no friend";
		}

	?>

	
</div>
<div clas="textHeader" > 
	<?php 
		if (strcmp($user, $username) != 0) {
			echo $user."'s"; 
		}
		else{
			echo "Your";
		}
			
	?>
	 albums </div>
<div class="profileLeftSideContent"> 
<a href = "view_albums.php?u=<?php echo $user;?>" >Albums </a>
<!--<input type="submit" name="view_albums" value="Albums" />!-->
</div>
</div> 