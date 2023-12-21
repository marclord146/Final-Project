<?php
session_id();
session_start();
include 'dbconfig.php';
$id=$_GET['uid'];
$sql="SELECT * FROM event WHERE Event_ID = $id"; // get event information
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);
$eventname=$row['Event_Name'];
$date=$row['Date'];
$venue=$row['Venue'];
$time=$row['Time'];
$price=$row['Price'];
$type=$row['Category'];
$des=$row['Description'];
$image=$row['Image'];
$quantity=$row['Quantity']; 

if (isset($_POST['submit'])){ // Get new information from input fields
  $eventname=$_POST['name'];
  $date=$_POST['date'];
  $venue=$_POST['venue'];
  $time=$_POST['time'];
  $price=$_POST['price'];
  $type=$_POST['category'];
  $des=$_POST['des'];
  $image=$_POST['image'];
  $quantity=$_POST['quantity'];
  
  
  // SQL query to update user information
  $sql="UPDATE event SET Event_ID=$id,Event_Name='$eventname',Date='$date',Venue='$venue',Time='$time',Price='$price',Category='$type',Description='$des',Image='$image',Quantity='$quantity' WHERE Event_ID=$id";
  $result=mysqli_query($conn,$sql);
  if($result){
    header('Location:myevents.php');

  }else{
    die(mysqli_error($conn));
  }
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

<section id="featured">
<div class="container text-center mt-1 py-5">
    <h2 class="text-black font-weight-bold">Update Events</h3>
    <br>
    

  </div>
  <div class="text-black mx-auto container">
      <form id="event-form"  method="POST">
        <div class="input-group">
          <label for="name">Event Name</label>
          <input type="text"  name="name" id="name" value="<?php echo $eventname;?>"/>
        </div>
        <div class="input-group">
           <label for="date">Date</label>
           <input type="date"  name="date" id="date" value="<?php echo $date;?>">
        </div>
        <div class="input-group">
          <label for="venue">Venue</label>
          <input type="text"  name="venue" id="venue" value="<?php echo $venue;?>"">
        </div>
        <div class="input-group">
           <label for="time">Time</label>
           <input type="time"  name="time" id="time" value="<?php echo $time;?>">
        </div>
        <div class="input-group">
           <label for="price">Price</label>
           <input type="text" name="price" id="price" value="<?php echo $price;?>">
        </div>
        <div class="input-group">
           <label for="des">Description</label>
           <textarea  name="des" id="des" rows="6" ><?php echo $des;?></textarea>
        </div>
        <div class="input-group">
           <label for="image">Image</label>
           <input type="file" name="image" id="image" accept="image/png, image/jpeg" value="<?php echo $image;?>">
        </div>
        <div class="input-group">
           <label for="quantity">Quantity</label>
           <input type="number" name="quantity" id="quantity" value="<?php echo $quantity;?>">
        </div>
        <div class="input-group">
           <label for="phone">Category</label>
           <select name="category" id="category" value="<?php echo $type;?>"> 
                    <option value="Concert">Concert</option>
                    <option value="Sporting Event">Sporting Event</option>
                    <option value="Theatrical Performance">Theatrical Performance</option>
            </select>
        </div>
        <div class="input-group">
           <input type="submit" id="" value="Update"  name="submit" class="btn">

        </div>
         
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