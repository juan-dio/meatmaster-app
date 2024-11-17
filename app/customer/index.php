<?php
session_start();
require("templates/header.php");
checkSignedIn();
$wallet = selectData("SELECT * FROM wallet WHERE kodePelanggan = {$_SESSION['userID']}");
if(empty($wallet)) {
  addWallet($_SESSION['userID']);
}
header("Location: ".BASEURL."/app/customer/product.php");
?>