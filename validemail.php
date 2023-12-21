<?php
$conn = mysqli_connect("localhost","root","mysql","eventsystem") or die("Couldn't connect to database");//datbase connection
$sql=sprintf("SELECT * FROM user WHERE Email= '%s'",
            $conn->real_escape_string($_GET["email"])); //used to escape special characters in a string that is being passed as a parameter to a MySQL query. 

$result=$conn->query($sql);
$is_available=$result->num_rows===0;

header("Content-Type: application/json");
echo json_encode(["available" => $is_available]);
?>