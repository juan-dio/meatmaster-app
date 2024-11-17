<?php
$page = 'customer';
$title = 'Customer Data';
?>

<?php require_once 'templates/header.php' ?>
<?php require_once 'templates/navbar.php' ?>

<?php $data = selectData("SELECT * FROM customers"); ?>

<section id="content">
	<div class="main-container">

		<div class="card-container">
			<h2>List Customer:</h2>

			<div class="table-container admin">
				<table>
					<tr>
						<th>No.</th>
						<th>Email</th>
						<th>Alamat</th>
					</tr>
					<?php $i = 1;
					foreach ($data as $ch) : ?>
						<tr>
							<td><?= $i; ?></td>
							<td><?= $ch["usernamePelanggan"] ?></td>
							<td><?= $ch["alamatPelanggan"] ?></td>
						</tr>
					<?php $i++;
					endforeach; ?>
				</table>
				<!-- end table -->
			</div>
			<!-- end card container -->
		</div>

	</div>
</section>

<?php require_once 'templates/footer.php'; ?>