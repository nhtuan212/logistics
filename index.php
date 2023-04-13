<?php
    require_once 'libraries/autoload.php';
    require_once $autoload->getFile();
?>
<!DOCTYPE html>
<html lang="vi">
	<head>
		<?php require_once LAYOUT."seo-head.php"; ?>
        <?php require_once LAYOUT."base-css.php"; ?>
        <?=$func->decode($optsetting['headjs'])?>
    </head>
    <body>
        <?php require_once LAYOUT."seo-body.php"; ?>
        <div class="cover">
            <?php require_once LAYOUT."header.php"; ?>
            <?php require_once LAYOUT."menu.php"; ?>
            <?php if($source != 'index') { ?><article class="page-inside container py-4"><?php } ?>
            <?php require_once TEMPLATE.$template."_tpl.php"; ?>
            <?php if($source != 'index') { ?></article><?php } ?>
            <?php require_once LAYOUT."footer.php"; ?>
            <i class="fas fa-angle-up totop hvr-opa transition"></i>
        </div>
        <?php require_once LAYOUT."tool.php"; ?>
        <?php require_once LAYOUT."strucdata.php"; ?>
        <?php require_once LAYOUT."base-js.php"; ?>
        <?=$func->decode($optsetting['bodyjs'])?>
    </body>
</html>