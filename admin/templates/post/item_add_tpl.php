<?php
    if($_GET['act'] == 'copy') $action = "index.php?com=".$com."&act=save_copy&type=".$type."&p=".$p."";
    else $action = "index.php?com=".$com."&act=save&type=".$type.$p.@$id_lv."";
?>
<div class="content-wrapper">

	<section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h4><?=$config['post'][$type]['title']?></h4>
                </div>
            </div>
        </div>
    </section>
	
    <form class="frm-admin content" method="post" action="<?=$action?>" enctype="multipart/form-data">
    	<div class="row">
            <?php if($config['post'][$type]['level']>0 || $config['post'][$type]['tags'] == true || $config['post'][$type]['photo'] == true || $config['post'][$type]['file'] == true) { ?>
        		<div class="col-md-4">
        			<div class="card card-outline card-danger">
        				<div class="card-header d-flex">
        					<h3 class="card-title">Hình ảnh</h3>
        				</div>

        				<div class="card-body">
                            <?php for($i=0; $i < $config['post'][$type]['level']; $i++) { ?>
                                <div class="form-group">
                                    <label><?=$config['post'][$type]['title']?> cấp <?=$i+1?></label>
                                    <?=get_ajax_category("category", "id_lv".($i+1)."", $type, $i+1)?>
                                </div>
                            <?php } ?>

                            <?php if($config['post'][$type]['tags']=='true') { ?>
                                <div class="form-group">
                                    <label>Tags</label>
                                    <?=get_tags(@$item['id'], $type.'_tags')?>
                                </div>
                            <?php } ?>

                            <?php if($config['post'][$type]['photo']=='true') { ?>
                                <div class="form-group">
                                    <?php include LAYOUT."photo.php";?>
                                </div>
        					<?php } ?>

                            <?php if($config['post'][$type]['file']=='true') {
                                $upload->setTitle('Upload File');
                                $upload->setData('file');
                                $upload->setName('file');
                                $upload->setDir(UPLOAD_FILE);
                                $upload->file();
                            } ?>
                            
                            <?php if($config['post'][$type]['gallery']=='true') { ?>
                                <?php include LAYOUT."gallery.php";?>
                            <?php } ?>
        				</div>
        			</div>
        		</div>
            <?php } ?>
            <div class="<?=($config['post'][$type]['level']>0 || $config['post'][$type]['tags'] == true || $config['post'][$type]['photo'] == true || $config['post'][$type]['file'] == true) ? "col-md-8" : "col-12"?>">
                <div class="card card-outline card-danger">
                    <div class="card-header d-flex">
                        <h3 class="card-title">Thông tin</h3>
                    </div>

                    <div class="card-body">
                        <?php foreach($config['post'][$type]['text'] as $attr => $value) { ?>
                            <?php if($value['lang']==false) { ?>
                                <div class="form-group">
                                    <label><?=$value['text']?></label>
                                    <?php if($value['type'] == 'textarea') { ?>
                                        <textarea id="<?=$attr.$lang?>" class="form-control <?php if($value['ckeditor']==true) echo "editor" ?> <?php if(@$value['validate']) echo "validate[required]" ?>" name="data[<?=$attr.$lang?>]" rows="<?=$value['rows']?>"/><?=$func->decode(@$item[$attr.$lang])?></textarea>                                         
                                    <?php } ?>
                                    <?php if($value['type'] == 'input') { ?>
                                        <input class="form-control <?php if($value['ckeditor']==true) echo "editor" ?> <?php if($value['validate']) echo "validate[required]" ?>" name="data[<?=$attr.@$lang?>]" value="<?=@$item[$attr.$lang]?>">
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        <?php } ?>
                        <?php if($act == 'edit' || $act == 'copy') { ?>
                            <?php if($config['post'][$type]['slug']=='true') { ?>
                                <?php include LAYOUT."slug.php";?>
                            <?php } ?>
                        <?php } ?>

                        <div class="nav-tabs-custom">
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
                                    <?php foreach($config['post'][$type]['text'] as $attr => $value) { ?>
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

                            <?php if($config['post'][$type]['seo']=='true') { ?>
                                <?php include LAYOUT."seo.php";?>
                            <?php } ?>
                        </div>

                        <div class="form-group form-number d-flex align-items-center">
	                    	<label>Số thứ tự</label>
	                    	<input type="text" class="form-control" name="data[number]" value="<?=(!empty(@$item['number'])) ? $item['number'] : 1?>" onkeypress="return OnlyNumber(event)">
	                    </div>

	                    <div class="cover-check">
                            <?php @$attr_array = explode(',', $item['status']); ?>
	                    	<?php foreach($config['post'][$type]['attr'] as $attr => $attr_value) { ?>
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

    	<div class="cover-button d-flex">
        	<input type="hidden" name="id" value="<?=!empty($item['id']) ? $item['id'] : 0?>" />
        	<input type="hidden" name="data[type]" value="<?=$type?>" />
            <button type="button" class="btn btn-primary" onclick="submit_admin(true)"><i class="far fa-save mr-1"></i>Hoàn tất</button>
            <button type="button" class="btn btn-danger"><a href="index.php"><i class="fas fa-sign-out-alt mr-1"></i>Thoát</a></button>
        </div>

    </form>
</div>