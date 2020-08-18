<?php
    function validateLogin($name, $password){
        include_once './database.php';
        include_once './closeDatabase.php';
        $connectionData= openConnection();
        if($connectionData["success"]){//connection succeded
            $encryptedPass= md5($password);
            $conn=$connectionData["connectionVar"];
            $query = "SELECT * FROM `user` WHERE username= '$name' and Password='$encryptedPass'";
            $result;
            if(!($result = mysqli_query($conn, $query))){//query cannot run
                closeConnection($connectionData["connectionVar"]);
                return array("success"=>false, "name"=>null,"surname"=>null ,"error"=>"Wrong credentials! Check Username and Password!");
            }
            else{
                $noOfRows=mysqli_num_rows($result);
                if($noOfRows==1){//user authenticated
                    $row=mysqli_fetch_row($result);
                    $name=$row[1];//getting the name
                    $surname= $row[2];//getting the surname
                    closeConnection($connectionData["connectionVar"]);
                    return array("success"=>true,"name"=>$name,"surname"=>$surname ,"error"=>"");
                }
                else{//user could not be authenticated
                    closeConnection($connectionData["connectionVar"]);
                    return array("success"=>false, "name"=>null,"surname"=>null ,"error"=>"Authentication Failed! Try again!");
                }
            }
        }
        else{//connection failed
            closeConnection($connectionData["connectionVar"]);
            return array("success"=>false, "error"=>$connectionData['error']);
            
        }
        
        
    }
?>
