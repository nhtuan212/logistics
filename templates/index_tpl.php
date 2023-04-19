<section class="cover-slider">
	<div class="slick__page slider" :show="1" :arrows="true" :fade="true" :animate="animate__fadeIn, animate__flipInX">
		<?php if (!empty($slider['slider'])) { ?>
			<?php foreach ($slider['slider'] as $i => $item) { ?>
				<div class="item-slider position-relative animate__animated">
					<a href="<?= $item['link'] ?>" target="_blank">
						<div class="img img-object">
							<?= $func->get_photo(array('dir' => UPLOAD_PHOTO_L, 'photo' => $item['photo'], 'name' => $item['name'], 'resize' => '1366x500x1',)); ?>
						</div>
						<?php /* ?>
						<div class="info d-flex justify-content-center align-items-center">
							<div>
								<h3 class="name animate__animated" data-animation="animate__fadeInUp" data-delay="0.8s"><?=$item['name']?></h3>
								<p class="desc animate__animated" data-animation="animate__fadeInRightBig" data-delay="1s"><?=$item['descript']?></p>
							</div>
						</div>
						<?php */ ?>
					</a>
				</div>
			<?php } ?>
		<?php } ?>
	</div>
</section>

<section class="cover-book-tour p-3">
	<div class="container bg-white p-md-4 p-2">
		<div class="title">Kính mời quý khách chọn thông tin cần tìm kiếm</div>
		<?php require_once LAYOUT . "newsletter.php"; ?>
	</div>
</section>

<?php /* ?>
<section class="cover-about py-4">
	<div class="container">
		<div class="row justify-content-between">
			<div class="col__1 col-md-5">
				<a class="img img-object" href="gioi-thieu"><?=$func->get_photo(array('dir' => UPLOAD_PHOTO_L,'photo' => $static['about']['photo'],'name' => $static['about']['name'],'resize' => '500x400x1',)); ?></a>
			</div>
			<div class="col__2 col-md-7">
				<h3 class="title text-left"><?=$static['about']['name']?></h3>
				<aside class="desc line-height-2"><div><?=$static['about']['descript']?></div></aside>
				<a class="xemthem none" href="gioi-thieu"><?=_xemthem?></a>
			</div>
		</div>
	</div>
</section>
<?php */ ?>

<?php /* ?>
<section class="cover-hotProduct py-4">
	<div class="container">
		<p class="title"><?=_sanphamnoibat?></p>
		<div class="paging-product" data-type="product"></div>
	</div>
</section>
<?php */ ?>

<section class="cover-hot-category py-4">
	<div class="container">
		<?php if (!empty($hot_category['product'])) { ?>
			<?php foreach ($hot_category['product'] as $j => $item_category) { ?>
				<div class="title mt-2"><?= $item_category['name'] ?></div>
				<div class="row slick__page" :show="5" :autoplay="false" :arrows="true" :lg-item="4" :md-item="3" :sm-item="2" :xs-item="2">
					<?php foreach ($hot_product['product'] as $i => $item) { ?>
						<?php if ($item['id_lv1'] == $item_category['id']) { ?>
							<a class=" item-product item-hot-product" href="<?= $item['tenkhongdau'] ?>">
								<div class="img hvr-zoom img-object">
									<?= $func->get_photo(array('dir' => $config['theme']['product']['dir'], 'photo' => $item['photo'], 'name' => $item['name'], 'resize' => '250x200x1',)); ?>
								</div>
								<div class="info p-2 position-relative">
									<h3 class="name mb-2 line-2"><?= $item['name'] ?></h3>
									<?php if (!empty($item['id_place_from'])) { ?>
										<div class="place_from text-white p-2"><?= $func->get_place('table_place_city', $item['id_place_from']) ?></div>
									<?php } ?>
									<?php if (!empty($item['date_tour'])) { ?>
										<div class="date_tour"><i class="far fa-clock mr-1"></i><?= $item['date_tour'] ?></div>
									<?php } ?>
									<?php if (!empty($item['date_from'])) { ?>
										<div class="date_from"><i class="far fa-calendar mr-1"></i><?= date('d/m/Y', $item['date_from']) ?></div>
									<?php } ?>
									<?php if (!empty($item['remain'])) { ?>
										<div class="remain"><i class="far fa-user mr-1"></i><?= $item['remain'] ?></div>
									<?php } ?>
									<p class="price text-right font-weight-bold"><?= $func->price($item['price'], $item['old_price']) ?></p>
								</div>
							</a>
						<?php } ?>
					<?php } ?>
				</div>
			<?php } ?>
		<?php } ?>
	</div>
</section>

<section class="cover-news py-4">
	<div class="container">
		<div class="row">
			<div class="col-md-8 mb-3">
				<div class="d-flex flex-wrap">
					<div class="col-sm-4 mb-2">
						<p class="title text-md"><?= _tintuc ?> & cẩm nang du lịch</p>
						<a href="<?= $hot_post['news'][0]['tenkhongdau'] ?>">
							<div class="info">
								<h3 class="name mt-2 mb-3 line-3"><?= $hot_post['news'][0]['name'] ?></h3>
								<p class="desc line-8"><?= $hot_post['news'][0]['descript'] ?></p>
							</div>
						</a>
					</div>
					<div class="col-sm-8 mb-2">
						<a href="<?= $hot_post['news'][0]['tenkhongdau'] ?>">
							<div class="img">
								<?= $func->get_photo(array('dir' => $config['theme']['news']['dir'], 'photo' => $hot_post['news'][0]['photo'], 'name' => $hot_post['news'][0]['name'], 'resize' => '500x350x1',)); ?>
							</div>
						</a>
					</div>
				</div>
			</div>
			<div class="col-md-4 slick__page mt-n1 mb-3" :show="3" :autoplay="false" :autoplay="false" :vertical="true">
				<?php if (!empty($hot_post['news'])) { ?>
					<?php foreach ($hot_post['news'] as $i => $item) { ?>
						<?php if ($i > 0) { ?>
							<a class="item-news py-2" href="<?= $item['tenkhongdau'] ?>">
								<div class="row justify-content-between">
									<div class="img col-5 img-object">
										<?= $func->get_photo(array('dir' => $config['theme']['news']['dir'], 'photo' => $item['photo'], 'name' => $item['name'], 'resize' => '150x105x1',)); ?>
									</div>
									<div class="info col-7">
										<h3 class="name line-3"><?= $item['name'] ?></h3>
										<?php /* ?><p class="desc line-3"><?= $item['descript'] ?></p><?php */ ?>
									</div>
								</div>
							</a>
						<?php } ?>
					<?php } ?>
				<?php } ?>
			</div>
		</div>
</section>

<section class="cover-partner py-md-4 py-2">
	<div class="container">
		<div class="title text-center">Khách hàng tiêu biểu</div>
		<?php if (!empty($slider['partner'])) { ?>
			<div class="slick__page" :show="6" :autoplay="false" :autoplay="true" :vertical="false" :lg-item="5" :md-item="4" :sm-item="3" :xs-item="2">
				<?php foreach ($slider['partner'] as $i => $item) { ?>
					<div class="item-partner col">
						<a href="<?= $item['link'] ?>" target="_blank">
							<div class="img img-object">
								<?= $func->get_photo(array('dir' => UPLOAD_PHOTO_L, 'photo' => $item['photo'], 'name' => $item['name'], 'resize' => '250x150x1',)); ?>
							</div>
						</a>
					</div>
				<?php } ?>
			</div>
		<?php } ?>
</section>