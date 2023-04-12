<section class="cover-partner py-4">
	<div class="container">
		<div class="slick__page" :show="6">
			<?php if (!empty($slider['partner'])) { ?>
				<?php foreach ($slider['partner'] as $i => $item) { ?>
					<a class="item-partner mx-1" href="<?=$item['link']?>" target="_blank">
						<?=$func->get_photo(array('dir' => UPLOAD_PHOTO_L,'photo' => $item['photo'],'name' => $item['name'],'resize' => '190x100x1',)); ?>
					</a>
				<?php } ?>
			<?php } ?>
		</div>
	</div>
</section>