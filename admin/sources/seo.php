<?php
	if(!defined('SOURCE')) die("Error");
	@define ( 'DIR' , UPLOAD_PHOTO);
	@$com = $func->decode($_REQUEST['com']);
	@$act = $func->decode($_REQUEST['act']);
	@$id = $func->decode($_REQUEST['id']);
	@$type = $func->decode($_REQUEST['type']);
	@$case = '';

	$current_url = "index.php?com=$com&act=$act&type=$type";
	$link = "index.php?com=$com&act=man&type=$type";
	$tbl = "seo";
	error_404('seo', 'page');
	if($error_404) return false;

	switch($act){
		case 'man': RouteAD::get(SOURCE.'@'.$tbl.'/item_add', get_item()); break;
		case 'save': RouteAD::get('', save_item()); break;
		default: $error_404 = true;
	}

	function get_item()
	{
		global $func, $d, $tbl, $item, $item_seo, $type;
		$item = $item_seo = $d->rawQueryOne("select * from #_$tbl where type=? and id_parent=? and level=?", array($type, '0', '0'));
		if(!$item)
		{
			$data['type'] = $type;
			$d->insert($tbl, $data);
		}
	}

	function save_item()
	{
		global $func, $d, $config, $tbl, $type, $link;
		if(empty($_POST)) $func->transfer("Không nhận được dữ liệu", $link, "error");
		$data = $_POST['data_seo'];

		$photo_name = $func->images_name($_FILES['photo']['name']);
		if($photo = $func->upload_image("photo", FORMAT_IMAGE, DIR, $photo_name))
		{
			$data['photo'] = $photo;
			$delete_photo = $d->rawQueryOne("select photo from #_$tbl where type=?", array($type));
			if($delete_photo) $func->delete_file(DIR.$delete_photo['photo']);
		}
		$d->where('type', $type);
		if($d->update($tbl, $data)) redirect($link);
	}
?>