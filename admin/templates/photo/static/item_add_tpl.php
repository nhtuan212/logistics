<?php $options = (isset($item['options']) && $item['options'] != '') ? json_decode($item['options'],true) : null; ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h4><?=$config['photo_static'][$type]['title']?></h4>
                </div>
            </div>
        </div>
    </section>  
    
    <form id="form-watermark" class="frm-admin content" method="post" action="index.php?com=<?=$com?>&act=save_static&type=<?=$type?>" enctype="multipart/form-data">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-danger">
                    <div class="card-header d-flex">
                        <h3 class="card-title">Thông tin</h3>
                    </div>

                    <div class="card-body">
                        <div class="nav-tabs-custom">
                            <div class="row">
                                <div class="col-md-5">
                                    <?php if($config['photo_static'][$type]['photo']=='true') include LAYOUT."photo.php"; ?>
                                </div>
                                <?php if($myPermission) { ?>
                                    <div class="col-md-7"><?php require LAYOUT."watermark.php"; ?></div>
                                <?php } ?>
                            </div>
                            <div class="row">
                                <?php if($config['photo_static'][$type]['link']=='true') { ?>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Link</label>
                                            <input type="text" class="form-control" value="<?=@$item['link']?>" name="data[link]"/>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            
                            <?php if (count($config['website']['lang'])>1 && !empty($config['photo_static'][$type]['text'])) {?>   
                                <ul class="nav nav-pills mb-2">
                                    <?php foreach ($config['website']['lang'] as $lang => $value) { ?>
                                        <li class="item-tab">
                                            <a class="nav-link" href="javascript:0" data-lang="<?=$lang?>"><?=$value?></a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            <?php } ?>

                            <?php foreach($config['website']['lang'] as $lang => $value) { ?>
                                <div class="tab-content content-<?=$lang?>">
                                    <?php foreach($config['photo_static'][$type]['text'] as $attr => $value) { ?>
                                        <?php if($value['lang']==true) { ?>
                                            <div class="form-group">
                                                <label><?=$value['text']?></label>
                                                <?php if($value['type'] == 'textarea') { ?>
                                                    <textarea id="<?=$attr.$lang?>" class="form-control <?php if($value['ckeditor']==true) echo "editor" ?> <?php if(@$value['validate']) echo "validate[required]" ?>" name="data[<?=$attr.$lang?>]" rows="<?=$value['rows']?>"/><?=$func->decode(@$item[$attr.$lang])?></textarea>                                         
                                                <?php } ?>
                                                <?php if($value['type'] == 'input') { ?>
                                                    <input id="<?=$attr.$lang?>" class="form-control <?php if($value['ckeditor']==true) echo "editor" ?> <?php if($value['validate']) echo "validate[required]" ?>" name="data[<?=$attr.@$lang?>]" value="<?=@$item[$attr.$lang]?>">
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                            <div class="cover-check">
                                <?php $attr_array = explode(',', $item['status']); ?>
                                <?php foreach($config['photo_static'][$type]['attr'] as $attr => $attr_value) { ?>
                                    <div class="form-group">
                                        <label><?=$attr_value?></label>
                                        <a class="check-items <?=(in_array($attr, $attr_array)) ? 'active' : ''?>" data-attr="<?=$attr?>">
                                            <input type="checkbox" name="status[<?=$attr?>]" value="<?=(in_array($attr, $attr_array)) ? $attr : ""?>" checked>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="cover-button d-flex justify-content-end">
            <input type="hidden" name="id" value="<?=!empty($item['id']) ? $item['id'] : 0?>" />
            <input type="hidden" name="data[type]" value="<?=$type?>" />
            <input type="hidden" name="data[date_updated]" value="<?=time()?>" />
            <button type="button" class="btn btn-primary" onclick="submit_admin()"><i class="far fa-save mr-1"></i>Hoàn tất</button>
            <button type="button" class="btn btn-danger"><a href="index.php"><i class="fas fa-sign-out-alt mr-1"></i>Thoát</a></button>
        </div>

    </form>
</div>