<?php
$page = 'supplier';
$title = 'Edit Supplier';
?>

<?php require_once 'templates/header.php' ?>
<?php require_once 'templates/navbar.php' ?>

<?php
$id = $_GET['id'];
$data = selectData("SELECT * FROM suplaier WHERE kodeSuplaier = $id");

// pemanggilan fungsi validasi dan disimpan di errors apabila tidak valid
$errors = [];
if (isset($_POST["edit"])) {
	validAll($errors, $_POST);
	validAlfa($errors, $_POST, "nama");
	validNumLen($errors, $_POST, "nomor");
	validAlfaNum($errors, $_POST, "alamat");
}

// Pengecekan tombol submit sdh ditekan atau belum dan error kosong (valid)
if (isset($_POST["edit"])  && $errors == []) {
	if (editSuplaier($_POST) > 0) {
		echo '<div class="popup">
						<span class="success">Supplier berhasil diedit</span>
					</div>';
		header('Refresh: 2, url=supplier-data.php');
	} else {
		echo '<div class="popup">
						<span class="danger">Supplier gagal diedit</span>
					</div>';
		header('Refresh: 2');
	}
}
?>

<section>
	<div class="main-container">
		<div class="formin-container">
			<form method="post">
				<input type="hidden" name="id" value="<?= $id ?>">
				<div class="form-title">
					<h2>Edit Supplier</h2>
				</div>
				<div class="form-element">
					<div class="input-field">
						<label for="nama">Nama Supplier</label>
						<input type="text" id="nama" name="nama" value="<?php if (!isset($_POST["edit"])) {
							echo $data[0]["namaSuplaier"];
						} else {
							echo $_POST["nama"];
						} ?>">
					</div>
					<div class="error-msg"><?php cekError($errors, "nama"); ?></div>
				</div>
				<div class="form-element">
					<div class="input-field">
						<label for="alamat">Alamat Supplier</label>
						<input type="text" id="alamat" name="alamat" value="<?php if (!isset($_POST["edit"])) {
							echo $data[0]["alamatSuplaier"];
						} else {
							echo $_POST["alamat"];
						} ?>">
					</div>
					<div class="error-msg"><?php cekError($errors, "alamat"); ?></div>
				</div>
				<div class="form-element">
					<div class="input-field">
						<label for="nomor">No. telp Supplier</label>
						<input type="text" id="nomor" name="nomor" value="<?php if (!isset($_POST["edit"])) {
							echo $data[0]["telpSuplaier"];
						} else {
							echo $_POST["nomor"];
						} ?>">
					</div>
					<div class="error-msg"><?php cekError($errors, "nomor"); ?></div>
				</div>
				<div class="form-element">
					<div class="input-field button">
						<button type="submit" name="edit" value="Edit">Edit</button>
						<button onclick="location.href='supplier-data.php'" type="button" class="cancel">Cancel</button>
					</div>
				</div>
			</form>
		</div>

	</div>
</section>

<?php require_once 'templates/footer.php'; ?>