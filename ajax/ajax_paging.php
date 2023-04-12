<?php
	include "ajax_config.php";
	$pagingAjax->perpage = ($func->encode($_GET['perpage'])) ? $func->encode($_GET['perpage']) : 1;
	$type = $func->encode($_GET['type']);
	@$id_lv1 = $func->encode($_GET['id_lv1']);
	$where = "";
	if(@$id_lv1 > 0) @$where = " and id_lv1 = '".$id_lv1."'";
	$pageLink = "ajax/ajax_paging.php?perpage=".$pagingAjax->perpage."&type=".$type."&id_lv1=".$id_lv1."";

	$theme->setDir($config['theme'][$theme->getType()]['dir']);
	$theme->setColumn($config['theme'][$theme->getType()]['column']);
	$theme->setResize($config['theme'][$theme->getType()]['size']);

	$pagingAjax->sql = "select id, name$lang as name, tenkhongdau, photo, price, old_price, options from #_product where id<>0 $where and type='".$type."' and ".$func->findInSet('display', 'status')." order by number, id desc";
	$product = $pagingAjax->HandlingQuery();

	$HTML = '<div class="row">';
	foreach ($product as $i => $item) {
		$funcLayout->setTbl('product');
		$funcLayout->setClass('item-custom item-product text-center');
		$funcLayout->setHvr('hvr-zoom');
		$funcLayout->infoTheme($type);
		$funcLayout->item($item);
		$funcLayout->setType($type);
		$funcLayout->setImage($config['theme']['product']['dir'], $config['theme']['product']['column'], $theme->getResize());
		$HTML .= $funcLayout->getTheme();
	}
	$HTML .= '</div>';
	$HTML .= '<div class="pagination">'.$pagingAjax->getAllPageLinks($pageLink).'</div>';
	echo $HTML;
?>