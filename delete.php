<!-- Deletes user's account -->

<?php
 //Starts session
 session_start();
 
 //Variables inserted into connection
 $host='localhost';
 $db_pword='redrose10';
 $db_uname='root';
 $dbname='myDB';
 
 //Connection variable 
 $conn=mysqli_connect($host, $db_uname, $db_pword, $dbname);
 
 /*Gets username from session variable and casts it to 
 a string */
 $username=(strval($_SESSION["username"]));
 
 //Deletes user's account
 $sql="DELETE FROM Account WHERE Username='$username'";
 
 mysqli_query($conn, $sql);
 
 //Unsets and destroys session
 session_unset();
 session_destroy();
 
 //Directs you to index.php
 header("Location: index.php");
?>
 