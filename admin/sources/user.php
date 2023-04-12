<?php
	if(!defined('SOURCE')) die("Error");
	@define ( 'DIR' , UPLOAD_USER);
	@$com = $func->decode($_REQUEST['com']);
	@$act = $func->decode($_REQUEST['act']);
	@$id = $func->decode($_REQUEST['id']);
	@$type = $func->decode($_REQUEST['type']);
	@$case = '';
	@$p = ($func->decode($_REQUEST['p'])) ? "&p=".$func->decode($_REQUEST['p']) : "";

	$current_url = "index.php?com=$com&act=$act&type=$type$p";
	$link = "index.php?com=$com&act=man&type=$type$p";
	$delete = "index.php?com=$com&act=delete&type=$type$p";
	$tbl = "user";

	@$w = $config[$com.$level_com][$type]['photo_width'];
	@$h = $config[$com.$level_com][$type]['photo_height'];
	@$zc = "1";
	@$resize = $w."x".$h."x".$zc;

	if(!empty($_SESSION['login_admin']) && $act != 'logout')
	{
		error_404('user');
		if($error_404) return false;
	}
	switch($act)
	{
		case 'login': RouteAD::get(SOURCE.'@'.$tbl.'/login'); break;
		case 'man': RouteAD::get(SOURCE.'@'.$tbl.'/'.$tbl.'/item', get_item()); break;
		case 'add': RouteAD::get(SOURCE.'@'.$tbl.'/'.$tbl.'/item_add'); break;
		case 'edit': RouteAD::get(SOURCE.'@'.$tbl.'/'.$tbl.'/item_add', edit_item()); break;
		case 'save': RouteAD::get('', save_item()); break;
		case 'delete': RouteAD::get('', delete_item()); break;
		case 'logout': RouteAD::get('', logout()); break;
		default: $error_404 = true;
	}
	function get_item()
	{
		global $func, $d, $config, $tbl, $user, $totalRows , $pageSize, $offset, $paging, $type;

		if(@$type!='') $where=" and type='".$_REQUEST['type']."'";
		if(@$_REQUEST['keyword']!='') $where.=" and ten like '%".$_REQUEST['keyword']."%'";
		$where.= " and role=1 order by number, id desc";

		$items = $d->rawQueryOne("select count(id) from #_$tbl where id<>0 $where");
		$totalRows = $items['count(id)'];
		$page = (isset($_GET['p']) && $_GET['p'] != "") ? $_GET['p'] : 1;
		$page --;
		$pageSize = 10;
		$bg = $page * $pageSize;
		$user = $d->rawQuery("select * from #_$tbl where id<>0 $where limit $bg, $pageSize");	
		$paging = $func->paging($totalRows, $pageSize);
	}

	function edit_item()
	{
		global $func, $d, $tbl, $item, $item_seo, $link, $type, $error_404, $options;
		$id = $func->decode($_GET['id']);
		$item = $d->rawQueryOne("select * from #_$tbl where id=?", array($id));
		$options = (isset($item['options']) && $item['options'] != '') ? json_decode($item['options'],true) : null;
		if(!$item) $error_404 = true;
	}

	function save_item()
	{
		global $func, $d, $config, $tbl, $type, $link;

		if($_POST['data'])
		{
			foreach($_POST['data'] as $column => $value)
			{
				if(is_array($value))
				{
					foreach($value as $info => $info_value)
					{
						$info_options[$info] = (!empty($info_value)) ? $info_value : "0";
					}
					$data[$column] = json_encode($info_options);
				}
				else
				{
					$data[$column] = $func->encode($value);
				}
			}
		}

		$id = $_POST['id'];
		@$photo_name = $func->images_name($_FILES['photo']['name']);
		if(@$photo = $func->upload_image("photo", FORMAT_IMAGE, DIR, $photo_name)) $data['photo'] = $photo;
		if(!empty($_POST['status']))
		{
			foreach($_POST['status'] as $attr_column => $attr_value) if($attr_value != "") @$status .= $attr_value.',';
			@$data['status'] = (!empty($status)) ? rtrim($status, ",") : "";
		}

		if(empty($_POST)) $func->transfer("Không nhận được dữ liệu", $link, "error");

		if($id)
		{
			$user = $d->rawQueryOne("select photo from #_$tbl where id=?", array($id));
			if(@$data['photo'] && $user) $func->delete_file(DIR.$user['photo']);
			if($_POST['password']) $data['password'] = $func->encrypt_password($config['login']['salt'], $_POST['password']);
			$data['date_updated'] = time();
			$d->where('id', $id);
			if(!$d->update($tbl, $data)) $func->transfer("Cập nhật dữ liệu bị lỗi", $link, "error");
		}
		else
		{
			$user = $d->rawQueryOne("select username from #_$tbl where username=?", array($data['username']));
			if($user) $func->transfer("Username đã tồn tại !", $link, "error");
			else
			{
				$data['password'] = $func->encrypt_password($config['login']['salt'], $_POST['password']);
				$data['date_created'] = time();
				$data['status'] = 'display';
				$data['number'] = 1;
				$data['role'] = 1;
				if(!$d->insert($tbl, $data)) $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=user&act=man".$link, "error");
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
			$user = $d->rawQueryOne("select id, photo from #_$tbl where id=?", array($id));
			if($user || $gallery)
			{
				$func->delete_file(DIR.$user['photo']);
				$delete = $d->rawQueryOne("delete from #_$tbl where id=?", array($id));
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
				$user = $d->rawQueryOne("select id, photo from #_$tbl where id=?", array($id));
				if($user)
				{
					$func->delete_file(DIR.$user['photo']);
					$delete = $d->rawQueryOne("delete from #_$tbl where id=?", array($id));
				}
				else $func->transfer("Xóa dữ liệu bị lỗi", $link, "error");
			}
			redirect($link);
		} 
		else $func->transfer("Không nhận được dữ liệu", $link, "error");
	}

	function logout()
	{
		global $func, $login_name_admin;
		$_SESSION[$login_name_admin] = false;
		unset($_SESSION['login_admin']);
		redirect("index.php?com=user&act=login");
	}
?>