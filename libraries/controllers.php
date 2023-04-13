<?php
$func->checkHTTP($http, $config['website']['arrayDomainSSL'], $config_url_http, $config['database']['url']);
// $wtmProduct = $d->rawQueryOne("select photo, options, status from #_photo where type = 'watermark'");

$router->setBasePath($PHP_SELF . '/');
$router->map('GET|POST', '', 'index');
$router->map('GET|POST', 'index.php', 'index');
$router->map('GET|POST', 'sitemap.xml', 'sitemap', 'sitemap');
// $router->map('GET|POST', '[a:com]/[a:lang]/', 'allpagelang', 'lang');
$router->map('GET|POST', '[a:com]', 'AllPage');
$router->map('GET', CACHE . '[i:w]x[i:h]x[i:z]/[**:src]', function ($w, $h, $z, $src) {
	global $createThumb;
	$createThumb->createThumbCache($w, $h, $z, $src, null, CACHE);
}, 'thumb');
// $router->map('GET', WATERMARK.'product/[i:w]x[i:h]x[i:z]/[**:src]', function($w,$h,$z,$src){
//     global $createThumb, $wtmProduct;
//     $createThumb->createThumbCache($w,$h,$z,$src,$wtmProduct, "product");
// }, 'watermark');
$match = $router->match();
if (is_array($match)) {
	if (is_callable($match['target'])) {
		call_user_func_array($match['target'], $match['params']);
	} else {
		$com = (isset($match['params']['com'])) ? $func->encode($match['params']['com']) : $func->encode($match['target']);

		if (!empty($match['params']['lang']) && $match['params']['lang'] != '') $_SESSION['lang'] = $match['params']['lang'];
		else if (!isset($_SESSION['lang']) && !isset($match['params']['lang'])) $_SESSION['lang'] = "";
		@$lang = $_SESSION['lang'];
		$fileLang = ($lang == '') ? 'vi' : $lang;

		$page = isset($_GET['p']) ? $_GET['p'] : 1;
	}
} else {
	header($_SERVER["SERVER_PROTOCOL"] . '404 Not Found');
	include("404.php");
	exit();
}

$sqlCache = "select * from #_setting";
$setting = $cacheFile->getCache($sqlCache, 'fetch', 7200);
$optsetting = (isset($setting['options']) && $setting['options'] != '') ? json_decode($setting['options'], true) : null;

$seo_company = $d->rawQueryOne("select title$lang as title, keywords$lang as keywords, description$lang as description from #_seo where type='company'");
require_once LIB . "lang/lang_$fileLang.php";

$arr_sitemap = array(
	array("com" => "gioi-thieu"),
	array("tbl" => "product", "type" => "product", "com" => "san-pham", "level" => $config['theme']['product']['level'],),
	array("tbl" => "post", "type" => "news", "com" => "tin-tuc", "level" => $config['theme']['news']['level'],),
	array("com" => "video"),
	array("com" => "lien-he"),
);

switch ($com) {
	case 'gioi-thieu':
		Route::get('static@static/static', 'about', _gioithieu);
		break;
	case 'san-pham':
		Route::get('product@product/product', 'product', _sanpham);
		break;
	case 'tin-tuc':
		Route::get('post@post/post', 'news', _tintuc);
		break;
	case 'video':
		Route::get('static@static/static', 'video', "Video");
		break;
	case 'lien-he':
		Route::get('static@static/static', 'contact', _lienhe);
		break;
	case 'tim-kiem':
		Route::get('search@product/product', 'product', _ketquatimkiem);
		break;
		// case 'lang':
		// 	switch($lang)
		// 	{
		// 		case '': $_SESSION['lang'] = ''; break;
		// 		case 'en': $_SESSION['lang'] = 'en'; break;
		// 		default: $_SESSION['lang'] = ''; break;
		// 	}
		// 	redirect($_SERVER['HTTP_REFERER']); break;
	case 'sitemap':
		include_once LIB . "/sitemap.php";
		exit();
	case 'index':
		Route::get('index@index', '', '');
		break;
}

$category = $d->rawQueryOne("select *, name$lang as name FROM #_category where FIND_IN_SET('display', status) and tenkhongdau!='' and tenkhongdau=?", array($com));
$pro_detail = $d->rawQueryOne("select *, name$lang as name, descript$lang as descript, content$lang as content FROM #_product where FIND_IN_SET('display', status) and tenkhongdau!='' and tenkhongdau=?", array($com));
$post_detail = $d->rawQueryOne("select *, name$lang as name, descript$lang as descript, content$lang as content FROM #_post where FIND_IN_SET('display', status) and tenkhongdau!='' and tenkhongdau=?", array($com));

$arr_template = array('product',);
if (!empty($category['type']) && in_array($category['type'], $arr_template)) if ($category) Route::get('product@product/product@article', $category['type'], $category['name']);
if (!empty($category['type']) && !in_array($category['type'], $arr_template)) if ($category) Route::get('post@post/post@article', $category['type'], $category['name']);
if ($pro_detail) Route::get('product@product/product_detail@article', $pro_detail['type'], $pro_detail['name']);
if ($post_detail) Route::get('post@post/post_detail@article', $post_detail['type'], $post_detail['name']);

$source = Route::source();
$template = Route::template();
$title = Route::title();
$type = Route::type();
$type_og = Route::type_og();

if ($source != "" || !$com) include SOURCE . $source . ".php";
if (!$template && !$source) {
	header($_SERVER["SERVER_PROTOCOL"] . '404 Not Found');
	include("404.php");
	exit();
}
