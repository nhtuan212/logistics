<!-- if($source != 'index') require_once LAYOUT."breadcrumbs.php"; -->
<?php
	// $crumbs = new BreadCrumbs($d);
	if($type == 'about') $breadcrumbs = $crumbs->setPage("gioi-thieu", _gioithieu, $type, "about");
	if($source == 'product')
	{
		if($type == 'product') $breadcrumbs = $crumbs->setPage("san-pham", _sanpham, $type, "product", @$level_cur);
	}
	if($source == 'post')
	{
		if($type == 'news') $breadcrumbs = $crumbs->setPage("tin-tuc", _tintuc, "post", $type, @$level_cur);
	}
	if($source == 'search') $breadcrumbs = $crumbs->setPage("", _timkiem, "", "");
	if($type == 'video') $breadcrumbs = $crumbs->setPage("video", "Video", "photo", $type);
	if($type == 'contact') $breadcrumbs = $crumbs->setPage("lien-he", _lienhe, "static", $type);
	$breadcrumbs = $crumbs->getBreadcrumbs();
?>

<section class="breadcrumb">
	<div class="container">
		<?=$breadcrumbs?>
	</div>
</section>