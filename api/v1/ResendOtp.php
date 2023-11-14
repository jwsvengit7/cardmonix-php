<?php
require_once("../../config/Config.php");
include "../../utils/Sql.php";
$array = array();

$email=isset($_GET['email']) ? $_GET['email'] : null;

$sql = new Query($conn);
$sendOtp=$sql->resendMail($email);
if($sendOtp=="User not found"){
    http_response_code(403); 
    $array["message"]="failed to send otp to your mail";

}else{
    $array["message"]="otp have been sent to your mail";

}

header("Content-Type: application/json");
echo json_encode($array);



