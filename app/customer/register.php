<?php
$page = 'register';
$title = 'Daftar sebagai pelanggan | Toko makanan: Meatmaster';

require '../base.php';
require_once '../templates/header.php';
require("../fregist.php");
$failRegist = FALSE;
?>

<section id="login">
	<div class="login-container">
		<form action="<?= htmlspecialchars("register.php") ?>" method="POST">
			<div class="form-container">
				<div class="form-title">
					<h2>Daftar</h2>
				</div>
				<div class="form-element">
					<div class="input-field">
						<label for="customerEmail">Surel</label>
						<input type="text" name="customerEmail" id="customerEmail" value="<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') {echo(htmlspecialchars($_POST['customerEmail']));} ?>">
					</div>
					<div class="error-msg">
						<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') {
							echo (isSetValue($_POST, 'customerEmail'));
						} ?>
					</div>
				</div>
				<div class="form-element">
					<div class="input-field">
						<label for="customeraddr">Alamat</label>
						<textarea name="customeraddr" id="customeraddr"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') {echo(htmlspecialchars($_POST['customeraddr']));} ?></textarea>
					</div>
					<div class="error-msg">
						<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') {
							echo (isSetValue($_POST, 'customeraddr'));
						} ?>
					</div>
				</div>
				<div class="form-element">
					<div class="input-field">
						<label for="customerpwd">Kata sandi</label>
						<input type="password" name="customerpwd" id="customerpwd">
					</div>
					<div class="error-msg">
						<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') {
							echo (isSetValue($_POST, 'customerpwd'));
						} ?>
					</div>
				</div>
				<div class="form-element">
					<div class="input-field">
						<label for="conf-password">Konfirmasi kata sandi</label>
						<input type="password" name="conf-password" id="conf-password">
					</div>
					<div class="error-msg">
						<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') {
							echo (isSetValue($_POST, 'conf-password'));
							echo (setSameDiffValue($_POST['customerpwd'], $_POST['conf-password']));
						} ?>
					</div>
				</div>
				<div class="form-element">
					<div class="input-field">
						<button type="submit" name="regist">Daftar</button>
					</div>
				</div>
				<div class="form-element">
					<div class="error-msg">
					<?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && ($_POST['customerEmail'] != "")) {
						echo (isRegisteredCustomer($_POST['customerEmail'], PDO_Connect));
					}
					if ($_SERVER['REQUEST_METHOD'] == 'POST' && ($failRegist == FALSE)) {
						isOKRegistCustomer($failRegist, PDO_Connect, $_POST['customerEmail'], $_POST['customerpwd'], $_POST['customeraddr']);
					} ?>
					</div>
				</div>
				<div class="account-link">
					Sudah punya akun?
					<a href="../login.php">Login</a>
				</div>
			</div>
		</form>
	</div>
</section>

<?php require_once 'templates/footer.php' ?>