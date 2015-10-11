 <?php
include("./inc/header.inc.php");
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
 
 ?>
<h2><?php echo $user. "'s"; ?> Albums</h2> <hr />
<table>
	<tr>

<?php


$get_albums = mysql_query("SELECT * FROM albums where created_by = '$user'");
$num_rows = mysql_num_rows($get_albums);


while ($row = mysql_fetch_assoc($get_albums)) {
	$id = $row['id'];
	$album_title = $row['album_title']; 
	$album_description = $row['album_description'];
	
	$date_created = $row['date_created'];

	$get_photos = mysql_query("SELECT * FROM photos where uid = '$album_title' && username = '$user'");
	$num_rows = mysql_num_rows($get_photos);
	$photo_row = mysql_fetch_assoc($get_photos);
	$id_photo = $photo_row['id'];
	$uid = $photo_row['uid'];
 	$user = $photo_row['username'];
 	$date = $photo_row['date_posted'];
 	$description = $photo_row['description']; 
 	$image_url = $photo_row['image_url'];

 	if (isset($_POST['delete_album_'.$album_title.''])) {
	echo "Removed";
	$delete_query = mysql_query("DELETE from albums where album_title = '$album_title'");
	header("Location: view_albums.php?u=$user");
}

	echo " 
	<td>
		<div class='albums'>";
		
		echo "
			<a href='view_photo.php?uid=$album_title'>;


			<img src=$image_url style='width: 200px; height:200px;'>
			$album_title
			</a>
			<center>";
			if($user == $username)
			echo	"
		<form method='POST' action='view_albums.php?u=$username'>
		<input type='submit' name='delete_album_$album_title' value='Remove'>
		</form>
		</center>
		</div>
	</td>	
	

	";

	
}

if (isset($_POST['create_album'])) {
	$album_title = @$_POST['album_title'];
	$album_description = @$_POST['album_description'];
	$date = date('Y-m-d');
	mkdir("./userdata/albums/$album_title");
	$insert_album = mysql_query("INSERT INTO albums values('', '$album_title', '$album_description', '$username', '$date')");

	header("Location: view_albums.php?u=$user");
}
	
	
?>
</tr>
<tr>
	<td><br> <br> <br> <br>
		<h2> Create a new album </h2> <br />
		<form method="POST" action="view_albums.php?u=<?php echo $user; ?>">
			Title<input type='text' name='album_title'> <br />
			Description<input type='text' name='album_description'> <br />
			<input type='submit' name='create_album'>
		
	</form>
	</td>
</tr>
</table>