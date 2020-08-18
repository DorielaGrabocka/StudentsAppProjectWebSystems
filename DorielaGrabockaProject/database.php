<?php
    // configure the data for database access
    
    function openConnection(){
        $dbhost = 'localhost';
        $dbuser = 'root';
        $dbpass = '';
        $dbname = 'universityms';
        if(!($conn = mysqli_connect($dbhost, $dbuser, $dbpass))){
            //include_once './closeDatabase.php';
            return array("success"=>false, "connectionVar"=>null,"error"=>'Error connecting to mysql');
        
        }
        else{
            if(!mysqli_select_db($conn, $dbname)){
                //include_once './closeDatabase.php';
                return array("success"=>false, "error"=>'Error connecting to the database!');
            }
            else{
                //include_once './closeDatabase.php';
                return array("success"=>true, "connectionVar"=>$conn ,"error"=>'');
            }
        
        }
    
    }
?>

