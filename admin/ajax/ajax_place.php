<?php
	include("ajax_config.php");

	$tbl = $_POST["tbl"];
	$id = $_POST["id"];
	$attr = $_POST["attr"];
	$title = $_POST["title"];

	$place = $d->rawQuery("select id, name$lang as name from #_$tbl where $attr=?", array($id));
?>

<option value="0">Chọn danh mục</option>
<?php for ($i=0; $i < count($place); $i++) { ?>
	<option value="<?=$place[$i]['id']?>">
		<?=$place[$i]['name']?>
	</option>
<?php } ?>