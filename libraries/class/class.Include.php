<?php
session_start();
$session = session_id();
@define("LIB", './libraries/');
@define("SOURCE", './sources/');
@define("ASSETS", 'assets/');
require_once LIB . "config.php";
// if($config['website']['arrayDomainSSL']) require_once LIB."checkSSL.php";

$detect = new Mobile_Detect;
$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
(@$config['developer']['mobile']) ? (($deviceType == 'phone') ? @define('TEMPLATE', './templates_m/') : @define('TEMPLATE', './templates/')) : @define('TEMPLATE', './templates/');
@define('LAYOUT', TEMPLATE . 'layout/');

$router = new AltoRouter();
$SQLInjection = new SQLInjection();
$d = new PDODb($config['database']);
$cacheFile = new CacheFile($d);
$func = new Functions($d);
$funcCart = new FunctionsCart($d);
$funcLayout = new FunctionsLayout($d);
$createThumb = new CreateThumb();
$validateURL = new ValidateURL($http, $config_url_http);
$statistic = new Statistic($d);
$addon = new AddonsOnline();
$CSSminifier = new CSSminifier(@$config['developer']['debug']);
$JSminifier = new JSminifier(@$config['developer']['debug']);
$mailer = new Mailer($d);
$seo = new Seo($d);

$SQLInjection->injection();
$countCart = $funcCart->countSession();
$result_statistic = $statistic->getCounter();
$online_statistic = $statistic->onlineCounter();

$validateURL->setUrl("index");
if ($config['developer']['lock_index']) $validateURL->setUrl("index.php");
$validateURL->resultURL();

require_once LIB . "controllers.php";
$category_group = $d->rawQuery("select id, name$lang as name, tenkhongdau, photo, type, level, status from #_category where " . $func->findInSet('display', 'status') . " order by number, id desc");
$product_group = $d->rawQuery("select id, id_lv1, id_place_from, id_place_to, name$lang as name, date_tour, remain, date_from, tenkhongdau, photo, price, old_price, type, status from #_product where ".$func->findInSet('hot,display', 'status')." order by number, id desc");
// $product_group = $d->rawQuery("select table_product.id, table_product.id_lv1, table_product.name$lang as name, table_product.place_from$lang as place_from, table_product.date_tour, table_product.remain, table_product.date_from, table_product.tenkhongdau, table_product.photo, table_product.price, table_product.old_price, table_product.type, table_product.status, table_place_city.name from #_product INNER JOIN #_place_city ON #_product.id_place_from=#_place_city.id where " . $func->findInSet('hot,display', '#_product.status') . " order by #_product.number, #_product.id desc");
$post_group = $d->rawQuery("select id, name$lang as name, descript$lang as descript, tenkhongdau, photo, type, status FROM #_post WHERE " . $func->findInSet('display', 'status') . " order by number, id desc");
$photo_multi = $d->rawQuery("select name$lang as name, type, link, photo, status from #_photo where FIND_IN_SET('display', status) order by number,id desc");
$static_group = $d->rawQuery("select name$lang as name, descript$lang as descript, content$lang as content, type, photo from #_static where FIND_IN_SET('display', status)");
require_once SOURCE . "custom.php";
$theme = new Theme();
if (isset($config['theme'][$theme->getType()]['tbl'])) {
	$theme->setTbl($config['theme'][$theme->getType()]['tbl']);
	$theme->setDir($config['theme'][$theme->getType()]['dir']);
	$theme->setColumn($config['theme'][$theme->getType()]['column']);
	$theme->setResize($config['theme'][$theme->getType()]['size']);
}
