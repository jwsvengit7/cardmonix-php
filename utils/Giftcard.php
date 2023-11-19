<?php
include "../../config/Mail/Mail.php";

class Giftcard implements Giftcards{
    private $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    public function buyGiftcard($giftcard,$userId){
        $category = $giftcard['category'];
        $rate = $giftcard['rate'];
        $sub_category = $giftcard['sub_category'];
        $price = $giftcard['price'];
        $comment = $giftcard['comment'];
        $type = $giftcard['type'];
        $date=time();

        $store = $this->conn->prepare("INSERT INTO  sell_giftcard(giftcard_userId,category,rate,sub_category,price,comment,type,date)VALUES(?,?,?,?,?,?,?,'$date')");
        $store->bind_param("sssssss",$userId,$category,$rate,$sub_category,$price,$comment,$type);
        $store->execute();
        
        return $store->affected_rows>0 ? "Giftcard have been placed" : "Error occured";
    }
    function viewGiftcards(){
        $view = $this->conn->prepare("SELECT * FROM giftcard");
        $view->execute();
        $validate=$view->get_result();
        return $validate->num_rows > 0 ?  $validate->fetch_assoc() : [];
        }
    function viewHistory($userId){
            $view = $this->conn->prepare("SELECT * FROM deposit WHERE userid=?");
            $view->bind_param("s",$userId);
            $view->execute();
            $validate=$view->get_result();
            return $validate->num_rows > 0 ?  $validate->fetch_assoc() : [];
    }

        }
interface Giftcards{
    function buyGiftcard($giftcard,$userId);
    function viewGiftcards();
    function viewHistory($userId);
}