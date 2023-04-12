<?php
	include ("ajax_config.php");	
	$id = $func->decode($_POST['id']);
	$attr = $func->decode($_POST['attr']);
	$type = $func->decode($_POST['type']);
	$place = $d->rawQuery("select id, name from table_place_$type where $attr=? and FIND_IN_SET('display', status) order by number, id desc", array($id));
?>

<option value=""><?=_quanhuyen?></option>
<?php foreach($place as $i => $item) { ?>
	<option value="<?=$item["id"]?>"><?=$item["name"]?></option>
<?php } ?>