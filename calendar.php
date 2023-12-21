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
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js"></script> <!--FullCalendar Javascript package -->
    <script>
  document.addEventListener('DOMContentLoaded',function(){
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl,{
      initialView:'dayGridMonth',
      height:750,
      events: 'getevents.php', // point to your PHP file
      eventClick: function(info) {
        // Get the event object
        var eventObj = info.event;
        var eventStartTime = new Date(eventObj.start);
        var eventStartTimeString = eventStartTime.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true }); // 12 hr time
        // Dynamically display the event details on the webpage
        var eventDetails = document.getElementById('event-details');
        eventDetails.innerHTML = '<img style="float:right;" width="150" height="150" src="media/'+eventObj.image+'"/><h3>'+eventObj.title+'</h3><h4>'+eventStartTimeString+'</h4><a href="singleevent.php?Event_ID='+eventObj.id+'"><button class="buy-btn">Buy Now</button></a>';
      }
    });
    calendar.render();
  });
</script>

    <title>Event Calendar</title>
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


<div class="container">
    <div class="wrapper" style="color:black;">
      <br>
      <br>
      <div id="calendar"></div><!--Display calendar-->
      <br>
      <br>
      <br>
      <div id="event-details"></div><!--Display event details when event is clicked on calendar-->
    </div>
</div>








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
