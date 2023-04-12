<?php
	if(!defined('SOURCE')) die("Error");
	if($_GET['keyword'])
	{
		$keyword = $_GET['keyword'];
		$where = " (name$lang LIKE '%$keyword%' or code LIKE '%$keyword%') and type='".$type."' and FIND_IN_SET('display', status) order by number,id desc";

		$page_count = $d->rawQueryOne("select count(id) from #_product where $where");
		$totalRows = $page_count['count(id)'];
		$page = (isset($_GET['p']) && $_GET['p'] != "") ? $_GET['p'] : 1;
		$page --;
		$pageSize = $optsetting['qpro_ins'];
		$bg = $page * $pageSize;
		$product = $d->rawQuery("select id, name$lang as name, descript$lang as descript, tenkhongdau, photo, price, old_price from #_product where $where limit $bg, $pageSize");
		$paging = $func->paging($totalRows, $pageSize);
	}

	$seo->Set(
		array(
			'type' => 'page_'.$type,
			'level' => 0,
			'photo' => !empty($photo) ? $config_url_http.$photo : '',
		)
	);
?>