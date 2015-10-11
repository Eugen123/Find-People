<link rel="stylesheet" type="text/css" href="./css/style.css" />

 <?php
include("./inc/header.inc.php");
?>
<h2>Create your like button </h2> <hr />
<br />
<form action="create_like_button.php" method ="POST">
<input type="text" name="like_button_url" value ="Enter the url of the page" onclick="value=''">
<input type="submit" name="create" value="Create" />	
	</form>

	<?php

if (isset($_POST['like_button_url'])) {
	$like_button_url = strip_tags($_POST['like_button_url']);
	
	$like_button_url2 = strstr($like_button_url, 'http://');
	if ($like_button_url2) {
		
		$date = date("Y-m-d");
		$uid = rand(1,9999999);
		$uid = md5($uid);

		$b_check=mysql_query("SELECT page_url from like_buttons where page_url='$like_button_url'");
		$num_rows_check = mysql_num_rows($b_check);
		if($num_rows_check == 0)
		{

		
		$create_button = mysql_query("INSERT INTO like_buttons values('','$user', '$like_button_url', '$date', '$uid')");
		$insert_like = mysql_query("INSERT INTO likes values('', '$user','-1', '$uid' )");

		echo '
		<div style="width: 400px; height: 250px; border: 1px solid #cccccc;">
		&lt;iframe src="http://localhost/Licenta/App/like_button_frame.php"?uid=$uid" style="border:0px; height: 35px; width: 100px;"&gt;

		&lt;/iframe &gt;
		</div>';
	}
	}
	else{
		 $like_button_url = "http://".$like_button_url; 
		
		$date = date("Y-m-d");
		$uid = rand(1,9999999);
		$uid = md5($uid);
		$create_button = mysql_query("INSERT INTO like_buttons values('','$user', '$like_button_url', '$date', '$uid')");
		$insert_like = mysql_query("INSERT INTO likes values('', '$user','-1', '$uid' )");
		echo '
		<div style="width: 400px; height: 250px; border: 1px solid #cccccc;">
		&lt;iframe src='."http://localhost/Licenta/App/like_button_frame.php?uid=$uid".' style="border:0px; height: 35px; width: 100px;"&gt;

		&lt;/iframe &gt;
		</div>';
	} 
	


}
	?>