<?php
    $title = "Number";
    include "layouts/header.php";
    include "layouts/navbar.php";

    if($_SERVER['REQUEST_METHOD']=="POST"){
        // validation
        $errors=[];
        if(empty($_POST['number'])){
            $errors['number'] = "<p class='alert alert-danger mt-3'>Please enter your contact number</p>";
        }
        if(empty($errors)){
            $_SESSION['contactNumber'] = $_POST['number'];
            header("location:Review.php");
            die;
        }
    }
?>
    
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="text-center text-info">Hospital Task</h2>
            </div>
            <div class="col-8 mt-5">
                <form method="post">
                    <div class="form-group">
                        <label>Enter your contact Number</label>
                        <input type="number" class="form-control" name="number">
                        <?= $errors['number']??""?>
                    </div>
                    <button type="submit" class="btn btn-dark my-3">Review</button>
                </form>
            </div>
        </div>
    </div>
<?php
include "layouts/footer.php";
include "layouts/scripts.php";
?>

    