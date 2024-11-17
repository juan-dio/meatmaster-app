<nav>
	<div class="nav-container">
		<a href="" class="logo">
			<img src="<?= BASEURL ?>/assets/img/meat.png" alt="meat-icon">
			<h1>MeatMaster</h1>
		</a>
		<ul class="link-list">
			<li><a href="<?= BASEURL ?>/app/customer/product.php" class="<?php if ($page == 'product') echo 'link-active' ?>">Daftar Produk</a></li>
			<li><a href="<?= BASEURL ?>/app/customer/categories.php" class="<?php if ($page == 'categories') echo 'link-active' ?>">Kategori</a></li>
			<li><a href="<?= BASEURL ?>/app/customer/transaction.php" class="<?php if ($page == 'transaction') echo 'link-active' ?>">Transaksi</a></li>
			<li><a href="<?= BASEURL ?>/app/customer/profil.php" class="<?php if ($page == 'profil') echo 'link-active' ?>">Profil</a></li>
			<li><a href="?Chongyun_x_REA_ATUH=Redirect_Sign_Out_Enabled" class="logout">Log out</a></li>
		</ul>
		<div class="hamburger-menu">
			<span></span>
			<span></span>
			<span></span>
		</div>
	</div>
</nav>

<?php signOut(); ?>