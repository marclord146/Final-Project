<?php
session_start();
if(isset($_POST['add_to_cart'])){
        //At least one product in the cart
if(isset($_SESSION['cart'])){
  $events_array_ids=array_column($_SESSION['cart'],"Event_ID");
  //check if product has already been added to cart
  if(!in_array($_POST['Event_ID'],$events_array_ids)){
    //add product to cart
    $event_id=$_POST['Event_ID'];

    $event_array=array(
                         'Event_ID'=> $event_id,
                         'Event_Name' => $_POST['Event_Name'],
                         'Date' => $_POST['Date'],
                         'Venue' => $_POST['Venue'],
                         'Time' => $_POST['Time'],
                         'Price'=> $_POST['Price'],
                         'Category' => $_POST['Category'],
                         'Description' => $_POST['Description'],
                         'Image' => $_POST['Image'],
                         'Quantity' => $_POST['Quantity']



    );
    $_SESSION['cart'][$event_id]= $event_array;
    
  }else{
    echo "<script>alert('Item has already been added to cart')</script>";
  }
}else{// if user adding first item to cart

//add product to cart
$event_id=$_POST['Event_ID'];

$event_array=array(
                     'Event_ID'=> $event_id,
                     'Event_Name' => $_POST['Event_Name'],
                     'Date' => $_POST['Date'],
                     'Venue' => $_POST['Venue'],
                     'Time' => $_POST['Time'],
                     'Price'=> $_POST['Price'],
                     'Category' => $_POST['Category'],
                     'Description' => $_POST['Description'],
                     'Image' => $_POST['Image'],
                     'Quantity' => $_POST['Quantity']



);
$_SESSION['cart'][$event_id]= $event_array;

}
calculateTotalCart();
}else if(isset($_POST['remove'])){   //remove item from cart
  $event_id=$_POST['eventid'];
  unset($_SESSION['cart'][$event_id]);

  calculateTotalCart();

}else if(isset($_POST['update'])){ //update quantity of item in cart
  $event_id=$_POST['eventid'];
  $quantity=$_POST['Quantity'];
  $event=$_SESSION['cart'][$event_id];
 
  $event['Quantity']=$quantity; //old quantity replace with new one
  $_SESSION['cart'][$event_id]=$event;

  calculateTotalCart();

}else{
  
}

function calculateTotalCart(){ //function to find total cost in cart
  $total_price=0;
  $total_quantity=0;
  foreach($_SESSION['cart'] as $id=>$event){
    $event=$_SESSION['cart'][$id];
    $price=$event['Price'];
    $quantity=$event['Quantity'];
    $total_price=$total_price +($price*$quantity);
    $total_quantity=$total_quantity+$quantity;

  }
  $_SESSION['total']=$total_price;
  $_SESSION['quantity']=$total_quantity;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <title>Cart</title>
</head>
<nav class="navbar navbar-expand-lg navbar-dark bg-black">
  <div class="container-fluid">
    <a class="navbar-brand" href="home.php"><img src="media/logo.png" alt=""></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
      <i class="fa fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse" id="mynavbar">
      <form class="search_box d-flex" action="results.php" method="GET">
        <input class="form-control me-3 w-100" name="text" type="text" placeholder="Search">
        <button class="search-btn" name="submit" type="submit">Search</button>
      </form>
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Events</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="concerts.php">Concerts</a></li>
            <li><a class="dropdown-item" href="sports.php">Sporting Events</a></li>
            <li><a class="dropdown-item" href="theatre.php">Theatrical Performances</a></li>
          </ul>
        </li>
        <li class="nav-item ">
          <a class="nav-link" href="calendar.php">Event Calendar</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cart.php">Cart(0)</a>
        </li>
        
          
          <?php
                    if(isset($_SESSION['Email'])){
                    
                      echo "<li class='nav-item dropdown'>";
                      echo "<a class='nav-link dropdown-toggle' href='account.php' role='button' data-bs-toggle='dropdown'>Hello,".$_SESSION['Name']."</a>";
                      echo "<ul class='dropdown-menu'>";
                      echo "<li><a class='dropdown-item' href='account.php'>Account</a></li>";
                      echo "<li><a class='dropdown-item' href='logout.php'>Logout</a></li>";
                      echo "</ul>";
                      echo "</li>";


                    }
                    else{
                     echo "<li class='nav-item'>";
                     echo "<a class='nav-link' href='login.php'>Login/Register</a>";
                     echo "</li>";

                    }
                    ?>
        
      </ul> 
    </div>
  </div>
</nav>

<section class="cart container my-5 py-5">
        <div class="container mt-5">
            <h2 class="font-weight-bold">Your Cart</h2>
            <hr>

        </div>



        <table class="mt-5 pt-5">
  
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
            
             <tr>
                <?php if(isset($_SESSION['cart'])){?><!--If  cart is set-->
                <?php foreach($_SESSION['cart'] as $key=> $value){?><!--for loop to display each item in the cart-->
                  <tr>
                  <td>
                  <div class='product-info'>
                  <form  action="cart.php"  method="POST">
                  <img src="<?php echo 'media/'.$value['Image'];?>">
                  <div>
                  <p class='text-black'><?php echo $value['Event_Name'];?></p>
                  <small><span>$</span><?php echo $value['Price']?></small>
                  <br>
                  <form action="cart.php" mehod="POST">
                  <input type='hidden' name='eventid'  value="<?php echo $value['Event_ID']?>"/>
                  <button type="submit" class="remove-btn" name="remove" >Remove</button>
                  </form>
                  </div>
                  </div>
                  </td>
                  <td>
                  <form action="cart.php" method="POST">
                  <input type="hidden" name="eventid"  value="<?php echo $value['Event_ID']?>"/>
                  <input type="number" class="text-black"  name="Quantity"  value="<?php echo $value['Quantity'];?>">
                  <button type="submit" class="update-btn"  name="update">Update</button>
                  </form>
                  </td>
                  <td>
                  
                  <span>$</span>
                  <span class='product-price'><?php echo number_format($value['Price'] * $value['Quantity'],2);?></span>  <!--Subtotal-->
                  </td>
                  </form>
                  
                
                  
               <?php } ?>
               <?php } ?>
                
            </tr>
        </table>
        
       
        <div class='cart-total mt-5 pt-5'>
         <table>
           <tr>
           <td>Total</td>
           <?php if (isset($_SESSION['cart'])){?>
            <td><span>$</span><?php echo number_format($_SESSION['total'],2);?></td>  <!--Total-->
            <?php } ?>
              </tr>
                 
            </table>
        </div>

        <div class='checkout-container'>
          <form method="GET" action="checkout.php">
          <button type="submit" name="checkout" class='checkout-btn'>Checkout</button>
          </form>
        </div>

        
        
        
      </section>

<footer class="bg-dark py-5 mt-5">
        <div class="container text-light text-center">
          <p class="display-5 mb-3" style="font-size:25px;">TTickets</p>
          <ul class="socials text-white mx-auto">                                              <!--Social Media Links-->
            <li><a href="#"><i class="fa fa-facebook"></i></a></li>           
            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
            <li><a href="#"><i class="fa fa-instagram"></i></a></li>
        </ul>
          <small class="text-white-50">&copy;Copyright by Marc Lord. All rights reserved.</small>

        </div>

       </footer>

       
</body>
</html>
