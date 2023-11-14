<?php
session_start();
require_once("../config/Config.php");
include "../utils/Sql.php";



            $response=array();

            $email = isset($_POST['email']) ? $_POST['email'] : null;
            $password = isset($_POST['password']) ? $_POST['password'] : null;
            $validate  = new Query($conn);
            $validateUser = $validate->validateUserEnable($email,$password);
            if($validateUser=="Incorrect Password"){
                $response["message"]=$validateUser;
                http_response_code(403); 
            }
            else if($validateUser=="User Needs to Activate Their Account"){
                $response["message"]=$validateUser;
                http_response_code(400); 
            }else{
                $_SESSION['token']=1;
            $response=$validateUser;
            http_response_code(200); 
            }
            
            header("Content-Type: application/json");
            echo json_encode($response);
      





?>