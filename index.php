<?php

session_start();

if(isset($_SESSION['userId'])){
    header("Location:lobby.php");
} else{
    header("Location:login.php");
}
?>

