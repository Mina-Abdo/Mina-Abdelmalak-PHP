<?php

use App\Database\Models\User;
use App\Mail\VerificationCode;
use App\Http\Requests\Validation;

$title = "Reset Password";
include "layouts/header.php";
$validation = new Validation;

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $validation->setInput($_POST['password'] ?? "")->setInputName('password')->required()->regex('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,32}$/',"Minimum eight and maximum 32 characters, at least one uppercase letter, one lowercase letter, one number and one special character")->confirmed($_POST['password_confirmation']);
    $validation->setInput($_POST['password_confirmation'] ?? "")->setInputName('password_confirmation')->required();
    if(empty($validation->getErrors())){
        $user = new User;
        $user->setPassword($_POST['password'])->setEmail($_SESSION['verification-email']);
        if($user->updatePassword()){
            unset($_SESSION['verification-email']);
            $success = "<div class='alert alert-success text-center'> Password Updated Succcessfully , you will be redirected to login page shortly ... </div>";
            header('refresh:3;url=login.php');
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
                                        <input type="password" name="password" placeholder="New Password">
                                        <?= $validation->getErrorMessage('password') ?>
                                        <input type="password" name="password_confirmation" placeholder="Password Confirmation">
                                        <?= $validation->getErrorMessage('password_confirmation') ?>
                                        <div class="button-box">  
                                            <button type="submit"><span>Change</span></button>
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