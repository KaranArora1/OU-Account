<?php
 //Starts session
 session_start();
 
  //Variables inserted into connection
 $host='localhost';
 $db_uname='root';
 $db_pword='redrose10';
 $dbname='myDB';
 
 //Connection variable and function
 $conn = mysqli_connect($host, $db_uname, $db_pword, $dbname);
 
 /*Casts each input received by POST into a string and then assigns
   it a variable */
 $username= (strval($_POST["username"]));
 $password= (strval($_POST["password"]));
 $confirm= (strval($_POST["confirm"]));  
 
 /*Gets length of password and directs you back to "Create an 
 Account" if it's less than 4 characters */
 $passlen=strlen($password);
 $uselen=strlen($username);
 $conlen=strlen($confirm);
 
 if (($uselen==0) or ($passlen==0) or ($conlen==0)){
 	$_SESSION["error"]="Please fill in all fields";
 	header("Location: index.php");
 	exit();
 	}
 
 elseif ($passlen< 4){
 	$_SESSION["error"]="Password must be at least 4 characters";
 	header("Location: index.php");
 	exit();
 	}
 
 elseif ($password != $confirm){
 	$_SESSION["error"]="The password you re-entered did not match";
 	header("Location: index.php");
 	exit();
 	}
 	
 //Checks all of the elements in the Username column of Account
 $sql= "SELECT Username FROM Account";
 $result= mysqli_query($conn, $sql);
 
 /* Checks if there are more than 0 rows. If this is true, it
 	gets the username in each row and compares it to the one
 	being entered. If they're the same, it takes you back to
 	the "Create an Account" screen. */
 if (mysqli_num_rows($result) > 0){
 	while ($row=mysqli_fetch_assoc($result)){
 		if ($row["Username"]== $username){
 			$_SESSION["error"]="Username already in use";
 			header("Location: index.php");
 			exit();
 			}
 		}
 	}
 
 /*Inserts $username into Username column and $password into 
   Password column of the table Account. Using variables in
   this fashion might allow for SQL injection? */
 $sql= "INSERT INTO Account (Username, Password) 
 VALUES ('$username', '$password')";
 
 mysqli_query($conn, $sql);
 
 //Sets session username
 $_SESSION["username"]=$username;

 //Closes mysql connection to database
 mysqli_close($conn);
 
 //Directs page to home.php
 header("Location: home.php");	
?>