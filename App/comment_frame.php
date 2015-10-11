<?php

session_start();
if(isset($_SESSION['user_login'])){
	
$username = $_SESSION['user_login'];
}
else{
	$username="";
}
?>
<style>
*{
	font-size: 12px;
	font-family: Arial, Helvetica, Sans-serif;
}
</style>

<?php


include("./inc/connect.inc.php");

$getid = $_GET['id'];
?>

 <script language = "javascript">
function toggle(){
	 var ele =document.getElementById("toggleComment");
	 var text = document.getElementById("displayComment");	
	 	var id =document.getElementById("displayComment");
	 	if(ele.style.display == "block"){
	 		ele.style.display = "none";
			
	 	}
	 	else{
	 		ele.style.display = "block";
			
	 	}

	

}
 </script>
 <?php
if (isset($_POST['postComment'. $getid.''])) {
$post_body =$_POST['post_body'];
$posted_to = "";	
$insert_post =mysql_query("INSERT INTO post_comments values('', '$post_body', '$username', '$posted_to', '$getid')");	
}
 ?>

<a href = "javascipt:;" onClick="jvascript:toggle()"><div style='float: right; display: inline;'> Post </div></a>
<div id ='toggleComment' style='display: none;'>

<form action="comment_frame.php?id=<?php echo $getid; ?>" method = "POST" name ="postComment<?php echo $getid; ?>">
	Enter your comment below : <p />
	<textarea rows="30" cols="100" style='height:50px;' name="post_body"> </textarea>
<input type="submit" name = "postComment<?php echo $getid; ?>" value="Post Comment">
</form>

</div>
<?php

$getComments = mysql_query("SELECT * from post_comments where post_id='$getid'");
$count = mysql_num_rows($getComments);
if ($count > 1) {
		
	
	while($comment = mysql_fetch_assoc($getComments)){
	
	$commment_body = $comment['post_body'];
	$commented_by = $comment['poted_by'];
	$commment_post_id = $comment['post_id']; 
	if ($commment_body != "") {
		echo "<b>$commented_by</b>: ".$commment_body."<br><hr />";
	}
	
}

}
else{

	echo "<br /><br /><br /><br /> <center>No commnens to show!</center><hr />";

}
?>