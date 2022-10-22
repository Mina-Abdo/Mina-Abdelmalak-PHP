<?php

use App\Database\Models\User;
use App\Http\Requests\Validation;

$title = "Login";
include "layouts/header.php";
include "App/Http/middlewares/guest.php";
include "layouts/navbar.php";
include "layouts/breadcrumb.php";
$validation = new Validation;

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $validation->setInput($_POST['email'] ?? "")->setInputName('email')->required()
    ->regex('/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/','Wrong email or password')->exists('users','email');
    $validation->setInput($_POST['password'] ?? "")->setInputName('password')->required()->regex('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,32}$/','Wrong email or password');
    if(empty($validation->getErrors())){
        $user = new User;
        $user->setEmail($_POST['email'])->setPassword($_POST['password']);
        $res = $user->getUserByEmail(); 
        if($res !== false){
            if($res->num_rows == 1){
                $user = $res->fetch_object();
                if(password_verify($_POST['password'],$user->password)){
                    if(is_null($user->email_verified_at)){
                        $_SESSION['verification-email'] = $_POST['email'];
                        $_SESSION['page'] = "login";
                        header('location:verification-code.php');die;
                    }else{
                        if(isset($_POST['remember_me'])){
                            setcookie('remember_me',$_POST['email'],  time() + 86400 * 365 , '/');
                        }
                        $_SESSION['user'] = $user;
                        header('location:index.php');die;
                    }
                }else{
                    $loginError = "<p class='text-danger font-weight-bold'> Wrong email or password </p>";
                }
            }else{
                $loginError = "<p class='text-danger font-weight-bold'> Wrong email or password </p>";
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
                            <h4> login </h4>
                        </a>
                    </div>
                    <div class="tab-content">
                        <div id="lg1" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <?= $error ?? "" ?>
                                    <form  method="post">
                                        <input type="email" name="email" placeholder="Email Address">
                                        <input type="password" name="password" placeholder="Password">
                                        <?= $validation->getErrorMessage('email') ?>
                                        <?= $validation->getErrorMessage('password') ?>
                                        <?= $loginError ?? "" ?>
                                        <div class="button-box">
                                            <div class="login-toggle-btn">
                                                <input type="checkbox" name="remember_me">
                                                <label>Remember me</label>
                                                <a href="forget-password.php">Forgot Password?</a>
                                            </div>
                                            <button type="submit"><span>Login</span></button>
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