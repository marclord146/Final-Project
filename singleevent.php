<?php
session_id();
session_start();
if(isset($_GET['Event_ID'])){//if Event_ID is set

$conn = mysqli_connect("localhost" ,"root","mysql","eventsystem") or die("Couldn't connect to database");//Database connection

$Event_ID=$_GET['Event_ID']; //Store Event_ID in variable

$stmt = $conn->prepare("SELECT * From event WHERE Event_ID=?");//SQL query cannot 
$stmt->bind_param("s",$Event_ID);//Bind values of Event_ID

$stmt->execute();//Execute SQL Query

$event= $stmt->get_result();//Get results

}
else{//If it is not set
header('location:home.php');// redirect to homepage
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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB24BIx3N3vIt_IzMTh3vcVNvM1KpVCN4c&callback=initMap" defer></script>

    <link rel="stylesheet" href="css/style.css">
    <title>Tickets</title>
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
        <button class="search-btn"  type="text" name="submit" type="button">Search</button>
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
        <li class="nav-item">
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

<section class="single-product my-5 pt-5">
    <div class="row mt-5">

      <?php while($row=$event->fetch_assoc()){?><!--While loop to display information on event-->
        
        <!--Displays event information-->
        <div class="col-lg-5 col-md-6 col-sm-12">
        <form action="cart.php" method="POST"> 
            <img class="img-fluid w-75 h-75 pb-1 mt-0 ms-5" src="media/<?php echo $row['Image'];?>"/>
        </div>
          <!--Displays event information-->
        <div class="col-lg-6 col-md-12 col-12 mx-auto pt-3">

          <h6>Venue: <?php echo $row['Venue'];?></h6>
          <h6>Date: <?php echo $row['Date'];?></h6>
          <h6>Time: <?php echo date("h:i A", strtotime($row['Time']));?></h6>
          <h3 class="py-4"><?php echo $row['Event_Name'];?></h3>
          <h2>$<?php echo $row['Price'];?></h2>
          <form method="POST" action="cart.php"><!--Form to submit event information to cart-->
          <input type="hidden" name="Event_ID" value="<?php echo $row['Event_ID'];?>"/>
          <input type="hidden" name="Image" value="<?php echo $row['Image'];?>"/>
          <input type="hidden" name="Event_Name" value="<?php echo $row['Event_Name'];?>"/>
          <input type="hidden" name="Price" value="<?php echo $row['Price'];?>"/>
          <input type="hidden" name="Category" value="<?php echo $row['Category'];?>"/>
          <input type="hidden" name="Venue" value="<?php echo $row['Venue'];?>"/>
          <input type="hidden" name="Description" value="<?php echo $row['Description'];?>"/>
          <input type="hidden" name="Date" value="<?php echo $row['Date'];?>"/>
          <input type="hidden" name="Time" value="<?php echo date("h:i A", strtotime($row['Time']));?>"/>


          <input type="number" name="Quantity" value="1">
          <button class="buy-btn" type="submit" name="add_to_cart">Add to Cart</button>

          </form>
          <h4 class="mt-5 mb-5" style="font-size:24px;">Description</h4>
          <span style="font-size:20px"><?php echo $row['Description'];?></span>
        </div> 

        </form>
        
        <?php } ?>
        
    </div>

    
</section>
<div id="map"></div>




    
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
