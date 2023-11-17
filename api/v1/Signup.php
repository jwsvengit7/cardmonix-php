<?php
require_once("../../config/Config.php");
include "../../utils/Repositories.php";
        $response=array(); 
        $email =  $_POST['email'] ?? null;
        $username = $_POST['username'] ?? null;
        $password =  password_hash($_POST['password'], PASSWORD_DEFAULT) ?? null;

        $validate  = new Repositories($conn);
        $validateUser = $validate->validateUser($email);
        if($validateUser=="User Already Exists"){
            $response["message"] = $validateUser;
    
            http_response_code(400); 

        }else if($validateUser=="User Needs to Activate Account"){
            $response["message"] = $validateUser;

            http_response_code(403); 
        }else{
       
        $user = array("email"=>$email,"username"=>$username,"password"=>$password);
        $insertRecord = $validate->insertUser($user);
    
        $response["payload"] =$insertRecord;
        http_response_code(200); 
      
        }
     
        header("Content-Type: application/json");
        echo json_encode($response);
  

?>
