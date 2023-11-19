<?php
session_start();
require_once("../../config/Config.php");
include "../../utils/Repositories.php";
$result=array();

if(isset($_GET['email']) && isset($_SESSION['token'])){
    $email=$_GET['email'] ?? null;

    $repo = new Repositories($conn);
    $valid=$repo->validateLoginUser($email);
    !$valid ? http_response_code(403) : http_response_code(201);
    
    $result['status']=$valid;

}


header("Content-Type: application/json");
echo json_encode($result);

