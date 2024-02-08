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
            $validate  = new Repositories($conn);
            $response['message'] = $validate->sendForgetPassword($email);
               http_response_code(200); 
            
}catch(Exception $e){
     $response=$e->getMessage();
            http_response_code(400); 
                 $response['message'] = $e->getMessage();
}
}
         
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST"); 
header("Content-Type: application/json");
            echo json_encode($response);
      