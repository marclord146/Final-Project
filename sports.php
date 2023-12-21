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
    <link rel="stylesheet" href="css/style.css">
    <title>Sports</title>
</head>
<nav class="navbar navbar-expand-lg navbar-dark bg-black">
  <div class="container-fluid">
    <a class="navbar-brand" href="home.php"><img src="media/logo.png" alt=""></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
      <i class="fa fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse" id="mynavbar">
      <form class="search_box d-flex" action="results.php" method="GET">
        <input class="form-control me-3 w-100" type="text" name="text" placeholder="Search">
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
                    if(isset($_SESSION['Email'])){//If user is logged in
                    
                      echo "<li class='nav-item dropdown'>";
                      echo "<a class='nav-link dropdown-toggle' href='account.php' role='button' data-bs-toggle='dropdown'>Hello,".$_SESSION['Name']."</a>";
                      echo "<ul class='dropdown-menu'>";
                      echo "<li><a class='dropdown-item' href='account.php'>Account</a></li>";
                      echo "<li><a class='dropdown-item' href='logout.php'>Logout</a></li>";
                      echo "</ul>";
                      echo "</li>";


                    }
                    else{//If user is not logged in
                     echo "<li class='nav-item'>";
                     echo "<a class='nav-link' href='login.php'>Login/Register</a>";
                     echo "</li>";

                    }
                    ?>
      </ul> 
    </div>
  </div>
</nav>

<section id="featured" class="my-5 py-5">
  <div class="container text-center mt-1 py-5">
    <h2 class="text-black font-weight-bold">Sporting Events</h3>
    <br>
    <br>

  </div>
  <div class="row mx-auto container-fluid">
    <?php include('getsports.php');?><!--include content from 'getsports.php'-->

    <?php while($row=$sport->fetch_assoc()){?><!--While loop to display all sporting events-->
    <div class="product text-center col-lg-3 col-md-4 col-sm-12">
      <img class="img-fluid mb-3" src="media/<?php echo $row['Image'];?>"/>
      <h5 class="p-name"><?php echo $row['Event_Name'];?></h5>
      <h4 class="p-price">$<?php echo $row['Price'];?></h4>
      <a href="<?php echo "singleevent.php?Event_ID=" .$row['Event_ID'];?>"><button class="buy-btn">Buy Now</button></a>
    </div>
    <?php  } ?>
    <nav aria-label="Page navigation example" >
      <ul class="pagination justify-content-center mt-5">
      <?php for ($i = 1; $i <= $totalPages; $i++) { ?> <!--For loop-->
      <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>"><!--Highlights current page-->
        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a><!--Hyperlink-->
      </li>
    <?php } ?>
        
      </ul>
     </nav>
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
<?php

?>