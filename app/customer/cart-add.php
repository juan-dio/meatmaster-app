<?php
$page = 'product';
$title = 'Shopping Cart';
session_start();
?>

<?php require_once 'templates/header.php' ?>
<?php require_once 'templates/navbar.php' ?>

<?php
if (!$_GET['id']) {
  header('location: cart.php');
  exit();
}
$valid= selectData("SELECT * FROM orders WHERE kodePelanggan={$_SESSION['userID']} AND keterangan='belum'");
if($valid==[]){
  header("Location:product.php");
}

$produk = selectData("SELECT * FROM products WHERE kodeProduk={$_GET['id']}");

// cek apakah produk ada didatabase (url injection)
if($produk==[]){
  header('location: product.php');
  exit();
}

$cek = selectData("SELECT * FROM orderdetail WHERE kodePesanan={$_SESSION["kodePesanan"]} AND kodeProduk={$_GET['id']}");
if (isset($_POST['tambah'])) {
  if ($_SESSION['jumlah'] < $produk[0]["stokProduk"]) {
    $_SESSION['jumlah'] += 1;
  }
} else if (isset($_POST['kurang'])) {
  if ($_SESSION['jumlah'] > 1) {
    $_SESSION['jumlah'] -= 1;
  }
} else if (!isset($_POST['kurang']) && !isset($_POST['tambah']) && !isset($_POST['masukkan'])) {
  $_SESSION['jumlah'] = 1;
}
$_POST["jumlah"] = $_SESSION['jumlah'];
$_POST["kodeProduk"] = intval($_GET['id']);
$_POST["kodePesanan"] = $_SESSION["kodePesanan"];
$_POST["subHarga"] = $produk[0]['hargaProduk'] * $_SESSION["jumlah"];
if ($cek == []) {
  if (isset($_POST["masukkan"])) {
    $tambah = addOrderDetail($_POST);
    if ($tambah > 0) {
      echo '<div class="popup">
              <span class="success">Barang berhasil ditambahkan ke keranjang</span>
            </div>';
      header('Refresh: 2, url=product.php');
    }
  }
} else {
  echo '<div class="popup">
          <span class="success">Barang sudah ada di keranjang</span>
        </div>';
  header('Refresh: 2, url=cart.php');
}
?>

<?php 
// mengecek stok dari produk kosong atau tidak
if($produk[0]["stokProduk"]<=0){
  header('location: product.php');
  exit();
}
?>

<section>
  <div class="main-container">

    <div class="card-container">
      <h2>Jumlah Produk:</h2>
      <form method="post">
        <!-- Product List -->
        <div class="card-list flex">
          <div class="card">
            <div class="card-pict">
            <img src="<?= BASEURL ?>/assets/img/product/<?= $produk[0]['gambarProduk'] ?>" alt="product">
            </div>
            <div class="card-desc cart">
              <h3><?= $produk[0]['namaProduk'] ?></h3>
              <p class="prod-desc"><?= $produk[0]["deskripsiProduk"] ?></p>
              <p class="prod-stok">Stock: <?= $produk[0]["stokProduk"] ?></p>
              <p class="prod-price"><?= $produk[0]['hargaProduk'] * $_SESSION["jumlah"] ?></p>
            </div>
            <div class="act-product">
              <div class="quantity">
                <button type="submit" name="kurang" value="-" class="minus">-</button>
                <div class="amount"><?= $_SESSION["jumlah"] ?></div>
                <button type="submit" name="tambah" value="+" class="plus">+</button>
              </div>
              <button type="submit" name="masukkan" value="Masukkan Order" class="prod-button">
                <img src="<?= BASEURL  ?>/assets/img/cart-plus.png" alt="cart-minus">
              </button>
            </div>
          </div>
          <!-- end card list -->
        </div>
      </form>
      <!-- end card container -->
    </div>

  </div>
</section>

<?php require_once 'templates/footer.php'; ?>