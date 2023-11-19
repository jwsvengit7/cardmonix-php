<?php
require_once "Balance.php";
 class Withdraw implements WithdrawService {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        }
        public  function widthraw($userId,$amount){
            $balance = new Balance($this->conn);
            $userAmount = $balance->getBalance($userId);
            try{
            if($userAmount< $amount){
                return "Insuffiecient Funds";
            }else{
                $minus = $this->conn->prepare("UPDATE balance SET amount=amount-? WHERE userid= ?");
                $minus->bind_param("ss",$amount,$userId);
                $minus->execute();
                $date=time();
                $transid=$date.time();
                $withdraw = $this->conn->prepare("INSERT INTO widthraw(userid,amount,date,transid,status)VALUES(?,?,'$date','$transid','PENDING')");
                $withdraw->bind_param("ss",$userId,$amount);
                $withdraw->execute();
                
        return ($withdraw->affected_rows > 0) ? "Succesfull widthdraw" : [];
            }
        }catch($e){
            return $e.getMessage();
        }

        }

}

interface WithdrawService{
    function widthraw($userId,$amount);
}