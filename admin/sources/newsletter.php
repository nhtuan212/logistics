<?php
	if(!defined('SOURCE')) die("Error");
	@$com = $func->decode($_REQUEST['com']);
	@$act = $func->decode($_REQUEST['act']);
	@$id = $func->decode($_REQUEST['id']);
	@$type = $func->decode($_REQUEST['type']);

	$current_url = "index.php?com=$com&act=$act&type=$type";
	$link = "index.php?com=$com&act=man&type=$type";
	$send = "index.php?com=$com&act=send&type=$type";
	$delete = "index.php?com=$com&act=delete&type=$type";
	$tbl = "newsletter";
	$case = "";

	error_404('newsletter');
	if($error_404) return false;

	switch($act){
		case 'man': RouteAD::get(SOURCE.'@'.$tbl.'/item', get_item()); break;
		case 'send': RouteAD::get('', send_item()); break;
		case 'delete': RouteAD::get('', delete_item()); break;
		default: $error_404 = true;
	}

	function get_item()
	{
		global $func, $d, $config, $tbl, $newsletter, $totalRows , $pageSize, $offset, $paging, $type;

		if(@$_REQUEST['type']!='') $where = " and type='".$_REQUEST['type']."'";
		if(@$_REQUEST['keyword']!='') $where .= " and email like '%".$_REQUEST['keyword']."%'";
		$where.= " order by number, id desc";

		$items = $d->rawQueryOne("select count(id) from #_$tbl where id<>0 $where");
		$totalRows = $items['count(id)'];
		$page = (isset($_GET['p']) && $_GET['p'] != "") ? $_GET['p'] : 1;
		$page --;
		$pageSize = 15;
		$bg = $page * $pageSize;
		$newsletter = $d->rawQuery("select * from #_$tbl where id<>0 $where limit $bg,$pageSize");	
		$paging = $func->paging($totalRows, $pageSize);
	}

	function send_item()
	{
		global $func, $d, $config, $link, $type, $mailer;

		$data = $_POST['data'];
		$listID = explode(",", $data['listID']);

		if($listID)
		{
			$data = $_POST['data'];
			$file_name = $func->images_name($_FILES['file']['name']);
			$fileMB = $_FILES['file']['size']/1024576;
			$limitMB = 5;
			if($fileMB > $limitMB) $func->transfer("** File đính kèm vượt quá giới hạn dung lượng", $link);				
			if($file = $func->upload_image("file", FORMAT_DOCUMENT, UPLOAD_FILE, $file_name)) $data['file'] = $file;

			$messages = '';
			$messages .= '
				<table style="text-align:left; 	font-weight: normal;">
					<tr>
						<th>Thư liên hệ từ website <a href="'.$_SERVER["SERVER_NAME"].'">'.$_SERVER["SERVER_NAME"].'</a></th>
					</tr>
					<tr>
						<td><strong>Chủ đề</strong>: '.$data['topic'].'</td>
					</tr>
					<tr>
						<td><strong>Nội dung</strong>: '.$data['content'].'</td>
					</tr>
				</table>';

			foreach($listID as $i => $item) {
				$id = $listID[$i];
				$email = $d->rawQueryOne("select options from #_newsletter where id=?", array($id));
				@$options = (isset($email['options']) && $email['options'] != '') ? json_decode($email['options'],true) : null;

				if(!empty($email))
				{
					$data['name'] = $options['name'];
					$data['email'] = $options['email'];
					$arr_email["dataEmail".$i] = $data;
				}
			}
			$mailer->sendEmail($arr_email, $messages, "Gửi email thành công", "Gửi email thất bại", $link);
		}
	}

	function delete_item()
	{
		global $func, $d, $config, $tbl, $type, $level, $link;
		$id =  $func->decode($_GET['id']);
		$list_id = $func->decode($_GET['list_check']);

		if($id)
		{
			$newsletter = $d->rawQueryOne("select id from #_$tbl where id=?", array($id));
			if($newsletter)
			{
				$delete = $d->rawQueryOne("delete from #_$tbl where id=?", array($id));
				redirect($link);
			}
			else $func->transfer("Xóa dữ liệu bị lỗi", $link, 'error');
		}
		elseif($list_id)
		{
			$list_check = explode(",", $list_id);
			for($i = 0; $i < count($list_check); $i++)
			{
				$id = $list_check[$i];
				$newsletter = $d->rawQueryOne("select id from #_$tbl where id=?", array($id));
				if($newsletter)
				{
					$delete = $d->rawQueryOne("delete from #_$tbl where id=?", array($id));
				}
				else $func->transfer("Xóa dữ liệu bị lỗi", $link, 'error');
			}
			redirect($link);
		} 
		else $func->transfer("Không nhận được dữ liệu", $link, 'error');
	}

?>