<?php
$page = 'unpaid';
$title = 'Transaksi Belum Dibayar';
?>

<?php require_once 'templates/header.php' ?>
<?php require_once 'templates/navbar.php' ?>

<?php
$data = selectData(
	"SELECT o.kodePesanan, o.tanggalPesan, c.usernamePelanggan, 
		(SELECT SUM(od.subHarga) FROM orderdetail od WHERE od.kodePesanan = o.kodePesanan) AS totalHarga, 
		(SELECT SUM(od.qty) FROM orderdetail od WHERE od.kodePesanan = o.kodePesanan) AS totalBarang
	FROM orders o
	JOIN customers c ON (o.kodePelanggan = c.kodePelanggan)
	WHERE o.keterangan = 'belum'
	ORDER BY o.tanggalPesan ASC
	;"
);
?>

<section id="content">
	<div class="main-container">

		<div class="card-container">
			<h2>Transaksi Belum Dibayar:</h2>

			<div class="print-link">
				Print: 
				<a href="<?= $_SERVER['PHP_SELF'] ?>" onclick="window.print()">PDF</a>
				<a href="print-unpaid.php">Excel</a>
			</div>
			
			<div class="chart-container">
				<div class="chart">
					<canvas id="myChart"></canvas>
				</div>
			</div>

			<div class="table-container unpaid">
				<table>
					<tr>
						<th>Tanggal Pesan</th>
						<th>Username</th>
						<th>Total Harga</th>
						<th>Total Barang</th>
						<th>Detail</th>
					</tr>
					<?php foreach($data as $ch): ?>
						<tr>
							<td><?= $ch['tanggalPesan'] ?></td>
							<td><?= $ch['usernamePelanggan'] ?></td>
							<td><?= $ch['totalHarga'] ?></td>
							<td><?= $ch['totalBarang'] ?></td>
							<td><a href="transaction-detail.php?isPaid=unpaid&kodePesanan=<?= $ch['kodePesanan'] ?>">detail</a></td>
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
$penjualan = 0;

$year = date('Y');
$month =  date('m');

$lastDate = cal_days_in_month(CAL_GREGORIAN, $month, $year);

$data = selectData(
	"SELECT o.kodePesanan, o.tanggalPesan, c.usernamePelanggan, 
		(SELECT SUM(od.subHarga) FROM orderdetail od WHERE od.kodePesanan = o.kodePesanan) AS totalHarga, 
		(SELECT SUM(od.qty) FROM orderdetail od WHERE od.kodePesanan = o.kodePesanan) AS totalBarang
	FROM orders o
	JOIN customers c ON (o.kodePelanggan = c.kodePelanggan)
	WHERE o.keterangan = 'belum' AND o.tanggalPesan BETWEEN '$year-$month-1 00:00:01' AND '$year-$month-$lastDate 23:59:59'
	ORDER BY o.tanggalPesan ASC
	;"
);

foreach ($data as $ch) :
	$waktu = explode(' ', $ch['tanggalPesan'])[0];
	if (!in_array($waktu, $labelChart)) {
		$labelChart[] = $waktu;
	}
endforeach;

$i = 0;
foreach ($data as $ch) :
	$waktu = explode(' ', $ch['tanggalPesan'])[0];
	if ($waktu == $labelChart[$i]) {
		$penjualan += (int)$ch['totalHarga'];
	} else {
		$valueChart[] = $penjualan;
		$penjualan = 0;
		$i++;
		$penjualan += (int)$ch['totalHarga'];
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
				label: 'Grafik Pesanan Bulan <?= date('F')." $year" ?>',
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