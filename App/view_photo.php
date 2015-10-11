 <?php
include("./inc/header.inc.php");
if(isset($_GET['uid'])){
 	$picture = mysql_real_escape_string($_GET['uid']);
 	if(ctype_alnum($picture)) {
 		$check = mysql_query("SELECT * FROM photos WHERE uid='$picture'");
 		
 			$get = mysql_fetch_assoc($check);
 			$uid = $get['uid'];
 			$user_name = $get['username'];
 			$date = $get['date_posted'];
 			$description = $get['description']; 
  
 ?>
<h2><?php echo $username. "'s"; ?> Photos</h2> <hr />
<table>
	<tr>

<?php
}
	
$get_photos = mysql_query("SELECT * FROM photos where uid = '$picture'");
$num_rows = mysql_num_rows($get_photos);
while ($row = mysql_fetch_assoc($get_photos)) {
	$id = $row['id'];
	$uid = $row['uid'];
 	$user = $row['username'];
 	$date = $row['date_posted'];
 	$description = $row['description']; 
 	$image_url = $row['image_url'];
 	$image_id = $row['img_id'];
 	$md5_image = md5($image_url);
	
 	if (isset($_POST['delete_photo_'.$md5_image.''])) {
	echo "Removed";
	$delete_query = mysql_query("DELETE from photos where img_id = '$image_id'");
	header("Location: view_photo.php?uid=$picture");
}
	echo " 
	<td>
		<div class='albums'>
			<img src='$image_url' height='170' width='170' /><br />
			$description
		</div>";
		if($user == $username)
			echo
		"
		<center>
		<form method='POST' action='view_photo.php?uid=$picture'>
		<input type='submit' name='delete_photo_$md5_image' value='Remove'>
		</form>
		</center>
	</td>	
	

	";


}


		
 		
 	}
 

 

?>

<?php
if (isset($_POST['uploadpic'])) {
	if ((@$_FILES['albumpic']['type']=='image/png') || (@$_FILES['profile']['type']=='image/jpg')) {
		
		$album_title = @$_GET['uid'];
		if(file_exists("userdata/albums/$album_title".@$_FILES["albumpic"]["name"].@$_FILES["albumpic"]["name"]))	
		{

		}
		else{
			$date = date('Y-m-d');
			move_uploaded_file($_FILES["albumpic"]["tmp_name"], "userdata/albums/$album_title"."/".@$_FILES["albumpic"]["name"]);
			$profile_pic_name = @$_FILES["albumpic"]["name"];
			$image_id_before_md5 = "$album_title/$profile_pic_name";
			$image_id = md5($image_id_before_md5);
			$profile_pic_query = mysql_query("INSERT INTO photos values('', '$album_title', '$username', '$date', '', 'http://localhost/Licenta/App/userdata/albums/$album_title/$profile_pic_name', '$image_id')");
            echo mysql_error();
            header("Location: view_photo.php?uid=$picture");
		}
}
}
else{
	//echo "Try another file type!";
}
?>


</tr>
</table>


<h2> Upload your photos </h2>
<hr />
 <form action="" method="POST" enctype="multipart/form-data">
 	
 	<input type="file" name="albumpic" /> <br />
 	<input type="submit" name ="uploadpic" /> <br />
 </form>
