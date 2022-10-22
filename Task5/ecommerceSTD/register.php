<?php

use App\Database\Models\User;
use App\Http\Requests\Validation;
use App\Mail\VerificationCode;

$title = "Register";
include "layouts/header.php";
include "App/Http/middlewares/guest.php";
include "layouts/navbar.php";
include "layouts/breadcrumb.php";

$validation = new Validation;
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $validation->setInput($_POST['first_name'] ?? "")->setInputName('first_name')->required()->string()->between(2,32);
    $validation->setInput($_POST['last_name'] ?? "")->setInputName('last_name')->required()->string()->between(2,32);
    $validation->setInput($_POST['email'] ?? "")->setInputName('email')->required()->regex('/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/')->unique('users','email');
    $validation->setInput($_POST['phone'] ?? "")->setInputName('phone')->required()->regex('/01[0125][0-9]{8}$/')->unique('users','phone');
    $validation->setInput($_POST['password'] ?? "")->setInputName('password')->required()->regex('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,32}$/',"Minimum eight and maximum 32 characters, at least one uppercase letter, one lowercase letter, one number and one special character")->confirmed($_POST['password_confirmation']);
    $validation->setInput($_POST['password_confirmation'] ?? "")->setInputName('password_confirmation')->required();
    $validation->setInput($_POST['gender'] ?? "")->setInputName('gender')->required()->in([0,1]);
    if(empty($validation->getErrors())){
        $verificationCode = rand(10000,99999);
       $user = new User;
       $user->setFirst_name($_POST['first_name'])
       ->setLast_name($_POST['last_name'])->setEmail($_POST['email'])
       ->setPhone($_POST['phone'])->setPassword($_POST['password'])
       ->setGender($_POST['gender'])
       ->setVerification_code($verificationCode);
       if($user->create()){
            // send mail
            $body = "<p> Hello {$_POST['first_name']} </p> 
            <p> Your Verification Code :<b style='color:blue;'> {$verificationCode} </b> </p>
            <p> Ecommerce Team.</p>";
            $verificationCodeMail = new VerificationCode($_POST['email'],"Verification Code Mail",$body);
            if($verificationCodeMail->send())
            {
                $_SESSION['verification-email'] = $_POST['email'];
                $_SESSION['page'] = "register";
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
                        <a  class="active"  data-toggle="tab" href="#lg2">
                            <h4> Register </h4>
                        </a>
                    </div>
                    <div class="tab-content">
                        <div id="lg2" class="tab-pane  active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <?= $error ?? "" ?>
                                    <form  method="post">
                                        <input type="text" name="first_name" placeholder="First name" value="<?= $_POST['first_name'] ?? "" ?>">
                                        <?= $validation->getErrorMessage('first_name') ?>
                                        <input type="text" name="last_name" placeholder="Last name" value="<?= $_POST['last_name'] ?? "" ?>">
                                        <?= $validation->getErrorMessage('last_name') ?>
                                        <input type="email" name="email" placeholder="Email" value="<?= $_POST['email'] ?? "" ?>">
                                        <?= $validation->getErrorMessage('email') ?>
                                        <input type="number" name="phone" placeholder="Phone number" value="<?= $_POST['phone'] ?? "" ?>">
                                        <?= $validation->getErrorMessage('phone') ?>
                                        <input type="password" name="password" placeholder="Password" >
                                        <?= $validation->getErrorMessage('password') ?>
                                        <input type="password" name="password_confirmation" placeholder="Password Confirmation" >
                                        <?= $validation->getErrorMessage('password_confirmation') ?>
                                        <select name="gender" class="form-control" id="">
                                            <option <?= (isset($_POST['gender']) && $_POST['gender'] == '1') ? 'selected' : '' ?> value="1">Male</option>
                                            <option <?= (isset($_POST['gender']) && $_POST['gender'] == '0') ? 'selected' : '' ?> value="0">Female</option>
                                        </select>
                                        <?= $validation->getErrorMessage('gender') ?>
                                        <div class="button-box mt-5">
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