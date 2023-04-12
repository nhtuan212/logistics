<?php
	$CSSminifier->cacheFile("admin/".ASSETS."plugins/adminlte/adminlte.css");
	$CSSminifier->cacheFile(ASSETS."plugins/slick/slick.css");
	$CSSminifier->cacheFile(ASSETS."plugins/magiczoomplus/magiczoomplus.css");
	$CSSminifier->cacheFile(ASSETS."css/animate.css");
	$CSSminifier->cacheFile(ASSETS."plugins/menutoggle/menutoggle.css");
	$CSSminifier->cacheFile(ASSETS."css/custom.css");
	$CSSminifier->cacheFile(ASSETS."css/style.css");
	$CSSminifier->cacheFile(ASSETS."css/media.css");
	$CSSminifier->cacheFile(LIB."fontawesome5.12.1/all.css");
	$CSSminifier->cacheFile(LIB."sweetalert2/sweetalert2.min.css");
	echo $CSSminifier->minify();
?>
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
<script src="<?=LIB?>jquery.min.js" type="text/javascript"></script>