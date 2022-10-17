<?php
$title = "Register";
use App\Database\Models\User;
use App\Http\Requests\Validation;
use App\Mail\Contract\VerificationCode;

include "layouts/header.php";
include "layouts/navbar.php";
include "layouts/breadcrumb.php";


$validation = new Validation;
if($_SERVER['REQUEST_METHOD'] == "POST"){

    $validation->setInput($_POST['first_name'] ?? "")->setInputName('first_name')->required()->string()->between(2,32);
    $validation->setInput($_POST['last_name'] ?? "")->setInputName('last_name')->required()->string()->between(2,32);
    $validation->setInput($_POST['email'] ?? "")->setInputName('email')->required()->regex('/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/')->unique("users" , "email");
    $validation->setInput($_POST['phone'] ?? "")->setInputName('phone')->required()->regex("/01[0125][0-9]{8}$/")->unique("users" , "phone");
    $validation->setInput($_POST['password'] ?? "")->setInputName('password')->required()->regex('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,32}$/','Minimum eight and maximum 10 characters, at least one uppercase letter, one lowercase letter, one number and one special character');
    $validation->setInput($_POST['password_verification'] ?? "")->setInputName('password_verification')->required();
    $validation->setInput($_POST['gender'] ?? "")->setInputName('gender')->required()->in([0,1]);
    if(empty($validation->getErrors())){
        //no validations errors
        $verification_code = rand(10000 , 99999);
        $user = new User;
        $user->setFirst_name($_POST['first_name'])->setLast_name($_POST['last_name'])->setEmail($_POST['email'])->setPhone($_POST['phone'])->setPassword($_POST['password'])->setGender($_POST['gender'])->setVerification_code($verification_code);
        if($user->create())
        {
            // send email
            $mailBody = "<p>Hello {$_POST['first_name']}</p>
            <p> your email verification code is : <b>{$verification_code}</b></p>
            <p>Website team</p>";
            $verificationCodeMail = new VerificationCode($_POST['email'] , "verification code email" , $mailBody);
            if($verificationCodeMail ->send()){
                $_SESSION['email_verification'] = $_POST['email'];
                header('location:verification-code.php');die;
            }else{
                $error = "<p class='text-danger text-weight-bold'>please try again later</p>";
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
                            <a class="active" data-toggle="tab" href="#lg2">
                                <h4> register </h4>
                            </a>
                        </div>
                        <div class="tab-content">
                            <div id="lg2" class="tab-pane active">
                                <div class="login-form-container">
                                    <?= $error ?? "" ?>
                                    <div class="login-register-form">
                                        <form method="post">
                                            <input class="form-control" name="first_name" type="text"  placeholder="first name" value="<?= $_POST['first_name'] ?? "" ?>">
                                            <?= $validation->getErrorMessage('first_name') ?>
                                            <input class="form-control" name="last_name"  type="text"  placeholder="last name" value="<?= $_POST['last_name'] ?? "" ?>">
                                            <?= $validation->getErrorMessage('last_name') ?>
                                            <input class="form-control" name="email" placeholder="Email" type="email" value="<?= $_POST['email'] ?? "" ?>">
                                            <?= $validation->getErrorMessage('email') ?>
                                            <input class="form-control" name="phone" type="text"  placeholder="phone" value="<?= $_POST['phone'] ?? "" ?>">
                                            <?= $validation->getErrorMessage('phone') ?>
                                            <input class="form-control" name="password" type="password"  placeholder="Password" >
                                            <?= $validation->getErrorMessage('password') ?>
                                            <input class="form-control" name="password_verification" type="password"  placeholder="verify password">
                                            <?= $validation->getErrorMessage('password_verification') ?>
                                            <select class="form-control mb-4" name="gender" id="">
                                                <!-- <option value="" selected>Please select your gender</option> -->
                                                <option <?php (isset($_POST['gender']) && $_POST['gender'] == '1') ? 'selected' : '' ?> value="1" >Male</option>
                                                <option <?php (isset($_POST['gender']) && $_POST['gender'] == '0') ? 'selected' : '' ?> value="0">Female</option>
                                            </select>
                                            <?= $validation->getErrorMessage('gender') ?>
                                            <div class="button-box ">
                                                <button type="submit"><span>Register</span></button>
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

include "layouts/footer.php";
include "layouts/scripts.php";
?>



