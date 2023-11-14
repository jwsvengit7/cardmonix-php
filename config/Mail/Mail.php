<?php
include "../../utils/Auth.php";
class Mail implements MailServer{
    private $email;
    private $result;
 

    public function __construct($email){
        $this->email=$email;
    }

    public function sendEmailOtp(){
        $auth = new Authenticate($this->email);
        $auth->generateOtp();
        $this->result=$auth->getOtp();
       
    }

    public function getContent(){
        return $this->result;
    }


}


interface MailServer{
    function sendEmailOtp();
    function getContent();

}


?>