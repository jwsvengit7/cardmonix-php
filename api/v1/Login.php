<?php
session_start();
require_once("../../config/Config.php");
include "../../utils/Repositories.php";



            $response=array();

            $email = $_POST['email'] ?? null;
            $password =  $_POST['password'] ?? null;
            $validate  = new Repositories($conn);
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