<?php
$page = 'supplier';
$title = 'Add Supplier';
?>

<?php require_once 'templates/header.php' ?>
<?php require_once 'templates/navbar.php' ?>

<?php
// pemanggilan fungsi validasi dan disimpan di errors apabila tidak valid
$errors = [];
if (isset($_POST["tambah"])) {
	validAll($errors, $_POST);
	validAlfa($errors, $_POST, "nama");
	validNumLen($errors, $_POST, "no");
	validAlfaNum($errors, $_POST, "alamat");
}

// pengecekan apabila tombol submit ditekan dan validasi aman
if (isset($_POST["tambah"]) && $errors == []) {
	$tambah = tambahSuplaier($_POST);
	if ($tambah > 0) {
		echo '<div class="popup">
						<span class="success">Supplier berhasil ditambahkan</span>
					</div>';
		header('Refresh: 2, url=supplier-data.php');
		exit();
	} else {
		echo '<div class="popup">
						<span class="danger">Supplier gagal ditambahkan</span>
					</div>';
		header('Refresh: 2');
	}
}
?>

<section>
	<div class="main-container">
		<div class="formin-container">
			<form method="POST">
				<div class="form-title">
					<h2>Add Supplier</h2>
				</div>
				<div class="form-element">
					<div class="input-field">
						<label for="nama">Nama Supplier</label>
						<input type="text" name="nama" id="nama" value="<?php if (isset($_POST["tambah"])) {
																															echo ($_POST['nama']);
																														} ?>">
					</div>
					<div class="error-msg"><?php cekError($errors, "nama"); ?></div>
				</div>
				<div class="form-element">
					<div class="input-field">
						<label for="alamat">Alamat Supplier</label>
						<input type="text" name="alamat" id="alamat" value="<?php if (isset($_POST["tambah"])) {
							echo ($_POST['alamat']);
						} ?>">
					</div>
					<div class="error-msg"><?php cekError($errors, "alamat"); ?></div>
				</div>
				<div class="form-element">
					<div class="input-field">
						<label for="no">No. Telp Supplier</label>
						<input type="text" name="no" id="no" value="<?php if (isset($_POST["tambah"])) {
							echo ($_POST['no']);
						} ?>">
					</div>
					<div class="error-msg"><?php cekError($errors, "no"); ?></div>
				</div>
				<div class="form-element">
					<div class="input-field button">
						<button type="submit" name="tambah" value="Tambah">Add</button>
						<button onclick="location.href='supplier-data.php'" type="button" class="cancel">Cancel</button>
					</div>
				</div>
			</form>
		</div>

	</div>
</section>

<?php require_once 'templates/footer.php'; ?>