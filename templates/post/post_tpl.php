<h2 class="title"><?=$title?></h2>
<?php if(count($post)==0) { ?>
	<div class="empty-page">** Nội dung đang được cập nhật ...</div>
<?php } ?>
<div class="row">
	<?php foreach ($post as $i => $item) {
		$funcLayout->setTbl('post');
		$funcLayout->setClass('item-custom item-post');
		$funcLayout->setHvr('hvr-opa');
		$funcLayout->infoTheme('post');
		$funcLayout->item($item);
		$funcLayout->setType($type);
		$funcLayout->setImage($theme->getDir(), $theme->getColumn(), $theme->getResize());
		echo $funcLayout->getTheme();
	} ?>
</div>
<div class="pagination"><?=$paging?></div>