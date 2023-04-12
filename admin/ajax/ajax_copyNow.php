<?php
	include ("ajax_config.php");
	$tbl = $func->decode($_POST['tbl']);
	$id = $func->decode($_POST['id']);
	$item = $d->rawQueryOne("select * from #_$tbl where id=?", array($id));
	if($item['id']) createCopy($item['name'], $item['tenkhongdau'], $tbl);

	function createCopy($title, $slug, $tbl)
	{
		global $func, $d, $item;
		$check = $d->rawQueryOne("select * from #_$tbl where tenkhongdau=?", array($slug));
		$id = $item['id'];
		if($check['id'])
		{
			$title .= "-1";
			$slug = $func->changeTitle($title);
			createCopy($title, $slug, $tbl);
		}
		else
		{
			$data = $d->rawQueryOne("select * from #_$tbl where id=?", array($id));
			$data['id'] = $d->getLastInsertId();
			$data['name'] = $title;
			$data['tenkhongdau'] = $func->changeTitle($data['name']);
			$data['photo'] = "";
			$d->insert($tbl, $data);
		}		
	}
?>