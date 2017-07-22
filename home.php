<!DOCTYPE html>
 
<?php
  session_start();
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
 
 <?php
  $name= $_SESSION["username"];
  echo("<h1>".$name."</h1>");
 ?>
 </div>
 
 <div id= "welcome"> 
 <h1>Welcome</h1>
 </div>
 
 </body>
 
</html>