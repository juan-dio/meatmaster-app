<?php
$page = 'product';
$title = 'Product Data';
?>

<?php require_once 'templates/header.php' ?>
<?php require_once 'templates/navbar.php' ?>

<?php 
$data = selectData(
	"SELECT * FROM products p 
	JOIN suplaier s ON (p.kodeSuplaier=s.kodesuplaier)
	JOIN categories c ON (c.kodeKategori=p.kodeKategori)"
);

if(isset($_GET['search'])) {
	$keyword = $_GET['keyword'];
	$data = selectData(
		"SELECT * FROM products p 
		JOIN suplaier s ON (p.kodeSuplaier=s.kodesuplaier)
		JOIN categories c ON (c.kodeKategori=p.kodeKategori)
		WHERE 
		p.namaProduk LIKE '%$keyword%' OR
		c.namaKategori LIKE '%$keyword%' OR
		s.namaSuplaier LIKE '%$keyword%'
		"
	);
}
?>

<section id="content">
	<div class="main-container">
		<form method="get">
			<div class="search">
				<input type="text" placeholder="Search product, categories, supplier" name="keyword">
				<button type="submit" name="search">
					<img src="<?= BASEURL  ?>/assets/img/search.png" alt="search">
				</button>
			</div>
		</form>

		<div class="card-container">
			<h2>List Produk:</h2>

			<!-- Product List -->
			<div class="card-list grid">
				<?php foreach($data as $ch): ?>
					<div class="card">
						<div class="card-pict">
							<img src="<?= BASEURL ?>/assets/img/product/<?= $ch['gambarProduk'] ?>" alt="<?= $ch["namaProduk"] ?>">
						</div>
						<div class="card-desc">
							<h3><?= $ch["namaProduk"] ?></h3>
							<p class="prod-sup"><?= $ch["namaSuplaier"] ?></p>
							<p class="prod-cate"><?= $ch["namaKategori"] ?></p>
							<p class="prod-desc"><?= $ch["deskripsiProduk"] ?></p>
							<p class="prod-stok">Stock: <?= $ch["stokProduk"] ?></p>
						</div>
						<div class="act-product">
							<p class="prod-price"><?= $ch["hargaProduk"] ?></p>
							<a href="product-edit.php?id=<?= $ch["kodeProduk"] ?>" class="prod-button">
								<img src="<?= BASEURL  ?>/assets/img/edit.png" alt="cart">
							</a>
							<a href="product-delete.php?id=<?= $ch["kodeProduk"];?>" class="prod-button delete">
								<img src="<?= BASEURL  ?>/assets/img/delete.png" alt="cart">
							</a>
						</div>
					</div>
				<?php endforeach; ?>
				<!-- end card List -->
			</div>
			<!-- end card container -->
		</div>

	</div>
</section>

	<a href="<?= BASEURL ?>/app/admin/product-add.php" class="box-link">
		<img src="<?= BASEURL  ?>/assets/img/plus.png" alt="plus">
		Add Product
	</a>

	<?php require_once 'templates/footer.php'; ?>