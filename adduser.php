<?php

$conn = mysqli_connect("localhost","root","mysql","eventsystem") or die("Couldn't connect to database");//Database Connection
$name=$_POST['name'];
$address=$_POST['address'];
$email=$_POST['email'];
$pass=$_POST['pass'];
$phone=$_POST['phone'];

$sql = "INSERT INTO user (Name, Address, Email, Phone_No, Password) VALUES ('$name','$address','$email','$phone','$pass')";//SQL query to add user to database
$result = mysqli_query($conn, $sql) or die("Connection failed: " . mysqli_connect_error());//Get Result
if($result){
       header('Location:signupsuccess.php');//redirects to 'signupsuccess.php'
}


?>