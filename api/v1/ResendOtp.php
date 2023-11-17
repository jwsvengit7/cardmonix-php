<?php
require_once("../../config/Config.php");
include "../../utils/Repositories.php";
$array = array();

$email= $_GET['email'] ?? null;

$sql = new Repositories($conn);
$sendOtp=$sql->resendMail($email);
if($sendOtp=="User not found"){
    http_response_code(403); 
    $array["message"]="failed to send otp to your mail";

}else{
    $array["message"]="otp have been sent to your mail";

}

header("Content-Type: application/json");
echo json_encode($array);



