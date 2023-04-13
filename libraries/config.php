<?php
if (!defined('LIB')) die("Error");
define('ROOT', __DIR__);
date_default_timezone_set('Asia/Ho_Chi_Minh');
(array_key_exists('HTTPS', $_SERVER) && $_SERVER["HTTPS"] == "on") ? $http = "https://" : $http = "http://";

define('NN_MSHD', '');
define('NN_AUTHOR', 'nhtuan.nina@gmail.com');
include_once LIB . "constant.php";

$PHP_SELF = "/logistics";
$config = array(
	'website' => array(
		'lang'           => array("" => "Tiếng Việt",),
		'arrayDomainSSL' => array(),
	),
	'database' => array(
		'php_self'         => $PHP_SELF . '/',
		'url'         => $_SERVER["HTTP_HOST"] . $PHP_SELF,
		// 'url'         => $_SERVER["SERVER_NAME"].$PHP_SELF,
		'type'        => 'mysql',
		'host'        => 'localhost',
		'username'    => 'root',
		'password'    => '',
		'dbname'      => 'logistics',
		'prefix'      => 'table_',
		'port'        => 3306,
		'meta_robots' => 'noodp,index,follow',
		'charset'     => 'utf8',
	),
	'login' => array(
		'salt'    => 'nht212',
		'rand'    => true,
		'delay'   => 15,
		'attempt' => 5,
	),
	'developer' => array(
		'copy'            => true,
		'debug'           => true,
		'responsive'      => true,
		'mobile'          => false,
		'cart'            => false,
		'lock_index'      => false,
		'error_reporting' => true,
	),
	'theme' => array(
		'product'   => array('tbl' => 'product', 'dir' => UPLOAD_PRODUCT_L, 'column' => 'photo', 'size' => '285x220x1', 'level' => '1',),
		'news'      => array('tbl' => 'post',    'dir' => UPLOAD_POST_L,    'column' => 'photo', 'size' => '285x220x1', 'level' => '0'),
		'utilities' => array('tbl' => 'post',    'dir' => UPLOAD_POST_L,    'column' => 'photo', 'size' => '285x220x1', 'level' => '0'),
		'service'   => array('tbl' => 'post',    'dir' => UPLOAD_POST_L,    'column' => 'photo', 'size' => '285x220x1', 'level' => '0'),
		'support'   => array('tbl' => 'post',    'dir' => UPLOAD_POST_L,    'column' => 'photo', 'size' => '285x220x1', 'level' => '0'),
		// 'policy' => array('tbl' => 'post', 'dir'    => UPLOAD_POST_L, 'column'    => 'photo', 'size' => '285x220x1', 'level' => '0'),
	),
);
error_reporting(($config['developer']['error_reporting']) ? E_ALL : 0);
$config_url_http = $http . $config['database']['url'] . "/";
$login_admin = $config['login']['salt'] . NN_MSHD;
