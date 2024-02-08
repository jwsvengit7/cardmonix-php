<?php
session_start();
require_once("../../config/Config.php");
include "../../utils/Bank.php";
include "../../utils/headers.php";


$result=array();
$headers = new Headers($_SERVER['REQUEST_URI']);
$userId=$headers->getHeaders();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
    $jsonContent = file_get_contents('php://input');
    $requestData = json_decode($jsonContent, true); 


if (!empty($userId)) {
    $accountName = $requestData['accountName'] ?? null;
    $bank = $requestData['bankName'] ?? null;
    $accountNumber = $requestData['accountNumber'] ?? null;
    $validate = new Bank($conn);
   
    $validateUser = $validate->addBankAccount(array(
        "accountName"=>$accountName,
        "accountNumber"=>$accountNumber,
        "bankName"=>$bank),
        $userId);

   if($validateUser==="Account Successfully added" || $validateUser === "Account Already Exists") {

        $result['message'] = $validateUser;
        http_response_code(200);

    }else{
        $result['message'] = $validateUser;
        http_response_code(403); 
    }
}
}


header("Content-Type: application/json");
echo json_encode($result);