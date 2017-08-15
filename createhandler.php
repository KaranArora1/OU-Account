<!-- Creates accounts -->

<?php
 //Starts session
 session_start();
 
 
 //If session username is set, it takes you to homepage
 if (isset($_SESSION["username"])){
 	header("Location: home.php");
 	exit();
 	}
 
 //Variables inserted into connection
 $host='localhost';
 $db_uname='root';
 $db_pword='redrose10';
 $dbname='myDB';
 
 //Connection variable 
 $conn = mysqli_connect($host, $db_uname, $db_pword, $dbname);
 
 /*Casts each input received by POST method
 into a string and then assigns it a variable */
 $username= (strval($_POST["username"]));
 $password= (strval($_POST["password"]));
 $confirm= (strval($_POST["confirm"]));  
 $email= (strval($_POST["email"]));
  
 //Gets length of username, password, re-entered password, and email
 $passlen=strlen($password);
 $uselen=strlen($username);
 $conlen=strlen($confirm);
 $emaillen=strlen($email);
 
 /*Directs you back to index.php if any of the lengths are zero
 with an error message stating to fill in all fields */
 if (($uselen==0) or ($passlen==0) or ($conlen==0) or ($emaillen==0)){
 	$_SESSION["error"]="Please fill in all fields";
 	header("Location: index.php");
 	exit();
 	}
 
 /*Directs you back to index.php if password length is less 
 than 4 characters and gives an error stating the password
 must be longer */
 elseif ($passlen< 4){
 	$_SESSION["error"]="Password must be at least 4 characters";
 	header("Location: index.php");
 	exit();
 	}
 
 /*Directs you back to index.php if the password and the 
 re-entered password do not match, stating an error that
 says to make sure they match */
 elseif ($password != $confirm){
 	$_SESSION["error"]="The password you re-entered did not match";
 	header("Location: index.php");
 	exit();
 	}
 
 /*Checks all of the elements in the Username and Email columns 
 of Account */
 $sql= "SELECT Username, Email, String FROM Account";
 $result= mysqli_query($conn, $sql);
 
//Array where used codes are sent
$list= array();
 
 /*Checks if there are more than 0 rows. If this is true, it
 gets the username and email from each row and compares it 
 to the ones being entered. If they're the same, it takes you 
 back to index.php because there can't be two of the same 
 username or email. Also, it goes through all of the codes
 in the database, appending them to $list.*/
 if (mysqli_num_rows($result) > 0){
 	while ($row=mysqli_fetch_assoc($result)){
 		if ($row["Username"]== $username){
 			//Sets error stating username is already taken
 			$_SESSION["error"]="Username is already in use";
 			header("Location: index.php");
 			exit();
 			}
 			
 		elseif ($row["Email"]== $email){
 			//Sets error stating email is already taken
 			$_SESSION["error"]="Email is already in use";
 			header("Location: index.php");
 			}
 		
 		$usedcode= $row["String"];
 		array_push($list, $usedcode);
 
 			}
 		}
 
//Random number is generated
$code= rand(0, 10000000000000000);
//Length of $list
$len= count($list);
$num=0;

/*While $num is less than the length of $list, this will repeat.
  If $code is equal to any string in $list, it is given another
  random string, and num is reset to 0 so everything in $list is 
  iterated through again. If $code does not equal the string given
  to it, $num is increased by one. This is done to ensure no two 
  codes are the same.*/
while ($num <= $len){
	if ($code== $list[$num]) {
		$code= rand(0, 10000000000000000);
		$num=0;
		}
	else {
		$num++;
		}
	}
 
//URL
$url= "http://localhost:8080/linkhandler.php?code=$code";
 
 /*Sends an email to the address entered. If there is an error,
   it sets a session error*/
 if (!(mail("$email","Account Creation",
 			"Click the link to create your account! $url", 
 		
 			"From: karanarora2001@gmail.com"))){
 	  $_SESSION["error"]= "There was an error sending the email"; 
 	  header("Location: index.php");
 	  exit();
 	  }
 
 //Sets session email
 $_SESSION["email"]=strval($email);
 
 //Sets date to be inserted
 $date = date('Y-m-d H:i:s');
 
 /*Inserts $username into Username column and $password into 
 Password column of the table Account. Also puts in email,
 status, and time (Using variables in this fashion might allow 
 for SQL injection?) */
 $sql= "INSERT INTO Account (
 Username,Password,Email,Status, String, Time_made) 
 VALUES ('$username','$password','$email','Inactive','$code','$date')";
 
 mysqli_query($conn, $sql);

 //Closes mysql connection to database
 mysqli_close($conn);
 
 //Directs you to email.php
 header("Location: email.php");	
?>