<?php
require_once "../../config/Mail/Mail.php";

class Repositories implements Queries {
    private $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    public function validateUser($email){
        $stmt = $this->conn->prepare("SELECT * FROM signup WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $validate = $stmt->get_result();

        if($validate->num_rows > 0){
            $fetchUser = $validate->fetch_assoc();
            $status = $fetchUser['status'];

            return $status=="false" ? "User Already Exists" : "User Needs to Activate Account";
        }
    }
    public function validateUserId($userId){
        $stmt = $this->conn->prepare("SELECT * FROM signup WHERE id = ?");
        $stmt->bind_param("s", $userId);
        $stmt->execute();
        $validate = $stmt->get_result();

            return $validate->num_rows > 0 ? "Enabled" : "User Not Found";
        
    }

    public function resendMail($email){
        $stmt = $this->conn->prepare("SELECT * FROM signup WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $validate = $stmt->get_result();

        if($validate->num_rows > 0){
            $otp = $this->sendMail($email);
            $time = time();

            $updateUser = $this->conn->prepare("UPDATE signup SET otp=?, date=? WHERE email=?");
            $updateUser->bind_param("sss", $otp, $time, $email);
            $updateUser->execute();

            return $otp;
        } else {
            return "User Not Found";
        }
    }
private function sendMail($email){
    $auth = new Mail($email);
    $auth->sendEmailOtp(); 
    return $auth->getContent(); 
}
    public function validateOtp($email, $otp){
        $stmt = $this->conn->prepare("SELECT * FROM signup WHERE email = ? and otp = ? and status='false'");
        $stmt->bind_param("ss", $email, $otp);
        $stmt->execute();
        $validate = $stmt->get_result();

        if($validate->num_rows > 0){
            $fetchUser = $validate->fetch_assoc();
            $timestamp = $fetchUser['date'];
            $currentTimestamp = time();

            $timeDifference = $currentTimestamp - $timestamp;

            if($timeDifference > 240){  
                return "OTP EXPIRED";
            } else {
                $update = $this->conn->prepare("UPDATE signup SET status='true' WHERE email=?");
                $update->bind_param("s", $email);
                $update->execute();

                return ($update->affected_rows > 0) ? "User Verify Successfully" : "User Update Failed: " . $this->conn->error;
            }
        } else {
            return "OTP Or User Not Found";
        }
    }

    private function generateToken($email){
        $token = md5(uniqid(true));
        $updateUser = $this->conn->prepare("UPDATE signup SET token=? WHERE email=?");
        $updateUser->bind_param("ss", $token, $email);
        $updateUser->execute();

        return ($updateUser->affected_rows > 0);
    }

    public function validateUserEnable($email, $password){
        $result = array();
        $this->generateToken($email);
    
        $stmt = $this->conn->prepare("SELECT * FROM signup WHERE email = ?  LIMIT 1");
        $stmt->bind_param("s", $email); 
        $stmt->execute();
        $validate = $stmt->get_result();
    
        if($validate->num_rows > 0){
            $fetchUser = $validate->fetch_assoc();
            $hashed_password = $fetchUser['password']; 
    
            if(password_verify($password, $hashed_password)){
                $status = $fetchUser['status'];
    
                if($status == "false"){
                    return "User Needs to Activate Their Account";
                }
              
            
                $result['username'] = $fetchUser['username'];
                $result['email'] = $fetchUser['email'];
                $result['role'] = $fetchUser['role'];
                $result['token'] = $fetchUser['token'];
    
                return $result;
            } else {
                return "Incorrect Password";
            }
        } else {
            return "User Not Found";
        }
    }
    
    
    public function insertUser($user){
        $time = time();
        $email = $user['email'];
        $otp = $this->sendMail($email);
        $username = $user['username'];
        $password = $user['password'];

        $insert = $this->conn->prepare("INSERT INTO signup(email, username, password, otp, date, status, role) VALUES (?, ?, ?, ?, ?, 'false', 'USER')");
        $insert->bind_param("sssss", $email, $username, $password, $otp, $time);
        $insert->execute();

        return ($insert->affected_rows > 0) ? $user : [];
    }
}

interface Queries {
    function insertUser($user);
    function validateUserEnable($email,$password);
    function validateUser($email);
    function validateOtp($email, $otp);
}
?>
