<section class="cover-menu">
	<div class="menu-mobile">
		<div class="d-flex justify-content-between">
			<a class="bar" href="#"><i class="fa fa-bars"></i></a>
			<?php /* ?>
			<a href="gio-hang">
				<i class="fas fa-shopping-cart"></i>
				<span>(<?=$countCart?>)</span>
			</a>
			<?php */ ?>
		</div>
	</div>

	<div class="menu nav-menu container d-block">
		<ul class="d-flex justify-content-center align-items-center">
			<!-- <li class="search d-flex justify-content-between">
		        <input class="keyword" onKeyPress="doEnter(event);" placeholder="<?= _timkiem ?>">
		        <i class="fa fa-search" onclick="onSearch(event);"></i>
		    </li> -->

			<li class="backInLeft">
				<a class="<?= ($com == '' || $com == 'index') ? "active" : "" ?>" href=""><?= _trangchu ?></a>
			</li>

			<?= $func->ShowMultiMenu("product", "product", $config['theme']['product']['level']); ?>

			<li class="backInLeft">
				<a class="<?= ($type == 'service') ? "active" : "" ?>" href="dich-vu"><?= _dichvu ?></a>
			</li>

			<li class="backInLeft">
				<a class="<?= ($type == 'contact') ? "active" : "" ?>" href="lien-he"><?= _lienhe ?></a>
			</li>
		</ul>
	</div>
</section>