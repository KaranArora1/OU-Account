<!DOCTYPE html>

<!-- Where you're directed after creating an account -->

<?php
	//Starts session
	session_start();
	
	//If the session username is set, it takes you to the homepage
	if (isset($_SESSION["username"])){
		header("Location:home.php");
		exit();
		}
	//If the session email isn't set, it takes you to index.php
	elseif (!(isset($_SESSION["email"]))){
		header("Location: index.php");
		exit();
		}
?>

<html> 
<head>
 	<title>Email</title>
 	<link rel="stylesheet" type="text/css" href="main.css">
</head>
<body> 
	<div class="head">
	<a href="index.php">Home</a>
	</div>
	
	<div class="welcome"> 
		<?php 
			  /*Prints a message in a green box stating the email 
			    was sent*/
			  $email=(strval($_SESSION["email"]));
			  echo '<p style= "width: 240px;';
			  echo 'margin-left: auto; margin-right: auto;';
			  echo 'margin-top: 30px; color: #21ba00;">';
			  echo "An email has been sent to $email for 
			   		authentication</p>";
			   
			  /*Unsets and destroys session so on refresh user is taken
				to index.php*/
			  session_unset();
			  session_destroy();
			  ?>
	</div>
	
</body>
</html>