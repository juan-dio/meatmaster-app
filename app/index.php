<?php 
require('base.php');
$page = 'index';
$title = 'Halaman Utama'
?>
<?php require('templates/header.php') ?>

<section id="homepage">

  <div class="main-logo">
    <img src="../assets/img/meat.png" alt="meat">
    <h1>MeatMaster</h1>
  </div>

  <div class="link-login">
    <a href="<?= BASEURL ?>/app/login.php">Login</a>
  </div>

</section>

<main>

  <div class="p1">
    <img src="../assets/img/meat.jpg" alt="meat">
    <p>
    Selamat datang di MeatMaster, destinasi utama Anda untuk pengalaman berbelanja daging yang tak tertandingi secara online! Di MeatMaster, kami menghadirkan koleksi daging pilihan terbaik dari sumber terpercaya, memastikan kualitas prima dan kelezatan yang tak terkalahkan. Dari daging sapi mewah hingga ayam segar, kami dengan bangga menyajikan produk-produk unggulan untuk memenuhi segala kebutuhan dapur Anda. Dengan layanan pengiriman cepat dan packaging yang aman, MeatMaster berkomitmen memberikan pengalaman belanja online yang nyaman dan memuaskan bagi para pecinta daging.
    </p>
  </div>

  <p>
  Selain menyediakan daging-daging berkualitas tinggi, MeatMaster juga menawarkan berbagai promosi menarik dan paket hemat yang memanjakan pelanggan setia kami. Dengan antusiasme untuk memberikan yang terbaik, MeatMaster bukan hanya sekadar toko online daging biasa, melainkan destinasi terpercaya bagi mereka yang menghargai kualitas, keamanan, dan kepraktisan dalam setiap pembelian daging secara online. Selamat berbelanja dan nikmati kelezatan sejati bersama MeatMaster!
  </p>

  <p>
  Di MeatMaster, kepuasan pelanggan adalah prioritas utama kami. Tim ahli kami selalu siap memberikan panduan dan rekomendasi untuk memastikan Anda mendapatkan daging sesuai keinginan dan kebutuhan Anda. Kami mengutamakan transparansi dan kejujuran dalam setiap transaksi, sehingga Anda dapat berbelanja dengan percaya diri, mengetahui bahwa setiap potongan daging yang Anda pilih telah melewati standar ketat kami untuk keamanan dan kualitas. Dengan MeatMaster, Anda tidak hanya membeli daging, tetapi juga membangun pengalaman kuliner yang istimewa dan tak terlupakan di meja makan Anda. Sambut kelezatan dengan MeatMaster, di mana kualitas dan pelayanan tak tertandingi menjadi kebiasaan.
  </p>

</main>



<?php require('templates/footer.php') ?>