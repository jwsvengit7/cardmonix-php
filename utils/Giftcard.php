<?php
include "../../config/Mail/Mail.php";

class Giftcard implements Giftcards{
    private $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    public function buyGiftcard($giftcard){

        return $giftcard;
    }
    function viewGiftcardHistory($userId){
        return $this->conn;
    }


}

interface Giftcards{
    function buyGiftcard($giftcard);
    function viewGiftcardHistory($userId);
}