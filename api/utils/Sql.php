<?php
class Query{
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
    private function generateToken($email){
        $token=md5(uniqid(true));
        $updateUser = $this->conn->query("UPDATE signup SET token='$token' WHERE email='$email'");
       return $updateUser;

    }
    public function validateUserEnable($email,$password){
        $result =array();
        $this->generateToken($email);
        $validate = $this->conn->query("SELECT * FROM signup WHERE email = '$email' and password = '$password'");
        if($validate->num_rows>0){
            $fetchUser = $validate->fetch_assoc();
            $result['status']=$fetchUser['status'];
            $status=$fetchUser['status'];
            if($status==false){
                return "User Need to activate his account";
            }
            $result['username']=$fetchUser['username'];
            $result['email']=$fetchUser['email'];
            $result['role']=$fetchUser['role'];
            $result['token']=$fetchUser['token'];
            return $result;

        }else{
            return "Incorrect Details";
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



?>