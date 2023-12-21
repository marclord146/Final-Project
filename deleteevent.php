<?php
include "dbconfig.php";
if(isset($_GET['did'])){
    $id=$_GET['did'];
    $sql="DELETE FROM event WHERE Event_ID=$id";
    $result=mysqli_query($conn,$sql);
    if($result){
        header('Location:myevents.php');
    }else{
        die(mysqli_error($conn));
    }
}
?>