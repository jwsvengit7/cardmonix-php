<?php
session_start();
require_once("../../config/Config.php");
include "../../utils/Repositories.php";
include "../../utils/headers.php";
include "../../utils/Withdraw.php";


$result=array();
$headers = new Headers($_SERVER['REQUEST_URI']);
$userId=$headers->getHeaders();


if (!empty($userId)) {
    $validate = new Repositories($conn);
   
    $validateUser = $validate->validateUserId($userId);

    if ($validateUser === "User Not Found") {
        $result['message'] = $validateUser;
        http_response_code(400);
    } else {
    $jsonContent = file_get_contents('php://input');
    $requestData = json_decode($jsonContent, true); 
    $type =  $requestData['type'] ?? null;
    $amount = $requestData['amount'] ?? null;

    $withdrawer = new Withdraw($conn);
    $send = $withdrawer->widthraw($type,$amount,$userId);
    $result['message'] = $send;
    http_response_code(200);



    }

}

header("Content-Type: application/json");
echo json_encode($result);