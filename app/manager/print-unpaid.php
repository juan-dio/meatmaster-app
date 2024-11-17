<?php
require("../base.php");
require("../function.php");
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Transaksi Belum Dibayar.xls");

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
	;"
);

?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Transaksi Belum Dibayar</title>
  <style>
    th, td {
      border: 1px solid black;
    }
  </style>
</head>

<body>

  <table>
    <tr>
      <th colspan="4">Transaksi Belum Dibayar Bulan <?= date('F')." $year" ?></th>
    </tr>
    <tr>
      <th>Tanggal Pesan</th>
      <th>Username</th>
      <th>Total Harga</th>
      <th>Total Barang</th>
    </tr>
    <?php foreach ($data as $ch) : ?>
      <tr>
        <td><?= $ch['tanggalPesan'] ?></td>
        <td><?= $ch['usernamePelanggan'] ?></td>
        <td><?= $ch['totalHarga'] ?></td>
        <td><?= $ch['totalBarang'] ?></td>
      </tr>
    <?php endforeach; ?>
  </table>


</body>

</html>