<?php
 //Runs every minute due to cron.txt
 
 /*If this script is accessed through a browser by a user, then he
   user will redirected to index.php*/
 if (!isset($GLOBALS['argv'])) {
 	header("Location: index.php");
 	exit();
 	}
 
 //Variables inserted into connection
 $host='localhost';
 $db_pword='redrose10';
 $db_uname='root';
 $dbname='myDB';
 
 //Connection variable 
 $conn=mysqli_connect($host, $db_uname, $db_pword, $dbname);
 
 //Empty array
 $list=array();
 
 //Current time (when cron checks)
 $nowdate = time();
 
 /*Get the Status, Username, and Time_made strings from each account.
   If the status is inactive, it compares the timestamp from Time_made
   to the $nowdate variable and subtracts the two. If the difference 
   is more than 600 seconds (10 minutes), the username is pushed to 
   the $list array. 
 */
 $sql="SELECT Status, Username, Time_made FROM Account";
 $result=mysqli_query($conn, $sql);
 
 if (mysqli_num_rows($result) > 0){
 	while ($row=mysqli_fetch_assoc($result)){
 		if ($row["Status"]== "Inactive"){
 			$username=$row["Username"];
 			$date=$row["Time_made"];
 			
 			//Casts to time variable
 			$pastdate=strtotime($date);
 			$diff=$nowdate-$pastdate;
 			
 			if ($diff > 600){
 				array_push($list, $username);
 				}	
 			}
 		}
 	}
 
//Gets length of $list
$len=count($list);
 
//Iterates over each username in $list and deletes it from the table
for($x=0;$x<$len;$x++)
  {
  $username= $list[$x];
  $sql="DELETE FROM Account WHERE Username='$username'";
  
  mysqli_query($conn, $sql);
  }

 //Closes connection to database
 mysqli_close($conn);
?>