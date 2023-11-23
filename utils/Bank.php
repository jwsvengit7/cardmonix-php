<?php
include "../../config/Mail/Mail.php";


class Bank {
    private $conn;

    public function __construct($conn){
        $this->conn=$conn;
    }
    public function addbankAccount($account,$userid){
        $findAccount  = $this->conn->prepare("SELECT * FROM bank WHERE userid=?");
        $findAccount->bind_param("s",$userid);
        $findAccount->execute();
        $validate=$findAccount->get_result();
        if($validate<1){
            $saveAccount = $this->conn->prepare("INSERT INTO bank(userid,accountName,accountNumber,bank)VALUES(?,?,?,?)");
            $findAccount->bind_param("ssss",$userid,$account['accountName'],$account['accountNumber'],$account["bank"]);
            $findAccount->execute();
            $validate=$findAccount->get_result();
            return $validate->affected_rows>0 ? "Account Successfully added" : "Error adding account";

        }else{
            return "Account Already Exist";
        }
    }
}