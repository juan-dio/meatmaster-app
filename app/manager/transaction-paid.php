<?php
$page = 'paid';
$title = 'Transaksi Sudah Dibayar';
?>

<?php require_once 'templates/header.php' ?>
<?php require_once 'templates/navbar.php' ?>

<?php
$data = selectData(
	"SELECT * FROM pembayaran p
	JOIN orders o ON (p.kodePesanan = o.kodePesanan)
	JOIN customers c ON (o.kodePelanggan = c.kodePelanggan)
	WHERE o.keterangan = 'sudah'
	ORDER BY p.waktuBayar ASC
	;"
);
?>

<section id="content">
	<div class="main-container">

		<div class="card-container">
			<h2>Transaksi Sudah Dibayar:</h2>

			<div class="print-link">
				Print: 
				<a href="<?= $_SERVER['PHP_SELF'] ?>" onclick="window.print()">PDF</a>
				<a href="print-paid.php">Excel</a>
			</div>

			<div class="chart-container">
				<div class="chart">
					<canvas id="myChart"></canvas>
				</div>
			</div>

			<div class="table-container paid">
				<table>
					<tr>
						<th>Username</th>
						<th>Tanggal Transaksi</th>
						<th>Metode Pembayaran</th>
						<th>Total Bayar</th>
						<th>Detail</th>
					</tr>

					<?php foreach ($data as $ch) : ?>
						<tr>
							<td><?= $ch['usernamePelanggan'] ?></td>
							<td><?= $ch['waktuBayar'] ?></td>
							<td><?= $ch['metode'] ?></td>
							<td><?= $ch['total'] ?></td>
							<td><a href="transaction-detail.php?isPaid=paid&kodePesanan=<?= $ch['kodePesanan'] ?>">detail</a></td>
						</tr>
					<?php endforeach; ?>
				</table>
				<!-- end table -->
			</div>
			<!-- end card container -->
		</div>

	</div>
</section>

<?php
$labelChart = [];
$valueChart = [];

$year = date('Y');
$month =  date('m');

$lastDate = cal_days_in_month(CAL_GREGORIAN, $month, $year);

$data = selectData(
	"SELECT * FROM pembayaran p
	JOIN orders o ON (p.kodePesanan = o.kodePesanan)
	JOIN customers c ON (o.kodePelanggan = c.kodePelanggan)
	WHERE o.keterangan = 'sudah' AND p.waktuBayar BETWEEN '$year-$month-1 00:00:01' AND '$year-$month-$lastDate 23:59:59'
	ORDER BY p.waktuBayar ASC
	;"
);

foreach ($data as $ch) :
	$waktu = explode(' ', $ch['waktuBayar'])[0];
	if (!in_array($waktu, $labelChart)) {
		$labelChart[] = $waktu;
	}
endforeach;

$i = 0;
$penjualan = 0;
foreach ($data as $ch) :
	$waktu = explode(' ', $ch['waktuBayar'])[0];
	if ($waktu == $labelChart[$i]) {
		$penjualan += (int)$ch['total'];
	} else {
		$valueChart[] = $penjualan;
		$penjualan = 0;
		$i++;
		$penjualan += (int)$ch['total'];
	}
endforeach;
$valueChart[] = $penjualan;
?>

<script src="<?= BASEURL ?>/assets/chartjs/dist/chart.umd.js"></script>
<script>
	var ctx = document.getElementById("myChart").getContext('2d');
	var myChart = new Chart(ctx, {
		type: 'line',
		data: {
			labels: <?= json_encode($labelChart); ?>,
			datasets: [{
				label: 'Grafik Pembelian Bulan <?= date('F')." $year" ?>',
				data: <?= json_encode($valueChart); ?>,
				borderWidth: 1,
				borderColor: '#36A2EB',
				backgroundColor: '#9BD0F5'
			}]
		},
		options: {
			scales: {
				y: {
					beginAtZero: true
				}
			}
		}
	});
</script>

<?php require_once 'templates/footer.php'; ?>