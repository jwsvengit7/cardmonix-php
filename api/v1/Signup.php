<?php
require_once("../../config/Config.php");
require_once ("../../utils/Repositories.php");
        $response=array(); 
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
    $jsonContent = file_get_contents('php://input');
    $requestData = json_decode($jsonContent, true);

        $email =  $requestData['email'];
        $username = $requestData['username'];
        $password =  password_hash($requestData['password'], PASSWORD_DEFAULT);
        

    $validate = new Repositories($conn);


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
        $response["message"] = "Success";
        $response["payload"] =$insertRecord;
        http_response_code(200); 
      
        }
        }
         header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST"); 
header("Content-Type: application/json");
            echo json_encode($response);
  

?>
