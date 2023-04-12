<?php
	if(!defined('SOURCE')) die("Error");
	@$com = $func->decode($_REQUEST['com']);
	@$act = $func->decode($_REQUEST['act']);
	@$id = $func->decode($_REQUEST['id']);
	@$case = '';
	@$type = $func->decode($_REQUEST['type']);
	@$p = ($func->decode($_REQUEST['p'])) ? "&p=".$func->decode($_REQUEST['p']) : "";

	$current_url = "index.php?com=$com&act=$act&type=$type$p";
	$link = "index.php?com=$com&act=man&type=$type$p";
	$delete = "index.php?com=$com&act=delete&type=$type$p";
	$tbl = "place_".$type;

	error_404('place');
	if($error_404) return false;

	switch($act){
		case 'man': RouteAD::get(SOURCE.'@place/'.$type.'/item', get_item()); break;
		case 'add': RouteAD::get(SOURCE.'@place/'.$type.'/item_add'); break;
		case 'edit': RouteAD::get(SOURCE.'@place/'.$type.'/item_add', edit_item()); break;
		case 'save': RouteAD::get('', save_item()); break;
		case 'delete': RouteAD::get('', delete_item()); break;
		default: $error_404 = true;
	}

	function get_item()
	{
		global $func, $d, $config, $tbl, $place, $totalRows , $pageSize, $offset, $paging, $type;
		if($type!='') $where=" and type='".$_REQUEST['type']."'"; 
		if(@$_REQUEST['keyword']!='') $where.=" and name like '%".$_REQUEST['keyword']."%'";
		if($type == 'dist' && (int)@$_REQUEST['id_city']!='') $where.=" and id_city=".(int)$_REQUEST['id_city']."";
		if($type == 'ward' && (int)@$_REQUEST['id_dist']!='') $where.=" and id_dist=".(int)$_REQUEST['id_dist']."";

		$where.= " order by number, id asc";

		$items = $d->rawQueryOne("select count(id) from #_$tbl where id<>0 $where");
		$totalRows = $items['count(id)'];
		$page = (isset($_GET['p']) && $_GET['p'] != "") ? $_GET['p'] : 1;
		$page --;
		$pageSize = 15;
		$bg = $page * $pageSize;
		$place = $d->rawQuery("select * from #_$tbl where id<>0 $where limit $bg,$pageSize");
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
		global $func, $d, $config, $tbl, $type, $link;
		$data = $_POST['data'];
		$id = $_POST['id'];
		if(!empty($_POST['status']))
		{
			foreach($_POST['status'] as $attr_column => $attr_value) if($attr_value != "") @$status .= $attr_value.',';
			@$data['status'] = (!empty($status)) ? rtrim($status, ",") : "";
		}
		
		if($id)
		{
			$data['date_updated'] = time();
			$d->where('id', $id);
			if(!$d->update($tbl, $data)) $func->transfer("Đã có lỗi xảy ra. Vui lòng thử lại sau", $link, "error");;
		}
		else
		{
			$data['date_created'] = time();
			if(!$d->insert($tbl, $data)) $func->transfer("Đã có lỗi xảy ra. Vui lòng thử lại sau", $link, "error");;
		}
		redirect($link);
	}

	function delete_item()
	{
		global $func, $d, $config, $tbl, $type, $link;
		$id = $func->decode($_GET['id']);
		$list_id = $func->decode($_GET['list_check']);

		if($id)
		{
			$delete = $d->rawQueryOne("delete from #_$tbl where id=?", array($id));
			redirect($link);
		}
		elseif($list_id)
		{
			$list_check = explode(",", $list_id);
			for($i = 0; $i < count($list_check); $i++)
			{
				$id = $list_check[$i];
				$delete = $d->rawQueryOne("delete from #_$tbl where id=?", array($id));
			}
			redirect($link);
		} 
		else $func->transfer("Không nhận được dữ liệu", $link, "error");
	}
?>