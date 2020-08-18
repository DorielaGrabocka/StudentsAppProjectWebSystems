<?php
    session_start();
    include_once './loginValidation.php';
    $errorMessage='';
    if(isset($_POST["login"])){
        //$errorMessage='';
        if(!empty($_POST["username"]) && !empty($_POST["password"])){
            $username= $_POST["username"];
            $pass=$_POST["password"];
            //echo $username . " " . $pass;
            $authentcation=validateLogin($username, $pass);
            //print_r($authentcation);
            if($authentcation["success"]){
                $_SESSION["nameOfUser"]=$authentcation["name"];
                $_SESSION["surnameOfUser"]=$authentcation["surname"];
                header('Location: mainWindow.php');
            }
            else{
                $errorMessage=$authentcation["error"];
            }
        }
        else{
            $errorMessage="Please enter your credentials!";
        }
    }
    
    
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Student Management System | UNYT</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link type="text/css" rel="stylesheet" href="css/loginStyle.css">
        <link rel="icon" href="resources/favicon.ico">
    </head>
    
    <body>
        <div class="header">
            <nav>
                    <ul class="menu">
                        <li><a href="https://www.unyt.edu.al" target="_blank">Go to UNYT Page</a></li>
                        <li><a href="registerUser.php" target="_self">Register</a></li>
                        
                    </ul>
            </nav>
        </div>
        
        <div class="main">
            <h1 class="welcome">Welcome to UNYT Students Management System!</h1>
            
            <form method="post" action="login.php">
            <p class="input">
                <label>Username: </label><span class="loginID"><input type="text" id="id" name="username"></span>
            </p>
            <p class="input">
                <label>Password: </label><span class="loginPwd"><input type="password" id="pwd" name="password"></span>
            </p>
            <p><input type="submit" name="login" class="logInButton" value="LOG IN"></p></form>
            <p class="errorMessage"><?php 
               if($errorMessage!=''){ 
                    echo $errorMessage;               
               } ?>
            </p>
        </div>
    
    </body>
</html>
