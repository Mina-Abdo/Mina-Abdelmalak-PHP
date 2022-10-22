<?php

use App\Database\Models\User;
use App\Mail\VerificationCode;
use App\Http\Requests\Validation;

$title = "Forget Password";
include "layouts/header.php";
$validation = new Validation;

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $validation->setInput($_POST['email'] ?? "")->setInputName('email')->required()->regex('/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/')->exists('users','email');
    if(empty($validation->getErrors())){
        $forgetPasswordCode = rand(10000,99999);
        $user = new User;
        $user->setVerification_code($forgetPasswordCode)->setEmail($_POST['email']);
        if($user->updateCode()){
            // send mail
            $body = "<p> Hello {$_POST['email']} </p> 
            <p> Your Forget Password Code :<b style='color:blue;'> {$forgetPasswordCode} </b> </p>
            <p> Ecommerce Team.</p>";
            $verificationCodeMail = new VerificationCode($_POST['email'],"Verification Code Mail",$body);
            if($verificationCodeMail->send()){
                $_SESSION['verification-email'] = $_POST['email'];
                $_SESSION['page'] = "forget";
                header('location:verification-code.php');die;
            }else{
                $error = "<div class='alert alert-danger text-center'> Please Try Again Later </div>";
            }
        }else{
            $error = "<div class='alert alert-danger text-center'> Something went wrong </div>";
        }
    }
}
?>
<div class="login-register-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                <div class="login-register-wrapper">
                    <div class="login-register-tab-list nav">
                        <a class="active" data-toggle="tab" href="#lg1">
                            <h4> <?= $title ?> </h4>
                        </a>
                    </div>
                    <div class="tab-content">
                        <div id="lg1" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <?= $error ?? "" ?>
                                    <?= $success ?? "" ?>
                                    <form method="post">
                                        <input type="email" name="email" placeholder="Email Address">
                                        <?= $validation->getErrorMessage('email') ?>
                                        <?= $wrongCode ?? "" ?>
                                        <div class="button-box">
                                           
                                            <button type="submit"><span>Verify</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
include "layouts/scripts.php";
?>