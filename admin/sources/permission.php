<?php
	if(!defined('SOURCE')) die("Error");
	@$com = $func->decode($_REQUEST['com']);
	@$act = $func->decode($_REQUEST['act']);
	@$id = $func->decode($_REQUEST['id']);
	@$type = $func->decode($_REQUEST['type']);
	@$p = ($func->decode($_REQUEST['p'])) ? "&p=".$func->decode($_REQUEST['p']) : "";

	$current_url = "index.php?com=$com&act=$act$p";
	$link = "index.php?com=$com&act=man$p";
	$delete = "index.php?com=$com&act=delete$p";
	$case = '';
	$tbl = "permission";

	if(!isset($config['permission']) || $config['permission']==false)
	{
		error_404('permission');
		if($error_404) return false;
	}

	switch($act){
		case 'man': RouteAD::get(SOURCE.'@user/'.$tbl.'/item', get_item()); break;
		case 'add': RouteAD::get(SOURCE.'@user/'.$tbl.'/item_add'); break;
		case 'edit': RouteAD::get(SOURCE.'@user/'.$tbl.'/item_add', edit_item()); break;
		case 'save': RouteAD::get('', save_item()); break;
		case 'delete': RouteAD::get('', delete_item()); break;
		default: $error_404 = true;
	}

	function get_item()
	{
		global $func, $d, $config, $tbl, $permission, $totalRows , $pageSize, $offset, $paging;

		$where = '';
		if(@$_REQUEST['keyword']!='') $where.=" and name like '%".$_REQUEST['keyword']."%'";
		$where.= " order by number, id desc";

		$items = $d->rawQueryOne("select count(id) from #_$tbl where id<>0 $where");
		$totalRows = $items['count(id)'];
		$page = (isset($_GET['p']) && $_GET['p'] != "") ? $_GET['p'] : 1;
		$page --;
		$pageSize = 15;
		$bg = $page * $pageSize;
		$permission = $d->rawQuery("select * from #_$tbl where id<>0 $where limit $bg,$pageSize");	
		$paging = $func->paging($totalRows, $pageSize);
	}

	function edit_item()
	{
		global $func, $d, $tbl, $item, $link, $list_permission;
		$id = $func->decode($_GET['id']);
		$item = $d->rawQueryOne("select * from #_$tbl where id=?", array($id));

		if($item)
		{
			$arr = $d->rawQuery("select permission from #_permission_detail where id_permission=?", array($id));

			if(!empty($arr))
			{
				foreach($arr as $permission) $list_permission[] = $permission['permission'];
			}
			else
			{
				$list_permission[] = '';
			}
		}
		else $func->transfer("Dữ liệu không có thực", $link, "error");
	}

	function save_item()
	{
		global $func, $d, $config, $tbl, $link;

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
			if($d->update($tbl, $data))
			{
				$d->rawQueryOne("delete from #_permission_detail where id_permission=?", array($id));				
			}
		}
		else
		{
			$data['date_created'] = time();
			if($d->insert($tbl, $data))
			{
				$id = $d->getLastInsertId();
			}
		}
		if($_POST['permission'])
		{
			$permission = $_POST['permission'];
			for($i=0; $i < count($permission); $i++)
			{
				$data_permission['id_permission'] = $id;
				$data_permission['permission'] = $permission[$i];
				$d->insert('permission_detail', $data_permission);
			}
		}
		redirect($link);
	}

	function delete_item()
	{
		global $func, $d, $config, $tbl, $type, $link;
		$id =  sanitize($_GET['id']);
		$list_id = sanitize($_GET['list_check']);

		if($id)
		{
			$user = $func->get_fetch("select id from #_$tbl where id='".$id."'");
			if($user || $gallery)
			{
				$delete = $func->get_fetch("delete from #_$tbl where id='".$id."'");
				redirect($link);
			}
			else $func->transfer("Xóa dữ liệu bị lỗi", $link, "error");
		}
		elseif($list_id)
		{
			$list_check = explode(",", $list_id);
			for($i = 0; $i < count($list_check); $i++)
			{
				$id = $list_check[$i];
				$user = $func->get_fetch("select id from #_$tbl where id='".$id."'");
				if($user)
				{
					$delete = $func->get_fetch("delete from #_$tbl where id='".$id."'");
				}
				else $func->transfer("Xóa dữ liệu bị lỗi", $link, "error");
			}
			redirect($link);
		} 
		else $func->transfer("Không nhận được dữ liệu", $link, "error");
	}
?>