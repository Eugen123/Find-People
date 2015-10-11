<link rel="stylesheet" type="text/css" href="./css/style.css" />

 <?php
session_start();
if(isset($_SESSION['user_login'])){
	
$username = $_SESSION['user_login'];
}
else{
	$username="";
}

 include("./inc/connect.inc.php");
$id='4'; 
if(isset($_GET['uid'])){

 	$uid = mysql_real_escape_string($_GET['uid']);
 	if(ctype_alnum($uid)) { 

$get_likes = mysql_query("SELECT total_likes, uid from likes where uid = '$uid'");
if(mysql_num_rows($get_likes) === 1){
 			$get = mysql_fetch_assoc($get_likes);
 			$total_likes = $get['total_likes'];
 			 $total_likes = $total_likes + 1; 
 			 $remove_likes = $total_likes - 2;
 			$uid = $get['uid'];
 			
 		}
 else 
 	{
 		$user_likes = mysql_query("INSERT INTO user_likes values('', '$username', '$uid')");
 		$user_likes = mysql_query("INSERT INTO likes values('', '$uid', '1', '$username')");

	}

 if (isset($_POST["like_button"])) {
   echo "rahat pe paine";
 	$like = mysql_query("UPDATE likes SET total_likes = '$total_likes' where uid='$uid'");
 	$user_likes = mysql_query("INSERT INTO user_likes values('', '$username', '$uid')");
 	header("Location: like_button_frame.php?uid=$uid");
 }

 if (isset($_POST["unlike_button"])) {
   $total_likes = $total_likes -1;
 	$like = mysql_query("UPDATE likes SET total_likes = '$remove_likes' where uid= '$uid'");
 	$user_likes = mysql_query("INSERT INTO user_likes values('', '$username', '$uid')");
 	$remove_like  = mysql_query("DELETE FROM user_likes where uid = '$uid' ");
 	header("Location: like_button_frame.php?uid=$uid");
 }
}

 //check for previous likes
 
$check_for_likes = mysql_query("SELECT * from user_likes where user='$username' && uid='$uid'");
$num_rows = mysql_num_rows($check_for_likes);
if($num_rows >= 1) {
	echo '<form action="like_button_frame.php?uid='.$uid.'  " method="POST">
<input type="submit" name="unlike_button" value="Unlike" >
<div style="display: inline;">
	 '.$total_likes. 'likes 
 </div>
 </form>'; 
}
else if ($num_rows == 0)  {
     echo '
 <form action="like_button_frame.php?uid='.$uid.'" method="POST">
<input type="submit" name="like_button" value="Like" >
<div style="display: inline;">
	 '.$total_likes. 'likes 
 </div>
 </form> ';

}

 
}
?>