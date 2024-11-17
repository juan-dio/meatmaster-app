<?php 
require "../function.php";
session_start();
try{
    makeOrder($_SESSION);
    header('Location:product.php');
}catch(Exception $e){
    header('Location:product.php');
}

?>