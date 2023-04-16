<?php  if(!defined('SOURCE')) die("Error");
	if($category){$level_cur = $category['level'];}
	if($pro_detail){$level_cur = $config['theme'][$type]['level'];}
	$where = " type = '".$type."'";

	if($category)
	{
		$level = $category['level'];
		$photo = ($category['photo']) ? CACHE.'300x200x2/'.UPLOAD_PRODUCT_L.$category['photo'] : '';
		$where .= " and id_lv$level='".$category['id']."'";
	}
	if($pro_detail)
	{
		$title_other = 'Tour liên quan';
		$d->rawQuery("update #_product SET view=view+1 WHERE tenkhongdau=?", array($com));
		$size = $d->rawQuery("select id, name$lang as name, attribute from #_attribute where FIND_IN_SET('display', status) and id_parent=? and type=? order by number,id desc", array($pro_detail['id'], 'size'));
		$color = $d->rawQuery("select id, name$lang as name, attribute from #_attribute where FIND_IN_SET('display', status) and id_parent=? and type=? order by number,id desc", array($pro_detail['id'], 'color'));
		$pro_gallery = $d->rawQuery("select id, name, photo from #_gallery where id_parent=? and type=? and FIND_IN_SET('display', status) order by number,id desc", array($pro_detail['id'], $type));

		$photo = ($pro_detail['photo']) ? CACHE.'300x200x2/'.UPLOAD_PRODUCT_L.$pro_detail['photo'] : '';
		$watermark_link = (strpos($config['theme'][$type]['size'], WATERMARK) !== false) ? WATERMARK.'product/500x400x1/' : '';
		$watermark_resize = (strpos($config['theme'][$type]['size'], WATERMARK) !== false) ? WATERMARK.'product/500x400x1' : '500x400x1';

		// Sản phẩm vừa xem
	    // @$func->product_seen($pro_detail['id']);
	    // @$product_seen = $d->rawQuery("select id, name$lang as name, tenkhongdau, photo, gia, giacu, view, sock, khuyenmai from #_product where FIND_IN_SET('display', status) and type='product' and FIND_IN_SET(id, '".$func->joinAttr($_SESSION['product-seen'], 'id')."') order by number, id desc");
		$where .= " and id<>'".$pro_detail['id']."' and id_lv1='".$pro_detail['id_lv1']."'";
	}

	$product = $d->rawQueryOne("select count(id) from #_product where $where and FIND_IN_SET('display', status) order by number,id desc");
	$totalRows = $product['count(id)'];
	$page = (isset($_GET['p']) && $_GET['p'] != "") ? $_GET['p'] : 1;
	$page --;
	$pageSize = $optsetting['qpro_ins'];
	$bg = $page * $pageSize;
	$product = $d->rawQuery("select id, name$lang as name, tenkhongdau, descript$lang as descript, photo, price, old_price, place_from$lang as place_from, date_tour, remain, date_from from #_product where $where and FIND_IN_SET('display', status) order by number,id desc limit $bg, $pageSize");
	$paging = $func->paging($totalRows, $pageSize);

	// Seo
	$seo->Set(
		array(
			'type' => ($category || $pro_detail) ? $type : 'page_'.$type,
			'level' => !empty($level) ? $level : 0,
			'photo' => ($category || $pro_detail) ? $config_url_http.$photo : '',
		)
	);
?>