<?php
 class Balance implements BalanceService {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getBalance($userId) {
    $balance =array();
      $stmt = $this->conn->prepare("SELECT * FROM balance WHERE user_id=?");
      $stmt->bind_param("s",$userId);
      $stmt->execute();
      $validate = $stmt->get_result();
      if($validate->num_rows > 0){
        $fetchUserBalance = $validate->fetch_assoc();
       $balance['crypto_balance'] = $fetchUserBalance['crypto_balance'];
       $balance['card_balance'] = $fetchUserBalance['giftcard_balance'];
          $balance['balance_amount'] = $fetchUserBalance['balance_amount'];
   
      }else{
       $balance['crypto_balance'] =0.00;
       $balance["card_balance"] = 0.00;
          $balance['balance_amount'] = 0.00;
 
      }
        return $balance;
    }

}

interface BalanceService{
    function getBalance($userId);

}