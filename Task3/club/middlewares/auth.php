<?php
// allow only visitors with contact number

if(empty($_SESSION['client']['name'])){
    header("location:Subscribe.php");
    die;
}

?>