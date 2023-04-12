<?php
	include("ajax_config.php");
	$act = @$_POST['act'];
	$id = @$_POST['id'];

	if($act == "deleteAll")
	{
		@$item = substr($_POST['item'], 0 , -1);
		@$list_check = explode(",", $item);		
		@$arrID = array();
		for($i = 0; $i < count($list_check); $i++)
		{
			$id = $list_check[$i];
			$gallery = $d->rawQueryOne("select * from #_gallery where id=?", array($id));
			$func->delete_file("../".UPLOAD_GALLERY.$gallery['photo']);
			$d->rawQuery("delete from #_gallery where id=?", array($id));
			array_push($arrID, $id);
		}
		$data = array('arrID' => $arrID);
	}
	else
	{
		$gallery = $d->rawQueryOne("select * from #_gallery where id=?", array($id));
		if($gallery)
		{
			$func->delete_file("../".UPLOAD_GALLERY.$gallery['photo']);
			@$delete = $d->rawQuery("delete from #_gallery where id=?", array($id));
			$data = array("md5" => md5($id));
		}
	}
	echo json_encode($data);
?>