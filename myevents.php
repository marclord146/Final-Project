<?php
session_id();
session_start();
include "dbconfig.php";
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
    <title>My Events</title>
</head>
<nav class="navbar navbar-expand-lg navbar-dark bg-black">
  <div class="container-fluid">
    <a class="navbar-brand" href="home.php"><img src="media/logo.png" alt=""></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
      <i class="fa fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse" id="mynavbar">
      <form class="search_box d-flex" action="results.php" method="GET">
        <input class="form-control me-3 w-100" type="text" placeholder="Search">
        <button class="search-btn" type="button">Search</button>
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

<section id="featured">
<div class="container text-center mt-1 py-5">
    <h2 class="text-black font-weight-bold">My Events</h3>
    <br>
    

  </div>
  <div class="container">
    <button><a href="createevent.php">Add Event</a></button>
    <br>
    <br>
    <br>

  </div>
  <table class="table  m-4">
  <thead>
    <tr>
      <th scope="col">Event ID</th>
      <th scope="col">Event Name</th>
      <th scope="col">Type</th>
      <th scope="col">Venue</th>
      <th scope="col">Date</th>
      <th scope="col">Time</th>
      <th scope="col">Price</th>
      <th scope="col">Quantity</th>
      <th scope="col">Image</th>
    </tr>
  </thead>
  <tbody>
    <?php 
     $promoterName = $_SESSION['Name']; // Get the promoter name from the logged-in user
    $sql="SELECT * from event Where Promoter='$promoterName'";
    $result=mysqli_query($conn,$sql);
    if($result){
      

      while($row=mysqli_fetch_assoc($result)){
        $eid=$row['Event_ID'];
        $eventname=$row['Event_Name'];
        $type=$row['Category'];
        $venue=$row['Venue'];
        $date=$row['Date'];
        $time=$row['Time'];
        $price=$row['Price'];
        $q=$row['Quantity'];
        $image=$row['Image'];
      echo "<tr>";
      echo "<td scope='row'>".$eid."</td>";
      echo "<td>".$eventname."</td>";
      echo "<td>".$type."</td>";
      echo "<td>".$venue."</td>";
      echo "<td>".$date."</td>";
      echo "<td>".$time."</td>";
      echo "<td>$".$price."</td>";
      echo "<td>".$q."</td>";
      echo "<td>".$image."</td>";
      echo "<td>";
      echo "<button class='update-btn'><a href='updateevent.php?uid=".$eid."'style='font-size:20px;background-color:red;'>Update</a></button>";
      echo "<button class='update-btn'><a href='deleteevent.php?did=".$eid."'style='font-size:20px;'>Delete</a></button>";
      echo "</td>";
      echo "</tr>";

      }

    }
    ?>
    

    
  </tbody>
  </table>
  
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
