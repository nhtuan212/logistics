<?php
	@define ( 'DIR' , UPLOAD_PHOTO);
	if(!defined('SOURCE')) $error_404 = true;
	@$com = $func->decode($_REQUEST['com']);
	@$act = $func->decode($_REQUEST['act']);
	@$id = $func->decode($_REQUEST['id']);
	@$type = $func->decode($_REQUEST['type']);
	@$case = "";
	@$tbl = 'static';

	@$current_url = "index.php?com=$com&act=$act&type=$type$level_url$p";
	@$link = "index.php?com=$com&act=man&type=$type$level_url$p";

	error_404('static');
	if($error_404) return false;
	switch($act){
		case 'man': RouteAD::get(SOURCE.'@'.$tbl.'/item_add', get_item()); break;
		case 'save': RouteAD::get('', save_item()); break;
		default: $error_404 = true;
	}

	function get_item()
	{
		global $config, $func, $case, $d, $tbl, $item, $item_seo, $type;

		foreach($config['website']['lang'] as $lang => $value)
		{
			foreach($config[$tbl.$case][$type]['text'] as $column => $value)
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

		$item = $d->rawQueryOne("select * from #_$tbl where type=?", array($type));
		if(!$item)
		{
			$data['status'] = 'display';
			$data['type'] = $type;
			$data['date_created'] = time();
			if($d->insert($tbl, $data))
			{
				$id = $d->getLastInsertId();
				$item_seo = $d->rawQueryOne("select * from #_seo where id_parent=? and type=?", array($id, $type));
				if(!$item_seo)
				{
					$data_seo['id_parent'] = $id;
					$data_seo['type'] = $type;
					$data_seo['level'] = 0;
					$d->insert("seo", $data_seo);
				}
			}
		}
		else
		{
			$id = $item['id'];
			$item_seo = $d->rawQueryOne("select * from #_seo where id_parent=? and type=?", array($id, $type));
		}
	}

	function save_item()
	{
		global $func, $d, $config, $tbl, $type, $link;
		if(empty($_POST)) $func->transfer("Không nhận được dữ liệu", $link, "error");
		@$data = $_POST['data'];
		@$data_seo = $_POST['data_seo'];
		@$id = $_POST['id'];
		foreach($_POST['status'] as $attr_column => $attr_value) if($attr_value != "") @$status .= $attr_value.',';
		@$data['status'] = (!empty($status)) ? rtrim($status, ",") : "";
		
		if($data_seo)
		{
			$d->rawQuery("delete from #_seo where id_parent=? and type=? and level='0'", array($id, $type));
			$data_seo['id_parent'] = $id;
			$data_seo['type'] = $type;
			$data_seo['level'] = 0;
			$d->insert('seo', $data_seo);
		}

		$photo_name = $func->images_name($_FILES['photo']['name']);
		if($photo = $func->upload_image("photo", FORMAT_IMAGE, UPLOAD_PHOTO, $photo_name))
		{
			$data['photo'] = $photo;
			$delete_photo = $d->rawQueryOne("select photo from #_$tbl where id=? and type=?", array($id, $type));
			if($delete_photo) $func->delete_file(UPLOAD_PHOTO.$delete_photo['photo']);
		}
		$d->where('type', $type);
		if(!$d->update($tbl, $data)) $func->transfer("Đã có lỗi xảy ra. Vui lòng thử lại sau", $link, "error");
		redirect($link);
	}
?>