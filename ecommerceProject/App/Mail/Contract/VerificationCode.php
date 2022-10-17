<?php
namespace App\Mail\Contract;

use Exception;
use App\Mail\Contract\Mail;

class VerificationCode extends Mail{
    public function send(){
        try{
            //Recipients
            $this->mail->setFrom('ecommerce@website.com', 'Ecommerce');
            $this->mail->addAddress($this->mailTo);               //Name is optional



            //Content
            $this->mail->isHTML(true);                                  //Set email format to HTML
            $this->mail->Subject = $this->subject;
            $this->mail->Body    = $this->body;
            $this->mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}