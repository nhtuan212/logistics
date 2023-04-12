<div class="content-wrapper">
	<section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1><?=$config['user'][$type]['title']?></h1>
                </div>
            </div>
        </div>
    </section>

    <form class="frm-admin content" action="index.php?com=<?=$com?>&act=save&type=<?=$type?>" method="post" enctype="multipart/form-data">
		<div class="row">
			<div class="col-12">
				<div class="card card-outline card-danger">
					<div class="card-body">
						<?php if(($config['permission'] == 'true') && ($config['user'][$type]['permission'] == 'true')) { ?>
							<div class="row">
								<div class="form-group col-md-6">
									<label>Phân quyền</label>
									<select class="form-control" name="data[id_permission]">
										<option value="">Chọn Quyền</option>
										<?php $permission = $d->rawQuery("select id, name from #_permission where FIND_IN_SET('display', status) order by number, id desc"); ?>
										<?php for ($i=0; $i < count($permission); $i++) { ?>
											<option value="<?=$permission[$i]['id']?>" <?=($item['id_permission'] == $permission[$i]['id']) ? "selected" : "" ?>>
												<?=$permission[$i]['name']?>
											</option>
										<?php } ?>
									</select>
								</div>
							</div>
						<?php } ?>

						<div class="row">
							<?php if($config['user'][$type]['photo'] == 'true') { ?>
								<div class="form-group col-md-6">
									<?php include LAYOUT."photo.php";?>
								</div>
							<?php } ?>
						</div>

						<div class="row">
							<div class="form-group col-md-4">
								<label>Username</label>
								<input type="text" class="form-control <?=($act=='add') ? "validate[required]" : ""?>" name="data[username]" value="<?=@$item['username']?>" <?=($act=='edit') ? "readonly" : ""?>/>
							</div>
							<div class="form-group col-md-4">
								<label>Password</label>
								<input type="password" class="form-control <?=($act=='add') ? "validate[required]" : ""?>" name="password" value=""/>
							</div>
						</div>

						<div class="row">
							<?php foreach($config['user'][$type]['text'] as $attr => $value) { ?>
								<div class="form-group <?=$value['col']?>">
									<label><?=$value['text']?></label>
									<input class="form-control <?php if($value['ckeditor']==true) echo "editor" ?> <?php if($value['validate']) echo "validate[required]" ?>" name="data[options][<?=$attr?>]" value="<?=@$options[$attr]?>">
								</div>
							<?php } ?>
						</div>

						<div class="form-group form-number d-flex align-items-center">
	                    	<label>Số thứ tự</label>
	                    	<div class="number">
	                    		<input type="text" class="form-control" data-id="<?=$item['id']?>" data-tbl="<?=$tbl?>" data-attr="number" name="data[number]" value="<?=($item['number']>0) ? $item['number'] : 1?>" onkeypress="return OnlyNumber(event)">
	                    	</div>
	                    </div>
	                    <div class="cover-check">
                            <?php $attr_array = explode(',', $item['status']); ?>
	                    	<?php foreach($config['user'][$type]['attr'] as $attr => $attr_value) { ?>
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
		<div class="cover-button d-flex justify-content-end">    
			<input type="hidden" name="id" value="<?=@$item['id']?>" />
			<input type="hidden" name="data[type]" value="<?=$type?>" />
			<button type="button" class="btn btn-primary" onclick="submit_admin()"><i class="far fa-save mr-1"></i>Hoàn tất</button>
			<button type="button" class="btn btn-danger"><a href="index.php"><i class="fas fa-sign-out-alt mr-1"></i>Thoát</a></button>
		</div>
	</form>
</div>