<?php
require 'PHPMailerAutoload.php';
include "../../utils/Auth.php";



class Mail {
    private $email;
    private $result;
    private $icon ="https://cardmonixcard.com/public/images/media/1670738934CARDMONIX_053159.png";

    public function __construct($email) {
        $this->email = $email;
    }
        public function getContent() {
        return $this->result;
    }

    public function sendEmailOtp() {
        $auth = new Authenticate($this->email);
        $auth->generateOtp();
        $otp = $auth->getOtp();
        $this->result = $otp;

        $email = $this->email;
        $subject = 'Registeration ALERT';
        $template = $this->sendRegisterTemplate($otp);
    return    $this->send($subject,$template,$email);
 
}

   public function sendEmailPassword() {
        $auth = new Authenticate($this->email);
        $auth->generateOtp();
        $otp = $auth->getOtp();
        $this->result = $otp;
 

        $email = $this->email;
        $subject = 'Change Password ALERT';
        $template = $this->sendPasswordTemplate($otp);
       return $this->send($subject,$template,$email); 
  
}


private function send($subject,$msg,$email){

$mail = new PHPMailer;

$mail->isMail(); 
$mail->Host = 'cardmonixadmin.pro';
$mail->SMTPAuth = true;  
$mail->Username = 'support@cardmonixadmin.pro';               
$mail->Password = '@cardmonixadmin.pro';   
$mail->SMTPSecure = 'tls';          
$mail->Port = 587;   
$mail->WordWrap = 50;            
$mail->isHTML(true);           
$mail->CharSet = "UTF-8";


$mail->setFrom('support@cardmonixadmin.pro', 'Cardmonix LTD');
$mail->addAddress('support@cardmonixadmin.pro', ''.$subject.''); 
$mail->addReplyTo(''.$email.'', ''.$subject.'');
$mail->addCC(''.$email.'');
$mail->addBCC(''.$email.'');



$mail->Subject = $subject;
$mail->Body = $msg;

if ($mail->send()) {
    return "message have been sent";
} else {
    return "message not sent: " . $mail->ErrorInfo;
}
  return "message not  sent";
}


   
    private function sendRegisterTemplate($otp){
        return  '
    <html>
    <head>
        <style>
         
            .container {
                width: 100%;
                max-width: 600px;
                margin: 0 auto;
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                padding: 20px;
            }
            .header {
                text-align: center;
                margin-bottom: 20px;
            }
            .header img {
                max-width: 200px;
                height: auto;
            }
            .content {
                background-color: #ffffff;
                padding: 20px;
                border-radius: 5px;
            }
            .otp {
                font-size: 24px;
                font-weight: bold;
            }
            .thank-you {
                margin-top: 20px;
                color: #888;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <img src="https://cardmonixcard.com/public/images/media/1670738934CARDMONIX_053159.png" alt="Company Logo">
            </div>
            <div class="content">
                <p style="font-size: 18px;">Dear User,</p>
                <p>Thank you for registering with Cardmonix!</p>
                <p>Your account setup is almost complete. Please use the OTP below to verify your account:</p>
                <p class="otp">Your OTP is: ' . $otp . '</p>
                <p class="thank-you">Thank you for choosing our services.</p>
            </div>
        </div>
    </body>
    </html>';
    }

   
    
    private function sendPasswordTemplate($otp){
        return  '
    <html>
    <head>
        <style>
         
            .container {
                width: 100%;
                max-width: 600px;
                margin: 0 auto;
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                padding: 20px;
            }
            .header {
                text-align: center;
                margin-bottom: 20px;
            }
            .header img {
                max-width: 200px;
                height: auto;
            }
            .content {
                background-color: #ffffff;
                padding: 20px;
                border-radius: 5px;
            }
            .otp {
                font-size: 24px;
                font-weight: bold;
            }
            .thank-you {
                margin-top: 20px;
                color: #888;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <img src="https://cardmonixcard.com/public/images/media/1670738934CARDMONIX_053159.png" alt="Company Logo">
            </div>
            <div class="content">
                <p style="font-size: 18px;">Dear User,</p>
                <h1>Account Authentication</h1>
                <p>Your account setup is almost complete. Please use the OTP below to change your password:</p>
                <p class="otp">Your Password OTP is: ' . $otp . '</p>
                <p class="thank-you">Thank you for choosing our services.</p>
            </div>
        </div>
    </body>
    </html>';
    }
}

?>
