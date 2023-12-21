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
    <title>Login</title>
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
        <li class="nav-item">
          <a class="nav-link" href="login.php">Login/Register</a>
        </li>
      </ul> 
    </div>
  </div>
</nav>

<section class="my-1 py-2">
  <div class="container text-center mt-4 pt-5">
      <h2 class="text-black form-weight-bold">Login</h2>
      <br>
      <br>

  </div>
  <div class="text-black mx-auto container">
      <form id="login-form" action="verify.php" method="POST">
        <?php if(isset($_GET['error'])){?>
          <p class="login-error"><?php echo $_GET['error']  ?></p>
        <?php } ?>
          <div class="input-group">
              <label for="email" style="padding-right: 20px;">Email:</label>
              <input type="email" name="email" id="email">
              
          </div>
          <br>
          <div class="input-group">
              <label for="pass">Password:</label>
              <input type="password"  name="pass" id="pass">
              
          </div>
          <br>
          <br>
          <div class="input-group">
              <input type="submit" id="login-btn" value="Login" name="login" class="btn">
          </div>
          <div class="input-group">
              <a id="register-url" href="register.php" class="btn">Don't have account? Register</a>
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