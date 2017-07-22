<!-- Signs users out --> 

<?php 
/*Starts session, unsets variables, and then destroys it
and redirects you to index.php*/
session_start();
session_unset();
session_destroy();

header("Location: index.php");
?>