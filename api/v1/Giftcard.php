<?php

require_once("../../config/Config.php");
include "../../utils/Repositories.php";
include "../../utils/Giftcard.php";
include "../../utils/headers.php";

$result = array();
$headers = new Headers($_SERVER['REQUEST_URI']);
$userId = $headers->getHeaders();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($userId)) {
        // Your existing code...
   try {
        $category = $_POST['category'];
        $rate = $_POST['rate'];
        $sub_category = $_POST['sub_category'];
        $price = $_POST['price'];
        $comment = $_POST['comment'];
        $type = $_POST['type'];
        $cardid = $_POST['cardid'];
        $giftcard = new Giftcard($conn);
        $values = array(
            'category' => $category,
            'rate' => $rate,
            'cardid' => $cardid,
            'sub_category' => $sub_category,
            'price' => $price,
            'comment' => $comment,
            'type' => $type
        );
         
        foreach ($values as $key => $value) {
            if (empty($values)) {
         
                throw new Error("Field should not be null");
             }
       }
         $result['message'] =$values;
         $file=$_FILES["files"];
  
     
          $buyGiftcard = $giftcard->buyGiftcard($values, $userId,$file);

            $result['message'] = $buyGiftcard;

            http_response_code(200);
      
    
    } catch (Exception $e) {
        
            $result['message'] = "Error: ";
            http_response_code(500);
        
         
    }
    }
    else {
        $result['message'] = "User needs to log in";
        http_response_code(400);
    }
   
}

header("Content-Type: application/json");
echo json_encode($result);
?>
