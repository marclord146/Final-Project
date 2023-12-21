<?php
  include 'dbconfig.php';//database connection
  session_start();
  if (isset($_POST['email']) && isset($_POST['pass'])){
    function validate($data){
      $data=trim($data); //removes whitespaces from input data
      $data=stripslashes($data); //remove backslashes from input data
      $data=htmlspecialchars($data); //converts special characters to their corresponding HTML entities
      return $data;
    }
    $email=validate($_POST['email']);
    $pass=validate($_POST['pass']);

    if(empty($email)){
      header("Location: login.php?error= Email is required!");   #If User Doesnt input their email
      exit();


    }else if(empty($pass)){
      header("Location: login.php?error= Password is required!"); #if user does not input their password
      exit();

    }else{
      $sql=("SELECT * FROM user WHERE Email='".$email."' AND Password='".$pass."'");   #If both email and password is correct
      $result=mysqli_query($conn,$sql);
      if(mysqli_num_rows($result)===1){
        $row=mysqli_fetch_assoc($result);
        if($row['Email']===$email && $row['Password']===$pass){
          $_SESSION['Email']=$row['Email'];
          $_SESSION['Name']=$row['Name'];
          $_SESSION['userId']=$row['userId'];
          header("Location:home.php"); //redirects to home page
          exit();

        }else{                                                                    #if either email or password is incorrect
          header("Location: login.php?error=Incorrect Email or Password");
          exit();

        }


      }else{
        header("Location: login.php?error=Incorrect Email or Password");
        exit();

      }
    }


  }else{
    header("Location: login.php");
    exit();
  }
 ?>