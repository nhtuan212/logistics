<?php
	@$w = $config[$com.$level_com][$type]['photo_width'];
	@$h = $config[$com.$level_com][$type]['photo_height'];
	@$zc = "1";
	@$resize = $w."x".$h."x".$zc;
	
	function get_category()
	{	
		global $func, $d, $config, $tbl, $category, $totalRows, $pageSize, $paging, $level, $type, $com;
		foreach($config['website']['lang'] as $lang => $value)
		{
			foreach($config[$com.'-lv'.$level][$type]['text'] as $column => $value)
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

		if($type) $where = " and type='".$type."'";
		if($level) $where .= " and level='".$level."'";
		if(@$_REQUEST['keyword']) $where .= " and name like '%".$_REQUEST['keyword']."%'";
		for($i=0; $i < @$config['product'][$type]['level']; $i++) { 
			if((int)@$_REQUEST['id_lv'.($i+1)]) $where.=" and id_lv".($i+1)."=".(int)$_REQUEST['id_lv'.($i+1)]."";
		}
		$where.=" order by number, id desc";

		$items = $d->rawQueryOne("select count(id) from #_$tbl where id<>0 $where");
		$totalRows = $items['count(id)'];
		$page = (isset($_GET['p']) && $_GET['p'] != "") ? $_GET['p'] : 1;
		$page --;
		$pageSize = 15;
		$bg = $page * $pageSize;
		$category = $d->rawQuery("select * from #_$tbl where id<>0 $where limit $bg, $pageSize");
		$paging = $func->paging($totalRows, $pageSize);
	}

	function edit_category()
	{
		global $func, $d, $tbl, $item, $item_seo, $level, $type, $link, $com;
		$id = $func->decode($_GET['id']);	
		$item = $d->rawQueryOne("select * from #_$tbl where id=?", array($id));
		$item_seo = $d->rawQueryOne("select * from #_seo where id_parent=? and type=? and level=?", array($id, $type, $level));
		if(!$id || !$item) $func->transfer("Đã có lỗi xảy ra. Vui lòng thử lại sau", $link, "error");
	}

	function save_category()
	{
		global $func, $d, $config, $tbl, $act, $type, $level, $link, $com;
		foreach($_POST['data'] as $column => $value) $data[$column] = $func->encode($value);
		@$data_seo = $_POST['data_seo'];
		@$id = $_POST['id'];
		@$slug = $_POST['slug'];
		@$photo_name = $func->images_name($_FILES['photo']['name']);
		if(@$photo = $func->upload_image("photo", FORMAT_IMAGE, DIR, $photo_name)) $data['photo'] = $photo;
		if(!empty($_POST['status']))
		{
			foreach($_POST['status'] as $attr_column => $attr_value) if($attr_value != "") @$status .= $attr_value.',';
			@$data['status'] = (!empty($status)) ? rtrim($status, ",") : "";
		}
		if($id && $act != "save_copy_category")
		{
			$category = $d->rawQueryOne("select photo from #_$tbl where id=?", array($id));
			if($data['photo'] && $category) $func->delete_file(DIR.$category['photo']);
			if($config[$com.'-lv'.$level][$type]['slug']==true)
			{
				if($slug) $data['tenkhongdau'] = $func->changeTitle($data['name']);
				else $data['tenkhongdau'] = $func->changeTitle($data['tenkhongdau']);
			}
			else $data['tenkhongdau'] = $func->changeTitle($data['name']);		
			$data['date_updated'] = time();
			$data['level'] = $level;
			$d->where('id', $id);
			if(!$d->update($tbl, $data)) $func->transfer("Đã có lỗi xảy ra. Vui lòng thử lại sau", $link, "error");
		}
		else
		{
			$data['tenkhongdau'] = $func->changeTitle($data['name']);
			$data['date_created'] = time();
			$data['level'] = $level;

			if(!$d->insert($tbl, $data)) $func->transfer("Đã có lỗi xảy ra. Vui lòng thử lại sau", $link, "error");
			$id = $d->getLastInsertId();
		}
		if($data_seo)
		{
			$d->rawQuery("delete from #_seo where id_parent=? and type=? and level=?", array($id, $type, $level));
			$data_seo['id_parent'] = $id;
			$data_seo['type'] = $type;
			$data_seo['level'] = $level;
			$d->insert('seo', $data_seo);
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
					$data_gallery['level'] = $level;
					$d->insert('gallery', $data_gallery);
				}
			}
		}
		redirect($link);
	}

	function delete_category()
	{
		global $func, $d, $config, $tbl, $type, $level, $link, $com;
		$id =  $func->decode($_GET['id']);
		$list_id = $func->decode($_GET['list_check']);
		if($id)
		{
			$product_category = $d->rawQueryOne("select id, photo from #_$tbl where id=?", array($id));
			$gallery_category = $d->rawQuery("select id, photo from #_gallery where id_parent=? and level=?", array($id, $level));		
			if($product_category || $gallery_category)
			{
				$func->delete_file(DIR.$product_category['photo']);
				foreach($gallery_category as $i => $value) {
					$func->delete_file(UPLOAD_GALLERY.$value['photo']);
				}
				$delete = $d->rawQueryOne("delete from #_$tbl where id='".$id."'");
				$delete_seo = $d->rawQueryOne("delete from #_seo where id_parent=? and type=? and level=?", array($id, $type, $level));
				$delete_gallery = $d->rawQueryOne("delete from #_gallery where id_parent=? and level=?", array($id, $level));
				redirect($link);
			}
			else $func->transfer("Đã có lỗi xảy ra. Vui lòng thử lại sau", $link, "error");
		}
		elseif($list_id)
		{
			$list_check = explode(",", $list_id);
			for($i = 0; $i < count($list_check); $i++)
			{
				$id = $list_check[$i];
				$product_category = $d->rawQueryOne("select id, photo from #_$tbl where id=?", array($id));
				$gallery_category = $d->rawQuery("select id, photo from #_gallery where id_parent=? and level=?", array($id, $level));
				if($product_category || $gallery_category)
				{
					$func->delete_file(DIR.$product_category['photo']);
					foreach($gallery_category as $j => $value) {
						$func->delete_file(UPLOAD_GALLERY.$value['photo']);
					}
					$delete = $d->rawQueryOne("delete from #_$tbl where id=?", array($id));
					$delete_seo = $d->rawQueryOne("delete from #_seo where id_parent=? and type=? and level=?", array($id, $type, $level));
					$delete_gallery = $d->rawQueryOne("delete from #_gallery where id_parent=? and level=?", array($id, $level));
				}
				else $func->transfer("Đã có lỗi xảy ra. Vui lòng thử lại sau", $link, "error");
			}
			redirect($link);
		} 
		else $func->transfer("Đã có lỗi xảy ra. Vui lòng thử lại sau", $link, "error");
	}
?>