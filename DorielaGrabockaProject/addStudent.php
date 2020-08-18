<?php
    
    include_once './sessionCheck.php';
    $informationMessage='#';
    
    $departments=getDepartments();
    $minor= getDepartments();
    //print_r ($departments["result"]);
    function getDepartments(){
        include_once './database.php';
        include_once './closeDatabase.php';
        $connectionData= openConnection();
        if($connectionData["success"]){//connection succeded
            $conn=$connectionData["connectionVar"];
            $query="SELECT DISTINCT Department FROM `course`";
            $result;
            if(!($result = mysqli_query($conn, $query))){//query cannot run
                closeConnection($connectionData["connectionVar"]);
                return array("success"=>false, "result"=>NULL ,"message"=>"Data cannot be retrieved from the database!");
            }
            else{
                closeConnection($connectionData["connectionVar"]);
                return array("success"=>true, "result"=>$result ,"message"=>"Data retrieved succesfully!");
            }
        }
        else{//database error
            return array("success"=>false, "result"=>NULL ,"message"=>"Database connection error!");
        }
    }//get departments function
    
    
    if(!isset($_POST["mainPage"])){
        if(isset($_POST["register"])){
            //mainPage not set
            if(!isset($_POST["name"]) OR !isset($_POST["surname"]) 
                OR !isset($_POST["email"]) OR !isset($_POST["birthday"]) 
                OR !isset($_POST["major"]) OR !isset($_POST["minor"]))
            {
                $informationMessage="All fields must be set!";
            }
            else{
                //validate data before sendinf them to the database
                $name=preg_match('/^[A-Z]{1}[a-zA-Z]*$/', $_POST["name"])==1?$_POST["name"]:'';
                $surname=preg_match('/^[A-Z]{1}[a-zA-Z]*$/', $_POST["surname"])==1?$_POST["surname"]:'';
                $email= preg_match('/^[a-zA-Z0-9]{1,}@[a-z]*\.[a-z]{1,3}$/', $_POST["email"])==1?$_POST["email"]:'';
                $birthday= strtotime($_POST["birthday"])< strtotime('12-12-2002')?$_POST["birthday"]:'';
                $major=$_POST["major"];
                $minor=$_POST["minor"];
                //echo $name . ' '. $surname . ' ' . $surname . ' ' . $email;
                if($name!='' AND $surname!='' AND $email!='' AND $birthday!=''){//ready to save data into the database
                    $insertResult=registerStudent($name, $surname, $email, $birthday, $major, $minor);
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
                        . "2-All fields must be filled<br>"
                        . "3-Students must be over <b>18 years old</b>.";
                }
            }
        }
    }
    else{//main page button is clicked
                header('Location: mainWindow.php');
    }
     
    
    
    function registerStudent($name, $surname, $email, $birthday, $major, $minor){
        include_once './database.php';
        include_once './closeDatabase.php';
        $connectionData= openConnection();
        if($connectionData["success"]){//connection succeded
                $studentVaildation= checkEmail($email, $connectionData["connectionVar"]);
                if($studentVaildation["success"]){//student with this email does not exist
                    $conn=$connectionData["connectionVar"];
                    $query = "INSERT INTO `student` (name,surname,email,birthday, major, minor) "
                        . " VALUES ('$name','$surname', '$email', '$birthday' ,'$major', '$minor')";
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
                    return array("success"=>false, "message"=>$studentVaildation["error"]);
                }
        
        }
        else{//database error
            return array("success"=>false, "message"=>"Database connection error!");
        }
        
    }//end of registerStudent function
    
    function checkEmail($email, $con){
        $query="SELECT * from student WHERE email='$email'";
        if(!($result= mysqli_query($con, $query))){
            return array("success"=>false, "error"=>'Error running query!');
        }
        else{
            if(mysqli_num_rows($result)>0){
                //username already exists in the database
                return array("success"=>false, "error"=>'Student with this email already exists');
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
        <title>Add Student | UNYT-SMS</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link type="text/css" rel="stylesheet" href="css/registrationStyle.css">
        <link rel="icon" href="resources/favicon.ico">
    </head>
    <body>
        <header>
            <h1>Add Student</h1>
        </header>
        <div class="main-content">
            <form method="post" action="addStudent.php">
            <table>
                <tr>
                    <td class="left">Name</td>
                    <td class="right"><input type="text" name="name" value="<?php echo (!isset($_POST['name']))?'':$_POST['name']?>" required></td>
                </tr>
                <tr>
                    <td class="left">Surname</td>
                    <td class="right"><input type="text" name="surname" value="<?php echo (!isset($_POST['surname']))?'':$_POST['surname']?>" required></td>
                </tr>
                <tr>
                    <td class="left">Email</td>
                    <td class="right"><input type="email" name="email" 
                                             placeholder="example@host.ext"
                                             value="<?php echo (!isset($_POST['email']))?'':$_POST['email']?>" required></td>
                </tr>
                <tr>
                    <td class="left">Birthday</td>
                    <td class="right"><input type="date" 
                                             name="birthday" value="<?php echo (!isset($_POST['birthday']))?'':$_POST['birthday']?>" required></td>
                </tr>
                <tr>
                    <td class="left">Major</td>
                    <td class="right">
                        <!--input type="text" name="major"
                                             value=<?php //echo (!isset($_POST['major']))?'':$_POST['major']?>-->
                        <?php 
                            print ("<select name='major'>");
                            while ($row = mysqli_fetch_row($departments["result"])) {
                                print("<option>$row[0]</option>");
                            }
                            print("</select>")
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="left">Minor</td>
                    <td class="right">
                        <!--input type="text" name="minor"
                                             value=<?php //echo (!isset($_POST['minor']))?'':$_POST['minor']?>-->
                        <?php 
                            print ("<select name='minor'>"
                                    . "<option selected>-</option>");
                            while ($row = mysqli_fetch_row($minor["result"])) {
                                print("<option>$row[0]</option>");
                            }
                            print("</select>")
                        ?>
                    </td>
                    
                </tr>
                <tr>
                    <td class="left">&nbsp;</td>
                    <td class="right"><input type="submit" name="register" value="Register" class="register">
                        <?php
                            if($informationMessage==''){
                                print("<input type='submit' name='mainPage' value='Main Page' class='register'>");
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



