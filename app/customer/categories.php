<?php 
$page = 'categories';
$title = 'Product Categories';
session_start();
?>

<?php require_once 'templates/header.php' ?>
<?php require_once 'templates/navbar.php' ?>

<?php 
$data = selectData("SELECT * FROM categories");

if(isset($_GET['search'])) {
	$keyword = $_GET['keyword'];
	$data = selectData(
		"SELECT * FROM categories 
    WHERE
		namaKategori LIKE '%$keyword%'
		"
	);
}

?>

<section>
    <div class="main-container">
      <form method="get">
        <div class="search">
          <input type="text" placeholder="Search categories" name="keyword">
          <button type="submit" name="search">
            <img src="<?= BASEURL  ?>/assets/img/search.png" alt="search">
          </button>
        </div>
      </form>
      
      <div class="card-container">
        <h2>List Kategori:</h2>

        <!-- Product List -->
        <div class="card-list flex">
          <?php foreach($data as $ch): ?>
          <div class="card categories">
            <div class="card-desc no-pict">
              <h3><?= $ch["namaKategori"] ?></h3>
            </div>
            <div class="browse-product">
              <a href="product.php?kategori=<?= $ch["kodeKategori"] ?>" class="goto-product">
                Product List
              </a>
            </div>
          </div>                    
          <?php endforeach; ?>

        </div>

      </div>

    </div>
  </section>

<?php require_once 'templates/footer.php'; ?>