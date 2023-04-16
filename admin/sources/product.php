<?php
	if(!defined('SOURCE')) $error_404 = true;
	@define ( 'DIR' , UPLOAD_PRODUCT);
	@define ( 'DIR_CATEGORY' , UPLOAD_PRODUCT_L);
	@$com = $func->decode($_REQUEST['com']);
	@$act = $func->decode($_REQUEST['act']);
	@$id = $func->decode($_REQUEST['id']);
	@$type = $func->decode($_REQUEST['type']);
	@$p = ($func->decode($_REQUEST['p'])) ? "&p=".$func->decode($_REQUEST['p']) : "";
	@$level = empty($_REQUEST['level']) ? 0 : $func->decode($_REQUEST['level']);
	@$level_url = empty($_REQUEST['level']) ? "" : '&level='.$level;
	@$level_com = empty($_REQUEST['level']) ? "" : '-lv'.$level;
	@$case = empty($_REQUEST['level']) ? "" : '_category';
	@$tbl = empty($_REQUEST['level']) ? 'product' : 'category';
	if(!empty($level)) require_once SOURCE."category.php";
	for($i=0; $i < @$config[$com][$type]['level']; $i++) {
		@$id_lv .= ($func->decode($_REQUEST['id_lv'.($i+1)])) ? "&id_lv".($i+1)."=".$func->decode($_REQUEST['id_lv'.($i+1)]) : "";
	}

	@$current_url = "index.php?com=$com&act=$act&type=$type$level_url$p";
	@$link = "index.php?com=$com&act=man$case&type=$type$level_url$p";
	@$delete = "index.php?com=$com&act=delete$case&type=$type$level_url$p";

	@$w = $config[$com.$level_com][$type]['photo_width'];
	@$h = $config[$com.$level_com][$type]['photo_height'];
	@$zc = "1";
	@$resize = $w."x".$h."x".$zc;

	error_404('product');
	if($error_404) return false;
	switch($act){
		case 'man'.$case: RouteAD::get(SOURCE.'@'.$tbl.'/item', empty($_REQUEST['level']) ? get_item() : get_category()); break;
		case 'add'.$case: RouteAD::get(SOURCE.'@'.$tbl.'/item_add'); break;
		case 'copy'.$case:
		case 'edit'.$case: RouteAD::get(SOURCE.'@'.$tbl.'/item_add', empty($_REQUEST['level']) ? edit_item() : edit_category()); break;
		case 'save_copy'.$case:
		case 'save'.$case: RouteAD::get('', empty($_REQUEST['level']) ? save_item() : save_category()); break;
		case 'delete'.$case: RouteAD::get('',  empty($_REQUEST['level']) ? delete_item() : delete_category()); break;
		default: $error_404 = true;
	}

	function get_item()
	{
		global $func, $d, $config, $tbl, $product, $totalRows , $pageSize, $offset, $paging, $type;
		foreach($config['website']['lang'] as $lang => $value)
		{
			foreach($config['product'][$type]['text'] as $column => $value)
			{
				if($value['lang']==true) $column = $column.$lang;
				else $column = $column;
				$data_type = $value['data_type'];
				$length = $value['length'];
				if($length) $length = $value['length'];
				$show_text = $d->rawQueryOne("show columns from #_$tbl like ?", array($column));
				if($show_text == null) $d->rawQuery("alter table #_$tbl ADD ".$column." ".$data_type.$length."");
			}
		}

		if($type) $where=" and type='".$type."'";
		if(@$_REQUEST['keyword']) $where.=" and name like '%".$_REQUEST['keyword']."%'";
		for($i=0; $i < $config['product'][$type]['level']; $i++) { 
			if(@(int)$_REQUEST['id_lv'.($i+1)]) $where.=" and id_lv".($i+1)."=".(int)$_REQUEST['id_lv'.($i+1)]."";
		}
		$where.= " order by number, id desc";

		$items = $d->rawQueryOne("select count(id) from #_$tbl where id<>0 $where");
		$totalRows = $items['count(id)'];
		$page = (isset($_GET['p']) && $_GET['p'] != "") ? $_GET['p'] : 1;
		$page --;
		$pageSize = 15;
		$bg = $page * $pageSize;
		$product = $d->rawQuery("select * from #_$tbl where id<>0 $where limit $bg,$pageSize");	
		$paging = $func->paging($totalRows, $pageSize);
	}
	function edit_item()
	{
		global $func, $d, $tbl, $item, $item_seo, $options, $link, $type, $error_404;
		$id = $func->decode($_GET['id']);
		$item = $d->rawQueryOne("select * from #_$tbl where id=?", array($id));
		$item_seo = $d->rawQueryOne("select * from #_seo where id_parent=? and type=? and level=?", array($id, $type, 0));
		$options = (isset($item['options']) && $item['options'] != '') ? json_decode($item['options'],true) : null;
		if(!$item) $error_404 = true;
	}
	function save_item()
	{
		global $func, $d, $config, $act, $tbl, $type, $link;
		@$data_seo = $_POST['data_seo'];
		@$id = $_POST['id'];
		@$slug = $_POST['slug'];

		if($_POST['data'])
		{
			foreach($_POST['data'] as $column => $value)
			{
				if(is_array($value))
				{
					foreach($value as $info => $info_value)
					{
						$options[$info] = (!empty($info_value)) ? $info_value : "0";
					}
					$data[$column] = json_encode($options);
				}
				else
				{
					$data[$column] = $func->encode($value);
				}
			}
		}
		
		@$photo_name = $func->images_name($_FILES['photo']['name']);
		@$file_name = $func->images_name($_FILES['file']['name']);
		if(@$photo = $func->upload_image("photo", FORMAT_IMAGE, DIR, $photo_name)) $data['photo'] = $photo;
		if(@$file = $func->upload_image("file", FORMAT_DOCUMENT, UPLOAD_FILE,$file_name)) $data['file'] = $file;
		@$data['price'] = ($data['price'] != "") ? $data['price'] : "0";
		@$data['old_price'] = ($data['old_price'] != "") ? $data['old_price'] : "0";
		
		$date_arr = explode("/", $_POST['date_from']);
		$date_from = $date_arr[0] . "-" . $date_arr[1] . "-" . $date_arr[2];
		@$data['date_from'] = (!empty($date_from)) ? strtotime($date_from) : "0";
		
		@$data['tags_group'] = ($_POST['tags_group']) ? rtrim(implode(",", $_POST['tags_group']), ",") : "";
		if(!empty($_POST['status']))
		{
			foreach($_POST['status'] as $attr_column => $attr_value) if($attr_value != "") @$status .= $attr_value.',';
			@$data['status'] = (!empty($status)) ? rtrim($status, ",") : "";
		}
		
		if($id && $act != "save_copy")
		{
			$product = $d->rawQueryOne("select photo, file from #_$tbl where id=?", array($id));
			if(@$data['photo'] && $product) $func->delete_file(DIR.$product['photo']);
			if(@$data['file'] && $product) $func->delete_file(UPLOAD_FILE.$product['file']);

			if($config['product'][$type]['slug']==true)
			{
				if($slug) $data['tenkhongdau'] = $func->changeTitle($data['name']);
				else $data['tenkhongdau'] = $func->changeTitle($data['tenkhongdau']);
			}
			else $data['tenkhongdau'] = $func->changeTitle($data['name']);
			$data['date_updated'] = time();

			$d->where('id', $id);
			if(!$d->update($tbl, $data)) $func->transfer("Đã có lỗi xảy ra. Vui lòng thử lại sau", $link, "error");
		}
		else
		{
			$data['tenkhongdau'] = $func->changeTitle($data['name']);
			$data['date_created'] = time();
			if(!$d->insert($tbl, $data)) $func->transfer("Đã có lỗi xảy ra. Vui lòng thử lại sau", $link, "error");
			$id = $d->getLastInsertId();
		}
		if($data_seo)
		{
			$d->rawQuery("delete from #_seo where id_parent=? and type=? and level='0'", array($id, $type));
			$data_seo['id_parent'] = $id;
			$data_seo['type'] = $type;
			$data_seo['level'] = 0;
			if(!$d->insert('seo', $data_seo)) $func->transfer("Không cập nhật được Gallery", $link, "error");			
		}
		if($_FILES['files'])
		{
			for($i=0; $i<count($_FILES['files']['name']); $i++)
			{
				$gallery_name = $func->images_name($_FILES['files']['name'][$i]);
				if(move_uploaded_file($_FILES['files']["tmp_name"][$i], UPLOAD_GALLERY.$gallery_name))
				{
					$data_gallery['photo'] = $gallery_name;
					@$data_gallery['name'] = $_POST['name'][$i];
					@$data_gallery['number'] = ($_POST['number'][$i]) ? $_POST['number'][$i] : 1;
					$data_gallery['type'] = $type;
					$data_gallery['id_parent'] = $id;
					$data_gallery['status'] = 'display';
					$d->insert('gallery', $data_gallery);
				}
			}
		}
		redirect($link);
	}
	function delete_item()
	{
		global $func, $d, $config, $tbl, $type, $level, $link;
		$id = $func->decode($_GET['id']);
		$list_id = $func->decode($_GET['list_check']);
		if($id)
		{
			$product = $d->rawQueryOne("select id, photo, file from #_$tbl where id=?", array($id));
			$gallery = $d->rawQuery("select id, photo from #_gallery where id_parent=? and level=0", array($id));

			$func->delete_file(DIR.$product['photo']);
			$func->delete_file(UPLOAD_FILE.$product['file']);
			foreach($gallery as $i => $value) $func->delete_file(UPLOAD_GALLERY.$value['photo']);
			$d->rawQueryOne("delete from #_$tbl where id=?", array($id));
			$d->rawQueryOne("delete from #_seo where id_parent=? and type=? and level=0", array($id, $type));
			$d->rawQueryOne("delete from #_gallery where id_parent=? and level=0", array($id));

		}
		elseif($list_id)
		{
			$list_check = explode(",", $list_id);
			for($i = 0; $i < count($list_check); $i++)
			{
				$id = $list_check[$i];
				$product = $d->rawQueryOne("select id, photo, file from #_$tbl where id=?", array($id));
				$gallery = $d->rawQuery("select id, photo from #_gallery where id_parent=? and level=0", array($id));

				$func->delete_file(DIR.$product['photo']);
				$func->delete_file(UPLOAD_FILE.$product['file']);
				foreach($gallery as $j => $value) $func->delete_file(UPLOAD_GALLERY.$value['photo']);
				$d->rawQueryOne("delete from #_$tbl where id=?", array($id));
				$d->rawQueryOne("delete from #_seo where id_parent=? and type=? and level=0", array($id, $type));
				$d->rawQueryOne("delete from #_gallery where id_parent=? and level=0", array($id));
			}
		}
		else $func->transfer("Đã có lỗi xảy ra. Vui lòng thử lại sau", $link, "error");
		redirect($link);
	}
?>