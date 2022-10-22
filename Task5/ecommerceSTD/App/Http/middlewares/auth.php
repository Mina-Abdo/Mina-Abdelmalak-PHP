<?php
// prevent => guest , allow => authenticated
if(! isset($_SESSION['user'])){
    header('location:login.php');die;
}