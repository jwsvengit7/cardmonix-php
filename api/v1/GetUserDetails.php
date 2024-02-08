<?php
session_start();
require_once("../../config/Config.php");
include "../../utils/Balance.php";
include "../../utils/headers.php";
include "../../utils/Repositories.php";
$result=array();
$headers = new Headers($_SERVER['REQUEST_URI']);
$userId=$headers->getHeaders();

   

if ($_SERVER['REQUEST_METHOD'] === 'GET' ) {
  

    $validate = new Repositories($conn);
   
    $validateUser = $validate->validateUserId($userId);
 if ($validateUser === "User Not Found") {
        $result['balance'] = $userId;
   
        http_response_code(400);
    } else {
$get = new Balance($conn);
$array = $get->getBalance($userId);
$result['balance'] = $array;
http_response_code(200);
}
}else{
 $result['balance'] = "Login Again";
http_response_code(403);   
}
   header("Access-Control-Allow-Origin: *");
   header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: GET,POST,OPTIONS"); 
header("Content-Type: application/json");
echo json_encode($result);