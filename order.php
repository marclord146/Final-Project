<?php
session_start();
include('dbconfig.php');
if(isset($_POST['checkout-btn'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $order_cost = $_SESSION['total'];
    $order_status = "not paid";
    $order_date = date("Y-m-d");

    $stmt = $conn->prepare("INSERT INTO orders (Order_Cost,Order_Status,Name,Email,Address,Phone_No,Order_Date) VALUES ($order_cost,'$order_status','$name','$email','$address',$phone,'$order_date')");

    if(!$stmt->execute()){
        header("location: index.php");
        exit;

    }
    $order_id = $stmt->insert_id;

    //Get all products from the cart and insert them into order_items table in database

    foreach($_SESSION['cart'] as $id=>$event){
        $event = $_SESSION['cart'][$id];
        $eventid = $event['Event_ID'];
        $eventname = $event['Event_Name'];
        $image= $event['Image'];
        $price = $event['Price'];
        $quantity= $event['Quantity'];

        $stmt1 = $conn->prepare("INSERT INTO order_items(Order_ID,Event_ID,Event_Name,Image,Price,Quantity,Name,Order_Date) VALUES ($order_id,$eventid,'$eventname','$image',$price,$quantity,'$name','$order_date')");

        
        $stmt1->execute();



    }
    
    //stores Order_ID in session
    $_SESSION['Order_ID'] = $order_id;
    
    //takes user to payment page
    header("Location: payment.php");





}

?>