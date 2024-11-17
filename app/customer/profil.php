<?php
session_start();
$page = 'profil';
$title = 'Profil';
$failUpdate = FALSE;
?>

<?php require_once 'templates/header.php'; getUserData(PDO_Connect, ($_SESSION['userID'] ?? $_COOKIE['userID'] ?? FALSE)) ?>
<?php require_once 'templates/navbar.php' ?>

<section>
	<div class="main-container profil">
		<div class="formin-container">
			<form method="POST">
				<div class="form-title">
					<h2>Profil Customer</h2>
				</div>
				<div class="form-element">
					<div class="input-field">
						<label for="customerEmail">Email</label>
						<input type="text" id="customerEmail" name="customerEmail" readonly value="<?= $UIDFetched['usernamePelanggan'] ?>">
					</div>
					<div class="error-msg">
						<?php if (isset($_POST['edit']) && $_SERVER['REQUEST_METHOD'] == 'POST') {echo(setted($_POST, "customerEmail"));} ?>
					</div>
				</div>
				<div class="form-element">
					<div class="input-field">
						<label for="alamat">Alamat</label>
						<textarea name="alamat" id="alamat"><?php if (isset($_POST['edit']) && $_SERVER['REQUEST_METHOD'] == 'POST') {echo($_POST['alamat']);} else {echo($UIDFetched['alamatPelanggan']);} ?></textarea>
					</div>
					<div class="error-msg">
						<?php if (isset($_POST['edit']) && $_SERVER['REQUEST_METHOD'] == 'POST') {echo(setted($_POST, "alamat"));} ?>
					</div>
				</div>
				<div class="form-element">
					<div class="input-field">
						<label for="customerpwdOLD">Password Lama</label>
						<input type="password" id="customerpwdOLD" name="customerpwdOLD">
					</div>
					<div class="error-msg">
						<?php if (isset($_POST['edit']) && $_SERVER['REQUEST_METHOD'] == 'POST') {echo(setted($_POST, "customerpwdOLD"));} ?>
					</div>
				</div>
				<div class="form-element">
					<div class="input-field">
						<label for="customerpwdNEW">Password Baru</label>
						<input type="password" id="customerpwdNEW" name="customerpwdNEW">
					</div>
					<div class="error-msg">
						<?php if (isset($_POST['edit']) && $_SERVER['REQUEST_METHOD'] == 'POST') {echo(setted($_POST, "customerpwdNEW"));} ?>
					</div>
				</div>
				<div class="form-element">
					<div class="input-field">
						<button type="submit" name="edit">Edit Profil</button>
					</div>
				</div>
				<div class="form-element">
					<div class="success-msg">
						<?php if (isset($_POST['edit']) && $_SERVER['REQUEST_METHOD'] == 'POST') {updateUserData($failUpdate, PDO_Connect, ($_SESSION['userID'] ?? $_COOKIE['userID'] ?? FALSE), $_POST['customerEmail'], $_POST['customerpwdNEW'], $_POST['alamat']);} ?>
					</div>
				</div>
			</form>
		</div>

		<?php 
		$wallet = selectData("SELECT * FROM wallet WHERE kodePelanggan = {$_SESSION['userID']}");
		$errors = [];
		if (isset($_POST["tambah"])) {
			validWallet($errors, $_POST, "dana");
			validWallet($errors, $_POST, "ovo");
			validWallet($errors, $_POST, "gopay");
		}
		?>
		
		<div class="formin-container">
			<form method="POST">
				<div class="form-title">
					<h2>Wallets</h2>
				</div>
				<div class="form-element">
					<div class="input-field">
						<label for="dana">DANA</label>
						<input type="text" id="dana" name="dana" value="<?php if(!isset($_POST["tambah"])){echo $wallet[0]['nomorWallet'];}else{echo $_POST["dana"];} ?>">
					</div>
					<div class="error-msg"><?php cekError($errors, "dana"); ?></div>
				</div>
				<div class="form-element">
					<div class="input-field">
						<label for="gopay">GOPAY</label>
						<input type="text" id="gopay" name="gopay" value="<?php if(!isset($_POST["tambah"])){echo $wallet[1]['nomorWallet'];}else{echo $_POST["gopay"];} ?>">
					</div>
					<div class="error-msg"><?php cekError($errors, "gopay"); ?></div>
				</div>
				<div class="form-element">
					<div class="input-field">
						<label for="ovo">OVO</label>
						<input type="text" id="ovo" name="ovo" value="<?php if(!isset($_POST["tambah"])){echo $wallet[2]['nomorWallet'];}else{echo $_POST["ovo"];} ?>">
					</div>
					<div class="error-msg"><?php cekError($errors, "ovo"); ?></div>
				</div>
				<div class="form-element">
					<div class="input-field">
						<button type="submit" name="tambah">Tambah Wallet</button>
						<?php if(isset($_POST['tambah']) && $_SERVER['REQUEST_METHOD'] == 'POST' && $errors==[]) editWallet($_SESSION['userID'], $_POST['dana'], $_POST['gopay'], $_POST['ovo']) ?>
					</div>
				</div>
			</form>
		</div>

	</div>
</section>

<?php require_once 'templates/footer.php'; ?>