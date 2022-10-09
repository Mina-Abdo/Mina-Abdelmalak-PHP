<?php
// allow only visitors with contact number

if(empty($_SESSION['contactNumber'])){
    header("location:Number.php");
}

?>