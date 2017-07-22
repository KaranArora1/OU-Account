<?php
 //Starts session
 session_start();
 
 //Variables for connection to database
 $host='localhost';
 $db_uname='root';
 $db_pword='redrose10';
 $dbname= 'myDB';
 
 //Function that connects to database
 $conn = mysqli_connect($host, $db_uname, $db_pword, $dbname);
 
 //Casts input to strings and gets them with POST
 $username= (strval($_POST["username"]));
 $password= (strval($_POST["password"]));
 
 $uselen=(strlen($username));
 $passlen=(strlen($password));
 
 if (($uselen==0) or ($passlen==0)){
 	$_SESSION["error"]="Please fill in all fields";
 	header("Location:signin.php");
 	exit();
 	}
 
 /*Selects the Username and Password columns from the Account 
 table*/
 $sql="SELECT Username, Password FROM Account";
 
 $result=mysqli_query($conn, $sql);
 
 /*Checks to see if there are more than 0 rows in the table. 
   If there are, it goes through each row and compares the 
   username and password entered by the user to the usernames
   and passwords in the columns. If it finds a match, it
   directs the user to home.php. If not, or if there's 0 
   rows, it direxts the user back to the sign-in page. */
 if (mysqli_num_rows($result)> 0) {
 	while ($row=mysqli_fetch_assoc($result)){
 		if (($row["Username"]==$username) and 
 		($row["Password"]==$password)){
 			header("Location: home.php");
 			
 			//Sets session username
 			$_SESSION["username"]= $username;
 			
 			//Closes mysql connection to database
			mysqli_close($conn);
 			exit();
 			}
 		else{
 			$_SESSION["error"]="Incorrect username or password";
 			header("Location: signin.php");
 			}
 		}
 	}
 else{
 	header("Location: signin.php");
 	}
 ?>