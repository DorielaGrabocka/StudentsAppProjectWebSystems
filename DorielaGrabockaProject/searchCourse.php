<?php
    include_once './sessionCheck.php';
    $departments=getDepartments();
    $coursesResult;
    $studentsOfCourse;
    $courseTitle;
    $showStudentsClicked=false;
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
        $stateAllCourses=true;
        $query="SELECT * FROM `course`";
        $coursesResult= getCourses($query);
    }
    else if(isset($_POST["search"])){//search button is clicked
        unset($_POST["search"]);
        unset($_POST["filter"]);
        unset($_POST["displayAll"]);
        $stateFilter=false;
        $stateSearch=true;
        $stateAllCourses=false;
        if(isset($_POST["courseTitle"])){
            $ctitle=$_POST["courseTitle"];
            $query="SELECT * from `course` where title like '$ctitle%'";
            $coursesResult= getCourses($query);
        }
        else{
            $infoMsg="Please enter a title";
        }
    }
    else if(isset($_POST["filter"])){//filter button is clicked
        unset($_POST["search"]);
        unset($_POST["filter"]);
        unset($_POST["displayAll"]);
        $stateFilter=true;
        $stateSearch=false;
        $stateAllCourses=false;
        if(isset($_POST["department"])){
            $dep=$_POST["department"];
            $query="SELECT * from `course` where department='$dep'";
            $coursesResult= getCourses($query);
        }
        else{
            $infoMsg="Please select a department";
        }
    }
    else{
        unset($_POST["search"]);
        unset($_POST["filter"]);
        unset($_POST["displayAll"]);
        $stateFilter=false;
        $stateSearch=false;
        $stateAllCourses=false;
        $query="SELECT * FROM `course`";
        $coursesResult= getCourses($query);
    }
    
    if(isset($_POST["showStudents"]) && !empty(($_POST["cID"])) ){
        $showStudentsClicked=true;
        $coID=$_POST["cID"];
        $query="select s.ID,s.Name,s.Surname,s.Birthday, s.Email ,s.Major,s.Minor "
                  ."from student s join studentcourse sc on s.ID=sc.StudentID "
                  ."join course c on c.ID=sc.CourseID where c.ID=$coID";
        $studentsOfCourse= getStudentsOfCourse($query);
        $query1="SELECT title from `course` where id=$coID";
        $rs= getCourses($query1);
        $data= mysqli_fetch_row($rs["result"]);
        $courseTitle=$data[0];
        unset($_POST["showStudents"]);
        unset($_POST["cID"]);
    }
    
    function getStudentsOfCourse($query){
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
    
    
    
    function getCourses($query){
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
        <title>Search Course | UNYT-SMS</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link type="text/css" rel="stylesheet" href="css/searchCourseStyle.css">
        <link rel="icon" href="resources/favicon.ico">
    </head>
    <body>
        <div class="back">
            <form method="post" action="searchCourse.php">
                <input type="submit" class="btn" name="back" value="Go back">
            </form>
        </div>
        <header>
            <h1>Course Data</h1>
        </header> 
        <div class="all-courses">
            <h4>All Courses</h4>
            
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
                <tbody>
                    <?php
                       while ($row = mysqli_fetch_row($coursesResult["result"])) {
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
                <form method="post" action="searchCourse.php">
                    <div class="search">
                        <table id="allCourses"><tr>
                            <td class="label"><label for="title">Enter Title</label></td>
                            <td class="choice"><input type="text" id="title" name="courseTitle"></td>
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
                        <td class="label"><label for="department">Filter By Department</label></td>
                        <td class="choice"><?php 
                            print ("<select name='department'>");
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
                            <td class="label"><label for="cID">Course ID</label></td>
                            <td class="choice"><input type="text" id="cID" name="cID" readonly></td>
                            <td class="buttons"><input type="submit" name="showStudents" value="Students" class="btn btn-course"></td>
                            <td class="lastCol"><p></p></td>
                        </tr></table>
                    </div>
                </form>    
            </div>
        
        <?php
            
                if($showStudentsClicked){
                    echo '<div class="student-list">
                        <h4>Students of ' . $courseTitle. '</h4>
            
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
                    <tbody>';
                    while ($row = mysqli_fetch_row($studentsOfCourse["result"])) {
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
            
            $showStudentsClicked=FALSE;
            ?>
    
        <!--Importing jQuery to be able to select rows of table-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            $(document).ready(function(){
                $(".all-courses tbody tr").click(function (){
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
