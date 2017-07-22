<!DOCTYPE html>

<!-- Checks if user is already logged in. If this is true 
     it redirects him to home.php -->
<?php
 session_start();
 if (isset($_SESSION["username"])){
 	header("Location: home.php");
 	}
?>

<html>
	
	<head>
		<title>Sign Up</title>
		<link rel="stylesheet" type="text/css" href="main.css">
	</head>
	
	<body>
		<div class="head">
		 <a href="signin.php">Sign In</a> 
		</div>
		
		<!-- Div for form to create a new account -->
		<div class= "create" id="create-index">
		
		<!-- Directs form to a php file that inserts input into  
			 database using POST method -->
		<form action="/createhandler.php" method= "POST"> 
			Username:<br>
			<input type="text" name="username"><br><br>
			Password:<br>
			<input type="password" name="password"><br><br>
			Confirm Password: 
			<input type="password" name="confirm"><br>
			<p id="charlimit"><i>
			Password must be at least 4 characters</i></p>	
			<input type="submit" value="Create Account">
		</form>
		</div> 
		
		<div class="title" id="title-index">
		<h2>Create an Account</h2>
		</div>
		
		<?php
		 if (isset($_SESSION["error"])){
		 	$error=$_SESSION["error"];
		 	
		 	echo '<div';
		 	
		 	echo ' style="background-color: rgba(255, 86, 86, 0.5);'; 
		 	echo ' height:50px; width: 325px;';
		 	echo ' border: 1px solid #fc4444;';
		 	echo ' margin-left:auto; margin-right: auto;';
		 	echo ' margin-top: -150px;">';
		 	
		 	echo '<p'; 
		 	echo ' style="width: 290px; color: #cc2b22;';
		 	echo ' padding-left:13px; padding-top:1px;';
		 	echo ' margin-left: auto; margin-right: auto;">';
		 	
		 	echo "$error</p>";
		 	
		 	echo "</div>";
		 	
		 	session_unset();
			session_destroy();
		 		  }
		?>
		
	</body>

</html>