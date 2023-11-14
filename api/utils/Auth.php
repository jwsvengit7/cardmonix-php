<?php

 class Authenticate {
    private $email;
    private $otpGenerator;

    public function __construct($email) {
        $this->email = $email;
    }

    public function generateOtp() {
        $this->otpGenerator = substr(md5(uniqid(true)),0,4);
      
    }
    public function getOtp(){
        return $this->otpGenerator;
    }

    
}



