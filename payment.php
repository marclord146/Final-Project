<?php
session_id();
session_start();

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
    <script src="https://js.stripe.com/v3/"></script><!-- Stripe.js -->
    <script src="js/stripe.js" defer></script><!-- Stripe.js  -->
    <link rel="stylesheet" href="css/style.css">
    <title>Payment Page</title>
</head>
<nav class="navbar navbar-expand-lg navbar-dark bg-black">
  <div class="container-fluid">
    <a class="navbar-brand" href="home.php"><img src="media/logo.png" alt=""></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
      <i class="fa fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse" id="mynavbar">
      <form class="search_box d-flex" action="results.php" method="GET">
        <input class="form-control me-3 w-100" type="text" name="text" value="" placeholder="Search">
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

<section class="my-5 py-5 checkout">
  <div class="container text-center mt-3 pt-5">
    <h2 class="font-weight-bold">Payment</h2>
    
  </div>
  <div class="mx-auto container text-center">
    <?php if(isset($_SESSION['Order_ID'])&& $_SESSION['Order_ID']!="" && isset($_SESSION['total'])&& $_SESSION['total'] != 0 ){?><!--If Order_Id is set and is empty also is the total is set and empty then display the payment form-->
    <!-- Your form fields and other inputs -->
    
    <form id="payment-form" action="process-payment.php" method="POST">
      <div class="form-group">
        <label for="card-number">Card Number</label>
          <div class="input-group">
            <div id="card-number-element" class="form-control"><!-- Stripe.js will inject the card number element here --></div>
            <div class="input-group-append">
            <span class="input-group-text" id="card-brand-logo"><!-- Displays card brand  and logo--></span>
            </div>
          </div>
      </div>
      <div class="form-group form-group-inline">
        <div class="expiry-cvc-container">
          <label for="card-expiry">Expiry Date</label>
          <div id="card-expiry-element" class="form-control">
        <!-- Stripe.js will inject the expiry date element here -->
          </div>
        </div>
        <div class="expiry-cvc-container">
          <label for="card-cvc">CVC</label>
          <div id="card-cvc-element" class="form-control">
        <!-- Stripe.js will inject the CVC element here -->
          </div>
        </div>
      </div>
      <div id="card-errors" role="alert"></div>
      <input type="hidden" name="paymentMethodId" id="paymentMethodId">
    <button type="submit" name="payment-btn" class="payment-btn">Submit Payment</button>
  </form>




        <?php } else{?>
            <p>You do not have an order</p>

            <?php } ?>

            <?php
    // Check if an error message is present in the URL
    if (isset($_GET['error'])) {
      // Retrieve and decode the error message
      $error = urldecode($_GET['error']);

      // Display the error message
      echo '<p id="error-message" class="error-message">' . $error . '</p>';
    }
    ?>
    
    
  </div>
  
</section>
<script>
  // Hide the error message after a specified time interval (in milliseconds)
  setTimeout(function() {
    var errorMessage = document.getElementById('error-message');
    if (errorMessage) {
      errorMessage.style.display = 'none';
    }
  }, 5000); // Change 5000 to the desired time interval in milliseconds
</script>



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