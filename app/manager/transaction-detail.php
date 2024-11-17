<?php
$title = 'Detail Transaksi';
require_once 'templates/header.php';

if (!isset($_GET['isPaid'])) {
	header('location: ' . BASEURL . '/app/manager/transaction-paid.php');
}

$page = $_GET['isPaid'];
require_once 'templates/navbar.php'
?>

<?php
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
			<h2>Transaction Detail:</h2>

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
				<a href="<?php if ($page == 'paid') echo BASEURL . '/app/manager/transaction-paid.php';
							else echo BASEURL . '/app/manager/transaction-unpaid.php' ?>" class="back">Kembali</a>
			</div>
			<!-- end card container -->
		</div>

	</div>
</section>

<?php require_once 'templates/footer.php'; ?>