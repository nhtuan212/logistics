<link rel="canonical" href="<?=$func->getCurrentPageURL()?>" />
<base href="<?=$config_url_http?>"/>
<?php if(@$config['developer']['responsive']) { ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php } elseif(@$config['developer']['mobile']) { ?>
<?php if($deviceType =='phone') { ?>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=1" />		
<?php } else { ?>
<meta name="viewport" content="width=1349, initial-scale=0">
<?php } ?>
<?php } else { ?>
<meta name="viewport" content="width=1349, initial-scale=0">
<?php } ?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" href="<?=$config_url_http.CACHE."32x32x1/".UPLOAD_PHOTO_L.$setting['favicon']?>" type="image/x-icon" />
<META NAME="ROBOTS" CONTENT="<?=$config['database']['meta_robots']?>" />
<meta name="author" content="<?=$optsetting['name']?>" />
<meta name="copyright" content="<?=$optsetting['name']?> [<?=$optsetting['email']?>]" />

<!--Meta seo web-->
<title><?=($source=='index') ? $optsetting['name'] : $seo->Get('title')?></title>
<meta name="keywords" content="<?=$seo->Get('keywords')?>" />
<meta name="description" content="<?=$seo->Get('description')?>" />

<!--Meta facebook-->
<meta property="og:type" content="<?=$type_og?>" />
<meta property="og:site_name" content="<?=$optsetting['name']?>" />
<meta property="og:image" content="<?=$seo->Get('photo')?>" />
<meta property="og:image:type" content="<?=$seo->Get('mime')?>" />
<meta property="og:image:alt" content="<?=$title?>" />
<meta property="og:image:width" content="<?=$seo->Get('width')?>" />
<meta property="og:image:height" content="<?=$seo->Get('height')?>" />
<meta property="og:title" content="<?=$seo->Get('title')?>" />
<meta property="og:description" content="<?=$seo->Get('description')?>" />
<meta property="og:url" content="<?=$seo->Get('url')?>" />