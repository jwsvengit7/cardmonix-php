<?php
include "../config/Mail/Mail.php";
class Query implements Queries {
    private $conn;

    public function __construct($conn){
        $this->conn=$conn;
    
    }
    public function validateUser($email){
        $validate = $this->conn->query("SELECT * FROM signup WHERE email = '$email'");
        if($validate->num_rows>0){
            $fetchUser = $validate->fetch_assoc();
            $status=$fetchUser['status'];
            if($status==true){
                return "User Already Exist";
            }else{
                return "User Need to activate his account";
            }
        }
    }
    public function resendMail($email){
        $validate = $this->conn->query("SELECT * FROM signup WHERE email = '$email'");
        if($validate->num_rows>0){
            $auth = new Mail($email);
            $auth->sendEmailOtp(); 
            $otp = $auth->getContent(); 
            $time=time();
            $updateUser = $this->conn->query("UPDATE signup SET otp='$otp',date='$time' WHERE email='$email'");
    
                return $otp;
          
        }else{
            return "User not found";
        }
    }

    public function validateOtp($email,$otp){
        $validate = $this->conn->query("SELECT * FROM signup WHERE email = '$email' and otp = '$otp' and status='false'");
        if($validate->num_rows>0){
            $fetchUser = $validate->fetch_assoc();
            $timestamp=$fetchUser['date'];
            $currentTimestamp = time();

            $timeDifference = $currentTimestamp - $timestamp;
                if($timeDifference>240 ){  
                    return "OTP EXPIRED";
            }else{

            $update=$this->conn->query("UPDATE signup SET status='true' WHERE email='$email'");
            if($update){
                return "User Verify Succesfully";
            }else{
                return "User Updated Failed".$this->conn->connect_error;
            }
        }
    }else{
        return "OTP Or User Not found".$this->conn->connect_error;
    }
    }

    private function generateToken($email){
        $token=md5(uniqid(true));
        $updateUser = $this->conn->query("UPDATE signup SET token='$token' WHERE email='$email'");
        return $updateUser;

    }
    public function validateUserEnable($email, $password){
        $result = array();
        $this->generateToken($email);
    
   
        $stmt = $this->conn->prepare("SELECT * FROM signup WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email); 
        $stmt->execute();
        $validate = $stmt->get_result();
    
        if($validate->num_rows > 0){
            $fetchUser = $validate->fetch_assoc();
            $hashed_password = $fetchUser['password']; 
            if(password_verify($password, $hashed_password)){
                $result['status'] = $fetchUser['status'];
                $status = $fetchUser['status'];
    
                if($status == "false"){
                    return "User needs to activate their account";
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
            return "User not found";
        }
    }
    

    public function insertUser($user){
        $time = time();
        $userdetails = $user;
        $email = $userdetails['email'];
        $otp = $userdetails['otp'];
        $username = $userdetails['username'];
        $password = $userdetails['password'];
        
        $insert = $this->conn->query("INSERT INTO signup(email,username,password,otp,date,status,role)VALUES('$email','$username','$password','$otp','$time','false','USER')");
       return $insert ? $userdetails : [];

    }

}

interface Queries {
    function insertUser($user);
    function validateUserEnable($email,$password);
    function validateUser($email);
    function validateOtp($email,$otp);
}



?>