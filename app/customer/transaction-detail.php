<?php
$page = 'transaction';
$title = 'Detail Transaksi';
session_start();
?>

<?php
require_once 'templates/header.php';
require_once 'templates/navbar.php'
?>

<?php
if(!isset($_GET['kodePesanan'])) {
	header('Location: Product.php');
}

$data = selectData(
	"SELECT * FROM orderDetail o
	JOIN products p ON (o.kodeProduk = p.kodeProduk)
	WHERE o.kodePesanan = {$_GET["kodePesanan"]}
	;"
);

?>

<section id="content">
	<div class="main-container">

		<div class="card-container">
			<h2>Detail Transaksi:</h2>

			<div class="table-container detail">
				<table>
					<tr>
						<th>Product</th>
						<th>Jumlah</th>
						<th>Harga Satuan</th>
						<th>Total Harga</th>
					</tr>
					<?php foreach($data as $ch): ?>
						<tr>
							<td><?= $ch['namaProduk'] ?></td>
							<td><?= $ch['qty'] ?></td>
							<td><?= $ch['hargaProduk'] ?></td>
							<td><?= $ch['subHarga'] ?></td>
						</tr>
					<?php endforeach; ?>
				</table>
				<!-- end table -->
				<a href="<?= BASEURL ?>/app/customer/transaction.php" class="back">Kembali</a>
			</div>
			<!-- end card container -->
		</div>

	</div>
</section>

<?php require_once 'templates/footer.php'; ?>