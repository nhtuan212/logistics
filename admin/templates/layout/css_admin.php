<link href="<?=LIB?>sweetalert2/sweetalert2.min.css?<?=$func->random(12)?>" type="text/css" rel="stylesheet">
<link href="<?=ASSETS?>plugins/adminlte/adminlte.css?<?=$func->random(12)?>" type="text/css" rel="stylesheet">
<link href="<?=ASSETS?>plugins/holdon/HoldOn.min.css?<?=$func->random(12)?>" type="text/css" rel="stylesheet">
<link href="<?=ASSETS?>css/login.css?<?=$func->random(12)?>" type="text/css" rel="stylesheet">
<link href="<?=ASSETS?>css/style.css?<?=$func->random(12)?>" type="text/css" rel="stylesheet">
<?php if(@$config[$com][$type]['gallery']=='true' || @$config[$com."-lv".$level][$type]['gallery']=='true') { ?>
	<link href="<?=ASSETS?>plugins/filer/jquery.filer.css?<?=$func->random(12)?>" type="text/css" rel="stylesheet" />
<?php } ?>
<?php if($source == 'attribute' && @$config['attribute'][$type]['color']=='true') { ?>
	<link href="<?=ASSETS?>plugins/colorpicker/jquery.minicolors.css?<?=$func->random(12)?>" rel="stylesheet">
<?php } ?>
<?php if($source == 'order') { ?>
	<link href="<?=ASSETS?>plugins/daterangepicker/daterangepicker.css?<?=$func->random(12)?>" rel="stylesheet">
	<link href="<?=ASSETS?>plugins/rangeSlider/ion.rangeSlider.min.css?<?=$func->random(12)?>" rel="stylesheet">
<?php } ?>
<link href="<?=LIB?>fontawesome5.12.1/all.css?<?=$func->random(12)?>" type="text/css" rel="stylesheet" />
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
<script src="<?=LIB?>jquery.min.js"></script>