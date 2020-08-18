<?php
    session_start();
    if(!isset($_SESSION["nameOfUser"]) || !isset($_SESSION["surnameOfUser"])){//user has not logged in
        header('Location: login.php');
        exit();
    }
    
?>