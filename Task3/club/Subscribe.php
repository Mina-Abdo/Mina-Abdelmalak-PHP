<?php
$title = "Subscribe";
include "layouts/header.php";
include "layouts/navbar.php";
if($_SERVER['REQUEST_METHOD']=="POST"){
    // validation
    
    $errors = [];
    if(empty($_POST['name'])){
        $errors['name'] = "<p class='alert alert-danger p-2'>Please enter your name</p>";
    }
    if(empty($_POST['familyMembers'])){
        $errors['familyMembers'] = "<p class='alert alert-danger p-2'>Please enter number of family members</p>";
    }
    if($_POST['familyMembers']<0){
        $errors['invalidFamilyMembers']="<p class='alert alert-danger p-2 mt-2'>Please enter a valid number</p>";
    }
    if(empty($errors)){
        $_SESSION['client'] = [
            'name'=>$_POST['name'],
            'familyMembers'=>$_POST['familyMembers'],
            "membersInfo"=>[]
        ];
        // session_destroy();
        header("location:Games.php");
        die;
    }
}
?>

<section class="container mt-3" style="margin-bottom: 100px;">
    <div class="row justify-content-center">
        <div class="col-8">
            <h2 class="text-center text-warning">Club task</h2>
            <form method="post">
                <div class="form-group">
                    <label>Enter your Name</label>
                    <input class="form-control" type="text" name="name" value="<?= $_POST['name']??"" ?>">
                    <p class="form-text p-2">PS: subscription costs <b>10000 EGP</b></p>
                    <?= $errors['name'] ??""?>
                </div>
                <div class="form-group">
                    <label>Enter number of family members</label>
                    <input class="form-control" type="number" name="familyMembers" value="<?= $_POST['familyMembers'] ?? '' ?>">
                    
                    <p class="form-text p-2">PS: family member subscription costs <b>2500 EGP</b></p>
                    <?= $errors['familyMembers'] ??""?>
                    <?= $errors['invalidFamilyMembers'] ?? '' ?>
                </div>
                <button type="submit" class="btn btn-success">Subscribe</button>
                
            </form>
        </div>
    </div>
</section>

<?php
include "layouts/footer.php";
include "layouts/scripts.php";
?>