<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="index.php" class="brand-link text-center">
        <img src="<?=ASSETS?>images/nina.png">
    </a>

    <div class="sidebar mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
            
            <?php /* ?>
            <li class="nav-item has-treeview <?php if($com=='user' || $com=='permission') echo 'menu-open' ?>">
                <a href="#" class="nav-link nav-title">
                    <i class="nav-icon fas fa-users"></i>
                    <p>Quản lý User<i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <?php if(count($config['user']['admin'])>0) { ?>
                        <?php permission_menu('User Quản trị', 'user', 'man', 'admin'); ?>
                    <?php } ?>
                    <?php if(count($config['user']['user'])>0) { ?>
                        <?php permission_menu('User', 'user', 'man', 'user'); ?>
                    <?php } ?>
                    <?php if($config['permission']==true) { ?>
                        <?php permission_menu('Phân quyền', 'permission', 'man', ''); ?>
                    <?php } ?>
                </ul>
            </li>
            <?php */ ?>

            <?php if(!empty($config['group'])) { ?>
                <?php foreach($config['group'] as $i => $group) { ?>
                    <?php foreach($group as $j => $current_type) foreach($current_type as $k) array_push($current_group, $k); ?>
                    <li class="nav-item has-treeview <?=(in_array($_GET['type'], $current_group)) ? "menu-open" : ""?>">
                        <a href="#" class="nav-link nav-title">
                            <i class="nav-icon text-sm fas fa-layer-group"></i>
                            <p><?=$i?><i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php if(!empty($group['product'])) { ?>
                                <?php $current_group = array(); ?>
                                <?php foreach($group['product'] as $type_group) { ?>
                                    <?php $title_group = $config['product'][$type_group]['title']; ?>
                                    <?php for($i=0; $i < $config['product'][$type_group]['level']; $i++) { ?>
                                        <?php foreach($config['product-lv'.($i+1)] as $type_group_level => $value_level) { ?>
                                            <?php if($type_group == $type_group_level) { ?>
                                                <?php permission_menu($value_level['title'], 'product', 'man_category', $type_group_level, $i+1); ?>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php permission_menu($title_group, 'product', 'man', $type_group); ?>
                                <?php } ?>
                            <?php } ?>

                            <?php if(!empty($group['post'])) { ?>
                                <?php $current_group = array(); ?>
                                <?php foreach($group['post'] as $type_group) { ?>
                                    <?php $title_group = $config['post'][$type_group]['title']; ?>
                                    <?php for($i=0; $i < $config['post'][$type_group]['level']; $i++) { ?>
                                        <?php foreach($config['post-lv'.($i+1)] as $type_group_level => $value_level) { ?>
                                            <?php if($type_group == $type_group_level) { ?>
                                                <?php permission_menu($value_level['title'], 'post', 'man_category', $type_group_level, $i+1); ?>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php permission_menu($title_group, 'post', 'man', $type_group); ?>
                                <?php } ?>
                            <?php } ?>

                            <?php if(!empty($group['static'])) { ?>
                                <?php $current_group = array(); ?>
                                <?php foreach($group['static'] as $type_group) { ?>
                                    <?php $title_group = $config['static'][$type_group]['title']; ?>
                                    <?php permission_menu($title_group, 'static', 'man', $type_group); ?>
                                <?php } ?>
                            <?php } ?>

                            <?php if(!empty($group['photo_static'])) { ?>
                                <?php $current_group = array(); ?>
                                <?php foreach($group['photo_static'] as $type_group) { ?>
                                    <?php $title_group = $config['photo_static'][$type_group]['title']; ?>
                                    <?php permission_menu($title_group, 'photo', 'man_static', $type_group); ?>
                                <?php } ?>
                            <?php } ?>

                            <?php if(!empty($group['photo_multi'])) { ?>
                                <?php $current_group = array(); ?>
                                <?php foreach($group['photo_multi'] as $type_group) { ?>
                                    <?php $title_group = $config['photo_multi'][$type_group]['title']; ?>
                                    <?php permission_menu($title_group, 'photo', 'man_multi', $type_group); ?>
                                <?php } ?>
                            <?php } ?>

                            <?php if(!empty($group['attribute'])) { ?>
                                <?php $current_group = array(); ?>
                                <?php foreach($group['attribute'] as $type_group) { ?>
                                    <?php $title_group = $config['attribute'][$type_group]['title']; ?>
                                    <?php permission_menu($title_group, 'attribute', 'man', $type_group); ?>
                                <?php } ?>
                            <?php } ?>

                            <?php if(!empty($group['order'])) { ?>
                                <?php $current_group = array(); ?>
                                <?php foreach($group['order'] as $type_group) { ?>
                                    <?php $title_group = 'Đơn hàng'; ?>
                                    <?php permission_menu($title_group, 'order', 'man', $type_group); ?>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>
            <?php } ?>

            <?php if(count(@$config['product'])>0) { ?>
                <?php foreach($config['product'] as $type_product => $value) { ?>
                    <?php if(!in_array($type_product, $stack_group)) { ?>
                        <li class="nav-item has-treeview <?php if($com=='product' && $_GET['type']==$type_product) echo 'menu-open' ?>">
                            <a href="#" class="nav-link nav-title">
                                <i class="nav-icon text-sm fas fa-boxes"></i>
                                <p>Quản lý <?=$value['title']?><i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <?php for($i=0; $i < $config['product'][$type_product]['level']; $i++) { ?>
                                    <?php foreach($config['product-lv'.($i+1)] as $type_product_level => $value_level) { ?>
                                        <?php if($type_product == $type_product_level) { ?>
                                            <?php permission_menu($value_level['title'], 'product', 'man_category', $type_product_level, $i+1); ?>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                                <?php permission_menu($value['title'], 'product', 'man', $type_product); ?>
                            </ul>
                        </li>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
                
            <?php if(!empty(@$config['developer']['cart'])) { ?>
                <?php if(!in_array('order', $stack_group)) { ?>
                    <li class="nav-item has-treeview <?php if($com=='order')echo 'menu-open' ?>">
                        <a href="#" class="nav-link nav-title">
                            <i class="nav-icon text-sm fas fa-shopping-cart"></i>
                            <p>Quản lý Đơn hàng<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php permission_menu('Đơn hàng','order','man'); ?>
                        </ul>
                    </li>
                <?php } ?>
            <?php } ?>

            <?php if(!empty(@$config['attribute'])) { ?>
                <?php foreach($config['attribute'] as $type_tags => $value) { ?>
                    <?php if(!in_array($type_tags, $stack_group) && ($type_tags != 'color' && $type_tags != 'size')) { ?>
                        <li class="nav-item has-treeview <?php if($com=='attribute') echo 'menu-open' ?>">
                            <a href="#" class="nav-link nav-title">
                                <i class="nav-icon text-sm fas fa-cubes"></i>
                                <p>Quản lý Thuộc tính<i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <?php foreach($config['attribute'] as $type_attribute => $value) {
                                    if ($type_attribute != 'color' && $type_attribute != 'size') {
                                        echo permission_menu($value['title'], 'attribute', 'man', $type_attribute);
                                    }                            
                                } ?>
                            </ul>
                        </li>
                    <?php } ?>
                <?php } ?>
            <?php } ?>

            <?php if(count($config['post'])>0) { ?>
                <li class="nav-item has-treeview <?php if($com=='post' && !in_array($_GET['type'], $stack_group)) echo 'menu-open' ?>">
                    <a href="#" class="nav-link nav-title">
                        <i class="nav-icon text-sm fab fa-wpforms"></i>
                        <p>Quản lý Bài viết<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php foreach($config['post'] as $type_post => $value) { ?>
                            <?php if(!in_array($type_post, $stack_group)) { ?>
                                <?php for($i=0; $i < $config['post'][$type_post]['level']; $i++) { ?>
                                    <?php foreach($config['post-lv'.($i+1)] as $type_post_level => $value_level) { ?>
                                        <?php if($type_post == $type_post_level) { ?>
                                            <?php permission_menu($value_level['title'], 'post', 'man_category', $type_post_level, $i+1); ?>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                                <?php permission_menu($value['title'], 'post', 'man', $type_post); ?>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>

            <li class="nav-item has-treeview <?php if($com=='static' && !in_array($_GET['type'], $stack_group)) echo 'menu-open' ?>">
                <a href="#" class="nav-link nav-title">
                    <i class="nav-icon text-sm far fa-address-card"></i>
                    <p>Quản lý Trang tĩnh<i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <?php if(count($config['static'])>0) { ?>
                        <?php foreach($config['static'] as $type_static => $value) { ?>
                            <?php if(!in_array($type_static, $stack_group)) { ?>
                                <?php permission_menu($value['title'], 'static', 'man', $type_static); ?>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </li>

            <li class="nav-item has-treeview <?php if(($com=='photo' || $com=='video') && !in_array($_GET['type'], $stack_group)) echo 'menu-open' ?>">
                <a href="#" class="nav-link nav-title">
                    <i class="nav-icon text-sm fas fa-photo-video"></i>
                    <p>Quản lý hình ảnh<?=(@$config['photo_multi']['video']) ? " - Video" : "" ?><i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <?php if(count($config['photo_static'])>0) { ?>
                        <?php foreach($config['photo_static'] as $type_photo_static => $value) { ?>
                            <?php if(!in_array($type_photo_static, $stack_group)) { ?>
                                <?php permission_menu($value['title'], 'photo', 'man_static', $type_photo_static); ?>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                    <?php if(count($config['photo_multi'])>0) { ?>
                        <?php foreach($config['photo_multi'] as $type_photo_multi => $value) { ?>
                            <?php if(!in_array($type_photo_multi, $stack_group)) { ?>
                                <?php permission_menu($value['title'], 'photo', 'man_multi', $type_photo_multi); ?>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </li>

            <li class="nav-item has-treeview <?php if($com=='seo') echo 'menu-open' ?>">
                <a href="#" class="nav-link nav-title">
                    <i class="nav-icon text-sm fas fa-share-alt"></i>
                    <p>Quản lý Seo page<i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <?php if(count($config['seo'])>0) { ?>
                        <?php foreach($config['seo']['page'] as $type_seo => $value_seo) { ?>
                            <?php permission_menu('Page '.$value_seo, 'seo', 'man', $type_seo); ?>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </li>
            
            <li class="nav-item has-treeview <?php if($com=='place') echo 'menu-open' ?>">
                <a href="#" class="nav-link nav-title">
                    <i class="nav-icon text-sm fas fa-map-marked-alt"></i>
                    <p>Quản lý Địa điểm<i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <?php if(count($config['place'])>0) { ?>
                        <?php foreach($config['place'] as $type_place => $value) { ?>
                            <?php permission_menu($value['title'], 'place', 'man', $type_place); ?>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </li>

            <li class="nav-item has-treeview <?php if($com=='setting' || $com=='admin') echo 'menu-open' ?>">
                <a href="#" class="nav-link nav-title">
                    <i class="nav-icon text-sm fas fa-cogs"></i>
                    <p>Quản lý Website<i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <?php permission_menu('Cấu hình Website','setting','man'); ?>
                    <?php permission_menu('Thông tin tài khoản', 'admin', 'info', 'admin'); ?>
                    <?php permission_menu('Đổi mật khẩu', 'admin', 'password', 'admin'); ?>
                </ul>
            </li>
        </ul>
    </section>
</aside>