<?php
    if($_GET['act'] == 'copy_category') $action = "index.php?com=".$com."&act=save_copy_category&type=".$type."&level=".$level."&p=".$p."";
    else $action = "index.php?com=".$com."&act=save_category&type=".$type."&level=".$level.$id_lv.$p."";
?>
<div class="content-wrapper">
	<section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h4><?=@$config[$com."-lv".$level][$type]['title']?></h4>
                </div>
            </div>
        </div>
    </section>	
	
    <form class="frm-admin content" method="post" action="<?=$action?>" enctype="multipart/form-data">
    	<div class="row">
            <?php if($config[$com."-lv".$level][$type]['photo']=='true') { ?>
                <div class="col-12">
                    <div class="card card-outline card-danger">
                        <div class="card-header d-flex">
                            <h3 class="card-title">Hình ảnh</h3>
                        </div>
                        <div class="card-body">
                            <div class="col-4">
                                <?php include LAYOUT."photo.php";?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

    		<div class="col-12">
    			<div class="card card-outline card-danger">
    				<div class="card-header d-flex">
    					<h3 class="card-title">Thông tin</h3>
    				</div>

    				<div class="card-body">
                        <?php foreach($config[$com."-lv".$level][$type]['text'] as $attr => $value) { ?>
                            <?php if($value['lang']==false) { ?>
                                <div class="form-group">
                                    <label><?=$value['text']?></label>
                                    <textarea id="<?=$attr?>" class="form-control <?php if($value['ckeditor']==true) echo "editor" ?> <?php if($value['validate']) echo "validate[required]" ?>" name="data[<?=$attr?>]" rows="<?=$value['rows']?>"/><?=$func->decode(@$item[$attr])?></textarea>
                                </div>
                            <?php } ?>
                        <?php } ?>
                        
                        <div class="row">
                            <?php for($i=0; $i < $level-1; $i++) { ?>
                                <div class="form-group col-md-4">
                                    <label>Sản phẩm cấp <?=$i+1?></label>
                                    <?=get_ajax_category($tbl, "id_lv".($i+1)."", $type, $i+1)?>
                                </div>
                            <?php } ?>
                        </div>

                        <?php if($act == 'edit_category' || $act == 'copy_category') { ?>
                            <?php if($config[$com.'-lv'.$level][$type]['slug']=='true') { ?>
                                <?php include LAYOUT."slug.php";?>
                            <?php } ?>
                        <?php } ?>

                        <div class="nav-tabs-custom">
                            <?php if (count($config['website']['lang'])>1) {?>   
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
                                    <?php foreach($config[$com."-lv".$level][$type]['text'] as $attr => $value) { ?>
                                        <?php if($value['lang']==true) { ?>
                                           <div class="form-group">
                                              <label><?=$value['text']?></label>
                                              <textarea id="<?=$attr?>" class="form-control <?php if($value['ckeditor']==true) echo "editor" ?> <?php if($value['validate']) echo "validate[required]" ?>" name="data[<?=$attr.$lang?>]" rows="<?=$value['rows']?>"/><?=$func->decode(@$item[$attr.$lang])?></textarea>
                                          </div>
                                      <?php } ?>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>

                        <?php if($config[$com."-lv".$level][$type]['seo']=='true') { ?>
                            <?php include LAYOUT."seo.php";?>
                        <?php } ?>

                        <div class="form-group form-number d-flex align-items-center">
                            <label>Số thứ tự</label>
                            <input type="text" class="form-control" name="data[number]" value="<?=(!empty(@$item['number'])) ? $item['number'] : 1?>" onkeypress="return OnlyNumber(event)">
                        </div>

                        <div class="cover-check">
                            <?php $attr_array = explode(',', @$item['status']); ?>
                            <?php foreach($config[$com."-lv".$level][$type]['attr'] as $attr => $attr_value) { ?>
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
            
            <?php if($config[$com."-lv".$level][$type]['gallery']=='true') { ?>                
                <div class="col-12">
                    <div class="card card-outline card-danger">
                        <div class="card-header d-flex">
                            <h3 class="card-title">Hình đính kèm</h3>
                        </div>
                        <div class="card-body"><?php include LAYOUT."gallery.php";?></div>
                    </div>
                </div>
            <?php } ?>
    	</div>

        <div class="cover-button d-flex">
            <input type="hidden" name="id" value="<?=!empty($item['id']) ? $item['id'] : 0?>" />
            <input type="hidden" name="data[type]" value="<?=$type?>" />
            <input type="hidden" name="data[level]" value="<?=$level?>" />
            <button type="button" class="btn btn-primary" onclick="submit_admin(true)"><i class="far fa-save mr-1"></i>Hoàn tất</button>
            <button type="button" class="btn btn-danger"><a href="index.php"><i class="fas fa-sign-out-alt mr-1"></i>Thoát</a></button>
        </div>
    </form>
</div>