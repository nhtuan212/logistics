<?php
	$linkSave = "index.php?com=setting&act=save";
	$options = (isset($item['options']) && $item['options'] != '') ? json_decode($item['options'],true) : null;
?>
<div class="content-wrapper">
	<section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?=$config['setting'][$type]['title']?></h1>
                </div>
            </div>
        </div>
    </section>

    <form class="frm-admin content" action="index.php?com=<?=$com?>&act=save" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-outline card-danger">
                    <div class="card-header d-flex">
                        <h3 class="card-title">Thông tin</h3>
                    </div>
                    <div class="card-body">
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

                            <?php foreach($config['website']['lang'] as $lang => $value) { ?>
                                <div class="tab-content content-<?=$lang?>">
                                    <div class="form-group">
                                        <label>Tên</label>
                                        <input type="text" class="form-control" name="data[options][name<?=$lang?>]" value="<?=@$options['name'.$lang]?>"/>
                                    </div>
                                    <div class="form-group">
                                        <label>Địa chỉ</label>
                                        <input type="text" class="form-control" name="data[options][address<?=$lang?>]" value="<?=@$options['address'.$lang]?>"/>
                                    </div>
                                    <?php foreach($config['setting'][$type]['text'] as $attr => $value) { ?>
                                        <?php if($value['lang']==true) { ?>
                                        	<div class="form-group <?=@$value['col']?>">
                                                <label><?=$value['text']?></label>
                                                <?php if($value['type'] == 'textarea') { ?>
                                                    <textarea id="<?=$attr.$lang?>" class="form-control <?php if($value['ckeditor']==true) echo "editor" ?> <?php if(@$value['validate']) echo "validate[required]" ?>" name="data[options][<?=$attr.$lang?>]" rows="<?=$value['rows']?>"/><?=$func->decode(@$options[$attr.$lang])?></textarea>                                        
                                                <?php } ?>
                                                <?php if($value['type'] == 'input') { ?>
                                                    <input class="form-control <?php if($value['ckeditor']==true) echo "editor" ?> <?php if($value['validate']) echo "validate[required]" ?>" name="data[options][<?=$attr.@$lang?>]" value="<?=@$options[$attr.$lang]?>">
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                            <?php include LAYOUT."seo.php";?>
                        </div>

                        <div class="row mt-2">
                        	<div class="col-sm-6"><?php include LAYOUT."photo.php";?></div>
                        	<div class="col-sm-6">
                        		<?=$upload->setTitle('Upload Favicon')?>
                        		<?=$upload->setData('favicon')?>
                        		<?=$upload->setName('favicon')?>
                        		<?=$upload->setWidth(32)?>
                        		<?=$upload->setheight(32)?>
                        		<?=$upload->photo()?>
                        	</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-outline card-danger">
                    <div class="card-header with-border">
                        <h3 class="card-title">Thông tin khác</h3>
                    </div>
                    <div class="card-body">
                    	<div class="row">
                    		<?php if($myPermission) { ?>
                    			<div class="form-group col-md-4">
                    				<label>Ip host</label>
                    				<input type="text" class="form-control" name="data[options][ip_host]" value="<?=@$options['ip_host']?>"/>
                    			</div>
                    			<div class="form-group col-md-4">
                    				<label>Email host</label>
                    				<input type="text" class="form-control" name="data[options][email_host]" value="<?=@$options['email_host']?>"/>
                    			</div>
                    			<div class="form-group col-md-4">
                    				<label>Pass host</label>
                    				<input type="password" class="form-control" name="data[options][pass_host]" value="<?=@$options['pass_host']?>"/>
                    			</div>
                    			<div class="form-group col-md-12">
                    				<label>Site Key</label>
                    				<input type="text" class="form-control" name="data[options][site_key]" value="<?=@$options['site_key']?>"/>
                    			</div>
                    			<div class="form-group col-md-12">
                    				<label>Secret Key</label>
                    				<input type="text" class="form-control" name="data[options][secret_key]" value="<?=@$options['secret_key']?>"/>
                    			</div>
                    		<?php } ?>
                    	</div>
                        <div class="row">
                        	<div class="form-group col-md-6">
                        		<label>Website</label>
                        		<input type="text" class="form-control" name="data[options][website]" value="<?=@$options['website']?>"/>
                        	</div>
                        	<div class="form-group col-md-6">
                        		<label>Email</label>
                        		<input type="text" class="form-control" name="data[options][email]" value="<?=@$options['email']?>"/>
                        	</div>
                        	<div class="form-group col-md-6">
                        		<label>Điện thoại</label>
                        		<input type="text" class="form-control" name="data[options][phone]" value="<?=@$options['phone']?>"/>
                        	</div>
                        	<div class="form-group col-md-6">
                        		<label>Fanpage</label>
                        		<input type="text" class="form-control" name="data[options][fanpage]" value="<?=@$options['fanpage']?>"/>
                        	</div>
                        	<?php foreach($config['setting'][$type]['text'] as $attr => $value) { ?>
                        		<?php if($value['lang']==false) { ?>
                        			<div class="form-group <?=@$value['col']?>">
                                        <label><?=$value['text']?></label>
                                        <?php if($value['type'] == 'textarea') { ?>
                                            <textarea id="<?=$attr.$lang?>" class="form-control <?php if($value['ckeditor']==true) echo "editor" ?> <?php if(@$value['validate']) echo "validate[required]" ?>" name="data[options][<?=$attr?>]" rows="<?=$value['rows']?>"/><?=$func->decode(@$options[$attr])?></textarea>                                         
                                        <?php } ?>
                                        <?php if($value['type'] == 'input') { ?>
                                            <input class="form-control <?php if($value['ckeditor']==true) echo "editor" ?> <?php if($value['validate']) echo "validate[required]" ?>" name="data[options][<?=$attr?>]" value="<?=@$options[$attr]?>">
                                        <?php } ?>
                                    </div>
                        		<?php } ?>
                        	<?php } ?>
                        	<div class="col-md-12"></div>
                        	<div class="form-group col-md-6 none">
                        		<label>Số Sản phẩm trang chủ</label>
                        		<input type="text" class="form-control" name="data[options][qpro]" value="<?=@$options['qpro']?>"/>
                        	</div>
                        	<div class="form-group col-md-6">
                        		<label>Số Sản phẩm trang trong</label>
                        		<input type="text" class="form-control" name="data[options][qpro_ins]" value="<?=@$options['qpro_ins']?>"/>
                        	</div>
                        	<div class="form-group col-md-6 none">
                        		<label>Số Bài viết trang chủ</label>
                        		<input type="text" class="form-control" name="data[options][qpost]" value="<?=@$options['qpost']?>"/>
                        	</div>
                        	<div class="form-group col-md-6">
                        		<label>Số Bài viết trang trong</label>
                        		<input type="text" class="form-control" name="data[options][qpost_ins]" value="<?=@$options['qpost_ins']?>"/>
                        	</div>
                        </div>
                        <div class="form-group">
                            <label>Iframe Map</label>
                            <textarea class="form-control" name="data[options][iframe]" rows="6" style="resize: none;"><?=$func->decode($options['iframe'])?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Head JS - Analytics ...</label>
                            <textarea class="form-control" name="data[options][headjs]" rows="5" style="resize: none;"><?=(!empty($options['headjs'])) ? $options['headjs'] : ""?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Body JS - Vchat - Animate ...</label>
                            <textarea class="form-control" name="data[options][bodyjs]" rows="5" style="resize: none;"><?=(!empty($options['bodyjs'])) ? $options['bodyjs'] : ""?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="cover-button d-flex justify-content-end">
            <input type="hidden" name="id" value="<?=$item['id']?>" />
            <button type="button" class="btn btn-primary" onclick="submit_admin()"><i class="far fa-save mr-1"></i>Hoàn tất</button>
            <button type="button" class="btn btn-danger"><a href="index.php"><i class="fas fa-sign-out-alt mr-1"></i>Thoát</a></button>
        </div>
    </form>
</div>