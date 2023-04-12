<?php
	if(!defined('SOURCE')) die("Error");
	@define ( 'DIR' , UPLOAD_USER);
	@$com = $func->decode($_REQUEST['com']);
	@$act = $func->decode($_REQUEST['act']);
	@$id = $func->decode($_REQUEST['id']);
	@$type = $func->decode($_REQUEST['type']);
	@$case = '';

	$current_url = "index.php?com=$com&act=$act&type=$type";
	$link_info = "index.php?com=$com&act=info&type=$type";
	$link_password = "index.php?com=$com&act=password&type=$type";
	$tbl = "user";
	switch($act)
	{
		case 'info': RouteAD::get(SOURCE.'@'.$tbl.'/admin/info', info()); break;
		case 'password': RouteAD::get(SOURCE.'@'.$tbl.'/admin/password', password()); break;
		case 'clearCache': RouteAD::get('', clearCache()); break;
		default: $error_404 = true;
	}

	function clearCache()
	{
		global $cacheFile, $func;
		if($cacheFile->clearCache()) $func->transfer("Xóa cache thành công", "index.php", 'success');
		else $func->transfer("Xóa cache thất bại", "index.php", 'error');
	}

	function info()
	{
		global $func, $d, $config, $item, $login_name_admin, $link_info, $tbl, $type, $options;
		$item = $d->rawQueryOne("select * from #_$tbl where username=?", array($_SESSION['login_admin']['username']));
		$options = (isset($item['options']) && $item['options'] != '') ? json_decode($item['options'],true) : null;

		if($_POST)
		{
			if($_POST['data'])
			{
				foreach($_POST['data'] as $column => $value)
				{
					if(is_array($value))
					{
						foreach($value as $info => $info_value)
						{
							$options[$info] = (!empty($info_value)) ? $info_value : "0";
						}
						$data[$column] = json_encode($options);
					}
					else
					{
						$data[$column] = $func->encode($value);
					}
				}
			}
			$id = $_POST['id'];
			@$photo_name = $func->images_name($_FILES['photo']['name']);
			if($photo = $func->upload_image("photo", FORMAT_IMAGE, DIR,$photo_name))
			{
				$data['photo'] = $photo;
				$delete_user = $d->rawQueryOne("select photo from #_$tbl where id=?", array($id));
				if($delete_user) $func->delete_file(DIR.$delete_user['photo']);
			}
			$d->where('id', $id);
			if($d->update($tbl, $data)) redirect($link_info);
		}
	}
	function password()
	{
		global $func, $d, $config, $item, $login_name_admin, $link_password, $tbl, $type;
		$item = $d->rawQueryOne("select * from #_$tbl where username=?", array($_SESSION['login_admin']['username']));

		if($_POST)
		{
			$data = $_POST['data'];
			$id = $_POST['id'];

			@$username = $d->rawQueryOne("select * from #_user where username!=? and username=? and role=? and type=?", array($_SESSION['login_admin']['username'], $_POST['username'], '3', $type));
			if($username) $func->transfer("Tên đăng nhập đã tồn tại!", $link_password, "error");

			$password = $_POST['password'];
			$new_pass = $_POST['new-pass'];
			$renew_pass = $_POST['renew-pass'];

			if($password == '') $func->transfer("Vui lòng nhập mật khẩu hiện tại", $link_password, "error");
			elseif($new_pass == '' && $renew_pass != '') $func->transfer("Vui lòng nhập mật khẩu mới", $link_password, "error");
			elseif($new_pass != '' && $renew_pass == '') $func->transfer("Vui lòng nhập xác nhận mật khẩu mới", $link_password, "error");
			elseif($func->encrypt_password($config['login']['salt'], $password) != $item['password']) $func->transfer("Mật khẩu không chính xác", $link_password, "error");
			elseif($new_pass != $renew_pass) $func->transfer("Xác nhận mật khẩu mới không chính xác", $link_password, "error");
			elseif($password && $new_pass && $renew_pass) $data['password'] = $func->encrypt_password($config['login']['salt'], $new_pass);
			else $data['password'] = $func->encrypt_password($config['login']['salt'], $password);
			
			$d->where('id', $id);
			if($d->update($tbl, $data))
			{
				session_unset();
				$func->transfer("Cập nhật thành công!", $link_password, "success");
			}
		}
	}
?>