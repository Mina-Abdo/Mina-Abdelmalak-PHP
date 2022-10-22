<?php

use App\Services\Media;
use App\Database\Models\User;
use App\Mail\VerificationCode;
use App\Http\Requests\Validation;

$title ="My Account";
include "layouts/header.php";
include "App/Http/middlewares/auth.php";

$validation = new Validation;
if($_SERVER['REQUEST_METHOD'] == "POST"){
    // profile info , photo update handling
    if(isset($_POST['update-profile'])){
        $validation->setInput($_POST['first_name'] ?? "")->setInputName('first_name')->required()->string()->between(2,32);
        $validation->setInput($_POST['last_name'] ?? "")->setInputName('last_name')->required()->string()->between(2,32);
        $validation->setInput($_POST['gender'] ?? "")->setInputName('gender')->required()->in([0,1]);
        if(empty($validation->getErrors())){
            $user = new User;
            $user->setFirst_name($_POST['first_name'])->setLast_name($_POST['last_name'])
            ->setGender($_POST['gender'])->setEmail($_SESSION['user']->email);
            if($user->update()){
                $_SESSION['user']->first_name = $_POST['first_name'];
                $_SESSION['user']->last_name = $_POST['last_name'];
                $_SESSION['user']->gender = $_POST['gender'];
                $success = "<div class='alert alert-success text-center'> Profile Updated Successfully </div>";
            }else{
                $error = "<div class='alert alert-danger text-center'> Something went wrong </div>";
            }
        }
    }
    // print_r(isset($_POST['change_password']));
    if((isset($_POST['uploadPhoto']))){
        if($_FILES['image']['error'] == 0){
            // validation
            $validation->setFile($_FILES['image'])->setInputName('image')->size(3*10**6)->extensions(['png','jpg','jpeg']);
            if(empty($validation->getErrors())){
                // upload image
                $media = new Media;
                if($media->setFile($_FILES['image'])->upload('assets/img/users/')){
                    // elmost5dm lw byrf3 sora msh l awl mara => ams7 eladema
                    if($_SESSION['user']->image != 'default.jpg'){
                        $media->delete('assets/img/users/'.$_SESSION['user']->image);
                    }
                    $user = New User;
                    $user->setImage($media->getNewMediaName())->setEmail($_SESSION['user']->email);
                    if($user->updateImage()){
                        $_SESSION['user']->image = $media->getNewMediaName();
                        $success = "<div class='alert alert-success text-center'> Profile Picture Uploaded Successfully </div>";
                    }else{
                        // error in updating
                        $error = "<div class='alert alert-danger text-center'> Something went wrong </div>";
    
                    }
                }else{
                    // upload error
                    $error = "<div class='alert alert-danger text-center'> Something went wrong </div>";
    
                }
            }
            
        }
    }

    if(isset($_POST['change_password'])){
        // change password handling
        $validation->setInput($_POST['old_password'] ?? "")
        ->setInputName('old_password')->required()
        ->regex('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,32}$/',"Minimum eight and maximum 32 characters, at least one uppercase letter, one lowercase letter, one number and one special character")
        ->matchOldPassword( $_SESSION['user']->password);
        $validation->setInput($_POST['new_password'] ?? "")->setInputName('new_password')->required()->regex('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,32}$/',"Minimum eight and maximum 32 characters, at least one uppercase letter, one lowercase letter, one number and one special character")->confirmed($_POST['password_confirmation']);
        $validation->setInput($_POST['password_confirmation'] ?? "")->setInputName('password_confirmation')->required();
        if(empty($validation->getErrors())){
            $user = new User;
            $user->setEmail($_SESSION['user']->email);
            $user->setPassword($_POST['new_password']);
            if($user->updatePassword()){
                $_SESSION['user']->password = $user->getPassword();
                // send email to confirm password update
                $body = "<p> Hello {$_SESSION['user']->first_name} </p> 
                <p> Your password has been changed succefully </b> </p>
                <p> Ecommerce Team.</p>";
                $verificationCodeMail = new VerificationCode($_SESSION['user']->email,"password update",$body);
                if($verificationCodeMail->send()){
                    unset($_SESSION['user']);
                    $success = "<p class='alert alert-success text-center'> password Updated Successfully </p>";
                    header('refresh:3;url=login.php');die;
                }else{
                    $error = "<div class='alert alert-danger text-center'> Something went wrong </div>";
                }
                
            }else{
                $error = "<div class='alert alert-danger text-center'> Something went wrong </div>";
            } 
        }
    }
    
// print_r($validation->matchOldPassword($_SESSION['user']->email));
// print_r($_SESSION['user']->email);
}
include "layouts/navbar.php";
include "layouts/breadcrumb.php";
?>
<!-- my account start -->
<div class="checkout-area pb-80 pt-100">
    <div class="container">
        <div class="row">
            <div class="ml-auto mr-auto col-lg-9">
                <div class="checkout-wrapper">
                    <div id="faq" class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>1</span> <a data-toggle="collapse" data-parent="#faq"
                                        href="#my-account-1">Edit your account information </a></h5>
                            </div>
                            <div id="my-account-1" class="panel-collapse collapse show">
                                <div class="panel-body">
                                    <form  method="post" enctype="multipart/form-data">
                                        <div class="billing-information-wrapper">
                                            <div class="account-info-wrapper">
                                                <h4>My Account Information</h4>
                                                <h5>Your Personal Details</h5>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 text-center">
                                                    <?= $error ?? "" ?>
                                                    <?= $success ?? "" ?>

                                                </div>
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-4 offset-4 text-center my-3">
                                                            <?php  
                                                                if($_SESSION['user']->image == 'default.jpg'){
                                                                    if($_SESSION['user']->gender == 1){
                                                                        $image = 'male.png';
                                                                    }else{
                                                                        $image = 'female.png';
                                                                    }
                                                                }else{
                                                                    $image = $_SESSION['user']->image;
                                                                }
                                                            ?>
                                                            <label for="file"><img src="assets/img/users/<?= $image ?>" id="image" class="w-100 rounded-circle" style="cursor: pointer;" alt=""></label>
                                                            <input type="file" name="image" id="file" class="d-none" onchange="loadFile(event)">
                                                            <?= $validation->getErrorMessage('image') ?>
                                                            <button class="btn btn-success rounded my-3" style="cursor: pointer" name="uploadPhoto" > <i class="fa fa-camera" aria-hidden="true"></i> Upload </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="billing-info">
                                                        <label>First Name</label>
                                                        <input type="text" name="first_name" value="<?= $_SESSION['user']->first_name ?>">
                                                        <?= $validation->getErrorMessage('first_name') ?>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="billing-info">
                                                        <label>Last Name</label>
                                                        <input type="text"  name="last_name" value="<?= $_SESSION['user']->last_name ?>">
                                                        <?= $validation->getErrorMessage('last_name') ?>

                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="billing-info">
                                                        <select name="gender" class="form-control" id="">
                                                            <option <?= $_SESSION['user']->gender == '1' ? 'selected' : '' ?> value="1">Male</option>
                                                            <option <?= $_SESSION['user']->gender == '0' ? 'selected' : '' ?> value="0">Female</option>
                                                        </select>
                                                        <?= $validation->getErrorMessage('gender') ?>

                                                    </div>
                                                </div>
                                            
                                            </div>
                                            <div class="billing-back-btn">
                                                <div class="billing-btn">
                                                    <button type="submit" name="update-profile">Update</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>2</span> <a data-toggle="collapse" data-parent="#faq"
                                        href="#my-account-2">Change your password </a></h5>
                            </div>
                            <div id="my-account-2" class="panel-collapse collapse">
                                <div class="panel-body">
                                <form method="post">
                                    <div class="billing-information-wrapper">
                                        <div class="account-info-wrapper">
                                            <h4>Change Password</h4>
                                            <h5>Your Password</h5>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12">
                                                
                                                    <div class="billing-info">
                                                        <label>Old Password</label>
                                                        <input type="password" name="old_password">
                                                        
                                                    </div>
                                                    <?= $validation->getErrorMessage("old_password") ?? "" ?>
                                                    
                                                    <div class="billing-info">
                                                        <label>New Password</label>
                                                        <input type="password" name="new_password">
                                                        <?= $validation->getErrorMessage("new_password") ?? "" ?>
                                                    </div>
                                                        <div class="billing-info">
                                                            <label>Password Confirm</label>
                                                            <input type="password" name="password_confirmation">
                                                            <?= $validation->getErrorMessage("password_confirmation") ?? "" ?>
                                                        </div>
                                                
                                                <div class="billing-back-btn">
                                                    <div class="billing-back">
                                                        <a href="#"><i class="ion-arrow-up-c"></i> back</a>
                                                    </div>
                                                    <div class="billing-btn">
                                                        <button type="submit" name="change_password" value="1">Continue</button>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>3</span> <a data-toggle="collapse" data-parent="#faq"
                                        href="#my-account-3">Modify your address book entries </a></h5>
                            </div>
                            <div id="my-account-3" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="billing-information-wrapper">
                                        <div class="account-info-wrapper">
                                            <h4>Address Book Entries</h4>
                                        </div>
                                        <div class="entries-wrapper">
                                            <div class="row">
                                                <div
                                                    class="col-lg-6 col-md-6 d-flex align-items-center justify-content-center">
                                                    <div class="entries-info text-center">
                                                        <p>Farhana hayder (shuvo) </p>
                                                        <p>hastech </p>
                                                        <p> Road#1 , Block#c </p>
                                                        <p> Rampura. </p>
                                                        <p>Dhaka </p>
                                                        <p>Bangladesh </p>
                                                    </div>
                                                </div>
                                                <div
                                                    class="col-lg-6 col-md-6 d-flex align-items-center justify-content-center">
                                                    <div class="entries-edit-delete text-center">
                                                        <a class="edit" href="#">Edit</a>
                                                        <a href="#">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="billing-back-btn">
                                            <div class="billing-back">
                                                <a href="#"><i class="ion-arrow-up-c"></i> back</a>
                                            </div>
                                            <div class="billing-btn">
                                                <button type="submit">Continue</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>4</span> <a href="wishlist.php">Modify your wish list
                                    </a></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
var loadFile = function(event) {
  var reader = new FileReader();
  reader.onload = function(){
    var output = document.getElementById('image');
    output.src = reader.result;
  };
  reader.readAsDataURL(event.target.files[0]);
};
</script>
<?php 
include "layouts/footer.php";
include "layouts/scripts.php";

?>
