<?php
session_start();
require_once("../../config/Config.php");
include "../../utils/Giftcard.php";
include "../../utils/headers.php";


$result=array();
$headers = new Headers($_SERVER['REQUEST_URI']);
$value=$headers->getHeadersInString();
$userid=$headers->getHeaders();

$gidtcard = new Giftcard($conn);

$result = $gidtcard->viewGiftcardsByCategory($value);


header("Content-Type: application/json");
echo json_encode($result);

