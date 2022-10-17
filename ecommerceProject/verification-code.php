<?php

use App\Database\Models\User;
use App\Http\Requests\Validation;

$title = "Verification code";
include "layouts/header.php";
include "layouts/navbar.php";
include "layouts/breadcrumb.php";

$validation = new Validation;
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $validation->setInput($_POST['verification_code'])->setInputName('verification_code')->required()->numeric()->digits(5);
    if($validation->getErrors()){
        $user = new User;
        $user->setEmail($_SESSION['email_verification'])->setVerification_code($_POST['verification_code']);
        $result = $user->verifyCode();
        if(! $result){
            if($result->num_rows == 1){
                $user->setEmail_verified_at(date("Y-m-d H:m:s"));
                if($user->verified()){
                    $success = "<p class='text-success text-weight-bold'>email verified</p>";
                    header('location:login.php');die;
                }else{
                    $error = "<p class='text-danger text-weight-bold'>Something went wrong</p>";
                }
            }else{
                $wrongCode = "<p class='text-danger text-weight-bold'>wrong code</p>";
            }
        }else{
            $error = "<p class='text-danger text-weight-bold'>Something went wrong</p>";
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
                                    <?= $error ?? " " ?>
                                    <?= $success ?? "" ?>
                                    <div class="login-register-form">
                                        <form action="#" method="post">
                                            <input type="number" name="verification_code" placeholder="verification code">
                                            <div class="button-box">
                                                <button type="submit"><span>Verify</span></button>
                                            </div>
                                            <?= $wrongCode ?? "" ?>
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
include "layouts/footer.php";
include "layouts/scripts.php";
?>



