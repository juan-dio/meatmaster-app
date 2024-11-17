<?php
$title = 'Administrator - Sistem Toko Makanan: Meatmaster';

require('../base.php');
require(BASEPATH."/app/fauth.php");

session_start();
checkAdminSignedIn();
whenIsManager();
header("Location: product-data.php");
require(BASEPATH."/app/templates/header.php");
?>


<?php
require(BASEPATH."/app/templates/footer.php");
?>