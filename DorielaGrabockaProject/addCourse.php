<?php
    
    include_once './sessionCheck.php';
    $informationMessage='#';
    $queryForDeps="SELECT DISTINCT Department FROM `course`";
    $queryForFac="SELECT DISTINCT Faculty FROM `course`";
    $departments=getDepartmentsOrFaculties($queryForDeps);
    $faculties= getDepartmentsOrFaculties($queryForFac);
    //print_r ($departments["result"]);
    function getDepartmentsOrFaculties($query){
        include_once './database.php';
        include_once './closeDatabase.php';
        $connectionData= openConnection();
        if($connectionData["success"]){//connection succeded
            $conn=$connectionData["connectionVar"];
            //$query="SELECT DISTINCT Department FROM `course`";
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
            if(!isset($_POST["title"]) OR !isset($_POST["instructor"]) 
                OR !isset($_POST["credits"]) OR !isset($_POST["day"]) 
                OR !isset($_POST["time"]) OR !isset($_POST["class"]) 
                    OR !isset($_POST["department"]) OR !isset($_POST["faculty"])
                    OR !isset($_POST["eligibility"]))
            {
                $informationMessage="All fields must be set!";
            }
            else{
                //validate data before sending them to the database
                $title=$_POST["title"];
                $instructor=preg_match('/^[A-Z]{1}[a-zA-Z]* [A-Z]{1}[a-zA-Z]*$/', $_POST["instructor"])==1?$_POST["instructor"]:'';
                $credits= $_POST["credits"];
                $day= $_POST["day"];
                $time= preg_match('/^[0-9][0-9]:[0]{2}-[0-9][0-9]:[0]{2}$/',$_POST["time"])==1?$_POST["time"]:'';
                $class=$_POST["class"];
                $department=$_POST["department"];
                $faculty=$_POST["faculty"];
                $eligibility=$_POST["eligibility"];
                //echo $title . ' '. $instructor . ' ' . $time ;
                if($title!='' AND $instructor!='' AND $time!=''){//ready to save data into the database
                    $insertResult=registerCourse($title, $instructor, $credits, $day, 
                            $time, $class, $department, $faculty, $eligibility);
                    if($insertResult["success"]){
                        $informationMessage='';
                    }
                    else{//data could not be saved into the database
                        $informationMessage=$insertResult["message"];
                    }
                }
                else{//data not in the proper format
                    $informationMessage="Error in processing data: <br>"
                        . "1-Title and Instructor <b>must start</b> with uppercase letter<br>"
                        . "2-Instructor should have boh name and surname starting with uppercase letters<br>"
                        . "3-Instructor's name and surname have to be seperated by space<br>"
                        . "2-All fields must be filled<br>"
                        . "3-Time must be in the form <b>09:00-21:00</b>";
                }
            }
        }
    }
    else{//main page button is clicked
                header('Location: mainWindow.php');
    }
     
    
    
    function registerCourse($title, $instructor, $credits, $day, 
                            $time, $class, $department, $faculty, $eligibility){
        include_once './database.php';
        include_once './closeDatabase.php';
        $connectionData= openConnection();
        if($connectionData["success"]){//connection succeded
                $courseVaildation= checkCourse($title, $instructor, $day, $time,$connectionData["connectionVar"]);
                if($courseVaildation["success"]){//student with this email does not exist
                    $conn=$connectionData["connectionVar"];
                    $query = "INSERT INTO `course` (title, instructor, credits, day, time, class, department, "
                            . "faculty, eligibility) "
                        . " VALUES ('$title', '$instructor', '$credits', '$day', 
                            '$time', '$class', '$department', '$faculty', '$eligibility')";
                    $result;
                    if(!($result = mysqli_query($conn, $query))){//query cannot run
                        closeConnection($connectionData["connectionVar"]);
                        return array("success"=>false, "message"=>"Data cannot be eneterd into the database!");
                    }
                    else{
                        closeConnection($connectionData["connectionVar"]);
                        return array("success"=>true, "message"=>"Course registered succesfully");
                
                    }
                }
                else{//user with that username found
                    closeConnection($connectionData["connectionVar"]);
                    return array("success"=>false, "message"=>$courseVaildation["error"]);
                }
        
        }
        else{//database error
            return array("success"=>false, "message"=>"Database connection error!");
        }
        
    }//end of registerUser function
    
    function checkCourse($title, $instructor, $day, $time, $con){
        $query="SELECT * from course WHERE "
                . "title='$title' and instructor='$instructor' and day='$day' and time='$time'";
        if(!($result= mysqli_query($con, $query))){
            return array("success"=>false, "error"=>'Error running query!');
        }
        else{
            if(mysqli_num_rows($result)>0){
                //username already exists in the database
                return array("success"=>false, "error"=>'This course exists!');
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
        <title>Add Course | UNYT-SMS</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link type="text/css" rel="stylesheet" href="css/addCourseStyle.css">
        <link rel="icon" href="resources/favicon.ico">
    </head>
    <body>
        <header>
            <h1>Add Course</h1>
        </header>
        <div class="main-content">
            <form method="post" action="addCourse.php">
            <table>
                <tr>
                    <td class="left">Title</td>
                    <td class="right">
                        <input type="text" name="title" value="<?php echo (!isset($_POST['title']))?'':$_POST['title']?>" required>
                    </td>
                </tr>
                <tr>
                    <td class="left">Instructor</td>
                    <td class="right">
                        <input type="text" name="instructor" value="<?php echo (!isset($_POST['instructor']))?'':$_POST['instructor']?>" required>
                    </td>
                </tr>
                <tr>
                    <td class="left">Credits</td>
                    <td class="right">
                        <input type="number" min="1" max="4" name="credits" value="<?php echo (!isset($_POST['credits']))?'':$_POST['credits']?>" required>
                    </td>
                </tr>
                <tr>
                    <td class="left">Day</td>
                    <td class="right">
                        <select name="day" required>
                            <option selected>Monday</option>
                            <option>Tuesday</option>
                            <option>Wednesday</option>
                            <option>Thursday</option>
                            <option>Friday</option>
                            <option>Saturday</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="left">Time</td>
                    <td class="right">
                        <input type="text" name="time"  placeholder="ex. 09:00-21:00" value="<?php echo (!isset($_POST['time']))?'':$_POST['time']?>" required>
                    </td>
                </tr>
                <tr>
                    <td class="left">Class</td>
                    <td class="right">
                        <input type="text" name="class" value="<?php echo (!isset($_POST['class']))?'':$_POST['class']?>" required>
                    </td>
                </tr>
                <tr>
                    <td class="left">Department</td>
                    <td class="right">
                        <!--input type="text" name="major"
                                             value=<?php //echo (!isset($_POST['major']))?'':$_POST['major']?>-->
                        <?php 
                                print ("<select name='department' required>");
                            while ($row = mysqli_fetch_row($departments["result"])) {
                                print("<option>$row[0]</option>");
                            }
                            print("</select>")
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="left">Faculty</td>
                    <td class="right">
                        <!--input type="text" name="minor"
                                             value=<?php //echo (!isset($_POST['minor']))?'':$_POST['minor']?>-->
                        <?php 
                            print ("<select name='faculty' required>");
                            while ($row = mysqli_fetch_row($faculties["result"])) {
                                print("<option>$row[0]</option>");
                            }
                            print("</select>")
                        ?>
                    </td>
                    
                </tr>
                <tr>
                    <td class="left">Eligibility</td>
                    <td class="right">
                        <select name="eligibility" required>
                            <option selected>-</option>
                            <option>All</option>
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <td class="left">&nbsp;</td>
                    <td class="right"><input type="submit" name="register" value="Add Course" class="register">
                        <?php
                            if($informationMessage==''){
                                print("<input type='submit' name='mainPage' value='Main Page' class='register'>");
                                $informationMessage="Course registered succesfully!";
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
