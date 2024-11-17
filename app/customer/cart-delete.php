<?php 
require 'templates/header.php';
session_start();
if(hapusOrderDetil($_GET["idProduk"],$_GET["idPesanan"])>0){
    echo '<div class="popup">
            <span class="success">Barang berhasil dihapus</span>
        </div>';
    // header('Refresh: 2, url=cart.php');
} else{
    echo '<div class="popup">
            <span class="danger">Barang gagal dihapus</span>
        </div>';
    // header('Refresh: 2, url=cart.php');
}

require 'templates/footer.php';
?>