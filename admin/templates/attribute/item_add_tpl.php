<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h4><?=$config['attribute'][$type]['title']?></h4>
                </div>
            </div>
        </div>
    </section>    
    <form class="frm-admin content" method="post" action="index.php?com=<?=$com?>&act=save&type=<?=$type?>&id_parent=<?=$id_parent?>&p=<?=$p?>" enctype="multipart/form-data">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-danger">
                    <div class="card-header d-flex">
                        <h3 class="card-title">Thông tin</h3>
                    </div>
                    <div class="card-body">
                        <div class="nav-tabs-custom">
                            <div class="row">
                                <?php if($config['attribute'][$type]['photo']=='true') { ?>
                                    <div class="form-group col-md-4">
                                        <?php include LAYOUT."photo.php";?>
                                    </div>
                                <?php } ?>

                                <div class="col-12">
                                    <?php if ($config['attribute'][$type]['lang'] == true) { ?>
                                        <?php if(count($config['website']['lang'])>1) {?>
                                            <ul class="nav nav-pills mb-2">
                                                <?php foreach ($config['website']['lang'] as $lang => $value) { ?>
                                                    <li class="item-tab">
                                                        <a class="nav-link" href="javascript:0" data-lang="<?=$lang?>"><?=$value?></a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        <?php } ?>
                                        <?php foreach ($config['website']['lang'] as $lang => $value) { ?>
                                            <div class="tab-content content-<?=$lang?>">
                                                <div class="row">
                                                    <?php foreach($config['attribute'][$type]['text'] as $attr => $value) { ?>
                                                        <?php if($value['lang']==true) { ?>
                                                            <div class="form-group <?=$value['col']?>">
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
                                            </div>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <div class="row">
                                            <?php foreach($config['attribute'][$type]['text'] as $attr => $value) { ?>
                                                <?php if($value['lang']==false) { ?>
                                                    <div class="form-group <?=$value['col']?>">
                                                        <label><?=$value['text']?></label>
                                                        <?php if($value['type'] == 'textarea') { ?>
                                                            <textarea id="<?=$attr?>" class="form-control <?php if($value['ckeditor']==true) echo "editor" ?> <?php if(@$value['validate']) echo "validate[required]" ?>" name="data[<?=$attr?>]" rows="<?=$value['rows']?>"/><?=$func->decode(@$item[$attr])?></textarea>
                                                        <?php } ?>
                                                        <?php if($value['type'] == 'input') { ?>
                                                            <input id="<?=$attr?>" class="form-control <?php if($value['ckeditor']==true) echo "editor" ?> <?php if($value['validate']) echo "validate[required]" ?>" name="data[<?=$attr?>]" value="<?=@$item[$attr]?>">
                                                        <?php } ?>
                                                    </div>
                                                <?php } ?>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </div>

                                <?php if($config['attribute'][$type]['price']=='true') { ?>
                                    <div class="form-group col-md-4">
                                        <label>Giá</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" value="<?=@$item['price']?>" name="data[price]" onkeypress="return OnlyNumber(event)"/>
                                            <div class="input-group-append">
                                                <span class="input-group-text">VNĐ</span>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if($config['attribute'][$type]['old_price']=='true') { ?>
                                    <div class="form-group col-md-4">
                                        <label>Giá cũ</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" value="<?=@$item['old_price']?>" name="data[old_price]" onkeypress="return OnlyNumber(event)"/>
                                            <div class="input-group-append">
                                                <span class="input-group-text">VNĐ</span>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if($config['attribute'][$type]['color']=='true') { ?>
                                    <div class="col-12">
                                        <div class="form-group box-color">
                                            <label>Color:</label>
                                            <div class="form-group d-flex">
                                                <input type="hidden" class="colorpicker-element" name="data[attribute]" value="<?=@$item['attribute']?>"/>
                                                <input type="text" class="form-control" value="<?=@$item['attribute']?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="form-group form-number d-flex align-items-center">
                                <label>Số thứ tự</label>
                                <input type="text" class="form-control" name="data[number]" value="<?=(!empty(@$item['number'])) ? $item['number'] : 1?>" onkeypress="return OnlyNumber(event)">
                            </div>

                            <div class="cover-check">
                                <?php $attr_array = explode(',', @$item['status']); ?>
                                <?php foreach($config['attribute'][$type]['attr'] as $attr => $attr_value) { ?>
                                    <div class="form-group">
                                        <label><?=$attr_value?></label>
                                        <a class="check-items <?=(in_array($attr, $attr_array) || ($act == 'add'.$case)) ? 'active' : ''?>" data-attr="<?=$attr?>">
                                            <input type="checkbox" name="status[<?=$attr?>]" value="<?=(in_array($attr, $attr_array) || ($act == 'add'.$case)) ? $attr : ""?>" checked>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="cover-button d-flex">
            <input type="hidden" name="id" value="<?=@$item['id']?>" />
            <input type="hidden" name="data[id_parent]" value="<?=@$id_parent?>" />
            <input type="hidden" name="data[type]" value="<?=@$type?>" />
            <button type="button" class="btn btn-primary" onclick="submit_admin()"><i class="far fa-save mr-1"></i>Hoàn tất</button>
            <button type="button" class="btn btn-danger"><a href="index.php"><i class="fas fa-sign-out-alt mr-1"></i>Thoát</a></button>
        </div>
    </form>
</div>