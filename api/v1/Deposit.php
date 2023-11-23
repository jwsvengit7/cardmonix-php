<?php
session_start();
require_once("../../config/Config.php");
include "../../utils/Repositories.php";

if(isset($_GET['userid']) && isset($_SESSION['token']))
$coinType = $_POST['type'] ?? null;
$price = $_POST['price'] ?? null;
$rate = $_POST['rate'] ?? null;


$repo = new Repositories($conn);
$sell=$repo->sellCoin(array(
    "coinType"=>$coinType,
    "price"=>$price,
    "rate"=>$rate

));
#





?>