<?php
	if(!defined('SOURCE')) die("Error");
	$act = $func->decode($_REQUEST['act']);
	$current_url = "index.php?com=$com&act=$act";
	$link = "index.php?com=$com&act=man";
	$case = "";
	$type = "setting";
	$tbl = "setting";

	switch($act){
		case 'man': RouteAD::get(SOURCE.'@'.$tbl.'/item_add', get_item()); break;
		case 'save': RouteAD::get('', save_item()); break;
		default: $error_404 = true;
	}

	/* Get setting */
	function get_item()
	{
		global $func, $d, $config, $item, $item_seo, $tbl, $type;
		$item = $d->rawQueryOne("select * from #_setting");
		$id = $item['id'];
		$item_seo = $d->rawQueryOne("select * from #_seo where id_parent=? and type=? and level=?", array($id, $type, 0));
		if(!$item_seo)
		{
			$data_seo['id_parent'] = $id;
			$data_seo['type'] = $type;
			$data_seo['level'] = 0;
			$d->insert('seo',$data_seo);
		}
	}

	/* Save setting */
	function save_item()
	{
		global $func, $d, $config, $tbl, $link, $type;
		if(empty($_POST)) $func->transfer("Không nhận được dữ liệu", $link, 'error');
		$id = (!empty($_POST['id'])) ? $func->encode($_POST['id']) : 0;

		$row = $d->rawQueryOne("select id, options from #_setting where id = ?",array($id));
		$option = json_decode($row['options'],true);
		if($_POST['data'])
		{
			foreach($_POST['data'] as $column => $value)
			{
				if(is_array($value))
				{
					foreach($value as $k2 => $v2) $option[$k2] = $v2;
					$data[$column] = json_encode($option);
				}
				else
				{
					$data[$column] = $func->encode($value);
				}
			}
		}
		foreach($_POST['data_seo'] as $column => $value) $data_seo[$column] = $func->encode($value);
		$photo_name = $func->images_name($_FILES['photo']['name']);
		$favicon_name = $func->images_name($_FILES['favicon']['name']);
		$row_photo = $d->rawQueryOne("select photo, favicon from #_$tbl");

		if($data_seo)
		{
			$d->rawQuery("delete from #_seo where id_parent=? and type=? and level=?", array($id, $type, 0));
			$data_seo['id_parent'] = $id;
			$data_seo['type'] = $type;
			$data_seo['level'] = 0;
			$d->insert('seo', $data_seo);
		}

		if($photo = $func->upload_image("photo", FORMAT_IMAGE, UPLOAD_PHOTO, $photo_name))
		{
			$data['photo'] = $photo;
			if($row_photo) $func->delete_file(UPLOAD_PHOTO.$row_photo['photo']);
		}
		if($favicon = $func->upload_image("favicon", FORMAT_IMAGE, UPLOAD_PHOTO, $favicon_name))
		{
			$data['favicon'] = $favicon;
			if($row_photo) $func->delete_file(UPLOAD_PHOTO.$row_photo['favicon']);
		}
		$d->update($tbl, $data);
		redirect($link);
	}
?>