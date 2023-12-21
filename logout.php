<?php
session_start();  
unset($_SESSION['email']);  
session_destroy();  //destroy/end session
header("location:home.php"); // redirects to home page
?>
=out 