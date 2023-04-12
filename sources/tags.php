<?php
	if(!defined('SOURCE')) die("Error");
	$tags = $d->rawQueryOne("select id, name$lang as name from #_attribute where id=?", array($id));
	$title = $tags['name'];

	$product = $d->rawQueryOne("select count(id) from #_product where FIND_IN_SET(".$id.", tags_group) and FIND_IN_SET('display', status) order by number,id desc");
	$totalRows = $product['count(id)'];
	$page = (isset($_GET['p']) && $_GET['p'] != "") ? $_GET['p'] : 1;
	$page --;
	$pageSize = $optsetting['qpro_ins'];
	$bg = $page * $pageSize;
	$product = $d->rawQuery("select * from #_product where FIND_IN_SET(".$id.", tags_group) and type=? order by number, id desc", array($type));
	$paging = $func->paging($totalRows, $pageSize);
?>