<nav>
	<div class="nav-container admin">
		<a href="" class="logo">
			<img src="<?= BASEURL ?>/assets/img/meat.png" alt="meat-icon">
			<h1>MeatMaster<span>(admin)</span></h1>
		</a>
		<ul class="link-list">
			<li><a href="<?= BASEURL ?>/app/admin/product-data.php" class="<?php if ($page == 'product') echo 'link-active' ?>">Data Produk</a></li>
			<li><a href="<?= BASEURL ?>/app/admin/supplier-data.php" class="<?php if ($page == 'supplier') echo 'link-active' ?>">Data Supplier</a></li>
			<li><a href="<?= BASEURL ?>/app/admin/customer-data.php" class="<?php if ($page == 'customer') echo 'link-active' ?>">Data Customer </a></li>
			<li><a href="?Chongyun_x_REA_ATUH=Redirect_Sign_Out_Enabled" class="logout">Log out</a></li>
		</ul>
		<div class="hamburger-menu">
			<span></span>
			<span></span>
			<span></span>
		</div>
	</div>
</nav>
<?php signOut() ?>