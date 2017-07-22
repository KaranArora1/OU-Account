<?php
 session_start();
 
 $host='localhost';
 $db_pword='redrose10';
 $db_uname='root';
 $dbname='myDB';
 
 $conn=mysqli_connect($host, $db_uname, $db_pword, $dbname);
 
 $username=(strval($_SESSION["username"]));
 
 $sql="DELETE FROM Account WHERE Username='$username'";
 
 mysqli_query($conn, $sql);
 
 session_unset();
 session_destroy();
 
 header("Location: index.php");
?>
 