<?php
include "../../config/Mail/Mail.php";

class Giftcard {
    private $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    public function buyGiftcard($giftcard){
        return $giftcard;
    }


}