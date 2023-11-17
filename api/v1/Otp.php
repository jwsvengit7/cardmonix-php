<?php
require_once("../../config/Config.php");
include "../../utils/Repositories.php";

$result = array();
$otp =  $_POST['otp'] ?? null;
$email = $_POST['email'] ?? null;

$validate = new Repositories($conn);
$verify = $validate->validateOtp($email, $otp);

if ($verify == "OTP EXPIRED") {
    http_response_code(400); 
    $result["message"] = $verify;
} else if ($verify == "User Verify Successfully") {
    http_response_code(200); 
    $result["message"] = $verify;
} else {
    http_response_code(500);
    $result["message"] = $verify;
}

header("Content-Type: application/json");
echo json_encode($result);
?>
