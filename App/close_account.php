 <?php

include("./inc/header.inc.php");
//back
if (isset($_POST['no'])) {
header("Location: account_settings.php");

}

//delete
if (isset($_POST['yes'])) {
	
$delete_account = mysql_query("DELETE FROM users where username='$username'");
	echo "Account deleted!";
	session_destroy();
	}	
?>

 <br />

 <center>
<form action="close_account.php" method="POST">

Are you sure?<br />
<input type="submit" name="no" value="No, take me back!">
<input type="submit" name="yes" value="I am sure">
</form>	
 </center>