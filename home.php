<!DOCTYPE html>
 
 <!-- Where you are directed if account creation or 
 sign-in is a success -->
 
<?php
  //Starts session
  session_start();
  
  /*If the session username isn't set, you're 
  taken to signin.php */
  if (!isset($_SESSION["username"])){
  	header("Location: signin.php");
  	}
  	
  //Sets name variable
  $name= $_SESSION["username"];
  ?>
 
<html>

 <head>
  <title>Home</title>
  <link rel="stylesheet" type="text/css" href="main.css">
 </head>
 
 <body>
 <div class="head">
 <a href="signout.php">Sign Out</a>
 <a id="delete" href="delete.php">Delete Account</a>
 
 <!-- Displays your username in the header -->
 <?php
  echo("<h1>".$name."</h1>");
 ?>
 </div>
 <!-- Welcome message -->
 <div class= "welcome"> 
 <h1>Welcome</h1>
 </div>
 
 </body>
 
</html>