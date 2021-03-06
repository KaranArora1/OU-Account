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
 			
 		elseif (password_verify($email, $row["Email"])){
 			//Sets error stating email is already taken
 			$_SESSION["error"]="Email is already in use";
 			header("Location: index.php");
 			exit();
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
  codes are the same. If two codes were the same, on the off chance
  that two accounts were inactive and had the same code, someone
  could be directed to another person's account. */
while ($num <= $len){
	if (password_verify($code, $list[$num])) {
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
 		
 			"From: Karan Arora"))){
 	  $_SESSION["error"]= "There was an error sending the email"; 
 	  header("Location: index.php");
 	  exit();
 	  }
 
 //Sets session email
 $_SESSION["email"]=strval($email);
 
 /*Hashing user password, email, and string using password_hash 
   function. Salt is automatically generated using this function 
   and the algorithm used is the strongest one PHP has (bcrypt
   I believe). The cost is set to 13.*/
 $option=array('cost' => 13);
 $hashpass= password_hash($password, PASSWORD_DEFAULT, $option);
 $hashmail= password_hash($email, PASSWORD_DEFAULT, $option);
 $hashcode= password_hash($code, PASSWORD_DEFAULT, $option);

 /*ORIGINAL CODE

 //Sets date to be inserted
 $date = date('Y-m-d H:i:s');
 
 $sql= "INSERT INTO Account (
 Username,Password,Email,Status, String, Time_made) 
 VALUES ('$username',
 '$hashpass',
 '$hashmail',
 'Inactive',
 '$hashcode',
 '$date')";
 
 mysqli_query($conn, $sql);*/
 
 //Statements below prevent SQL injection
 //Variable that holds string inactive (bind_param only accepts vars)
 $inactive="Inactive";
 
 /*Initializes object, prepares statement, binds parameters into
   prepared statement, executes statement and closes it */
 $stmt= mysqli_stmt_init($conn);
 
 mysqli_stmt_prepare($stmt, "INSERT INTO Account (Username, Password,
 Email, Status, String) VALUES (?, ?, ?, ?, ?)");
 
 mysqli_stmt_bind_param($stmt, "sssss", $username, $hashpass, 
 $hashmail, $inactive, $hashcode);
 
 mysqli_stmt_execute($stmt);
 mysqli_stmt_close($stmt);

 //Closes mysql connection to database
 mysqli_close($conn);
 
 //Directs you to email.php
 header("Location: email.php");	
?>