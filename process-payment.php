<?php
include 'dbconfig.php';
require_once('stripe/init.php');

\Stripe\Stripe::setApiKey('sk_test_51N5HUTKEkL2KQIeIt188zgFJJDb01iqPYtXDkxoHAxYQfTkI7boGpcNXNwQ4X3vvfYJFmR8DGrUgiX9oRJvolwQf003adCkwYi');

$paymentMethodId = $_POST['paymentMethodId'];
$amount = 100000; // Replace with your desired amount

try {
  // Create a PaymentIntent
  $paymentIntent = \Stripe\PaymentIntent::create([
    'amount' => $amount,
    'currency' => 'usd',
    'payment_method' => $paymentMethodId,
    'confirm' => true,
  ]);

  // Payment succeeded
  // You can retrieve the PaymentIntent ID with $paymentIntent->id

  // Remove items from the cart
  session_start();

  

  // Check if the cart session exists
  if (isset($_SESSION['cart'])) {
    // Loop through the cart items and remove them
    foreach ($_SESSION['cart'] as $key => $item) {
      // Remove the item from the cart
      unset($_SESSION['cart'][$key]);
      calculateTotalCart();
      
    }
  }

  $orderId = $_SESSION['Order_ID'];

  $sql = "UPDATE orders SET Order_Status= 'paid' WHERE Order_ID = '$orderId'";

// Execute the SQL query using your database connection object, assuming you have already established the connection
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if ($result) {
    // Redirect to success page or display a success message
    header('Location: success.php');
    exit;
} else {
    // Handle the error, redirect to an error page, or display an error message
    header('Location: error.php?error=' . urlencode(mysqli_error($connection)));
    exit;
}








  
} catch (\Stripe\Exception\CardException $e) {
  // Card error occurred
  $error = $e->getMessage();
  // Redirect to error page or display an error message
  header('Location: payment.php?error=' . urlencode($error));
  exit;
} catch (\Stripe\Exception\RateLimitException $e) {
  // Too many requests made to the API too quickly
  $error = $e->getMessage();
  // Redirect to error page or display an error message
  header('Location: error.php?error=' . urlencode($error));
  exit;
} catch (\Stripe\Exception\InvalidRequestException $e) {
  // Invalid parameters were supplied to Stripe's API
  $error = $e->getMessage();
  // Redirect to error page or display an error message
  header('Location: error.php?error=' . urlencode($error));
  exit;
} catch (\Stripe\Exception\AuthenticationException $e) {
  // Authentication with Stripe's API failed
  $error = $e->getMessage();
  // Redirect to error page or display an error message
  header('Location: error.php?error=' . urlencode($error));
  exit;
} catch (\Stripe\Exception\ApiConnectionException $e) {
  // Network communication with Stripe failed
  $error = $e->getMessage();
  // Redirect to error page or display an error message
  header('Location: error.php?error=' . urlencode($error));
  exit;
} catch (\Stripe\Exception\ApiErrorException $e) {
  // Generic error occurred
  $error = $e->getMessage();
  // Redirect to error page or display an error message
  header('Location: error.php?error=' . urlencode($error));
  exit;
}
function calculateTotalCart() {
  // Initialize total amount
  $totalAmount = 0;

  // Check if the cart session exists
  if (isset($_SESSION['cart'])) {
    // Loop through the cart items and calculate the total amount
    foreach ($_SESSION['cart'] as $item) {
      // Assuming each item has a 'price' and 'quantity' property
      $itemPrice = $item['Price'];
      $itemQuantity = $item['Quantity'];
      $subtotal = $itemPrice * $itemQuantity;

      // Add the subtotal to the total amount
      $totalAmount += $subtotal;
    }
  }

  // Store the total amount in the session
  $_SESSION['total'] = $totalAmount;

  return $totalAmount;
}

?>
