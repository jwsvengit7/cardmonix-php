<?php

include "Notification.php";

class Giftcard implements Giftcards{
    private $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }
public function buyGiftcard($giftcard, $userId, $files)
{
    $category = $giftcard['category'];
    $rate = $giftcard['rate'];
    $sub_category = $giftcard['sub_category'];
    $price = $giftcard['price'];
    $id = $giftcard['cardid'];
    $comment = $giftcard['comment'];
    $type = $giftcard['type'];
    $transid = time() . time();
    $date = time();
    $status = "false";

    $uploadedFiles = $this->upload($files);
    return $uploadedFiles;

    // if (is_string($uploadedFiles) && strpos($uploadedFiles, "Sorry") !== false) {
    //     return $uploadedFiles;
    // } else {

    //     $store = $this->conn->prepare("INSERT INTO  sell_giftcard(giftcardId,giftcard_image,giftcard_userId,category,rate,sub_category,price,comment,type,status,date,transid)VALUES(?,?,?,?,?,?,?,?,?,?,'$date','$transid')");
    //     $store->bind_param("ssssssssss", $id, $uploadedFiles[0], $userId, $category, $rate, $sub_category, $price, $comment, $type, $status);

    //     $store->execute();
    //     $sellGiftcardId = $this->conn->insert_id;  

    //     $stmt = $this->conn->prepare("INSERT INTO file_paths (file_path, giftcard_id) VALUES (?, ?)");
    //     foreach ($uploadedFiles as $filePath) {
    //         $stmt->bind_param('si', $filePath, $sellGiftcardId);
    //         $stmt->execute();
    //     }

    //     $message = "Transaction";
    //     $Notification = new Notification($this->conn);
    //     $Notification->sendNotification($message, $status, $userId, $transid);

    //     return $store->affected_rows > 0 ? "Giftcard has been placed. ID: $sellGiftcardId".$files : "Error occurred";
    // }
}

private function upload($files)
{
    $uploadedFiles = 0;

    $target_dir = "images/";

    foreach ($files['name'] as $key => $name) {
        $time = time();
        $target_file = $target_dir . $time . basename($name);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if ($files['size'][$key] > 2000000) {
            return "Sorry, your file is too large. Maximum allowed size is 2MB.";
        } elseif (!move_uploaded_file($files['tmp_name'][$key], $target_file)) {
            return "Sorry, your file Failed";
        } else {
            $uploadedFiles= 111;
        }
    }

    return $uploadedFiles;
}



public function viewGiftcards() {
    $view = $this->conn->prepare("SELECT * FROM app_giftcard");
    $view->execute();
    $validate = $view->get_result();

    $result = array();
    while ($row = $validate->fetch_assoc()) {
        $result[] = $row;
    }

    return ($validate->num_rows > 0) ? $result : [];
}
public function viewGiftcardsByiD($id) {
    $view = $this->conn->prepare("SELECT * FROM app_giftcard WHERE id =?");
      $view->bind_param("s",$id);
    $view->execute();
    $validate = $view->get_result();

    $result = array();
    while ($row = $validate->fetch_assoc()) {
        $result[] = $row;
    }

    return ($validate->num_rows > 0) ? $result : [];
}
public function viewGiftcardsByCategory($category) {
    $view = $this->conn->prepare("SELECT * FROM card_category");  
    $view->execute();
    $validate = $view->get_result();

    $result = array();
    while ($row = $validate->fetch_assoc()) {
        $result[] = $row[$category];
    }

    return ($validate->num_rows > 0) ? $result : [];
}

 public   function viewGiftcardsHistory($userId){
      $view = $this->conn->prepare("SELECT * FROM sell_giftcard WHERE giftcard_userId=?");  
           $view->bind_param("s",$userId);
    $view->execute();
    $validate = $view->get_result();

    $result = array();
    while ($row = $validate->fetch_assoc()) {
        $result[] = $row;
    }

    return ($validate->num_rows > 0) ? $result : [];
        
    }

  public  function viewHistory($userId){
            $view = $this->conn->prepare("SELECT * FROM deposit WHERE userid=?");
            $view->bind_param("s",$userId);
            $view->execute();
            $validate=$view->get_result();
            return $validate->num_rows > 0 ?  $validate->fetch_assoc() : [];
    }

        }
interface Giftcards{
    function buyGiftcard($giftcard,$userId,$file);
    function viewGiftcards();
    function viewHistory($userId);
    function viewGiftcardsHistory($userId);
}
?>