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
  $name= $_SESSION["username"];
  echo("<h1>".$name."</h1>");
 ?>
 </div>
 <!-- Welcome message -->
 <div id= "welcome"> 
 <h1>Welcome</h1>
 </div>
 
 </body>
 
</html>