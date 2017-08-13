<?php
 //Starts session
 session_start();
 
 /*Function that returns true if the username entered in the 
 link query is real and inactive*/
 function checker($newsql, $newconn, $newusername) {
 
 	$result= mysqli_query($newconn, $newsql);
 	if (mysqli_num_rows($result) > 0){
 		while ($row=mysqli_fetch_assoc($result)){
 			if (($row["Username"]== $newusername) and 
 				($row["Status"]=="Inactive")){
 				return true;
 			}
 		}
 	}
 }
 
 //Variables inserted into connection
 $host='localhost';
 $db_uname='root';
 $db_pword='redrose10';
 $dbname='myDB';
 
 //Connection variable 
 $conn = mysqli_connect($host, $db_uname, $db_pword, $dbname);

 /*Gets the username specified in the query from URL emailed 
   to the user*/
 $username=(strval($_GET['username']));
 
 /*If the function is false it must mean someone tried typing
   the URL in to gain access to an account (the account wasn't 
   real or is already activated). As a result you're taken to
   index.php, and the session is unset and destroyed.*/
 $sql= "SELECT Username, Status FROM Account";
 
 if (!(checker($sql, $conn, $username))){
 	session_unset();
 	session_destroy();
 	header("Location: index.php");
 	exit();
 	}
 			
 //Updates account column to make user's account active
 $sql= "UPDATE Account
 		SET Status='Active'
 		WHERE Username= '$username';";
 
 mysqli_query($conn, $sql);
 
 //Sets session username
 $_SESSION["username"]= $username;

 //Takes you to home page
 header("Location: home.php");
 
 //Closes SQL Connection
 mysqli_close($conn);
 ?>