<?php
require("../base.php");
require("../function.php");
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Transaksi Sudah Dibayar.xls");

$year = date('Y');
$month =  date('m');

$lastDate = cal_days_in_month(CAL_GREGORIAN, $month, $year);

$data = selectData(
  "SELECT * FROM pembayaran p
	JOIN orders o ON (p.kodePesanan = o.kodePesanan)
	JOIN customers c ON (o.kodePelanggan = c.kodePelanggan)
	WHERE o.keterangan = 'sudah' AND p.waktuBayar BETWEEN '$year-$month-1 00:00:01' AND '$year-$month-$lastDate 23:59:59'
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
    th,
    td {
      border: 1px solid black;
    }
  </style>
</head>

<body>

  
  <table>
    <tr>
      <th colspan="4">Transaksi Sudah Dibayar Bulan <?= date('F') . " $year" ?></th>
    </tr>
    <tr>
      <th>Username</th>
      <th>Tanggal Transaksi</th>
      <th>Metode Pembayaran</th>
      <th>Total Bayar</th>
    </tr>
    <?php foreach ($data as $ch) : ?>
      <tr>
        <td><?= $ch['usernamePelanggan'] ?></td>
        <td><?= $ch['waktuBayar'] ?></td>
        <td><?= $ch['metode'] ?></td>
        <td><?= $ch['total'] ?></td>
      </tr>
    <?php endforeach; ?>
  </table>

</body>

</html>