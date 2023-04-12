<section class="cover-category">
	<?php if (!empty($hot_category['product'])) { ?>
		<?php foreach ($hot_category['product'] as $j => $item_lv1) { ?>
			<div class="box-category py-2">
				<div class="container">
					<p class="title"><?=$item_lv1['name']?></p>
					<a class="xemthem none" href="<?=$item_lv1['tenkhongdau']?>">Xem thêm</a>
					<div class="row">
						<?php if (!empty($custom_product['product'])) {
							foreach ($custom_product['product'] as $i => $item) {
								if ($item['id_lv1'] == $item_lv1['id']) {
									$funcLayout->setTbl('product');
									$funcLayout->setClass('item-custom item-product text-center');
									$funcLayout->setHvr('hvr-zoom');
									$funcLayout->infoTheme('product');
									$funcLayout->item($item);
									$funcLayout->setType($type);
									$funcLayout->setImage($config['theme']['product']['dir'], $config['theme']['product']['column'], $config['theme']['product']['size']);
									echo $funcLayout->getTheme();
								}
							}
						} ?>
					</div>
				</div>
			</div>
		<?php } ?>
	<?php } ?>
</section>