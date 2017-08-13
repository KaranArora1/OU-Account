<!DOCTYPE html>

<!-- Main page of website. Allows you to create an account -->

<?php
 //Starts session
 session_start();
 //If the session username is set, it takes you to home.php
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
		
		<!-- Directs form to a php file that sends email   
			using POST method -->
		<form action="/createhandler.php" method= "POST"> 
		
			Username:<br>
			<input type="text" name="username"><br><br>
			
			Password:<br>
			<input type="password" name="password"><br>
			<p class="charlimit"><i>
			Password must be at least 4 characters</i></p>
			
			Confirm Password: 
			<input type="password" name="confirm"><br><br>
			
			Email:
			<br><input type="text" name="email"><br>
			<p class="charlimit"><i>
			A message will be sent to this email for 
			authentication</i></p>
			
			<input type="submit" value="Create Account">
		</form>
		</div> 
		
		<div class="title" id="title-index">
		<h2>Create an Account</h2>
		</div>
		
		<!-- If a session error is set it displays it at the top of
		the screen -->
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
		 	
		 	/*Unsets and destroys session so the error message 
		 	goes away on refresh */
		 	session_unset();
			session_destroy();
		 		  }
		?>
		
	</body>

</html>
