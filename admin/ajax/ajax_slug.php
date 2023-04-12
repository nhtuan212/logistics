<?php
	include ("ajax_config.php");
	$id = $func->decode($_POST['id']);
	$name = $func->decode($_POST['name']);
	$slug = $func->decode($_POST['slug']);
	$type = $func->decode($_POST['type']);
	$act = $func->decode($_POST['act']);
	($name && $type == 'check') ? $slug = $func->changeTitle($name) : $slug = $slug;
	if($act != 'copy' && $act != 'copy_category') $where = "and id<>'".$id."'";

	$arr_table = array('product', 'product_category', 'post', 'post_category');
	foreach($arr_table as $v => $tbl) {
		@$checkSlug = $d->rawQueryOne("select id, tenkhongdau from #_$tbl where id<>0 $where and tenkhongdau=?", array($slug));
		if($checkSlug) $return = 1;
		if(@$return == 1) break;
	}
	@$rs = ($return == 1) ? 'invalid' : 'success';
	$data = array('rs' => $rs, 'slug' => $slug);
	echo json_encode($data);
?>