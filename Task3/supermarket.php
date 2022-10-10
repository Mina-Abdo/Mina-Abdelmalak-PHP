<?php

$cities = ['cairo'=>0 , 'giza'=>30, 'alex'=>50, 'other'=>100];
function drawCity($citiesVar , $val=true){
    $citiesSelect = "
        <select class='form-select' name='city'>
        <option>Select delivery location</option>";
        
    foreach ($citiesVar as $cityName => $delivery) {
        if(empty($_POST['city'])){
            $citiesSelect .= "<option value='".$cityName."'>".$cityName."</option>";
        }else{
            if($cityName ===$_POST['city']){
                $citiesSelect .= "<option value='".$cityName."' selected>".$cityName."</option>";
            }
            $citiesSelect .= "<option value='".$cityName."'>".$cityName."</option>";
        }
        
    }
    $citiesSelect .= "</select>";
    return $citiesSelect;
}
$citySelect = drawCity($cities);



if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // inputs validation
    $errors = [];
    if (empty($_POST['name'])) {
        $errors['name'] = "<p class='alert alert-danger p-2 mt-2'> please enter your name </p>";
    }
    if (empty($_POST['city'])) {
        $errors['city'] = "<p class='alert alert-danger p-2 mt-2'> Please choose delivery location </p>";
    }
    if (empty($_POST['products'])) {
        $errors['products'] = "<p class='alert alert-danger p-2 mt-2'> Please enter number of products to purchase </p>";
    }
// print_r($_POST);
    if (empty($errors)) {
        // validation is passed
        
        // draw products data form
        $productDetails = ['ProductName', 'Quantity', 'Price'];
            function drawProductTable($details){
                    $productTable = "
                    
                            <table class='table mt-2'>
                                <thead>";
                                    foreach ($details as $detail) {
                                        $productTable .= "<th class='text-center'>{$detail}</th>";
                                    }
                                    $productTable .= "</thead>
                                            <tbody>";
                                    for ($i = 0; $i < $_POST['products']; $i++) {
                                        $productTable .= "
                                                            <tr class='table-primary'>";
                                            foreach ($details as $detailKey) {
                                                if($detailKey === 'ProductName'){
                                                    $productTable .= "<td><input type='text' name='";
                                                    
                                                    $productTable .= $i.$detailKey;
                                                    $productTable .= "'></td>";
                                                }else{
                                                    $productTable .= "<td><input type='number' name='";
                                                    $productTable .= $i.$detailKey;
                                                    $productTable .= "'></td>";
                                                }
                                                
                                            }
                            $productTable .= "</tr>";
                        }
                        $productTable .= "</tbody>
                            </table>";
                    
                    return $productTable;
            }
            $productForm = "<div class='col-8 mt-3'>
                            <div class='form-group'>";
                
            $productForm = drawProductTable($productDetails);
            
            $productForm .="  </div>";
            $productForm .="<button type='submit' class='btn btn-primary' name='productInfo'>Recipet</button>
                            </div>";
        
            }
            // print_r($_POST);
            if(isset($_POST['productInfo'])){
                $productForm = "";
                array_push($productDetails , 'Subtotal');
                $recieptTable="
                <table class='table my-3'>
                <thead>";
                    foreach ($productDetails as $detail) {
                        $recieptTable .= "<th class='text-center'>{$detail}</th>";
                            }
                            $recieptTable .= "</thead>
                                <tbody>";
                                $subtotal=0;
                                for ($i = 0; $i < $_POST['products']; $i++) {
                                    
                                    $recieptTable .= "
                                            <tr class='table-primary'>";
                                        foreach ($productDetails as $detailKey) {
                                            
                                            if($detailKey==='ProductName'){
                                                $recieptTable .= "<td class='text-center'>".ucfirst($_POST[$i.$detailKey])."</td>";
                                            }elseif($detailKey==='Quantity' || $detailKey==='Price'){
                                                $recieptTable .= "<td class='text-center'>".$_POST[$i.$detailKey]."</td>";
                                            }elseif($detailKey==='Subtotal'){
                                                // $subtotal+= ($_POST[$i.'Quantity']*$_POST[$i.'Price']);
                                                $recieptTable .= "<td class='text-center'>".((float)$_POST[$i.'Quantity']*(float)$_POST[$i.'Price'])." EGP</td>";
                                            }
                                            
                                        }
                                        $subtotal+= ((float)$_POST[$i.'Quantity']*(float)$_POST[$i.'Price']);
                                        
                            $recieptTable .= "</tr>";
                            
                    }
                        $recieptTable .= "
                        <tr>
                                <td class='text-center'>Client name</td>
                                <td class='text-center'>".ucfirst($_POST['name'])."</td>
                            </tr>
                            <tr>
                                <td class='text-center'>City</td>
                                <td class='text-center'>".ucfirst($_POST['city'])."</td>
                            </tr>
                            <tr>
                                <td class='text-center'>Subtotal</td>
                                <td class='text-center'>{$subtotal} EGP</td>
                            </tr>";                                
                            
                            if($subtotal<=1000){
                                $discount = 0;
                            }elseif($subtotal>1000 && $subtotal<=3000){
                                $discount = 0.10;
                            }
                            elseif($subtotal>3000 && $subtotal<=4500){
                                $discount = 0.15;
                            }elseif($subtotal>4500){
                                $discount = 0.20;
                            }
                            $totalAfterDiscount = $subtotal - ($subtotal*$discount);
                                $recieptTable .= "
                                <tr>
                                    <td class='text-center'>Discount</td>
                                    <td class='text-center'>".$discount * $subtotal." EGP</td>
                                </tr>
                                <tr>
                                    <td class='text-center'>Total after discount</td>
                                    <td class='text-center'>{$totalAfterDiscount} EGP</td>
                                </tr>";
                            if($_POST['city'] ==='cairo'){
                                $deliveryFee = 0;
                            }elseif($_POST['city'] ==='giza'){
                                $deliveryFee = 30;
                            }elseif($_POST['city'] ==='alex'){
                                $deliveryFee = 50;
                            }elseif($_POST['city'] ==='other'){
                                $deliveryFee = 100;
                            }
                                $total = $totalAfterDiscount + $deliveryFee;
                                $recieptTable .= "
                                <tr>
                                    <td class='text-center'>Delivery</td>
                                    <td class='text-center'>{$deliveryFee} EGP</td>
                                </tr>
                                <tr class='bg-success'>
                                    <td class='text-center'>Total</td>
                                    <td class='text-center'>{$total} EGP</td>
                                </tr>";
                            
                            $recieptTable .= "
                            </tbody>
                            </table>";
                // print_r($_POST);
            }
}
?>


<!doctype html>
<html lang="en">

<head>
    <title>Supermarket</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class=" col-12 text-center text-success mt-5">
                <h2>Supermarket Task</h2>
            </div>
            <div class=" col-8 mt-5">
                <form method="post">
                    <div class="form-group">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" value="<?= $_POST['name'] ?? '' ?>">
                        <?= $errors['name'] ?? "" ?>
                    </div>
                    <div class="form-group">
                        <!-- <label class="form-label">Choose your delivery location</label> -->
                        
                            <!-- <?php foreach($cities as $city=>$val){?>
                                <div class="form-check" name="city">
                                    <input class="form-check-input" type="radio" value="<?php $_POST['city'] ?? ($city)  ?>" >
                                    <label class="form-check-label"><?= ucfirst($city) ?></label>
                                </div>
                            <?php } ?> -->
                        <?= $citySelect ?>
                        <?= $errors['city'] ?? "" ?>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Number of products</label>
                        <input type="number" class="form-control" name="products" value="<?= $_POST['products'] ?? '' ?>">
                        <?= $errors['products'] ?? "" ?>
                    </div>
                    <input type="submit" class="btn btn-success" name="inputDetails" value="Order">
                    <div class="form-group">
                        <?= $productForm??""?>
                    </div>
                    
                </form>
            </div>
            <div class="col-8 my-3">
                <?= $recieptTable ?? '' ?>
            </div>
            
            
        </div>

    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>