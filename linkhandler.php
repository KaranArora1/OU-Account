<?php
 //Starts session
 session_start();
 
 //Sends you to your homepage if username is set
 if (isset($_SESSION["username"])){
		header("Location:home.php");
		exit();
		}
 
 /*Function that returns true if the code in the link corresponds to
   an account, and that account is inactive*/
 function checker($newsql, $newconn, $newcode) {
 
 	$result= mysqli_query($newconn, $newsql);
 	if (mysqli_num_rows($result) > 0){
 		while ($row=mysqli_fetch_assoc($result)){
 			//Unhashes string in table and compares it to first param.
 			 if ((password_verify($newcode, $row["String"])
 			  	 and ($row["Status"]=="Inactive"))){
 					//Set session username
 					$_SESSION["username"]=$row["Username"];
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
 $code=(strval($_GET['code']));
 
 /*If the function is false it must mean someone tried typing
   the URL in to gain access to an account (the account wasn't 
   real or is already activated). As a result you're taken to
   index.php, and the session is unset and destroyed.*/
 $sql= "SELECT String, Status, Username FROM Account";
 
 if (!(checker($sql, $conn, $code))){
 	//Unsets and destroys session
 	session_unset();
 	session_destroy();
 	
 	//Starts session
 	session_start();
 	//Sets session error
 	$_SESSION["error"]= "Account does not exist";
 	header("Location: index.php");
 	exit();
 	}
 
 $username= $_SESSION["username"];
 
/* ORIGINAL CODE
 $sql= "UPDATE Account
 		SET Status='Active'
 		WHERE Username= '$username';";
 
 mysqli_query($conn, $sql);*/
 
 /*Updates account column to make user's account active and prevents
   SQL injection */
   
  /*Initializes object, prepares statement, binds parameters into
   prepared statement, executes statement and closes it */
 $stmt= mysqli_stmt_init($conn);
 
 mysqli_stmt_prepare($stmt, "UPDATE Account SET Status='Active'
 WHERE Username=?");
 
 mysqli_stmt_bind_param($stmt, "s", $username);
 
 mysqli_stmt_execute($stmt);
 mysqli_stmt_close($stmt);

 //Takes you to home page
 header("Location: home.php");
 
 //Closes SQL Connection
 mysqli_close($conn);
 ?>