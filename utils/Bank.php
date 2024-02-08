<?php

class Bank {
    private $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    public function addBankAccount($account, $userid){
        $findAccount = $this->conn->prepare("SELECT * FROM BANK WHERE userid=?");
        $findAccount->bind_param("s", $userid);
        $findAccount->execute();
        $validate = $findAccount->get_result();

        if($validate->num_rows < 1){ 
            $saveAccount = $this->conn->prepare("INSERT INTO BANK(userid, accountName, accountNumber, bank) VALUES(?,?,?,?)");
            $saveAccount->bind_param("ssss", $userid, $account['accountName'], $account['accountNumber'], $account["bankName"]);
            $saveAccount->execute();
            $affectedRows = $saveAccount->affected_rows;
            
            return $affectedRows > 0 ? "Account Successfully added" : "Error adding account";
        } else {
            return "Account Already Exists";
        }
    }
    
     public function getBankById($userid){
    $findAccount = $this->conn->prepare("SELECT * FROM BANK WHERE userid=?");
    $findAccount->bind_param("s", $userid);
    $findAccount->execute();
    $result = $findAccount->get_result();

    if($result->num_rows > 0){ 
        $accountDetails = $result->fetch_assoc();
        return $accountDetails; 
    } else {
        return null; 
    }
}

}


?>