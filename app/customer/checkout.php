<?php
$page = 'product';
$title = 'Check Out';
session_start();
?>

<?php require_once 'templates/header.php' ?>
<?php require_once 'templates/navbar.php' ?>


<?php
$data = selectData("SELECT * FROM orders o
JOIN orderdetail od ON (o.kodePesanan=od.kodePesanan)
JOIN products p ON (od.kodeProduk=p.kodeProduk)
WHERE o.kodePelanggan={$_SESSION['userID']} AND o.keterangan='belum'
");

$wallet = selectData("SELECT * FROM wallet WHERE kodePelanggan = {$_SESSION["userID"]} AND nomorWallet <> ''");
?>

<?php
if (isset($_POST['bayar'])) {
	if (addPembayaran($data[0]['kodePesanan'], $_POST['metode'])) {
		echo '<div class="popup">
						<span class="success">Pembayaran berhasil</span>
					</div>';
		header('Refresh: 2, url=product.php');
	} else {
		echo '<div class="popup">
						<span class="danger">Pembayaran gagal</span>
					</div>';
	}
}
?>

<section>
	<div class="main-container">
		<div class="card-container">
			<h2>Pembayaran:</h2>

			<!-- Product List -->
			<div class="card-list checkout">
				<?php
				$totalHarga = 0;
				$jumlahBarang = 0;
				?>
				<?php foreach ($data as $ch) : ?>
					<div class="card">
						<div class="card-pict">
							<img src="<?= BASEURL ?>/assets/img/product/<?= $ch['gambarProduk'] ?>" alt="product">
						</div>
						<div class="card-desc checkout">
							<h3><?= $ch["namaProduk"] ?></h3>
							<p class="prod-desc"><?= $ch["deskripsiProduk"] ?></p>
						</div>
						<div class="act-product">
							<p class="prod-price"><?= $ch["subHarga"] ?></p>
							<div class="amount-product">
								Quantity: <?= $ch["qty"] ?>
							</div>
						</div>
					</div>
					<?php
					$totalHarga += (int)$ch["subHarga"];
					$jumlahBarang += (int)$ch['qty'];
					?>
				<?php endforeach; ?>

			</div>

		</div>

		<form method="post">
			<div class="payment">
				<h3>Jumlah Barang: <?= $jumlahBarang; ?></h3>
				<h3>Total Bayar: <?=  $totalHarga; ?></h3>
				<label for="metode">Metode Pembayaran:</label>
				<?php if(empty($wallet)){ ?>
					<input type="text" id="metode" value="Anda belum memiliki wallet, tambahkan melalui halaman profil" disabled >
				<?php } else { ?>
					<select name="metode" id="metode">
						<?php foreach ($wallet as $w) {
							if ($w['namaWallet'] == $data[0]['metode']) { ?>
								<option value="<?= $w['namaWallet'] ?>"><?= $w['namaWallet'] ?></option>
						<?php }
						} ?>
						<?php foreach ($wallet as $w) {
							if ($w['namaWallet'] != $data[0]['metode']) { ?>
								<option value="<?= $w['namaWallet'] ?>"><?= $w['namaWallet'] ?></option>
						<?php }
						} ?>
					</select>
				<?php } ?>
				<button type="submit" name="bayar" <?= (empty($wallet)) ? 'class="disabled" disabled' : '' ?>>Bayar</button>
			</div>
		</form>
	</div>
</section>

<a href="<?= BASEURL ?>/app/customer/cart.php" class="circle-link">
	<img src="<?= BASEURL  ?>/assets/img/cart-shopping.png" alt="cart-shopping">
</a>

<?php require_once 'templates/footer.php'; ?>