<?php
session_start();
require_once("../../config/Config.php");
include "../../utils/Bank.php";
include "../../utils/headers.php";


$result=array();
$headers = new Headers($_SERVER['REQUEST_URI']);
$userId=$headers->getHeaders();



if (isset($_SESSION['token']) && !empty($userId)) {
    $accountName = $_POST['accountName'] ?? null;
    $bank = $_POST['bank'] ?? null;
    $accountNumber = $_POST['accountNumber'] ?? null;
    $validate = new Bank($conn);
   
    $validateUser = $validate->addbankAccount(array(
        "accountName"=>$accountName,
        "accountNumber"=>$accountNumber,
        "bank"=>$bank);$userId);

    if ($validateUser === "User Not Found") {
        $result['message'] = $validateUser;
     
        http_response_code(400);
    } else if($validateUser==="Account Successfully added") {

        $result['message'] = $validateUser;
        http_response_code(200);

    }else{
        $result['message'] = $validateUser;
        http_response_code(403); 
    }
}


header("Content-Type: application/json");
echo json_encode($result);