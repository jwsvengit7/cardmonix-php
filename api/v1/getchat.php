<?php
session_start();
require_once("../../config/Config.php");
include "../../utils/Repositories.php";
include "../../utils/Chat.php";
include "../../utils/headers.php";

$result = array();
$headers = new Headers($_SERVER['REQUEST_URI']);
$userId = $headers->getHeaders();

if (!empty($userId)) {
    $validate = new Repositories($conn);
    $validateUser = $validate->validateUserId($userId);

    if ($validateUser === "User Not Found") {
        $result['message'] = $validateUser;
      
        http_response_code(400);
    } else {
        $chat = new Chat($conn);
        $result["chats"] = $chat->getChatByUser($userId);
       
    }
}

// Add the Access-Control-Allow-Origin header to allow requests from all domains
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
echo json_encode($result);
?>
