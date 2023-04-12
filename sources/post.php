<?php  if(!defined('SOURCE')) die("Error");
	if($category){@$level_cur = $category['level'];}
	if($post_detail){@$level_cur = $config['theme'][$type]['level'];}
	$where = " type = '".$type."'";

	if($category)
	{
		$level = $category['level'];
		$photo = ($category['photo']) ? CACHE.'300x200x2/'.UPLOAD_PRODUCT_L.$category['photo'] : '';
		$where = " type='".$type."' and id_lv$level='".$category['id']."'";
	}
	
	if($post_detail)
	{
		$title_other = _tinlienquan;
		$d->rawQuery("update #_post SET view=view+1 WHERE tenkhongdau=?", array($com));
		$post_gallery = $d->rawQuery("select id, name, photo from #_gallery where id_parent=? and type=? and FIND_IN_SET('display', status) order by number,id desc", array($post_detail['id'], $type));
		$photo = ($post_detail['photo']) ? CACHE.'300x200x2/'.UPLOAD_PRODUCT_L.$post_detail['photo'] : '';
		$where = " type='".$type."' and id<>'".$post_detail['id']."' and id_lv1='".$post_detail['id_lv1']."'";
	}

	$post = $d->rawQueryOne("select count(id) from #_post where $where and FIND_IN_SET('display', status) order by number,id desc");
	$totalRows = $post['count(id)'];
	$page = (isset($_GET['p']) && $_GET['p'] != "") ? $_GET['p'] : 1;
	$page --;
	$pageSize = $optsetting['qpost_ins'];
	$bg = $page * $pageSize;
	$post = $d->rawQuery("select id, name$lang as name, tenkhongdau, descript$lang as descript, photo, type from #_post where $where and FIND_IN_SET('display', status) order by number,id desc limit $bg, $pageSize");
	$paging = $func->paging($totalRows, $pageSize);

	$seo->Set(
		array(
			'type' => ($category || $pro_detail) ? $type : 'page_'.$type,
			'level' => !empty($level) ? $level : 0,
			'photo' => ($category || $pro_detail) ? $config_url_http.$photo : '',
		)
	);
?>