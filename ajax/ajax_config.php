<?php
	session_start();
	$session=session_id();
	@define ( 'SOURCE' , '../sources/');
	@define ( 'LIB' , '../libraries/');
	@define ( "ASSETS" , 'assets/');

	$lang = $_SESSION['lang'] = (!isset($_SESSION['lang']) || $_SESSION['lang']=='') ? '' : $_SESSION['lang'];
	($_SESSION['lang'] == '') ? $fileLang = 'vi' : $fileLang = $_SESSION['lang'];
	include_once LIB."config.php";
	require_once LIB.'autoload.php';
	
	new autoload();
	$SQLInjection = new SQLInjection();
	$d = new PDODb($config['database']);
	$func = new Functions($d);
	$funcCart = new FunctionsCart($d);
	$funcLayout = new FunctionsLayout($d);
	$createThumb = new CreateThumb();
    $pagingAjax = new PaginationsAjax();
    
    $SQLInjection->injection();
	require_once LIB."lang/lang_$fileLang.php";
    $theme = new Theme();
?>