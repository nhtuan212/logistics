<?php
	if(!defined('SOURCE')) die("Error");
	@define ( 'DIR' , UPLOAD_PHOTO);
	@$com = $func->decode($_REQUEST['com']);
	@$act = $func->decode($_REQUEST['act']);
	@$id = $func->decode($_REQUEST['id']);
	@$id_parent = $func->decode($_REQUEST['id_parent']);
	@$type = $func->decode($_REQUEST['type']);
	@$case = '';
	@$p = ($func->decode($_REQUEST['p'])) ? "&p=".$func->decode($_REQUEST['p']) : "";

	$current_url = "index.php?com=$com&act=$act&type=$type&id_parent=$id_parent$p";
	$link = "index.php?com=$com&act=man&type=$type&id_parent=$id_parent$p";
	$delete = "index.php?com=$com&act=delete&type=$type&id_parent=$id_parent$p";
	$tbl = "attribute";

	@$w = $config[$com.$level_com][$type]['photo_width'];
	@$h = $config[$com.$level_com][$type]['photo_height'];
	@$zc = "1";
	@$resize = $w."x".$h."x".$zc;

	switch($act){
		case 'man': RouteAD::get(SOURCE.'@'.$tbl.'/item', get_item()); break;
		case 'add': RouteAD::get(SOURCE.'@'.$tbl.'/item_add'); break;
		case 'edit': RouteAD::get(SOURCE.'@'.$tbl.'/item_add', edit_item()); break;
		case 'save': RouteAD::get('', save_item()); break;
		case 'delete': RouteAD::get('', delete_item()); break;
		default: $error_404 = true;
	}

	function get_item()
	{
		global $func, $d, $config, $tbl, $attribute, $totalRows , $pageSize, $offset, $paging, $type, $id_parent;
		foreach($config['website']['lang'] as $lang => $value)
		{
			foreach($config['attribute'][$type]['text'] as $column => $value)
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

		$where = " and type='".$type."'";
		if(@$_REQUEST['keyword']!='') $where.=" and ten like '%".$_REQUEST['keyword']."%'";
		if ($id_parent > 0) $where .= " and id_parent='".$id_parent."'";		
		$where .= " order by number, id desc";

		$items = $d->rawQueryOne("select count(id) from #_$tbl where id<>0 $where");
		$totalRows = $items['count(id)'];
		$page = (isset($_GET['p']) && $_GET['p'] != "") ? $_GET['p'] : 1;
		$page --;
		$pageSize = 15;
		$bg = $page * $pageSize;
		$attribute = $d->rawQuery("select * from #_$tbl where id<>0 $where limit $bg,$pageSize");
		$paging = $func->paging($totalRows, $pageSize);
	}
	function edit_item()
	{
		global $func, $d, $tbl, $item, $link, $type, $error_404;
		$id = $func->decode($_GET['id']);
		$item = $d->rawQueryOne("select * from #_$tbl where id=?", array($id));
		if(!$item) $error_404 = true;
	}
	function save_item()
	{
		global $func, $d, $config, $tbl, $link;
		foreach(@$_POST['data'] as $column => $value) $data[$column] = $func->encode($value);	
		@$id = $_POST['id'];
		@$data['id_parent'] = ($data['id_parent'] != "") ? $data['id_parent'] : "0";
		@$photo_name = $func->images_name($_FILES['photo']['name']);
		if(!empty($_POST['status']))
		{
			foreach($_POST['status'] as $attr_column => $attr_value) if($attr_value != "") @$status .= $attr_value.',';
			@$data['status'] = (!empty($status)) ? rtrim($status, ",") : "";
		}	
		if(@$photo = $func->upload_image("photo", FORMAT_IMAGE, DIR, $photo_name)) $data['photo'] = $photo;
		if($id)
		{
			$attribute = $d->rawQueryOne("select photo from #_$tbl where id=?", array($id));
			if(@$data['photo'] && $attribute) $func->delete_file(DIR.$attribute['photo']);
			$d->where('id', $id);
			$d->update($tbl, $data);
		}
		else $d->insert($tbl, $data);
		redirect($link);
	}

	function delete_item()
	{
		global $func, $d, $config, $tbl, $link;
		$id = $func->decode($_GET['id']);
		$list_id = $func->decode($_GET['list_check']);
		if($id)
		{
			$delete = $d->rawQueryOne("delete from #_$tbl where id=?", array($id));
		}
		elseif($list_id)
		{
			$list_check = explode(",", $list_id);
			for($i = 0; $i < count($list_check); $i++)
			{
				$id = $list_check[$i];
				$delete = $d->rawQueryOne("delete from #_$tbl where id=?", array($id));
			}
		}
		else $func->transfer("Không nhận được dữ liệu", $link, "error");
		redirect($link);
	}
?>