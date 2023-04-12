<?php
	include("ajax_config.php");
	$tbl = $_POST["tbl"];
	$id = $_POST["id"];
	$attr = $_POST["attr"];
	$type = $_POST["type"];
	$level = $_POST["level"]+1;
	@$category = $d->rawQuery("select id, name$lang as name from #_$tbl where $attr=? and type=? and level=?", array($id, $type, $level));
?>

<option value="0">Chọn danh mục</option>
<?php for ($i=0; $i < count($category); $i++) { ?>
	<option value="<?=$category[$i]['id']?>">
		<?=$category[$i]['name']?>
	</option>
<?php } ?>