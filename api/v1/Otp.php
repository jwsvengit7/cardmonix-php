<?php
require_once("../config/Config.php");
include "../config/Mail/Mail.php";
include "../utils/Sql.php";

$result = array();
$otp = isset($_POST['otp']) ? $_POST['otp'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;

$validate = new Query($conn);
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
