<section class="cover-slider">
	<div class="slick__page slider" :show="1" :arrows="true" :fade="true" :animate="animate__fadeIn, animate__flipInX">
		<?php if (!empty($slider['slider'])) { ?>
			<?php foreach ($slider['slider'] as $i => $item) { ?>
				<div class="item-slider position-relative animate__animated">
					<a href="<?=$item['link']?>" target="_blank">
						<div class="img img-object">
							<?=$func->get_photo(array('dir' => UPLOAD_PHOTO_L,'photo' => $item['photo'],'name' => $item['name'],'resize' => '1366x500x1',)); ?>
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

<section class="cover-hotProduct py-4">
	<div class="container">
		<p class="title"><?=_sanphamnoibat?></p>
		<div class="paging-product" data-type="product"></div>
	</div>
</section>

<section class="cover-news py-4">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<p class="title"><?=_tintucnoibat?></p>
				<div class="row">
					<div class="col-md-6">
						<a href="<?=$hot_post['news'][0]['tenkhongdau']?>">
							<div class="img hvr-opa">
								<?=$func->get_photo(array('dir' => $config['theme']['news']['dir'],'photo' => $hot_post['news'][0]['photo'],'name' => $hot_post['news'][0]['name'],'resize' => '390x220x1',));?>
							</div>
							<div class="info">
								<h3 class="name my-2"><?=$hot_post['news'][0]['name']?></h3>
								<p class="desc line-2"><?=$hot_post['news'][0]['descript']?></p>
							</div>
						</a>
					</div>
					<div class="col-md-6 slick__page mt-n1" :show="3" :autoplay="false" :vertical="true">
						<?php if (!empty($hot_post['news'])) { ?>
							<?php foreach ($hot_post['news'] as $i => $item) { ?>
								<?php if($i > 0) { ?>
									<a class="item-news py-2" href="<?=$item['tenkhongdau']?>">
										<div class="row justify-content-between">
											<div class="img hvr-opa col-5 img-object">
												<?=$func->get_photo(array('dir' => $config['theme']['news']['dir'],'photo' => $item['photo'],'name' => $item['name'],'resize' => '150x110x1',)); ?>
											</div>
											<div class="info col-7">
												<h3 class="name line-1 mb-1"><?=$item['name']?></h3>
												<p class="desc line-3"><?=$item['descript']?></p>
											</div>
										</div>
									</a>
								<?php } ?>
							<?php } ?>
						<?php } ?>
					</div>
				</div>
			</div>

			<div class="col-md-4">
				<p class="title">Video</p>
				<?=$addon->addonOnline("", '100%', 255, "video", "slick")?>
			</div>
		</div>
	</div>
</section>