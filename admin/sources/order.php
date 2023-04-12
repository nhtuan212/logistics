<?php
	if(!defined('SOURCE')) die("Error");
	@$com = $func->decode($_REQUEST['com']);
	@$act = $func->decode($_REQUEST['act']);
	@$id = $func->decode($_REQUEST['id']);
	@$p = ($func->decode($_REQUEST['p'])) ? "&p=".$func->decode($_REQUEST['p']) : "";

	$current_url = "index.php?com=$com&act=$act$p";
	$link = "index.php?com=$com&act=man$p";
	$delete = "index.php?com=$com&act=delete$p";
	$case = '';
	$tbl = "order";

	if(empty($config['developer']['cart']))
	{
		error_404('order');
		if($error_404) return false;
	}
	switch($act)
	{
		case 'man': RouteAD::get(SOURCE.'@'.$tbl.'/item', get_item()); break;
		case 'add': RouteAD::get(SOURCE.'@'.$tbl.'/item_add'); break;
		case 'edit': RouteAD::get(SOURCE.'@'.$tbl.'/item_add', edit_item()); break;
		case 'save': RouteAD::get('', save_item()); break;
		case 'delete': RouteAD::get('', delete_item()); break;
		default: $error_404 = true;
	}

	function get_item()
	{
		global $func, $d, $config, $tbl, $order, $totalRows , $pageSize, $offset, $paging, $orderNew, $orderNew_count, $orderNew_total, $orderNew_percent, $orderConfirm, $orderConfirm_count, $orderConfirm_total, $orderConfirm_percent, $orderShip, $orderShip_count, $orderShip_total, $orderShip_percent, $orderSuccess, $orderSuccess_count, $orderSuccess_total, $orderSuccess_percent, $rangeMin, $rangeMax, $priceFrom, $priceTo;

		$where = "";
		if(@$_GET['keyword']!='') $where = " and code like '%".$_GET['keyword']."%'";
		if(@$_GET["daterange"]!='')
		{
			$daterange = explode("-", $_GET["daterange"]);	
			$startDate = $daterange[0];
			$endDate = $daterange[1];

			if($startDate)
			{
				$date_arr = explode("/", $startDate);
				$ngaytao = $date_arr[0]."-".$date_arr[1]."-".$date_arr[2];
				$where.= " and ngaytao >= '".strtotime($ngaytao)."'";
			}
			if($endDate)
			{
				$date_arr = explode("/", $endDate);
				$ngaytao = $date_arr[0]."-".$date_arr[1]."-".$date_arr[2];
				$where.= " and ngaytao <= '".strtotime($ngaytao)."'";
			}
		}
		if(@$_GET["id_city"]) $where.= " and id_city = '".$_GET["id_city"]."'";
		if(@$_GET["id_dist"]) $where.= " and id_dist = '".$_GET["id_dist"]."'";
		if(@$_GET["id_status"]) $where.= " and id_status = '".$_GET["id_status"]."'";
		if(@$_GET["id_payments"]) $where.= " and id_payments = '".$_GET["id_payments"]."'";

		@$rangePrice = explode(";", $_GET["rangePrice"]);
		@$priceFrom = $rangePrice[0];
		@$priceTo = $rangePrice[1];
		if(@$_GET["rangePrice"]) $where.= " and total >= '".$priceFrom."' and total <= '".$priceTo."'";

		$where.= " order by number, id desc";

		$items = $d->rawQueryOne("select count(id) from #_$tbl where id<>0 $where");
		$totalRows = $items['count(id)'];
		$page = (isset($_GET['p']) && $_GET['p'] != "") ? $_GET['p'] : 1;
		$page --;
		$pageSize = 15;
		$bg = $page * $pageSize;
		$order = $d->rawQuery("select * from #_$tbl where id<>0 $where limit $bg,$pageSize");
		$paging = $func->paging($totalRows, $pageSize);

		$list_order = $d->rawQuery("select id from #_$tbl where id<>0");

		$range = $d->rawQueryOne("select MIN(total) as min, MAX(total) as max from #_$tbl where id<>0");
		$rangeMin = $range['min'];
		$rangeMax = $range['max'];

		$orderNew = $d->rawQuery("select * from #_order where id_status='1'");
		$orderNew_price = $d->rawQueryOne("select SUM(total) as total from #_order where id_status='1'");
		$orderNew_count = count($orderNew);
		$orderNew_total = $orderNew_price['total'];
		@$orderNew_percent = round(($orderNew_count*100)/count($list_order));

		$orderConfirm = $d->rawQuery("select * from #_order where id_status='2'");
		$orderConfirm_price = $d->rawQueryOne("select SUM(total) as total from #_order where id_status='2'");
		$orderConfirm_count = count($orderConfirm);
		$orderConfirm_total = $orderConfirm_price['total'];
		@$orderConfirm_percent = round(($orderConfirm_count*100)/count($list_order));

		$orderShip = $d->rawQuery("select * from #_order where id_status='3'");
		$orderShip_price = $d->rawQueryOne("select SUM(total) as total from #_order where id_status='3'");
		$orderShip_count = count($orderShip);
		$orderShip_total = $orderShip_price['total'];
		@$orderShip_percent = round(($orderShip_count*100)/count($list_order));

		$orderSuccess = $d->rawQuery("select * from #_order where id_status='4'");
		$orderSuccess_price = $d->rawQueryOne("select SUM(total) as total from #_order where id_status='4'");
		$orderSuccess_count = count($orderSuccess);
		$orderSuccess_total = $orderSuccess_price['total'];
		@$orderSuccess_percent = round(($orderSuccess_count*100)/count($list_order));
	}

	function edit_item()
	{
		global $func, $d, $tbl, $item, $order_detail, $link, $type, $error_404;
		$id = $func->decode($_GET['id']);
		$item = $d->rawQueryOne("select * from #_$tbl where id=?", array($id));
		$order_detail = $d->rawQuery("select * from #_order_detail where id_parent=? order by number, id desc", array($item['id']));
		if(!$item) $error_404 = true;
	}
	function save_item()
	{
		global $func, $d, $config, $tbl, $type, $link;
		$data = $_POST['data'];
		if(empty($_POST)) $func->transfer("Không nhận được dữ liệu", "index.php?com=order&act=man");
		$id = $func->decode($_POST['id']);
			
		if($id)
		{
			$data['date_updated'] = time();
			$d->where('id', $id);
			if($d->update($tbl, $data)) redirect($link);
		}
	}

	function delete_item()
	{
		global $func, $d, $config, $tbl, $type, $level, $link;
		$id =  $func->decode($_GET['id']);
		$list_id = $func->decode($_GET['list_check']);

		if($id)
		{
			$order = $d->rawQueryOne("select id from #_$tbl where id=?", array($id));
			if($order)
			{
				$delete = $d->rawQueryOne("delete from #_$tbl where id=?", array($id));
				$delete_detail = $d->rawQueryOne("delete from #_order_detail where id_parent=?", array($id));
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
				$order = $d->rawQueryOne("select id from #_$tbl where id=?", array($id));
				if($order)
				{
					$delete = $d->rawQueryOne("delete from #_$tbl where id=?", array($id));
					$delete_detail = $d->rawQueryOne("delete from #_order_detail where id_parent=?", array($id));
				}
				else $func->transfer("Xóa dữ liệu bị lỗi", $link);
			}
			redirect($link);
		} 
		else $func->transfer("Không nhận được dữ liệu", $link);
	}
?>