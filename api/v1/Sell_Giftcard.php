<?php
session_start();
require_once("../../config/Config.php");
include "../../utils/Giftcard.php";
include "../../utils/Repositories.php";
include "../../utils/headers.php";


$result=array();
$headers = new Headers($_SERVER['REQUEST_URI']);
$userId=$headers->getHeaders();



if (isset($_SESSION['token']) && !empty($userId)) {
    $validate = new Repositories($conn);
   
    $validateUser = $validate->validateUserId($userId);

    if ($validateUser === "User Not Found") {
        $result['message'] = $validateUser;
        $result['status'] = "error";
        http_response_code(400);
    } else {
      
        $category = $_POST['category'] ?? null;
        $rate = $_POST['rate'] ?? null;
        $sub_category = $_POST['sub_category'] ?? null;
        $price = $_POST['price'] ?? null;
        $comment = $_POST['comment'] ?? null;
        $type = $_POST['type'] ?? null;
        $giftcard = new Giftcard($conn);
        $values=array(
            'category' => $category,
            'rate' => $rate,
            'sub_category' => $sub_category,
            'price' => $price,
            'comment' => $comment,
            'type' => $type
        );
        foreach ($values as $key => $value) {
            if(empty($value)){
                throw new Error("Filed Should not be null");
            } 
        }

        try {
            $buyGiftcard = $giftcard->buyGiftcard($values,$userId);

             $result['message'] = "succesful place ypur card on order admin will approve when veriication is done";
            
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