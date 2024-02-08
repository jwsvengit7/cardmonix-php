<?php
require_once "Balance.php";
 class Withdraw implements WithdrawService {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        }
        public  function widthraw($type,$amount,$userId){
            $balance = new Balance($this->conn);
            $userAmount = $balance->getBalance($userId);
          
            if($userAmount< $amount){
                return "Insuffiecient Funds";
            }else{
            
                $minus = $this->conn->prepare("UPDATE balance SET balance_amount=balance_amount-?,$type=$type-?  WHERE userid= ?");
                $minus->bind_param("sss",$amount,type,$userId);
                $date=time();
                $transid=$date.time();
                if( $minus->execute()){
                $withdraw = $this->conn->prepare("INSERT INTO widthraw(userid,amount,date,transid,status,type)VALUES(?,?,'$date','$transid','PENDING',?)");
                $withdraw->bind_param("sss",$userId,$amount,$type);
                $withdraw->execute();
                }else{
                    return null;
                }
                
        return ($withdraw->affected_rows > 0) ? "Succesfull widthdraw" : [];
            }
       

        }

}

interface WithdrawService{
    function widthraw($userId,$amount);
}