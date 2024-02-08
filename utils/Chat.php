<?php
class Chat {
    private $conn;
    
    public function __construct($conn){
        $this->conn=$conn;
    }
    
  public function getChatByUser($userid){
 $stmt = $this->conn->prepare("SELECT * FROM chat WHERE `from` = ? OR `to` = ? ORDER BY date DESC");

    $stmt->bind_param("ss", $userid, $userid);
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    $chats = array();
    while ($row = $result->fetch_assoc()) {
        $chats[] = $row;
    }
    
    return $chats;
}

public function insert_chat($userId, $from, $acceptKey,$to, $message) {
    $time=time();
   
    $stmt = $this->conn->prepare("INSERT INTO chat (`from`, `to`, `message`, `acceptkey`,`date`) VALUES (?, ?, ?, ?,?)");
   
    $stmt->bind_param("sssss", $from, $to, $message, $acceptKey,$time);
    

    if ($stmt->execute()) {
      
        return true;
    } else {
     
        return false;
    }
}

public function saveMessageToDatabase($userId, $from, $acceptKey,$to, $message) {
    $time=time();
    $stmt = $this->conn->prepare("INSERT INTO chat (`from`, `to`, `message`, `acceptkey`,`date`) VALUES (?, ?, ?, ?,?)");
    $stmt->bind_param("sssss", $from, $to, $message, $acceptKey,$time);
    

    if ($stmt->execute()) {
      
        return true;
    } else {
     
        return false;
    }
}

public function fetchMessageHistory() {
    $stmt = $this->conn->query("SELECT * FROM chat ORDER BY id DESC ");
    $result = $stmt->get_result();
    
    $chats = array();
    while ($row = $result->fetch_assoc()) {
        $chats[] = $row;
    }
    
    return $chats;
}


}

