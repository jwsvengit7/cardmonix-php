<?php
session_start();
require_once("../../config/Config.php");
include "../../utils/Repositories.php";
include "../../utils/Coin.php";
include "../../utils/headers.php";
$result=array();
$headers = new Headers($_SERVER['REQUEST_URI']);
$userId=$headers->getHeaders();




if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['token'])) {
  

    $validate = new Repositories($conn);
   
    $validateUser = $validate->validateUserId($userId);
 if ($validateUser === "User Not Found") {
        $result['message'] = $validateUser;
        $result['status'] = "error";
        http_response_code(400);
    } else {

  
$jsonContent = file_get_contents('php://input');
$requestData = json_decode($jsonContent, true);
$coinType = $requestData['coin'] ?? null;
$price = $requestData['price'] ?? null;
$image = $requestData['image'] ?? null;
$repo = new Coin($conn,$userId);

 $resultd=$repo->sellCoin($coinType,$price,$image);


  $result['message'] =$resultd;
 http_response_code(200);

 }

}else{
    $result['message'] = $_SESSION['token'];
}

header("Content-Type: application/json");
echo json_encode($result);

?>