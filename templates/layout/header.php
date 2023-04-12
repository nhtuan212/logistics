<header class="cover-header" style="background: url(<?=$func->get_photoSelect('bg-header', '1366x150x1')?>) center/cover no-repeat;">
	<section class="box-header py-3">
		<div class="container">
			<div class="d-flex justify-content-between align-items-center flex-wrap">
				<a href="" class="logo"><img src="<?=$func->get_photoSelect('logo', '100x100x1')?>"/></a>
				<img class="banner" src="<?=$func->get_photoSelect('banner', '300x100x1')?>"/>
				<div class="info">
					<div class="hotline"><?=$optsetting['phone']?></div>
					<div class="lang mt-2 d-flex justify-content-end">
						<a href="<?=$func->lang("")?>" class="mr-2"><img src="<?=ASSETS?>images/lang-vi.png" alt="Việt Nam"/></a>
						<a href="<?=$func->lang("en")?>"><img src="<?=ASSETS?>images/lang-en.png" alt="Tiếng Anh"/></a>
					</div>
				</div>
			</div>
		</div>
	</section>
</header>