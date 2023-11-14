<?php
require_once("../config/Config.php");
include "../config/Mail/Mail.php";
include "../utils/Sql.php";
        $response=array(); 
        $email = isset($_POST['email']) ? $_POST['email'] : null;
        $username = isset($_POST['username']) ? $_POST['username']: null;
        $password = isset($_POST['password']) ? $_POST['password'] : null;
        

        $validate  = new Query($conn);
        $validateUser = $validate->validateUser($email);
        if($validateUser=="User Already Exist"){
            $response["message"] = $validateUser;
            $response["status-code"]=403;

        }else if($validateUser=="User Need to activate his account"){
            $response["message"] = $validateUser;
            $response["status-code"]=403;
        }else{
      
        $auth = new Mail($email);
        $auth->sendEmailOtp(); 
        $otp = $auth->getContent(); 
       
        $user = array("email"=>$email,"username"=>$username,"password"=>$password,"otp"=>$otp);
        $insertRecord = $validate->insertUser($user);
    
        $response["payload"] =$insertRecord;
        $response["status-code"]=200;
      
        }
     
        header("Content-Type: application/json");
        echo json_encode($response);
  

?>
