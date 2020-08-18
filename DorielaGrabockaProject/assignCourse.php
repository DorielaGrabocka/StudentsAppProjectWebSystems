<?php
    include_once './sessionCheck.php';
    $infoMessage='';
    $showPossibilitiesClicked=false;
    $allStudents= getDATA("SELECT * from `student`");
    $possibleCoursesRes;
    $stName;
    $stSurname;
    $firstTime=false;
    $courseID=-1;
    if(!isset($_POST["showPossibilites"]) && !isset($_POST["addCourse"])){
        $firstTime=true;
    }
    else{
        $firstTime=false;
        $showPossibilitiesClicked=true;
    }
    
    
    if($showPossibilitiesClicked){
        //echo 'inside if 1';
        $showPossibilitiesClicked=true;
        getPossibilities();
        //unset($_POST["showPossibilites"]);
        $data= getPossibilities();
        $possibleCoursesRes=$data["result"];
        $stName=$data["name"];
        $stSurname=$data["surname"];
    }
    
    
    
    if(isset($_POST["addCourse"]) && !empty($_POST["cID"])){//a course must be selected besides of the assign button being pressed
        $studentId=$_POST["stID"];
        $courseId=$_POST["cID"];
        $courseID=$courseId;
        $showPossibilitiesClicked=true;
        //echo 'inside if 2'. $studentId.'  '.$courseId;
        unset($_POST["addCourse"]);
        $data= hasCourse($studentId, $courseId);
        if($data["present"]){
            $infoMessage=$data["message"];
        }
        else{
            $query="INSERT into `studentcourse` VALUES ($studentId, $courseId)";
            $insertion= addCourseToStudent($query);
            $infoMessage=$insertion["message"];
        }
        
    }
    
    function hasCourse($studID, $courseID){
        $query="SELECT * from `studentcourse` WHERE studentid=$studID and courseid=$courseID";
        $assignementRES= getDATA($query);
        $numOfRows= mysqli_num_rows($assignementRES["result"]);
        if($numOfRows>0){
            return array("present"=>true, "message"=>"This course is in the course list of the student!");
        }
        else{
            return array("present"=>false, "message"=>"");
        }
    }
    
    
    
    
    
    function getPossibilities(){
        if(!empty($_POST["sID"])){
            $sid=$_POST["sID"];
            $queryGetStudent="SELECT major,minor, name, surname FROM student WHERE id=$sid";
            $stRes= getDATA($queryGetStudent);
            $st= mysqli_fetch_row($stRes["result"]);
            $sMajor=$st[0];//major
            $sMinor=$st[1];//minor
            $queryForPossibilities=
                    "SELECT * from course where department='$sMajor' or department='$sMinor' or eligibility='All'";
            $possibleCoursesRes= getDATA($queryForPossibilities);
            return array("result"=>$possibleCoursesRes, "name"=> $st[2], "surname"=> $st[3]);
        }
        
         
        
    }
    
    
    function getDATA($query){
        include_once './database.php';
        include_once './closeDatabase.php';
        $connectionData= openConnection();
        if($connectionData["success"]){//connection succeded
            $conn=$connectionData["connectionVar"];
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
    }
    
    
    function addCourseToStudent($query){
        include_once './database.php';
        include_once './closeDatabase.php';
        $connectionData= openConnection();
        if($connectionData["success"]){//connection succeded
            $conn=$connectionData["connectionVar"];
            $result;
            if(!($result = mysqli_query($conn, $query))){//query cannot run
                closeConnection($connectionData["connectionVar"]);
                return array("success"=>false, "message"=>"Data cannot be retrieved from the database!");
            }
            else{
                closeConnection($connectionData["connectionVar"]);
                return array("success"=>true,"message"=>"Course added succesfully!");
            }
        }
        else{//database error
            return array("success"=>false, "result"=>NULL ,"message"=>"Database connection error!");
        }
    }
?>












<!DOCTYPE html>
<html>
    <head>
        <title>Assign Course | UNYT-SMS</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link type="text/css" rel="stylesheet" href="css/assignCourseStyle.css">
        <link rel="icon" href="resources/favicon.ico">
    </head>
    <body>
        <div class="back">
            <form method="post" action="searchCourse.php">
                <input type="submit" class="btn" name="back" value="Go back">
            </form>
        </div>
        <header>
            <h1>Assign Course to  Student</h1>
        </header>
        
        <div class="studentsTable">
            <h4>Students</h4>
            
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Surname</th>
                        <th>Birthday</th>
                        <th>Email</th>
                        <th>Major</th>
                        <th>Minor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                       while ($row = mysqli_fetch_row($allStudents["result"])) {
                                print("<tr>");
                                foreach ($row as $val){
                                    print("<td>$val</td>");
                                }
                                print("</tr>");
                            } 
                    ?>
                </tbody>
            </table>
        </div>
        
        <div class="show-possiblities">
            <form method="post" action="assignCourse.php">
            <table>
                <tr>
                    <td class="label"><label for="sID">Student ID</label></td>
                    <td class="choice"><input type="text" id="sID" name="sID" value="<?php echo (!isset($_POST['sID']))?'':$_POST['sID']?>" readonly></td>
                    <td class="buttons"><input type="submit" name="showPossibilites" value="Show possibilities" class="btn btn-course"></td>
                
                </tr>
            </table>
            
        </div>
        
        <?php
        if($showPossibilitiesClicked){
        print (
                '<div class="coursesTable">
            <h4> Possible Courses of '. $stName. '  '. $stSurname.'</h4>
            
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Instructor</th>
                        <th>Credits</th>
                        <th>Day</th>
                        <th>Time</th>
                        <th>Class</th>
                        <th>Department</th>
                        <th>Faculty</th>
                        <th>Eligibility</th>
                    </tr>
                </thead>
                <tbody>');
                        
                       while ($row = mysqli_fetch_row($possibleCoursesRes["result"])) {
                                print("<tr>");
                                foreach ($row as $val){
                                    print("<td>$val</td>");
                                }
                                print("</tr>");
                            } 
                   print('
                </tbody>
            </table>
        </div>
        
        <div class="add-course">
                    
                    <table>
                    <tr>
                        <td class="label"><label for="cID">Course ID</label></td>
                        <td class="choice"><input type="text" id="cID" name="cID" value="'. ($courseID==-1?"":$courseID) .'" readonly></td>
                        <td class="label"><label for="stID">Student ID</label></td>
                        <td class="choice"><input type="text" id="stuID" name="stID" value="'. $_POST["sID"]. '" readonly></td>
                        <td class="buttons"><input type="submit" name="addCourse" value="Assign" class="btn btn-course"></td>
                    </tr>
                    <tr>
                        <td colspan="4">');
                        
                            if($infoMessage!=''){
                                print '<p class="message">'.$infoMessage.'</p>';
                            }
                        
                    print '</td>
                    </tr>
                </table>
                </form>
            </div>';
            
        }
        ?>
        
        <!--Importing jQuery to be able to select rows of table-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            $(document).ready(function(){
                $(".studentsTable tbody tr").click(function (){
                    var data=$(this).children("td").map(function (){
                        return $(this).text();
                    }).get();
                    var id=data[0];
                    $("#sID").val(id);
                    $("#stuID").val(id);
                    
                });
                $(".coursesTable tbody tr").click(function (){
                    var data=$(this).children("td").map(function (){
                        return $(this).text();
                    }).get();
                    var id=data[0];
                    $("#cID").val(id);
                    
                    
                });
                
            });
        </script>
        
    </body>
</html>
