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
 
 /*ORIGINAL CODE
 //Deletes user's account
 $sql="DELETE FROM Account WHERE Username='$username'";
 mysqli_query($conn, $sql);
 */
 
 //Statements below prevent SQL injection
 
 /*Initializes object, prepares statement, binds parameters into
   prepared statement, executes statement and closes it */
 $stmt= mysqli_stmt_init($conn);
 
 mysqli_stmt_prepare($stmt, "DELETE FROM Account WHERE Username=?");
 
 mysqli_stmt_bind_param($stmt, "s", $username);
 
 mysqli_stmt_execute($stmt);
 mysqli_stmt_close($stmt);
 
 //Unsets and destroys session
 session_unset();
 session_destroy();
 
 //Directs you to index.php
 header("Location: index.php");
?>
 
 