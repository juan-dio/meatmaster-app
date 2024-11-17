<?php
$page = 'product';
$title = 'Edit Product';
?>

<?php require_once 'templates/header.php' ?>
<?php require_once 'templates/navbar.php' ?>

<?php 
// ketika tidak ada 
if(!isset($_GET['id'])){
	header("Location:product-data.php");
}

$data = selectData("SELECT * FROM products WHERE kodeProduk=$_GET[id]");
$suplai = selectData("SELECT * FROM suplaier");
$kategori = selectData("SELECT * FROM categories");

// pemanggilan validasi
$errors = [];
if(isset($_POST["edit"])){
    validAll($errors, $_POST);
    validAlfa($errors, $_POST,"namaProduk");
    validNum($errors, $_POST,"harga");
    validNum($errors, $_POST,"stok");
    validAlfaNum($errors, $_POST, "deskripsi");
}

// cek apakah sudah submit dan tidak ada yg error (validasi aman)
if(isset($_POST["edit"]) && $errors==[]){
    if (editProduk($_POST)>0){
				echo '<div class="popup">
					<span class="success">Data berhasil diubah</span>
				</div>';
				header('Refresh: 2, url=product-data.php');
    } else{
				echo '<div class="popup">
					<span class="danger">Data gagal diubah</span>
				</div>';
				header('Refresh: 2, url=product-data.php');
    };
}
?>

<section>
	<div class="main-container">
		<div class="formin-container">
			<form method="post" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?= $data[0]['kodeProduk'];?>">
        <input type="hidden" name="gambarLama" value="<?= $data[0]["gambarProduk"];?>">
				<div class="form-title">
					<h2>Edit Product</h2>
				</div>
				<div class="form-element">
					<div class="input-field">
						<label for="kategori">Kategori</label>
						<select name="kategori" id="kategori">
								<?php foreach($kategori as $ch){
										if($ch["kodeKategori"]==$data[0]["kodeKategori"]){?>
												<option value="<?= $ch["kodeKategori"] ?>"><?= $ch["namaKategori"] ?></option>
								<?php }}?>
								<?php foreach($kategori as $ch){
										if($ch["kodeKategori"]!=$data[0]["kodeKategori"]){?>
												<option value="<?= $ch["kodeKategori"] ?>"><?= $ch["namaKategori"] ?></option>
								<?php }}?>
						</select>
					</div>
				</div>
				<div class="form-element">
					<div class="input-field">
						<label for="suplai">Supplier</label>
						<select name="suplai" id="suplai">
								<?php foreach($suplai as $ch){
										if($ch["kodeSuplaier"]==$data[0]["kodeSuplaier"]){?>
												<option value="<?= $ch["kodeSuplaier"] ?>"><?= $ch["namaSuplaier"] ?></option>
										<?php }}?>
										<?php foreach($suplai as $ch){
										if($ch["kodeSuplaier"]!=$data[0]["kodeSuplaier"]){?>
												<option value="<?= $ch["kodeSuplaier"] ?>"><?= $ch["namaSuplaier"] ?></option>
										<?php }}?>
						</select>
					</div>
				</div>
				<div class="form-element">
					<div class="input-field">
						<label for="namaProduk">Nama Produk</label>
						<input type="text" name="namaProduk" id="namaProduk" value="<?php if(!isset($_POST["edit"])){echo $data[0]["namaProduk"];} else {echo $_POST["namaProduk"];}?>">
					</div>
					<div class="error-msg"><?php cekError($errors,"namaProduk");?></div>
				</div>
				<div class="form-element">
					<div class="input-field">
						<label for="gambar">Gambar lama</label>
						<div class="form-gambar">
							<img src="<?= BASEURL ?>/assets/img/product/<?= $data[0]['gambarProduk'] ?>" alt="">
						</div>
					</div>
				</div>
				<div class="form-element">
					<div class="input-field">
						<label for="gambar">Gambar baru</label>
						<input type="file" name="gambar" id="gambar">
					</div>
				</div>
				<div class="form-element">
					<div class="input-field">
						<label for="harga">Harga</label>
						<input type="text" name="harga" id="harga" value="<?php if(!isset($_POST["edit"])){echo $data[0]["hargaProduk"];} else {echo $_POST["harga"];}?>">
					</div>
					<div class="error-msg"><?php cekError($errors,"harga");?></div>
				</div>
				<div class="form-element">
					<div class="input-field">
						<label for="stok">Stok</label>
						<input type="text" name="stok" id="stok" value="<?php if(!isset($_POST["edit"])){echo $data[0]["stokProduk"];} else {echo $_POST["stok"];}?>">
					</div>
					<div class="error-msg"><?php cekError($errors,"stok");?></div>
				</div>
				<div class="form-element">
					<div class="input-field">
						<label for="deskripsi">Deskripsi</label>
						<textarea name="deskripsi" id="deskripsi"><?php if(!isset($_POST["edit"])){echo $data[0]["deskripsiProduk"];} else {echo $_POST["deskripsi"];}?></textarea>
					</div>
					<div class="error-msg"><?php cekError($errors,"deskripsi");?></div>
				</div>
				<div class="form-element">
					<div class="input-field button">
						<button type="submit" value="Edit" name="edit">Edit</button>
						<button onclick="location.href='product-data.php'" type="button" class="cancel">Cancel</button>
					</div>
				</div>
			</form>
		</div>

	</div>
</section>

<?php require_once 'templates/footer.php'; ?>
