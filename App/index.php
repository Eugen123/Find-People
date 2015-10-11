	<?php include("./inc/header.inc.php"); ?>

	<?php
	$reg = @$_POST['reg'];

		$fn="";
		$ln="";
		$un="";
		$em="";
		$passwd="";
		$passwd2="";
		$d="";
		$u_check="";

		$fn= strip_tags(@$_POST['fname']);
		$ln= strip_tags(@$_POST['lname']);
	    $un= strip_tags(@$_POST['uname']);
	  	$em= strip_tags(@$_POST['email']);
		$pass= strip_tags(@$_POST['passwd']);
		$pass2= strip_tags(@$_POST['cpasswd']);
		$d= date("Y-m-d");


		if($reg)
		{
			if($pass==$pass2)
				
				$u_check=mysql_query("SELECT username from users where username='$un'");
				$check=mysql_num_rows($u_check);
				$e_check=mysql_query("SELECT email from users where email='$em'");
				$email_check = mysql_num_rows($e_check);
				if($check == 0)
				{
					if($email_check==0){
					if($fn&&$ln&&$un&&$em&&$pass&&$pass2)
					{
						if($pass==$pass2)
						{
							
							if(strlen($un>25)||strlen($fn)>25||strlen($ln)>25)
							{
								echo "The maximum limit is 25 chars";
							}
								
							else 
							{
								if(strlen($pass)>30||strlen($pass)<5)
									{
										echo "The password must be between 5 and 30 chars long";
									}
								else 
								{
									$pass= md5($pass);
									$pass2=md5($pass2);
									$query=mysql_query("INSERT into users values('', '$un', '$fn', '$ln', '$em', '$pass', '$d', '0', '', '', '')");
									
									die("<h2> Welcome to findFriends </h2> Login to your account to get started...");
								}	
							}
							
						}
						else
						{
							echo "Your passwords dont match";
						}
					}	

					else{
							echo "Please fill all the fields";
						}
				}
		
				else
				{
					 echo "Username already taken...";
				}
		

		}	
	
				else{
					echo "The email is already registered!";
				}
			}


		//user login code

	if(isset($_POST["user_login"]) && isset($_POST["password_login"])){
		$user_login = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["user_login"]);
		$password_login = preg_replace('#[^A-Za-z0-9]#i', '' , $_POST["password_login"]);
		$password_login_md5 = md5($password_login);
		$sql = mysql_query("SELECT id FROM users WHERE username='$user_login' AND password='$password_login_md5'");
		$userCount = mysql_num_rows($sql);	
		if($userCount == 1){
			while($row = mysql_fetch_array($sql)){
				$id = $row["id"];
			}
			$_SESSION["user_login"] = $user_login;
			header("location: home.php");
			exit();


		}
		else {

		
			echo "That information is incorrect, try again";
			exit();
		}

	}

?>

			
			<table >
				<tr>
					<td width="60%" valign="top">
						<h2>Already a member? Sign in below!</h2>
						<form action="index.php" method="POST"> 
							<input type="text" name="user_login" size="25" placeholder="Username" /> <br /> <br />
							<input type="password" name="password_login" size="25" placeholder="Password" /> <br /> <br />
							<input type="submit" name = "login" value="Login">	
							
						</form>
					</td>
					<td width="40%" valign="top">
						<h2>Sign up Below!</h2>
						<form action="index.php" method="POST">

							<input type="text" name="fname" size="25" placeholder="First Name" /> <br /> <br />
							<input type="text" name="lname" size="25" placeholder="Last Name" /> <br /> <br />
							<input type="email" name="email" size="25" placeholder="Email" /> <br /> <br />
							<input type="text" name="uname" size="25" placeholder="User Name" /> <br /> <br />
							<input type="password" name="passwd" size="25" placeholder="Password" /> <br /> <br />
							<input type="password" name="cpasswd" size="25" placeholder="Confirm Password" /> <br /> <br />
							<input type="submit" name = "reg" value="Sign up">	
						</form>
					</td>
				</tr>
			</table>	
			
	<php include ("footer.inc.php"); ?>