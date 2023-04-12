<?php
	if(!defined('SOURCE')) die("Error");
	if($com == 'lien-he')
	{
		$contact = $d->rawQueryOne("select id, content$lang as content, photo from #_static where type=?", array($type));
		$photo = '';

		if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recaptcha_response'])) {

			$recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
			$recaptcha_secret = $optsetting['secret_key'];
			$recaptcha_response = $_POST['recaptcha_response'];

			$recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
			$recaptcha = json_decode($recaptcha);
			
			$data = $_POST['data_contact'];
			if($_POST['data_contact'])
			{
				foreach($_POST['data_contact'] as $column => $value)
				{
					if(is_array($value))
					{
						foreach($value as $opt => $options)
						{
							$info_options[$opt] = (!empty($options)) ? $options : "0";
						}
						$data[$column] = json_encode($info_options);
					}
					else
					{
						$data[$column] = $func->encode($value);
					}
				}
			}
			$data['date_created'] = time();
			$data['status'] = 'display';
			$data['number'] = 1;
			if($d->insert('newsletter', $data)) $func->formContact($data);
			else $func->transfer("Gửi liên hệ thất bại", "lien-he", "error");
			
			if($recaptcha->score >= 0.5)
			{
				$data = $_POST['data_contact'];
				if($_POST['data_contact'])
				{
					foreach($_POST['data_contact'] as $column => $value)
					{
						if(is_array($value))
						{
							foreach($value as $opt => $options)
							{
								$info_options[$opt] = (!empty($options)) ? $options : "0";
							}
							$data[$column] = json_encode($info_options);
						}
						else
						{
							$data[$column] = $func->encode($value);
						}
					}
				}
				$data['date_created'] = time();
				$data['status'] = 'display';
				$data['number'] = 1;
				if($d->insert('newsletter', $data)) $func->formContact($data);
				else $func->transfer("Gửi liên hệ thất bại", "lien-he", "error");
			}
			else $func->transfer("Gửi liên hệ thất bại", "lien-he", "error");
		}
	}
	elseif($com == 'video')
	{
		$where = " and type='video' and FIND_IN_SET('display', status) order by number, id desc";
		$video = $d->rawQueryOne("select count(id) from #_photo where id<>0 $where");

		$totalRows = $video['count(id)'];
		$page = (isset($_GET['p']) && $_GET['p'] != "") ? $_GET['p'] : 1;
		$page --;
		$pageSize = 12;
		$bg = $page * $pageSize;
		$video = $d->rawQuery("select id, name$lang as name, link from #_photo where id<>0 $where limit $bg, $pageSize");
		$paging = $func->paging($totalRows, $pageSize);
	}
	else
	{
		$static_detail = $d->rawQueryOne("select name$lang as name, content$lang as content, photo from #_static where type=? and FIND_IN_SET('display', status)", array($type));
		$photo = (!empty($static_detail['photo'])) ? CACHE."300x200x2/".UPLOAD_PHOTO_L.$static_detail['photo'] : '';
	}
	$seo->Set(
		array(
			'type' => $type,
			'level' => 0,
			'photo' => !empty($photo) ? $config_url_http.$photo : '',
		)
	);
?>