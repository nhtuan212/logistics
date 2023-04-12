<?php
	if(!defined('SOURCE')) die("Error");
	@define ( 'DIR' , UPLOAD_PHOTO);

	@$com = $func->decode($_REQUEST['com']);
	@$act = $func->decode($_REQUEST['act']);
	@$id = $func->decode($_REQUEST['id']);
	@$type = $func->decode($_REQUEST['type']);
	@$p = ($func->decode($_REQUEST['p'])) ? "&p=".$func->decode($_REQUEST['p']) : "";
	@$case = (strpos($act, 'static') == true) ? '_static' : '_multi';
	@$kind = (strpos($act, 'static') == true || strpos($act, 'watermark') == true) ? 'static' : 'multi';
	@$tbl = 'photo';

	@$current_url = "index.php?com=$com&act=$act&type=$type$level_url$p";
	@$link = "index.php?com=$com&act=man$case&type=$type$level_url$p";
	@$delete = "index.php?com=$com&act=delete$case&type=$type$level_url$p";

	if($kind == 'static')
	{
		switch($act){
			case 'man'.$case: RouteAD::get(SOURCE.'@'.$tbl.'/'.$kind.'/item_add', get_static()); break;
			case 'save'.$case: RouteAD::get('', save_static()); break;
			case "save-watermark": RouteAD::get('', saveWatermark()); break;
			case "preview-watermark": RouteAD::get('', previewWatermark()); break;
			default: $error_404 = true;
		}
	}
	if($kind == 'multi')
	{
		switch($act){
			case 'man'.$case: RouteAD::get(SOURCE.'@'.$tbl.'/'.$kind.'/item', get_item()); break;
			case 'add'.$case: RouteAD::get(SOURCE.'@'.$tbl.'/'.$kind.'/item_add'); break;
			case 'edit'.$case: RouteAD::get(SOURCE.'@'.$tbl.'/'.$kind.'/item_edit', edit_item()); break;
			case 'save'.$case: RouteAD::get('', save_item()); break;
			case 'delete'.$case: RouteAD::get('',  delete_item()); break;
			default: $error_404 = true;
		}
	}

	error_404($tbl.'_'.$kind);
	if($error_404) return false;
	
	$w = $config[$tbl.'_'.$kind][$type]['photo_width'];
	$h = $config[$tbl.'_'.$kind][$type]['photo_height'];
	$zc = "1";
	$resize = $w."x".$h."x".$zc;

	function get_static()
	{
		global $config, $func, $case, $d, $tbl, $item, $type;

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
			$data['status'] = "display";
			$data['type'] = $type;
			$data['date_created'] = time();
			$d->insert($tbl, $data);
		}
	}
	function save_static()
	{
		global $func, $d, $config, $tbl, $type, $link, $func;
		if(empty($_POST)) $func->transfer("Không nhận được dữ liệu", $link, "error");
		$id = $_POST['id'];
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
		if(!empty($_POST['status']))
		{
			foreach($_POST['status'] as $attr_column => $attr_value) if($attr_value != "") @$status .= $attr_value.',';
			@$data['status'] = (!empty($status)) ? rtrim($status, ",") : "";
		}
			
		$photo_name = $func->images_name($_FILES['photo']['name']);
		if($photo = $func->upload_image("photo", FORMAT_IMAGE, DIR, $photo_name))
		{
			$data['photo'] = $photo;
			$delete_photo = $d->rawQueryOne("select photo$lang as photo from #_$tbl where id=? and type=?", array($id, $type));
			if($delete_photo) $func->delete_file(DIR.$delete_photo['photo']);
		}

		if(isset($config['photo_static'][$type]['watermark']) && $config['photo_static'][$type]['watermark'] == true)
		{
			$func->removeDir(WATERMARK);
			$func->RemoveFilesFromDirInXSeconds(UPLOAD_TEMP, 1);
		}
		$d->where('type', $type);
		if($d->update($tbl, $data))
		{
			$data['date_updated'] = time();
			redirect($link);
		}
	}

	function get_item()
	{
		global $config, $func, $d, $tbl, $photo_multi, $totalRows , $pageSize, $offset, $paging, $case, $type;

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

		if(@$_REQUEST['type']!='') $where=" and type='".$_REQUEST['type']."'";
		if(@$_REQUEST['keyword']!='') $where.=" and ten like '%".$_REQUEST['keyword']."%'";
		$where.= " order by number, id desc";

		$items = $d->rawQueryOne("select count(id) from #_$tbl where id<>0 $where");
		$totalRows = $items['count(id)'];
		$page = (isset($_GET['p']) && $_GET['p'] != "") ? $_GET['p'] : 1;
		$page --;
		$pageSize = 15;
		$bg = $page * $pageSize;
		$photo_multi = $d->rawQuery("select * from #_$tbl where id<>0 $where limit $bg,$pageSize");
		$paging = $func->paging($totalRows, $pageSize);
	}

	function edit_item()
	{
		global $func, $d, $tbl, $item, $tbl, $link, $type;
		$id = $func->decode($_GET['id']);	
		$item = $d->rawQueryOne("select * from #_$tbl where id=?", array($id));
		if(!$id || !$item) $func->transfer("Không nhận được dữ liệu", $link, "error");
	}

	function save_item()
	{
		global $func, $d, $config, $tbl, $type, $link;
		if(empty($_POST)) $func->transfer("Không nhận được dữ liệu", $link, "error");
		@$data = $_POST['data'];
		@$id = $_POST['id'];

		if($id)
		{
			$photo_name = $func->images_name($_FILES['photo']['name']);
			if($photo = $func->upload_image("photo", FORMAT_IMAGE, DIR, $photo_name))
			{
				$data['photo'] = $photo;
				$delete_photo = $d->rawQueryOne("select photo from #_$tbl where id=? and type=?", array($id, $type));
				if($delete_photo) $func->delete_file(DIR.$delete_photo['photo']);
			}
			if(!empty($_POST['status']))
			{
				foreach($_POST['status'] as $attr_column => $attr_value) if($attr_value != "") @$status .= $attr_value.',';
				@$data['status'] = (!empty($status)) ? rtrim($status, ",") : "";
			}
			$d->where('id', $id);
			if(!$d->update($tbl, $data)) $func->transfer("Đã có lỗi xảy ra. Vui lòng thử lại sau", $link, "error");
		}
		else
		{
			for($i=0; $i < $config['photo_multi'][$type]['count']; $i++)
			{
				foreach($config['photo_multi'][$type]['text'] as $attr => $value) {
					foreach($config['website']['lang'] as $lang => $value) @$data[$attr.$lang] = $_POST[$attr.$lang.$i];
				}				

				foreach($_POST['status'.$i] as $attr_column => $attr_value) if($i == $attr_column) if($attr_value != "") @$status .= $attr_value.',';
				@$data['status'] = (!empty($status)) ? rtrim($status, ",") : "";

				@$data['link'] = $_POST['link'.$i];
				@$data['number'] = $_POST['number'.$i];
				if(!empty($config['photo_multi'][$type]['photo'])) $photo_name = $func->images_name($_FILES['photo'.$i]['name']);				
				if(($photo = $func->upload_image("photo".$i, FORMAT_IMAGE, DIR, @$photo_name)))
				{
					$data['photo'] = $photo;
					if(!$d->insert($tbl, $data)) $func->transfer("Đã có lỗi xảy ra. Vui lòng thử lại sau", $link, "error");
				}
				if(($data['name'.$lang] || $data['link']) && empty($data['photo']))
				{
					if(!$d->insert($tbl, $data)) $func->transfer("Đã có lỗi xảy ra. Vui lòng thử lại sau", $link, "error");
				}
			}
		}
		redirect($link);
	}

	function delete_item()
	{
		global $func, $d, $config, $tbl, $type, $link;
		$id =  $func->decode($_GET['id']);
		$list_id = $func->decode($_GET['list_check']);

		if($id)
		{	
			$slider_list = $d->rawQueryOne("select id, photo from #_$tbl where id=?", array($id));
			if($slider_list)
			{
				$func->delete_file(DIR.$slider_list['photo']);
				$d->rawQueryOne("delete from #_$tbl where id=?", array($id));
				redirect($link);
			}
			else $func->transfer("Xóa dữ liệu bị lỗi", $link);
		}
		elseif($list_id)
		{
			$list_check = explode(",", $list_id);
			for($i = 0; $i < count($list_check); $i++)
			{
				$id = $list_check[$i];
				$slider_list = $d->rawQueryOne("select id, photo from #_$tbl where id=?", array($id));
				if($slider_list)
				{
					$func->delete_file(DIR.$slider_list['photo']);
					$d->rawQueryOne("delete from #_$tbl where id=?", array($id));
				}
				else $func->transfer("Xóa dữ liệu bị lỗi", $link, "error");
			}
			redirect($link);
		} 
		else $func->transfer("Không nhận được dữ liệu", $link, "error");
	}


	function saveWatermark()
	{
		global $d, $func, $config, $type;

		if(isset($_POST['data']))
		{
			parse_str(urldecode($_POST['data']), $data);
			$upload = false;
			if(isset($_FILES['file']))
			{
				$file_name = $func->uploadName($_FILES['file']["name"]);
				$photo = $func->uploadImage("file", $config['photo']['photo_static'][$type]['photo_type'], UPLOAD_TEMP, "tmp");
				$upload = true;
				$path = UPLOAD_TEMP.$photo;
			}
			else
			{
				$item = $d->rawQueryOne("select * from #_photo where type = ? limit 0,1",array($type));
				$path = DIR.$item['photo'];
			}
		}

		echo json_encode(
			array(
				"path" => $path,
				"upload" => $upload,
				"data" => $data['data']['options']['watermark'],
				"position" => $data['data']['options']['watermark']['position'],
				"image" => ASSETS."images/preview-watermark.png",
			)
		);

		exit;
	}

	/* Preview watermark */
	function previewWatermark()
	{
		global $createThumb;
		$createThumb->createThumbCache(500,0,1,$_GET['img'],null,"preview",true,$_GET);
	}

?>