<?php
session_start();
include 'dbconfig.php';

if (isset($_SESSION['Name'])) { // if the name in the session is set or not
    $promoterName = $_SESSION['Name'];
    
    // Rest of the code to insert event data into the database
    $eventname = $_POST['name'];
    $date = $_POST['date'];
    $venue = $_POST['venue'];
    $time = $_POST['time'];
    $price = $_POST['price'];
    $des = $_POST['des'];
    $image = $_POST['image'];
    $quantity = $_POST['quantity'];
    $type = $_POST['category'];
    //SQL query to insert event information into event table
    $sql = "INSERT INTO event (Event_Name, Date, Venue, Time, Price, Category, Description, Image, Quantity, Promoter) VALUES ('$eventname', '$date', '$venue', '$time', $price, '$type', '$des', '$image', '$quantity', '$promoterName')";
  
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header('Location: myevents.php');//redirects to myevents.php page
    } else {
        die("Connection failed: " . mysqli_connect_error());
    }
} else {
    // Handle case where user is not logged in
    echo "User not logged in";
}
?>
