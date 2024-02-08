<?php
require_once("../../config/Config.php");
include "../../utils/Repositories.php";
$array = array();
if(isset($_GET['email']) && !empty($_GET['email'])){
$email= $_GET['email'] ?? null;

$sql = new Repositories($conn);
$sendOtp=$sql->resendMail($email);
if($sendOtp=="User Not Found"){
    http_response_code(403); 
      $array["message"]=$sendOtp;

}else{
    $array["message"]="otp have been sent to your mail";

}
}
header("Content-Type: application/json");
echo json_encode($array);



