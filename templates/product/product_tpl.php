<h2 class="title"><?=$title?></h2>
<?php if(count($product)==0) { ?>
	<div class="empty-page">** Nội dung đang được cập nhật ...</div>
<?php } ?>
<div class="row">
	<?php foreach ($product as $i => $item) {
		$funcLayout->setTbl('product');
		$funcLayout->setClass('item-custom item-product text-center');
		$funcLayout->setHvr('hvr-zoom');
		$funcLayout->infoTheme($type);
		$funcLayout->item($item);
		$funcLayout->setType($type);
		$funcLayout->setImage($theme->getDir(), $theme->getColumn(), $theme->getResize());
		echo $funcLayout->getTheme();
	} ?>
</div>
<div class="pagination"><?=$paging?></div>