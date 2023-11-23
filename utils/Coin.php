<?php
include "../../config/Mail/Mail.php";


class Coin {
    private $conn;
    private $userid;

    public function __construct($conn,$userid){
        $this->conn=$conn;
        $this->userid=$userid;
    }

    public function sellCoin($coin){
      $rate=$coin=['rate'];
      $coin=$coin['coin'];
      $price =$coin['price'];
      $time=time();

      $deposit = $this->conn->prepare("INSERT INTO deposit(userid,time,rate,amount,price)VALUES(?,?,?,?,?)");
      $deposit->bind_param("sssss",$this->userid,$time,$rate,$amount,$price);
      $deposit->execute();
      $validate=$execute->get_result();
      return $validate->affected_rows> 0 ? "Successfully Deposit" : "Error";

    }

}
