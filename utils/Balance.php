<?php
 class Balance implements BalanceService {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getBalance($userId) {
      $stmt = $this->conn->prepare("SELECT * FROM balance WHERE userid=?");
      $stmt->bind_param("s",$userId);
      $stmt->execute();
      $validate = $stmt->get_result();
      if($validate->num_rows > 0){
        $fetchUserBalance = $validate->fetch_assoc();
        $amount = $fetchUserBalance['amount'];
        return $amount;
      }else{
        return 0;
      }
      
    }

}

interface BalanceService{
    function getBalance($userId);

}