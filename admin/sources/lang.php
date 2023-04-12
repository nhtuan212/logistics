<?php	if(!defined('SOURCE')) die("Error");

@$com = $func->decode($_REQUEST['com']);
@$act = $func->decode($_REQUEST['act']);
@$id = $func->decode($_REQUEST['id']);
@$p = ($func->decode($_REQUEST['p'])) ? "&p=".$func->decode($_REQUEST['p']) : "";

$current_url = "index.php?com=$com&act=$act$p";
$link = "index.php?com=$com&act=man$p";
$delete = "index.php?com=$com&act=delete$p";
$case = "";
$tbl = "lang";

if(@$myPermission){
	switch($act){
		case 'create': RouteAD::get(get_create()); break;
		case 'man': RouteAD::get(SOURCE.'@'.$tbl.'/item', get_item()); break;
		case 'add': RouteAD::get(SOURCE.'@'.$tbl.'/item_add'); break;
		case 'edit': RouteAD::get(SOURCE.'@'.$tbl.'/item_add', edit_item()); break;
		case 'save': RouteAD::get('', save_item()); break;
		case 'delete': RouteAD::get('', delete_item()); break;
		default: $error_404 = true;
	}
}
if(!@$myPermission)
{
	error_404('lang');
	if($error_404) return false;
}
function get_create()
{
	global $d, $config, $link, $func;
	foreach($config['website']['lang'] as $lang => $value)
	{
		if($lang == "") $lang = "vi";
		$langlist = $d->rawQuery("select str, lang$lang from #_lang");
		$langfile = fopen(LIB."lang/"."lang_".$lang.".php", "w") or $func->transfer("Không thể tạo tập tin.", $link, "error");

		$str = '<?php';
		for($i=0;$i<count($langlist);$i++) $str .= PHP_EOL.'define("'.$langlist[$i]['str'].'","'.$langlist[$i]['lang'.$lang].'");';
		$str .= PHP_EOL.'?>';

		fwrite($langfile, $str);
		fclose($langfile);
	}
	$func->transfer("Tạo tập tin ngôn ngữ thành công", $link, "success");
}

function get_item()
{
	global $func, $d, $config, $tbl, $items, $totalRows , $pageSize, $offset, $paging, $type;

	foreach($config['website']['lang'] as $lang => $value)
	{
		if ($lang != "") {
			$show_text = $d->rawQueryOne("show columns from #_$tbl like ?", array('lang'.$lang));
			if($show_text == null) $d->rawQuery("alter table #_$tbl ADD lang".$lang." varchar(100)");
		}		
	}

	$where = "";
	if(@$_REQUEST['keyword']!='') $where=" and str like '%".$_REQUEST['keyword']."%'";
	$items = $d->rawQueryOne("select count(id) from #_$tbl where id<>0 $where");
	$totalRows = $items['count(id)'];
	$page = (isset($_GET['p']) && $_GET['p'] != "") ? $_GET['p'] : 1;
	$page --;
	$pageSize = 15;
	$bg = $page * $pageSize;
	$items = $d->rawQuery("select * from #_$tbl where id<>0 $where order by number, id desc limit $bg,$pageSize");
	$paging = $func->paging($totalRows, $pageSize);
}

function edit_item()
{
	global $func, $d, $tbl, $item, $link, $type, $error_404;
	$id = $func->decode($_GET['id']);
	$item = $d->rawQueryOne("select * from #_$tbl where id=?", array($id));
	if(!$item) $error_404 = true;
}

function save_item()
{
	global $func, $d, $config, $tbl, $type, $link;

	$data = $_POST['data'];
	$id = $_POST['id'];
	
	if($id)
	{
		$d->where('id', $id);
		if($d->update($tbl, $data));
	}
	else
	{
		if($d->insert($tbl, $data));
	}
	redirect($link);
}

function delete_item()
{
	global $func, $d, $config, $tbl, $type, $link;
	$id = $func->decode($_GET['id']);
	$list_id = $func->decode($_GET['list_check']);

	if($id)
	{
		$delete = $d->rawQueryOne("delete from #_$tbl where id=?", array($id));
		redirect($link);
	}
	elseif($list_id)
	{
		$list_check = explode(",", $list_id);
		for($i = 0; $i < count($list_check); $i++)
		{
			$id = $list_check[$i];
			$delete = $d->rawQueryOne("delete from #_$tbl where id=?", array($id));
		}
		redirect($link);
	} 
	else $func->transfer("Không nhận được dữ liệu", $link);
}

?>