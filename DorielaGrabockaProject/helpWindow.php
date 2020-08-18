<?php
?>


<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Help | UNYT-SMS</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link type="text/css" rel="stylesheet" href="css/helpWindowStyle.css">
        <link type="text/css" rel="stylesheet" href="css/footerStyle.css">
        <link rel="icon" href="resources/favicon.ico">
        
    </head>
    <body>
        <div>
            <h1>Help Window</h1>
            <h2>Student Management System  -  June 2020 -Designed to improve staff performance...</h2>
            <div class="letter">
                <p class="intro"><b>Dear User,</b></p>
                <p>This system is intended for academic use. Its main goal is to help staff be more organized and efficient.</p>
                <p>Functionalities:</p>
                    <ol>
                        <li><b>Add Student</b> &mdash; this button will redirect you to a new window that will
                            enable you to  enter students and register a particular student.
                        </li>
                        <li><b>Add Courses</b> &mdash; this button will redirect you to a new window that will
                            enable you to add a course to the course list.
                        </li>
                        <li><b>Search Courses</b> &mdash; this button will redirect you to a new window that will
                            contain the table of all courses offered by the university. By clicking in the desired row of a table 
                            you can see the participants of the course. You can search a course by title even by entering 
                            part of the title.You can filter the courses by department, as well.
                        </li>
         
                        <li><b>Search Students</b> &mdash; this window will give you the possibility to see all students of the
                            university. You can search for students by entering their
                            name and then pressing the Search button. If you want to see all students simply press
                            Display All button. You can also filter students by degree, as well.
                        </li>
                        <li><b>Assign Course to Student</b> &mdash; this window will give you the possibility to register
                            a student in a specific course. You should select the student from the students table and then select a course 
                            from the course table and at the end press the <b>Assign</b> button.
                        </li>
                        <li><b>Log out</b> &mdash; this will sign you out and redirect to the Log In page.
                        </li>

                    </ol>

                <p>If there are any issues, please e-mail at <b>dorielag18@gmail.com</b> or <b>dorielagrabocka@unyt.edu.al</b>.</p>
    
                <p>We hope you enjoy your experience here!<br><span class="goodye">BEST WISHES!</span></p>
            </div>
        </div>
        
        <?php
            include_once './footer.php';
        ?>
        
        <!--This is neededfor the IONICOS to display. They need anintenet connection too.-->
        <script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
    </body>
</html>

