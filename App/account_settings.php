 <?php

 include("inc/header.inc.php");
if($username){
	
}

else{
	die("You are not logged");
}

 ?>

<?php
$senddata = @$_POST['senddata'];

//Password variables
$old_password = @$_POST['oldpassword'];
$new_password = @$_POST['newpassword'];
$repeat_password = @$_POST['repeatpassword'];

if ($senddata) {

	$password_query = mysql_query("SELECT * FROM users where username = '$username'" );
	while ($row = mysql_fetch_assoc($password_query)) {
		$db_password = $row['password'];
		
		$old_password_md5 = md5($old_password);

		if ($old_password_md5 == $db_password) {
				
			if ($new_password == $repeat_password) {

				if (strlen($new_password) <= 4) {
					echo "sorry";
				}
				else{
				$md5_password = md5($new_password);
				$password_update_query = mysql_query("UPDATE users SET password = '$md5_password' WHERE username = '$username'");
				echo "Success!";
			}
			
		}	
		else
		{
			echo "Password does not match!";
		}
	}
	}
}

else
{
	//echo "send some data";
}

$get_info = mysql_query("SELECT first_name, last_name, bio from users where username = '$username'");
$get_row = mysql_fetch_assoc($get_info);
$firstname = $get_row['first_name'];
$lastname = $get_row['last_name'];
$bio = $get_row['bio'];

//submit 
if ($senddata) {
$form_fname = @$_POST['fname'];
$form_lname = @$_POST['lname'];
$form_bio = @$_POST['bio'];	
}


//check if the user has uploaded a photo
$check_pic = mysql_query("SELECT profile_pic from users where username = '$username'");
$get_pic_row = mysql_fetch_assoc($check_pic);
$profile_pic_db = $get_pic_row['profile_pic'];
if($profile_pic_db == ""){
$profile_pic = "img/profile.png";
}

else{
	$profile_pic = "userdata/profilepics/".$profile_pic_db;
}
//profile image upload

if(isset($_FILES['profilepic'])){
	if ((@$_FILES['profilepic']['type']=='image/png') || (@$_FILES['profile']['type']=='image/jpg')) {
		$chars = "abcdefghijklmnopqrstuvxyzABCDEFGHIJKLMNOPQRSTUVXYZ1234567890";
		$rand_dir_name = substr( str_shuffle($chars),0,15);
		mkdir("./userdata/profilepics/$rand_dir_name");

		if(file_exists("userdata/profilepics/$rand_dir_name".@$_FILES["profilepic"]["name"].@$_FILES["profilepic"]["name"]))	
		{

		}
		else{

			move_uploaded_file($_FILES["profilepic"]["tmp_name"], "userdata/profilepics/$rand_dir_name"."/".@$_FILES["profilepic"]["name"]);
			$profile_pic_name = @$_FILES["profilepic"]["name"];
			$profile_pic_query = mysql_query("UPDATE users SET profile_pic = '$rand_dir_name/$profile_pic_name' WHERE username = '$username'");
            
            header("Location: account_settings.php");
		}	

		}

	else{
		
		echo "Invalid file! Please upload a jpeg or png file.";
	}
}
	else{
	
		//echo "profile pics is not set 2";
	
	}




	$updateinfo = @$_POST['updateinfo'];
	if ($updateinfo) {
		$new_fname = $_POST['fname'];
		$new_lname = $_POST['lname'];
		$new_bio = $_POST['aboutyou'];
		
		$update = mysql_query("UPDATE users set first_name = '$new_fname', last_name = '$new_lname', bio = '$new_bio' where username = '$username'");
		header("Location: account_settings.php");
	}

?>
 <h2> Edit your account settings </h2>
 <hr />
 <p><h3> Upload Your Profile photo</h3> </p>
 <form action="" method="POST" enctype="multipart/form-data">
 	<img src="<?php echo $profile_pic;  ?>" />
 	<input type="file" name="profilepic" /> <br />
 	<input type="submit" name ="uploadpic" value = "Upload" /> <br />
 </form>
 <hr />
 <form action="account_settings.php" method="post">
 <p><h2>Change Your Password:</h2> </p>
<div><h3>Your old password</h3> </div><input type="password" name="oldpassword" id="oldpassword" size="30"><br /> <br />
<div><h3>Your new password</h3></div><input type="password" name="newpassword" id="newpassword" size="30"><br /> <br />
<div><h3>Repeat password</h3></div><input type="password" name="repeatpassword" id="repeatpassword" size="30"><br /> <br />

<input type="submit" name="senddata" id="senddata" value="Change Password">

</form>
<hr />

<form action="account_settings.php" method="POST">
<p> <h2>Update your profile info</h2></p> <br /> <br /> 
<div><h3>First Name </h3></div><input type="text" name="fname" id="fname" size="40" value="<?php echo $firstname; ?>"><br /> <br /> 
<div><h3>Last Name</h3></div><input type="text" name="lname" id="lname" size="40" value="<?php echo $lastname; ?>"><br /> <br />
<div><h3>About you </h3> </div><textarea type="text" name="aboutyou" id="aboutyou" cols="70" rows="7" value=""> <?php  echo $bio; ?> </textarea> <br /> <br />

<hr />
<input type="submit" name="updateinfo" id="updateinfo" value="Update">

</form>

<form type="" action="close_account.php" method="POST">

<h2> Close account</h2> <br />

<input type="submit" name="delete_account"  value="Close Account">

</form>