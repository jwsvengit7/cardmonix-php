
<?php
session_start();
require_once("../../config/Config.php");
include "../../utils/Bank.php";
include "../../utils/headers.php";


$result=array();
$headers = new Headers($_SERVER['REQUEST_URI']);
$userId=$headers->getHeaders();
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  



if (!empty($userId)) {

    $validate = new Bank($conn);
   
    $validateUser = $validate->getBankById($userId);

 if($validateUser==null) {

        $result['message'] = [];
        http_response_code(200);

    }else{
        $result['message'] = $validateUser;
        http_response_code(200); 
    }
}
}


header("Content-Type: application/json");
echo json_encode($result);