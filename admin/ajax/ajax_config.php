<?php
	@define ( 'LIB' , '../../libraries/');	
	include_once LIB."config.php";
	require_once LIB.'autoload.php';
    new autoload();
    $d = new PDODb($config['database']);
	$func = new Functions($d);
	$statistic = new Statistic($d);
	include_once LIB."functions_admin.php";
?>