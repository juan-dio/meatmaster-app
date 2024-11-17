<?php
$page = 'register';
$title = "Pendaftaran | Administrasi Laman Toko Makanan: Meatmaster";
require("../base.php");
require(BASEPATH . "/app/fregist.php");
require(BASEPATH . "/app/templates/header.php");
$failRegist = FALSE;
?>
<section id="login">
    <div class="login-container">
        <form action="<?= htmlspecialchars("register.php") ?>" method="POST">
            <div class="form-container">
                <div class="form-title">
                    <h2>Pendaftaran untuk pengguna admin</h2>
                </div>
                <div class="form-element">
                    <div class="input-field">
                        <label for="adminusr">Nama pengguna</label>
                        <input type="text" id="adminusr" name="adminusr" value="<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                                                                    echo ($_POST['adminusr']);
                                                                                } ?>" >
                    </div>
                    <div class="error-msg">
                        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            echo (isSetValue($_POST, 'adminusr'));
                        } ?>
                    </div>
                </div>
                <div class="form-element">
                    <div class="input-field">
                        <label for="adminpwd">Kata sandi</label>
                        <input type="password" id="adminpwd" name="adminpwd" >
                    </div>
                    <div class="error-msg">
                        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            echo (isSetValue($_POST, 'adminpwd'));
                        } ?>
                    </div>
                </div>
                <div class="form-element">
                    <div class="input-field">
                        <label>Jabatan</label>
                        <div class="radio">
                            <label for="admin">
                                <input type="radio" name="jabatan" value="1" id="admin" checked >Admin
                            </label>
                            <label for="manajer">
                                <input type="radio" name="jabatan" id="manajer" value="2" >Manajer
                            </label>
                        </div>
                    </div>
                    <div class="error-msg">
                        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            echo (isSetValue($_POST, 'jabatan'));
                        } ?>
                    </div>
                </div>
                <div class="form-element">
                    <div class="input-field">
                        <button type="submit" id="submit" value="Masuk">Buat akun</button>
                    </div>
                </div>
                <div class="form-element">
                    <div class="error-msg">
                        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && ($_POST['adminusr'] != "")) {
                            echo (isRegisteredAdmin($_POST['adminusr'], PDO_Connect));
                        }
                        if ($_SERVER['REQUEST_METHOD'] == 'POST' && ($failRegist == FALSE)) {
                            isOKRegistAdmin($failRegist, PDO_Connect, $_POST['adminusr'], $_POST['adminpwd'], $_POST['jabatan']);
                        } ?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<?php require(BASEPATH . "/app/admin/templates/footer.php") ?>