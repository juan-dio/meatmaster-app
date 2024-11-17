<?php
session_start();
require("../base.php");
require("../fauth.php");
require("../function.php");
isNotSignedIn();
checkAdminSignedIn();
whenIsNOTManager();
?>

<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $title ?></title>
	<link rel="stylesheet" href="<?= BASEURL  ?>/assets/css/base.css">
	<link rel="stylesheet" href="<?= BASEURL  ?>/assets/css/style.css">
</head>

<body>