<?php
class Coin {
    private $conn;
    private $userid;

    public function __construct($conn, $userid) {
        $this->conn = $conn;
        $this->userid = $userid;
    }

    public function sellCoin($coin,$price,$image) {
     
        $amountinusd = $price;
        $time = time();

        $deposit = $this->conn->prepare("INSERT INTO deposit(userId, image, date, amount, amountusd, status) VALUES (?, ?, ?, ?, ?, 'PENDING')");
        $deposit->bind_param("isdds", $this->userid, $image, $time, $price, $amountinusd);
        $deposit->execute();

        if ($deposit) {
            return "Successfully deposited Wait for the admnin to confirm";
        } else {
            return "Error in depositing";
        }
    }
}
?>