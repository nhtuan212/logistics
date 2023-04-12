<nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link text-danger" href="../" target="_blank"><i class="fas fa-reply-all"></i><span class="ml-2 text-sm">Xem website</span></a>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i><span class="ml-2 text-sm text-danger">Thông báo</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <?php if(!empty($config['newsletter'])) { ?>
                    <?php foreach ($config['newsletter'] as $i => $item_newsletter) { ?>
                        <a href="index.php?com=newsletter&act=man&type=<?=$i?>" class="dropdown-item border-bottom">
                            <i class="fas fa-file-signature mr-2"></i><?=$item_newsletter['title']?>
                            <?php $count = $d->rawQueryOne("select count(id) as numrows from #_newsletter where type=?", array($i)); ?>
                            <span class="float-right text-muted text-sm"><?=$count['numrows']?></span>
                        </a>
                    <?php } ?>
                <?php } ?>
                
                <a href="index.php?com=order&act=man&type=sanpham" class="dropdown-item border-bottom none">
                    <i class="fas fa-shopping-cart mr-2"></i>Đơn hàng
                    <?php $count_order = $d->rawQueryOne("select count(id) as numrows from #_order"); ?>
                    <span class="float-right text-muted text-sm"><?=count($count_order)?></span>
                </a>
            </div>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-cogs"></i><span class="ml-2 text-sm text-danger">Điều khiển</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">                
                <?php if(isset($myPermission)) { ?>
                    <a class="dropdown-item d-flex align-items-center border-bottom" href="index.php?com=lang&act=man">
                        <i class="fas fa-language text-md mr-2"></i> Ngôn ngữ
                    </a>
                <?php } ?>
                <a class="dropdown-item d-flex align-items-center border-bottom" href="index.php?com=setting&act=man">
                    <i class="fas fa-cog text-md mr-2"></i> Cấu hình website
                </a>
                <a class="dropdown-item d-flex align-items-center border-bottom" href="index.php?com=admin&act=info&type=admin">
                    <i class="fas fa-users-cog text-md mr-2"></i> Thông tin tài khoản
                </a>
                <a class="dropdown-item d-flex align-items-center border-bottom" href="index.php?com=admin&act=password&type=admin">
                    <i class="fas fa-key text-md mr-2"></i> Đổi mật khẩu
                </a>
                <a class="dropdown-item d-flex align-items-center border-bottom" href="index.php?com=admin&act=clearCache&type=admin">
                    <i class="far fa-trash-alt text-md mr-2"></i> Xóa bộ nhớ tạm
                </a>
                <a class="dropdown-item d-flex align-items-center border-bottom" href="index.php?com=user&act=logout">
                    <i class="fas fa-sign-out-alt text-md mr-2"></i> Log out
                </a>
            </div>
        </li>
    </ul>
</nav>
<?php if(@$notice_login) { ?>
    <div class="notice-login">
        <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="icon fas fa-exclamation-triangle"></i> Có người đăng nhập vào tài khoản của bạn !!!
        </div>
    </div>
<?php } ?>