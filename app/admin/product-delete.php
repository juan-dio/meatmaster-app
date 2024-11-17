<?php 
$title = 'Hapus Produk';
?>

<?php require_once 'templates/header.php' ?>

<?php 
$kodeProduk=$_GET["id"];
try {
    hapusProduk($kodeProduk);
    echo '<div class="popup">
            <span class="success">Data berhasil dihapus</span>
        </div>';
	header('Refresh: 2; url=product-data.php');
} catch(Exception $e) {
    echo '<div class="popup">
            <span class="danger">Data gagal dihapus</span>
        </div>';
	header('Refresh: 2; url=product-data.php');
};
?>

<?php require_once 'templates/footer.php'; ?>