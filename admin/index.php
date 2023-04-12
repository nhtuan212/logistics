<?php
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    session_start();
    @define ( 'LIB' , '../libraries/');
    @define ( 'SOURCE' , './sources/');
    @define ( 'TEMPLATE' , './templates/');
    @define ( 'LAYOUT' , TEMPLATE.'/layout/');
    @define ( 'CACHE' , '../upload/cache/');
    @define ( 'WATERMARK' , '../upload/watermark/');
    @define ( 'ASSETS' , './assets/');

    include_once LIB."config.php";
    require_once LIB.'autoload.php';
    $d = new PDODb($config['database']);
    $func = new Functions($d);
    @$upload = new Upload($d, $_GET['com'], $_GET['act'], $_GET['level']);
    $statistic = new Statistic($d);
    $createThumb = new CreateThumb();
    $cacheFile = new CacheFile($d);
    $theme = new Theme();
    $mailer = new Mailer($d);
    include_once LIB."config_menu_admin.php";
    include_once LIB."functions_admin.php";
    if(isset($_GET['com']) && isset($_GET['act']))
    {
        if(permission($_GET['com'], $_GET['act'], @$_GET['type'], @$_GET['level'])) $func->transfer("Bạn chưa được phân quyền hành động này. Vui lòng liên hệ admin. Cảm ơn!",'index.php', "error");      
    }
    include_once LIB."controllers_admin.php";
    
    if((!isset($_SESSION[$login_admin]) || $_SESSION[$login_admin]==false) && $act!="login") redirect("index.php?com=user&act=login");
    if((isset($_SESSION[$login_admin]) || @$_SESSION[$login_admin]==true) && !isset($myPermission))
    {
        $id_user = (int)$_SESSION['login_admin']['id'];
        $timenow = time();

        //Thoát tất cả khi đổi user, mật khẩu hoặc quá thời gian 1 tiếng không hoạt động
        $login_check = $d->rawQueryOne("select username, password, lastlogin, user_token, login_session from #_user WHERE id=?", array($id_user));

        $cookiehash = $login_check['login_session'];
        if($_SESSION['login_session']!=$cookiehash || ($timenow - $login_check['lastlogin'])>3600) {
            session_destroy();
            redirect("index.php?com=user&act=login");
        }
        $notice_login = ($_SESSION['login_token'] !== $login_check['user_token']) ? true : false;
        $token = md5(time());
        $_SESSION['login_token'] = $token;

        //Cập nhật lại thời gian hoạt động và token
        $d->rawQuery("update #_user set lastlogin=?, user_token=? where id=?", array($timenow, $token, $id_user));
    }
    if(isset($_GET['elfinder'])){
        require_once ASSETS."plugins/elfinder/php/connector.minimal.php";
        exit;
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="icon" href="<?=CACHE."32x32x1/".UPLOAD_PHOTO_L.$setting['favicon']?>" type="image/x-icon" />
        <?php if(!@$error_404) { ?>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <?php } else { ?>
            <meta http-equiv="Refresh" content="10; url=index.php">
        <?php } ?>
        <title>Admin</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php include LAYOUT."css_admin.php";?>
    </head>
    <body class="hold-transition skin-blue sidebar-mini <?=((!$_SESSION[$login_admin]) && ($_SESSION[$login_admin] == 0)) ? "login-page" : ""?>">
        <?php if(isset($_SESSION[$login_admin]) && ($_SESSION[$login_admin] == 1)) { ?>
            <div class="wrapper">
                <?php include LAYOUT."header_admin.php";?>
                <?php include LAYOUT."menu_admin.php";?>
                <?php (!@$error_404) ? include TEMPLATE.$template."_tpl.php" : include TEMPLATE."404.php"; ?>
                <?php include LAYOUT."footer_admin.php";?>
            </div>
        <?php } else { ?>
            <?php include TEMPLATE.$template."_tpl.php"; ?>
        <?php } ?>
    </body>
    <?php include LAYOUT."js_admin.php";?>
</html>