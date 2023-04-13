<?php	
	require_once 'libraries/autoload.php';	
	include_once $autoload->getFile();
?>
<!DOCTYPE html>
<html lang="vi">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="Refresh" content="10; url=<?=$config_url_http?>"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>404! Error Page</title>
		<base href="<?=$config_url_http?>"/>
		<link href="<?=ASSETS?>css/404.css" type="text/css" rel="stylesheet" />
		<link rel="icon" href="<?=CACHE."32x32x1/".UPLOAD_PHOTO_L.$setting['favicon']?>" type="image/x-icon" />
	</head>

	<body>
		<div id="notfound">
			<div class="notfound">
				<div class="notfound-404">
					<h1><span>4</span><span>0</span><span>4</span></h1>
				</div>
				<div class="notfound-line"></div>
				<div class="notfound-info">
					<h2>Oops! Page Not Be Found</h2>
					<p>Sorry but the page you are looking for does not exist, have been removed. name changed or is temporarily unavailable</p>
					<a href="">Back to homepage</a>
				</div>
			</div>
		</div>
	</body>
</html>