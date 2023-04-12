<?php
	include ("ajax_config.php");
	$id = $_POST['id'];
	$idGallery_arr = $_POST['idGallery_arr'];
	$type = $_POST['type'];
	$level = $_POST['level'];

	if($level) $level = 'level = '.$level.'';
	else $level = 'level = 0';

	$gallery = $d->rawQuery("select id, number from #_gallery where id_parent=? and type=? and $level order by number, id desc", array($id, $type));

	$numb_arr = array();
	for($i=0; $i<count($gallery); $i++) {
		array_push($numb_arr, $gallery[$i]['number']);
	}

	for($i=0; $i < count($gallery); $i++) {
		$data['number'] = $gallery[$i]['number'];
		$d->where('id', $idGallery_arr[$i]);
		$d->update('gallery', $data);
	}

	$data_json = array('number' => $numb_arr, 'id' => $idGallery_arr);
	echo json_encode($data_json);
?>