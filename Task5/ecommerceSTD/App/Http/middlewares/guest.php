<?php
// prevent => authenticated user , allow => guest
if(isset($_SESSION['user'])){
    header('location:index.php');die;
}