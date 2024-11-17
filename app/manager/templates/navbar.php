<nav>
	<div class="nav-container">
		<a href="" class="logo">
			<img src="<?= BASEURL ?>/assets/img/meat.png" alt="meat-icon">
			<h1>MeatMaster<span>(manager)</span></h1>
		</a>
		<ul class="link-list">
			<li><a href="<?= BASEURL ?>/app/manager/transaction-paid.php" class="<?php if ($page == 'paid') echo 'link-active' ?>">Sudah Dibayar</a></li>
			<li><a href="<?= BASEURL ?>/app/manager/transaction-unpaid.php" class="<?php if ($page == 'unpaid') echo 'link-active' ?>">Belum Dibayar</a></li>
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