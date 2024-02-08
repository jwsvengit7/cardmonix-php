<?php
session_start();
require_once("../../config/Config.php");
include "../../utils/Repositories.php";
include "../../utils/Giftcard.php";
include "../../utils/headers.php";


$result=array();
$headers = new Headers($_SERVER['REQUEST_URI']);
$userId=$headers->getHeaders();


if (!empty($userId)) {
    $validate = new Repositories($conn);
   
    $validateUser = $validate->validateUserId($userId);

    if ($validateUser === "User Not Found") {
        $result['message'] = $validateUser;
        $result['status'] = "error";
        http_response_code(400);
    } else {
     
        $giftcard = new Giftcard($conn);
      
        try {
            $buyGiftcard = $giftcard->viewGiftcardsHistory($userId);
             $result['message'] = $buyGiftcard;
            
            http_response_code(200);
        } catch (Exception $e) {
            http_response_code(500);
            $result['message'] = "Error: " . $e->getMessage();
          
        }
    }
} else {
    $result['message'] = "User needs to log in";

    http_response_code(400);
}


header("Content-Type: application/json");
echo json_encode($result);