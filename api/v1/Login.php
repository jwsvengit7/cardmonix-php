<?php
session_start();
require_once("../../config/Config.php");
include "../../utils/Repositories.php";

            $response=array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
    $jsonContent = file_get_contents('php://input');
    $requestData = json_decode($jsonContent, true); 
try{

            $email = $requestData['email'];
            $password =  $requestData['password'];
            $validate  = new Repositories($conn);
            $validateUser = $validate->validateUserEnable($email,$password);
            if($validateUser=="Incorrect Password"){
                $response["message"]=$validateUser;
                http_response_code(403); 
            }
            else if($validateUser=="User Needs to Activate Their Account"){
                $response["message"]=$validateUser;
                http_response_code(400); 
            } 
             else if($validateUser=="Error"){
                $response["message"]=$validateUser;
                http_response_code(403); 
            }
                else if($validateUser=="User Not Found"){
                $response["message"]=$validateUser;
                http_response_code(404); 
            }
            else{
            $_SESSION['token']=$validateUser['token'];
            $response=$validateUser;
            http_response_code(200); 
            }
}catch(Exception $e){
     $response=$e->getMessage();
            http_response_code(400); 
}
}
           
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST"); 
header("Content-Type: application/json");
            echo json_encode($response);
      





?>