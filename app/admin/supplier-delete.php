<?php $title = 'Hapus Supplier' ?>
<?php require_once 'templates/header.php' ?>

<?php 
$kodeSuplaier=$_GET["id"];
try{
    hapusSuplaier($kodeSuplaier)>0;
    echo '<div class="popup">
            <span class="success">Supplier berhasil dihapus</span>
        </div>';
    header('Refresh: 2, url=supplier-data.php');
}catch(Exception $e){
    echo '<div class="popup">
                    <span class="danger">Supplier gagal dihapus karena sedang menyuplai barang</span>
                </div>';
    header('Refresh: 2, url=supplier-data.php');
}
?>

<?php require_once 'templates/footer.php'; ?>