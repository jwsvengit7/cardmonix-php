<?php

require_once("../../config/Config.php");
include "../../utils/Repositories.php";
include "../../utils/Chat.php";
include "../../utils/headers.php";

$result = array();
$headers = new Headers($_SERVER['REQUEST_URI']);
$userId = $headers->getHeaders();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($userId)) {
        $jsonContent = file_get_contents('php://input');
    $requestData = json_decode($jsonContent, true); 
   try {
        $from = $requestData['from'];
        $to = $requestData['to'];
        $acceptKey = $from.$to;
        $message = $requestData['message'];
        
        $chat = new Chat($conn);
        
        $addChat = $chat->insert_chat($userId,$from,$acceptKey,$to,$message);
        
        $result['message'] = $addChat;
        
   }    catch (Exception $e) {
        
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
