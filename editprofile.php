<?php
session_start();
include 'dbconfig.php'; // database connection
$id=$_GET['uid'];
$sql="SELECT * FROM user WHERE userId = $id"; // get user information from database using the users id
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);
$name=$row['Name'];
$email=$row['Email'];
$address=$row['Address'];
$phone=$row['Phone_No'];
$pass=$row['Password'];


if (isset($_POST['submit'])){ // Get the new information from the fields
  $name=$_POST['name'];
  $address=$_POST['address'];
  $email=$_POST['email'];
  $pass=$_POST['pass'];
  $phone=$_POST['phone'];
  
  
  // SQL query to update user information
  $sql="UPDATE user SET userId=$id,Name='$name',Email='$email',Address='$address',Phone_No='$phone',Password='$pass' WHERE userId=$id";
  $result=mysqli_query($conn,$sql);
  if($result){
    header('Location:profile.php');// redirects back to profile page

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
    <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js" defer></script>
    <link rel="stylesheet" href="css/style.css">
    <title>Update Profile</title>
</head>
<nav class="navbar navbar-expand-lg navbar-dark bg-black">
  <div class="container-fluid">
    <a class="navbar-brand" href="home.php"><img src="media/logo.png" alt=""></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
      <span class="navbar-toggler-icon"></span>
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
 
<section class="my-1 py-2">
  <div class="container text-center mt-4 pt-5">
      <h2 class="text-black form-weight-bold">Edit Profile</h2>
      <br>
      <br>

  </div>
  <div class="text-black mx-auto container">
      <form id="register-form"   method="POST" >
        <div class="input-group">
          <label for="name">Full Name</label>
          <input type="text"  name="name" id="name" value="<?php echo $name;?>">
        </div>
        <div class="input-group">
           <label for="address">Address</label>
           <input type="text"  name="address" id="address" value="<?php echo $address;?>">
        </div>
        <div class="input-group">
          <label for="email">Email</label>
          <input type="email"  name="email" id="email" value="<?php echo $email;?>">
        </div>
        <div class="input-group">
           <label for="pass">Password</label>
           <input type="password"  name="pass" id="pass" value="<?php echo $pass;?>">
        </div>
        <div class="input-group">
           <label for="confirmpass">Confirm Password</label>
           <input type="password" name="confirmpass" id="confirmpass">
        </div>
        <div class="input-group">
           <label for="phone">Cellphone No.</label>
           <input type="text"  name="phone" id="phone" value="<?php echo $phone;?>">
        </div>
        <div class="input-group">
           <input type="submit" id="" value="Update Profile"  name="submit" class="btn">

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