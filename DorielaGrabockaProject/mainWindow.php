<?php
    include_once './sessionCheck.php';
    if(isset($_POST["logout"])){
        session_destroy();
        header('Location: login.php');
    }
    else{
        if(isset($_POST["addStudent"])){
            header('Location: addStudent.php');
        }
        if(isset($_POST["addCourse"])){
            header('Location: addCourse.php');
        }
        if(isset($_POST["searchStudent"])){
            header('Location: searchStudent.php');
        }
        if(isset($_POST["searchCourse"])){
            header('Location: searchCourse.php');
        }
        if(isset($_POST["assignCourse"])){
            header('Location: assignCourse.php');
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Main Window | UNYT-SMS</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link type="text/css" rel="stylesheet" href="css/mainWindowStyle.css">
        <link rel="icon" href="resources/favicon.ico">
    </head>
    <body>
        
        <header>
            <div class="header-right">
                <form method="post" action="mainWindow.php">
                    <a href="helpWindow.php" class="btn-logout help-link">Help</a>    
                    <input type="submit" name="logout" value="Log out" class="btn-logout">
                </form>                
            </div>
        </header>
        
        <div class="main-content">
            <section class="welcome-message">
                <div>
                    <h1>Welcome 
                        <span class="name"><?php print($_SESSION["nameOfUser"] ."   ". $_SESSION["surnameOfUser"]);?></span>
                    </h1>
                </div>
            </section>
        
            <section class="main-page-content">
                <form method="post" action="mainWindow.php">
                <table>
                    <tr>
                        <td class="left">
                            <div>
                            <ion-icon name="person-add-outline" class="icon"></ion-icon>
                            <input type="submit" value="Add Student" name="addStudent" class="btn-full">
                            </div>
                        </td>
                        <td class="right">
                            <ion-icon name="book-outline"></ion-icon>
                            <input type="submit" value="Add Course" name="addCourse" class="btn-full">
                        </td>
                    </tr>
                    <tr>
                        <td class="left">
                            <ion-icon name="search-sharp"></ion-icon>
                            <input type="submit" value="Search Student" name="searchStudent" class="btn-full">
                        </td>
                        <td class="right">
                            <ion-icon name="search-sharp"></ion-icon>
                            <input type="submit" value="Search Course" name="searchCourse" class="btn-full">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="last-row">
                           <ion-icon name="library-outline"></ion-icon>
                           <input type="submit" value="Assign Course to Student" name="assignCourse" class="btn-full last-button">
                 
                        </td>
                    </tr>
                </table>
                
                </form>
            </section>
        
        </div>
        
        
        
        <footer>
            
                <p>Reach UNYT</p>

                <ul class="social media">
                    <li>
                        <a href="https://www.facebook.com/unyt.edu.al/"  target="_blank">
                            <ion-icon name="logo-facebook" class="icon-small logo-facebook"></ion-icon>
                        </a>
                    </li>
                    <li>
                        <a href="https://twitter.com/UNYT_Official" target="_blank">
                            <ion-icon name="logo-twitter" class="icon-small logo-twitter"></ion-icon>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.linkedin.com/school/university-of-new-york-tirana/" target="_blank">
                            <ion-icon name="logo-linkedin" class="icon-small logo-linkedin"></ion-icon>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com/unyt_official/" target="_blank">
                            <ion-icon name="logo-instagram" class="icon-small logo-insatgram"></ion-icon>
                        </a>
                    </li>
                </ul>
            
        </footer>
        <!--This is needed for the IONICOS to display. They need an internet connection too.-->
        <script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
    </body>
</html>
