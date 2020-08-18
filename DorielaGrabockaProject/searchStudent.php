<?php
    include_once './sessionCheck.php';
    $departments=getDepartments();
    $studentsResult;
    $coursesOfStudent;
    $studentName;
    $studentSurname;
    $showCoursesClicked=false;
    $infoMsg='';
    if(isset($_POST["back"])){
        header('Location: mainWindow.php');
    }
    if(isset($_POST["displayAll"])){//we are at the beginning or user has clicked dispaly all
        unset($_POST["search"]);
        unset($_POST["filter"]);
        unset($_POST["displayAll"]);
        $stateFilter=false;
        $stateSearch=false;
        $stateAllStudents=true;
        $query="SELECT * FROM `student`";
        $studentsResult= getStudents($query);
    }
    else if(isset($_POST["search"])){//search button is clicked
        unset($_POST["search"]);
        unset($_POST["filter"]);
        unset($_POST["displayAll"]);
        $stateFilter=false;
        $stateSearch=true;
        $stateAllStudents=false;
        if(isset($_POST["studentName"])){
            $stName=$_POST["studentName"];
            $query="SELECT * from `student` where name like '$stName%'";
            $studentsResult= getStudents($query);
        }
        else{
            $infoMsg="Please enter a name";
        }
    }
    else if(isset($_POST["filter"])){//filter button is clicked
        unset($_POST["search"]);
        unset($_POST["filter"]);
        unset($_POST["displayAll"]);
        $stateFilter=true;
        $stateSearch=false;
        $stateAllStudents=false;
        if(isset($_POST["major"])){
            $mjr=$_POST["major"];
            $query="SELECT * from `student` where major='$mjr'";
            $studentsResult= getStudents($query);
        }
        else{
            $infoMsg="Please select a major";
        }
    }
    else{
        unset($_POST["search"]);
        unset($_POST["filter"]);
        unset($_POST["displayAll"]);
        $stateFilter=false;
        $stateSearch=false;
        $stateAllStudents=false;
        $query="SELECT * FROM `student`";
        $studentsResult= getStudents($query);
    }
    
    if(isset($_POST["showCourses"]) && !empty(($_POST["stID"])) ){
        $showCoursesClicked=true;
        $studID=$_POST["stID"];
        $query="select c.ID, c.Title, c.Instructor, c.Day, c.Time, c.Class, "
                  . "c.Credits, c.Department, c.Faculty, c.Eligibility "
                  . "from student s join studentcourse sc on s.ID=sc.StudentID "
                  . "join course c on c.ID=sc.CourseID where s.ID=$studID";
        $coursesOfStudent= getCoursesOfStudent($query);
        $query1="SELECT name, surname from `student` where id=$studID";
        $rs=getStudents($query1);
        $data= mysqli_fetch_row($rs["result"]);
        $studentName=$data[0];
        $studentSurname=$data[1];
        unset($_POST["showCourses"]);
        unset($_POST["stID"]);
    }
    
    function getCoursesOfStudent($query){
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
    
    
    
    function getStudents($query){
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
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Search Student | UNYT-SMS</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link type="text/css" rel="stylesheet" href="css/searchStudentStyle.css">
        <link rel="icon" href="resources/favicon.ico">
    </head>
    <body>
        <div class="back">
            <form method="post" action="searchStudent.php">
                <input type="submit" class="btn" name="back" value="Go back">
            </form>
        </div>
        <header>
            <h1>Student Data</h1>
        </header> 
        <div class="all-students">
            <h4>All Students</h4>
            
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
                       while ($row = mysqli_fetch_row($studentsResult["result"])) {
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
            <div class="functionalities">
                <form method="post" action="searchStudent.php">
                    <div class="search">
                        <table id="allStudents"><tr>
                            <td class="label"><label for="name">Enter Name</label></td>
                            <td class="choice"><input type="text" id="name" name="studentName" ></td>
                            <td class="buttons"><input type="submit" name="search" value="Search" class="btn"></td>
                            <td class="lastCol">
                                <?php
                                    if($stateSearch){
                                        echo '<input type="submit" name="displayAll" value="Display All" class="btn">';
                            
                                    }
                                ?></td>
                        </tr></table>
                    </div>
                    
                    <div class="filter">
                        <table><tr>
                        <td class="label"><label for="major">Filter By Major</label></td>
                        <td class="choice"><?php 
                            print ("<select name='major'>");
                            while ($row = mysqli_fetch_row($departments["result"])) {
                                print("<option>$row[0]</option>");
                            }
                            print("</select>")
                        ?></td>
                        <td class="buttons"><input type="submit" name="filter" value="Filter" class="btn"></td>
                        <td class="lastCol"><?php
                            if($stateFilter){
                                echo '<input type="submit" name="displayAll" value="Display All" class="btn">';
                            }
                            ?>
                        </td>
                        </tr></table>
                        <table><tr>
                            <td class="label"><label for="stID">Student ID</label></td>
                            <td class="choice"><input type="text" id="stID" name="stID" readonly></td>
                            <td class="buttons"><input type="submit" name="showCourses" value="Courses" class="btn btn-course"></td>
                            <td class="lastCol"><p></p></td>
                        </tr></table>
                    </div>
                </form>    
            </div>
        
        <?php
            
                if($showCoursesClicked){
                    echo '<div class="course-list">
                        <h4>Courses of ' . $studentName. " " . $studentSurname. '</h4>
            
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
                    <tbody>';
                    while ($row = mysqli_fetch_row($coursesOfStudent["result"])) {
                        print("<tr>");
                        foreach ($row as $val){
                            print("<td>$val</td>");
                        }
                        print("</tr>");
                    } 
                   
               echo '</tbody>
            </table>        </div>
';
            }
            
            $showCoursesClicked=FALSE;
            ?>
    
        <!--Importing jQuery to be able to select rows of table-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            $(document).ready(function(){
                $(".all-students tbody tr").click(function (){
                    var data=$(this).children("td").map(function (){
                        return $(this).text();
                    }).get();
                    var id=data[0];
                    $("#stID").val(id);
                });
                
            });
        </script>
    
    </body>
</html>
