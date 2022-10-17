<?php
namespace App\Mail\Contract;

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;

abstract class Mail{
        //Server settings                                         
        private $Host       = 'smtp.mailtrap.io';                     //Set the SMTP server to send through
        private $Username   = 'da9458c8f181b2';                     //SMTP username
        private$Password   = 'b16bdad1a3fd8f';                               //SMTP password
        private $encryption = 'tls';            //Enable implicit TLS encryption
        private $Port       = 587; 
        protected PHPMailer $mail;
        private $mailTo , $subject , $body;

        public function __construct($mailTo , $subject , $body)
        {
            $this->mailTo = $mailTo;
            $this->subject = $subject;
            $this->body = $body;

            $this->mail = new PHPMailer(true);
            $this->mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
            $this->mail->isSMTP();                                            //Send using SMTP
            $this->mail->Host       = $this->Host;                     //Set the SMTP server to send through
            $this->mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $this->mail->Username   = $this->Username;                     //SMTP username
            $this->mail->Password   = $this->Password;                               //SMTP password
            $this->mail->SMTPSecure = $this->encryption;            //Enable implicit TLS encryption
            $this->mail->Port       = $this->Port;   
        }
        public abstract function send();
}