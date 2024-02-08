<?php
require_once("../../config/Config.php");
include "../../utils/Repositories.php";

$result = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
    $jsonContent = file_get_contents('php://input');
    $requestData = json_decode($jsonContent, true); 
$otp =  $requestData['otp'];
$email = $requestData['email'];
 $password =  password_hash($requestData['password'], PASSWORD_DEFAULT);

$validate = new Repositories($conn);
$verify = $validate->validatePasswordChange($email, $otp,$password);

if ($verify == "OTP Have Expired") {
    http_response_code(400); 
    $result["message"] = $verify;
} else if ($verify == "Password Change Successfully") {
    http_response_code(200); 
    $result["message"] = $verify;
} else {
    http_response_code(500);
    $result["message"] = $verify;
}
}else{
     http_response_code(500);
    $result["message"] = "Method Type is POST"; 
}

header("Content-Type: application/json");
echo json_encode($result);
?>
