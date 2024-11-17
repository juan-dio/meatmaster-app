<?php
$page = 'transaction';
$title = 'Transaction Data';
session_start();
?>

<?php require_once 'templates/header.php' ?>
<?php require_once 'templates/navbar.php' ?>

<?php
$data = selectData(
	"SELECT * FROM pembayaran p
	JOIN orders o ON (p.kodePesanan = o.kodePesanan)
	WHERE o.kodePelanggan = {$_SESSION["userID"]} AND o.keterangan = 'sudah'
	;"
);

?>

<section id="content">
	<div class="main-container">

		<div class="card-container">
			<h2>Histori Pesanan:</h2>

			<div class="table-container customer">
				<table>
					<tr>
						<th>Tanggal Transaksi</th>
						<th>Metode Pembayaran</th>
						<th>Total</th>
						<th>Detail</th>
						<!-- <th>Aksi</th> -->
					</tr>
					<?php foreach($data as $ch): ?>
						<tr>
							<td><?= $ch['waktuBayar'] ?></td>
							<td><?= $ch['metode'] ?></td>
							<td><?= $ch['total'] ?></td>
							<td><a href="<?= BASEURL ?>/app/customer/transaction-detail.php?kodePesanan=<?= $ch['kodePesanan'] ?>">detail</a></td>
						</tr>
					<?php endforeach; ?>
				</table>
				<!-- end table -->
			</div>
			<!-- end card container -->
		</div>

	</div>
</section>

<?php require_once 'templates/footer.php'; ?>