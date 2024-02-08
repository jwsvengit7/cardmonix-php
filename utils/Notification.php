<?php

class Notification {
    private $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }
    
    public function sendNotification($message, $status, $userid, $transid) {
        $date = time();
        $receiveDate = time();

        $notification = $this->conn->prepare("INSERT INTO notification(status, recievdate, date, message, userid, transid) VALUES ('false', '$receiveDate', '$date', '$message',?,?)");

        $notification->bind_param("ss", $userid, $transid);
        $notification->execute();
        
        return $notification->affected_rows > 0 ? true : false;
    }
}
?>
