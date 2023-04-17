<!-- Base JS -->
<script type="text/javascript">
	var _BASE = _BASE || {};
	<?php /* ?>
		var _CART = _CART || {};
	<?php */ ?>
	var _ALT_IMAGE = '<?=@$optsetting['name']?>';
	var _PLACEHOLDER_SEARCH = '<?=_nhaptukhoa?>';
	var _LANG = '<?=@$lang?>';
	var _RESPONSIVE = '<?=@$config['developer']['responsive']?>';
	var _MOBILE = '<?=@$config['developer']['mobile']?>';
	var _SOURCE = '<?=@$source?>';
	var _TEMPLATE = '<?=@$template?>';
	var _SOURCE_INDEX = <?=($source == 'index') ? "true" : "false" ?>;
	var _COUNT_PRODUCT = '<?=$optsetting['qpro_ins']?>';
	<?php /* ?>
		var _CHOSE_SIZE = "<?=_chonsize?>";
		var _CHOSE_COLOR = "<?=_chonmau?>";
		var _SUCCESS_ADD_CART = "<?=_themgiohangthanhcong?>";
		var _GET_CURRENT_PAGE = "<?=$func->getCurrentPageURL()?>";
	<?php */ ?>
	if(_TEMPLATE == 'product/product_detail') {
		var mzOptions = {
			zoomMode: "off",
			hint: "off",
			rightClick: true,
		};
	}
</script>
<?php
	$JSminifier->cacheFile(LIB."sweetalert2/sweetalert2.min.js");
	$JSminifier->cacheFile(LIB."bootstrap/bootstrap.bundle.min.js");
	$JSminifier->cacheFile(ASSETS."plugins/slick/slick.js");
	$JSminifier->cacheFile(ASSETS."plugins/menutoggle/menutoggle.js");
	$JSminifier->cacheFile(ASSETS."plugins/magiczoomplus/magiczoomplus.js");
	$JSminifier->cacheFile('admin/'.ASSETS."plugins/daterangepicker/moment.min.js");
	$JSminifier->cacheFile('admin/'.ASSETS."plugins/daterangepicker/daterangepicker.js");
	$JSminifier->cacheFile(ASSETS."js/bundle.js");
	// $JSminifier->cacheFile(ASSETS."js/cart.js");
	echo $JSminifier->minify();
?>
<?php if($source != 'index') { ?>
    <script type="text/javascript">
    	setTimeout(function(){
    		var addthis_config = addthis_config || {};
    		addthis_config.lang = _LANG;
    		$(".share-toolbox").addClass("addthis_inline_share_toolbox_kvb6");

    		var script = document.createElement('script');
    		script.src = "//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5c789e8673f1c09c";
    		script.type = 'text/javascript';
    		document.getElementsByTagName('body')[0].appendChild(script);
    	}, 1000);
    </script>
<?php } ?>
<?php if($com=='lien-he' && $PHP_SELF=="") { ?>
	<script src="https://www.google.com/recaptcha/api.js?render=<?=$optsetting['site_key']?>"></script>
    <script type="text/javascript">
    	grecaptcha.ready(function () {
			grecaptcha.execute('<?=$optsetting['site_key']?>', { action: 'contact' }).then(function (token) {
				var recaptchaResponse = document.getElementById('recaptchaResponse');
				recaptchaResponse.value = token;
			});
		});
    </script>
<?php } ?>