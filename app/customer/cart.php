<?php
$page = 'product';
$title = 'Shopping Cart';
session_start();
?>

<?php require_once 'templates/header.php' ?>
<?php require_once 'templates/navbar.php' ?>

<?php 
$data=selectData("SELECT * FROM orders o
JOIN orderdetail od ON (o.kodePesanan=od.kodePesanan)
JOIN products p ON (od.kodeProduk=p.kodeProduk)
WHERE o.kodePelanggan={$_SESSION['userID']} AND o.keterangan='belum'
");

// cek apakah sudah buat keranjang
if($data==[]){
	header("Location:product.php");
}
?>

<section>
	<div class="main-container">

		<div class="card-container">
			<h2>List Pesanan:</h2>

			<!-- Product List -->
			<div class="card-list flex">
				<?php foreach($data as $ch): ?>
					<div class="card">
						<div class="card-pict">
							<img src="<?= BASEURL ?>/assets/img/product/<?= $ch['gambarProduk'] ?>" alt="product">
						</div>
						<div class="card-desc cart">
							<h3><?= $ch["namaProduk"] ?></h3>
							<p class="prod-desc"><?= $ch["deskripsiProduk"] ?></p>
							<p class="prod-price"><?= $ch["subHarga"] ?></p>
						</div>
						<div class="act-product">
							<div class="amount-product">
								Quantity: <?= $ch["qty"] ?>
							</div>
							<a href="cart-delete.php?idPesanan=<?= $ch["kodePesanan"] ?>&idProduk=<?= $ch['kodeProduk'] ?>" class="prod-button red">
								<img src="<?= BASEURL  ?>/assets/img/cart-minus.png" alt="cart-minus">
							</a>
						</div>
					</div>
				<?php endforeach; ?>
			<!-- end card List -->
			</div>
		<!-- end card container -->
		</div>

	</div>
</section>

<a href="<?= BASEURL  ?>/app/customer/checkout.php" class="box-link">
	<img src="<?= BASEURL  ?>/assets/img/cart-check.png" alt="cart-check">
	Check out
</a>

<?php require_once 'templates/footer.php'; ?>