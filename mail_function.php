<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
    function sendOTP($email,$otp){

        

        // Mail/SMS agent
        $message_body= "One Time Password for login authentication:<br><br>".$otp;

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host='smtp.gmail.com';
        $mail->SMTPAuth= true;
        $mail->Username= 'username';
        $mail->Password='password';
        $mail->SMTPSecure='tls';
        $mail->Port = 587;
        $mail->isHTML(true);
        $mail->AddReplyTo('to@gmail.com','Splitster Inc.');
        $mail->SetFrom('from@gmail.com','Splister Inc.');
        $mail->AddAddress($email);
        $mail->Subject = "OTP to Login";
        $mail->MsgHTML($message_body);
        $result=$mail->Send();
        if(!$result){
            echo "Mailer Error: ". $mail->ErrorInfo;
        }
        else{
            return $result;
        }


    }
