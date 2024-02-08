<?php
session_start();
require_once("../../config/Config.php");
include "../../utils/Giftcard.php";



$result=array();


if ($_SERVER['REQUEST_METHOD'] === 'GET' ) {
  

        $giftcard = new Giftcard($conn);
      

        try {
            $buyGiftcard = $giftcard->viewGiftcards();

             $result['data'] = $buyGiftcard;
            
            http_response_code(200);
        } catch (Exception $e) {
            http_response_code(500);
            $result['data'] = "Error: " . $e->getMessage();
          
        
    }



}

header("Content-Type: application/json");
echo json_encode($result);