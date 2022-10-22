<?php

use App\Database\Models\User;
use App\Http\Requests\Validation;

$title = "Verification Code";
include "layouts/header.php";
$validation = new Validation;

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $validation->setInput($_POST['verification_code'] ?? "")->setInputName('verification_code')->required()->numeric()->digits(5);
    if(empty($validation->getErrors())){
        $user = new User;
        $user->setEmail($_SESSION['verification-email'])->setVerification_code($_POST['verification_code']);
        $result = $user->checkCode();
        if($result !== false){
            if($result->num_rows == 1){
                $user->setEmail_verified_at(date('Y-m-d H:i:s'));
                if($user->verified()){
                    if($_SESSION['page'] == 'register'){
                        unset($_SESSION['verification-email']);
                        unset($_SESSION['page']);
                        $success = "<div class='alert alert-success text-center'> Correct Verification Code , You will be redirected to login page shortly ... </div>";
                        header('refresh:3;url=login.php');
                    }elseif($_SESSION['page'] == 'forget'){
                        $success = "<div class='alert alert-success text-center'> Correct Verification Code , You will be redirected to reset your password shortly ... </div>";
                        unset($_SESSION['page']);
                        header('refresh:3;url=reset-password.php');
                    }elseif($_SESSION['page'] == 'login'){
                        unset($_SESSION['verification-email']);
                        unset($_SESSION['page']);
                        $success = "<div class='alert alert-success text-center'> Correct Verification Code , You will be redirected to Your Account shortly ... </div>";
                        $_SESSION['user'] = $result->fetch_object();
                        header('refresh:3;url=my-account.php');
                    }
                    
                }else{
                    $error = "<div class='alert alert-danger text-center'> Something went wrong </div>";
                }
            }else{
                $wrongCode = "<p class='font-weight-bold text-danger'> Wrong Code </p>";
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
                                        <input type="number" name="verification_code" placeholder="Verification Code">
                                        <?= $validation->getErrorMessage('verification_code') ?>
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