<?php
    session_start();
    $informationMessage='#';
    if(!isset($_POST["login"])){
    if(isset($_POST["register"])){
        if(!isset($_POST["name"]) OR !isset($_POST["surname"]) 
                OR !isset($_POST["email"]) OR !isset($_POST["username"]) 
                OR !isset($_POST["password"]) OR !isset($_POST["con-password"]))
        {
            $informationMessage="All fields must be set!";
        }
        else{
            //validate data before sendinf them to the database
            $name=preg_match('/^[A-Z]{1}[a-zA-Z]*$/', $_POST["name"])==1?$_POST["name"]:'';
            $surname=preg_match('/^[A-Z]{1}[a-zA-Z]*$/', $_POST["surname"])==1?$_POST["surname"]:'';
            $email= preg_match('/^[a-zA-Z0-9]{1,}@unyt\.edu\.al$/', $_POST["email"])==1?$_POST["email"]:'';
            $username=$_POST["username"];
            $pwd=$_POST["password"];
            $cpwd=$_POST["con-password"];
            
            if($name!='' AND $surname!='' AND $email!='' AND $pwd==$cpwd){//ready to save data into the database
                $insertResult=registerUser($name, $surname, $email, $username, $pwd);
                if($insertResult["success"]){
                    $informationMessage='';
                }
                else{//data could not be saved into the database
                    $informationMessage=$insertResult["message"];
                }
            }
            else{//data not in the proper format
                $informationMessage="Error in processing data: <br>"
                        . "1-Name and Surname <b>must start</b> with uppercase letter<br>"
                        . "2-Email must be the official one ending with <b>@unyt.edu.al</b><br>"
                        . "3-Password and Confirm Password must match.";
            }
        }
    }
    
    }
    else{
        header('Location: login.php');
    }
    
    function registerUser($name, $surname, $email, $username, $password){
        include_once './database.php';
        include_once './closeDatabase.php';
        $connectionData= openConnection();
        if($connectionData["success"]){//connection succeded
                $usernameVaildation= checkUsername($username, $connectionData["connectionVar"]);
                if($usernameVaildation["success"]){//user with this username does not exist
                    $encryptedPass= md5($password);
                    $conn=$connectionData["connectionVar"];
                    $query = "INSERT INTO `user` (name,surname,email,username,password) "
                        . " VALUES ('$name','$surname', '$email', '$username' ,'$encryptedPass')";
                    $result;
                    if(!($result = mysqli_query($conn, $query))){//query cannot run
                        closeConnection($connectionData["connectionVar"]);
                        return array("success"=>false, "message"=>"Data cannot be eneterd into the database!");
                    }
                    else{
                        closeConnection($connectionData["connectionVar"]);
                        return array("success"=>true, "message"=>"You registered succesfully");
                
                    }
                }
                else{//user with that username found
                    closeConnection($connectionData["connectionVar"]);
                    return array("success"=>false, "message"=>$usernameVaildation["error"]);
                }
        
        }
        else{//database error
            return array("success"=>false, "message"=>"Database connection error!");
        }
        
    }//end of registerUser function
    
    function checkUsername($username, $con){
        $query="SELECT * from user WHERE username='$username'";
        if(!($result= mysqli_query($con, $query))){
            return array("success"=>false, "error"=>'Error running query!');
        }
        else{
            if(mysqli_num_rows($result)>0){
                //username already exists in the database
                return array("success"=>false, "error"=>'User with this username already exists');
            }
            else{
                return array("success"=>true, "error"=>'');
            }
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Registration Page | UNYT-SMS</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link type="text/css" rel="stylesheet" href="css/registrationStyle.css">
        <link rel="icon" href="resources/favicon.ico">
    </head>
    <body>
        <header>
            <h1>Registration page</h1>
        </header>
        <div class="main-content">
            <form method="post" action="registerUser.php">
            <table>
                <tr>
                    <td class="left">Name</td>
                    <td class="right"><input type="text" name="name" value=<?php echo (!isset($_POST['name']))?'':$_POST['name']?>></td>
                </tr>
                <tr>
                    <td class="left">Surname</td>
                    <td class="right"><input type="text" name="surname" value=<?php echo (!isset($_POST['surname']))?'':$_POST['surname']?>></td>
                </tr>
                <tr>
                    <td class="left">Email</td>
                    <td class="right"><input type="email" name="email" 
                                             placeholder="example@unyt.edu.al"
                                             value=<?php echo (!isset($_POST['email']))?'':$_POST['email']?>></td>
                </tr>
                <tr>
                    <td class="left">Username</td>
                    <td class="right"><input type="text" 
                                             name="username" value=<?php echo (!isset($_POST['username']))?'':$_POST['username']?>></td>
                </tr>
                <tr>
                    <td class="left">Password</td>
                    <td class="right"><input type="password" name="password"
                                             value=<?php echo (!isset($_POST['password']))?'':$_POST['password']?>></td>
                </tr>
                <tr>
                    <td class="left">Confirm Password</td>
                    <td class="right"><input type="password" name="con-password"
                                             value=<?php echo (!isset($_POST['con-password']))?'':$_POST['con-password']?>></td>
                </tr>
                <tr>
                    <td class="left">&nbsp;</td>
                    <td class="right"><input type="submit" name="register" value="Register" class="register">
                        <?php
                            if($informationMessage==''){
                                print("<input type='submit' name='login' value='Log in' class='register'>");
                                $informationMessage="You registered succesfully!";
                            }
                        ?>
                    </td>
                    
                </tr>
                
            </table>
            </form>
            <p class="message"><?php
                   if($informationMessage!='#'){                            
                        echo $informationMessage;
                   }                   
            ?></p>
        </div>
    </body>
    
</html>



