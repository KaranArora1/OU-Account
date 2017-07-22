<!DOCTYPE html>

<!-- Sign-in page -->

<?php
 //Starts session
 session_start();
 //If session username is set, it takes you to home.php
 if (isset($_SESSION["username"])){
 	header("Location: home.php");
 	}
?>

<html>
<head>
 <title>Sign in</title>
 <link rel="stylesheet" type="text/css" href="main.css">
</head>

<body>

<div class="title" id="title-sign">
 <h2>Sign-in with an Existing Account</h2>
</div>
	
<div class="head">
 <a href="index.php">Create an Account</a>
</div>

<!-- Where you enter information to sign in -->
<div class="create" id="create-sign">

<!-- Takes input to signhandler.php with POST method -->
 <form action="/signhandler.php" method="POST">
 	Username:<br>
 	<input type="text" name="username"><br><br>
 	Password:<br>
 	<input type="password" name="password">
 	<input type="submit" value="Sign in">
 </form>
</div>

<!-- If there is a session error then it displays it at the 
top of the screen -->
<?php
if (isset($_SESSION["error"])){
	$error=$_SESSION["error"];
		 	
	echo '<div';
		 	
	echo ' style="background-color: rgba(255, 86, 86, 0.5);'; 
	echo ' height:50px; width: 325px;';
	echo ' border: 1px solid #fc4444;';
	echo ' margin-left:auto; margin-right: auto;';
	echo ' margin-top: -275px;">';
		 	
	echo '<p'; 
	echo ' style="width: 290px; color: #cc2b22;';
	echo ' padding-left:13px; padding-top:1px;';
	echo ' margin-left: auto; margin-right: auto;">';
		 	
	echo "$error</p>";
		 	
	echo "</div>";
	
	/*Unsets and destroys session so error message goes
	away on refresh */
	session_unset();
	session_destroy();
	}
?>

</body>
</html>