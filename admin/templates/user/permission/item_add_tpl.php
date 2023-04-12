<div class="content-wrapper">
	<section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1>Phân quyền user</h1>
                </div>
            </div>
        </div>
    </section>

    <form class="frm-admin frm-permission content" action="index.php?com=<?=@$com?>&act=save&type=<?=@$type?>" method="post" enctype="multipart/form-data">
		<div class="row">
			<div class="col-12">
				<div class="card card-outline card-danger">
					<div class="card-body">
						<div class="form-group">
							<label>Tên nhóm quyền</label>
							<input type="text" class="form-control validate[required]" name="data[name]" value="<?=@$item['name']?>"/>
						</div>

						<div class="cover-check">
							<div class="form-group form-number d-flex">
								<label>Số thứ tự</label>
								<div class="number">
									<input type="text" class="form-control" data-id="<?=@$item['id']?>" data-tbl="<?=$tbl?>" data-attr="number" name="data[number]" value="<?=(@$item['number']>0) ? @$item['number'] : 1?>" onkeypress="return OnlyNumber(event)">
								</div>
							</div>
							<div class="cover-check">
                                <?php @$attr_array = explode(',', $item['status']); ?>
                                <div class="form-group">
                                    <label>Hiển thị</label>
                                    <a class="check-items <?=(in_array('display', $attr_array) || ($act == 'add'.$case)) ? 'active' : ''?>" data-attr="display">
                                        <input type="checkbox" name="status[display]" value="<?=(in_array('display', $attr_array) || ($act == 'add'.$case)) ? 'display' : ""?>" checked>
                                    </a>
                                </div>
                            </div>
						</div>

						<button type="button" class="btn btn-outline-primary" onclick="AllPermission()">Chọn tất cả</button>
						<button type="button" class="btn btn-outline-danger ml10" onclick="UnAllPermission()">Bỏ chọn tất cả</button>
					</div>
				</div>
			</div>
			<?php if(@count($config['product'])>0) { ?>
				<div class="col-12">
					<div class="card card-outline card-danger">
						<div class="card-header">
							<h3 class="card-title d-flex">
								<a class="check PermissionGroup"></a>
								<span>Sản phẩm</span>
							</h3>
						</div>
						<div class="card-body">
							<?php foreach($config['product'] as $type_product => $value) { ?>
								<?php for($i=0; $i < $config['product'][$type_product]['level']; $i++) { ?>
									<?php foreach($config['product-lv'.($i+1)] as $type_product_level => $value_level) { ?>
										<?php if(@$type_product == $type_product_level) { ?>
											<div class="form-group row item-permission">
												<label class="col-sm-2 col-form-label d-flex">
													<a class="check PermissionTitle"></a>
													<span><?=$value_level['title']?></span>
												</label>
												<div class="col-sm-10 d-flex flex-wrap">
													<div class="check-permission d-flex">
														<a class="check <?= (in_array('product,man_category,'.$type_product.','.($i+1), $list_permission)) ? "active" : "" ?>">
															<input type="checkbox" name="permission[]" value="product,man_category,<?=$type_product_level?>,<?=($i+1)?>" <?php if(@$list_permission) echo (in_array('product,man_category,'.$type_product_level.','.($i+1), $list_permission)) ? "checked" : "" ?>>
														</a>
														<label>Xem</label>
													</div>
													<div class="check-permission d-flex">
														<a class="check <?= (in_array('product,add_category,'.$type_product.','.($i+1), $list_permission)) ? "active" : "" ?>">
															<input type="checkbox" name="permission[]" value="product,add_category,<?=$type_product_level?>,<?=($i+1)?>" <?php if(@$list_permission) echo (in_array('product,add_category,'.$type_product_level.','.($i+1), $list_permission)) ? "checked" : "" ?>>
														</a>
														<label>Thêm</label>
													</div>
													<div class="check-permission d-flex">
														<a class="check <?= (in_array('product,edit_category,'.$type_product.','.($i+1), $list_permission)) ? "active" : "" ?>">
															<input type="checkbox" name="permission[]" value="product,edit_category,<?=$type_product_level?>,<?=($i+1)?>" <?php if(@$list_permission) echo (in_array('product,edit_category,'.$type_product_level.','.($i+1), $list_permission)) ? "checked" : "" ?>>
														</a>
														<label>Sửa</label>
													</div>
													<div class="check-permission d-flex">
														<a class="check <?= (in_array('product,delete_category,'.$type_product.','.($i+1), $list_permission)) ? "active" : "" ?>">
															<input type="checkbox" name="permission[]" value="product,delete_category,<?=$type_product_level?>,<?=($i+1)?>" <?php if(@$list_permission) echo (in_array('product,delete_category,'.$type_product_level.','.($i+1), $list_permission)) ? "checked" : "" ?>>
														</a>
														<label>Xóa</label>
													</div>
												</div>
											</div>
										<?php } ?>
									<?php } ?>
								<?php } ?>
								<div class="form-group row item-permission">
									<label class="col-sm-2 col-form-label d-flex">
										<a class="check PermissionTitle"></a>
										<span><?=$value['title']?></span>
									</label>
									<div class="col-sm-10 d-flex flex-wrap">
										<div class="check-permission d-flex">
											<a class="check <?= (in_array('product,man,'.$type_product.',0', $list_permission)) ? "active" : "" ?>">
												<input type="checkbox" name="permission[]" value="product,man,<?=$type_product?>,0" <?php if(@$list_permission) echo (in_array('product,man,'.$type_product.',0', $list_permission)) ? "checked" : "" ?>>
											</a>
											<label>Xem</label>
										</div>
										<div class="check-permission d-flex">
											<a class="check <?= (in_array('product,add,'.$type_product.',0', $list_permission)) ? "active" : "" ?>">
												<input type="checkbox" name="permission[]" value="product,add,<?=$type_product?>,0" <?php if(@$list_permission) echo (in_array('product,add,'.$type_product.',0', $list_permission)) ? "checked" : "" ?>>
											</a>
											<label>Thêm</label>
										</div>
										<div class="check-permission d-flex">
											<a class="check <?= (in_array('product,edit,'.$type_product.',0', $list_permission)) ? "active" : "" ?>">
												<input type="checkbox" name="permission[]" value="product,edit,<?=$type_product?>,0" <?php if(@$list_permission) echo (in_array('product,edit,'.$type_product.',0', $list_permission)) ? "checked" : "" ?>>
											</a>
											<label>Sửa</label>
										</div>
										<div class="check-permission d-flex">
											<a class="check <?= (in_array('product,delete,'.$type_product.',0', $list_permission)) ? "active" : "" ?>">
												<input type="checkbox" name="permission[]" value="product,delete,<?=$type_product?>,0" <?php if(@$list_permission) echo (in_array('product,delete,'.$type_product.',0', $list_permission)) ? "checked" : "" ?>>
											</a>
											<label>Xóa</label>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			<?php } ?>
			<?php if(@count($config['post'])>0) { ?>
				<div class="col-12">
					<div class="card card-outline card-danger">
						<div class="card-header">
							<h3 class="card-title d-flex">
								<a class="check PermissionGroup"></a>
								<span>Bài viết</span>
							</h3>
						</div>
						<div class="card-body">
							<?php foreach($config['post'] as $type_post => $value) { ?>
								<?php for($i=0; $i < $config['post'][$type_post]['level']; $i++) { ?>
									<?php foreach($config['post-lv'.($i+1)] as $type_post_level => $value_level) { ?>
										<?php if(@$type_post == $type_post_level) { ?>
											<div class="form-group row item-permission">
												<label class="col-sm-2 col-form-label d-flex">
													<a class="check PermissionTitle"></a>
													<span><?=$value_level['title']?></span>
												</label>
												<div class="col-sm-10 d-flex flex-wrap">
													<div class="check-permission d-flex">
														<a class="check <?= (in_array('post,man_category,'.$type_post.','.($i+1), $list_permission)) ? "active" : "" ?>">
															<input type="checkbox" name="permission[]" value="post,man_category,<?=$type_post_level?>,<?=($i+1)?>" <?php if(@$list_permission) echo (in_array('post,man_category,'.$type_post_level.','.($i+1), $list_permission)) ? "checked" : "" ?>>
														</a>
														<label>Xem</label>
													</div>
													<div class="check-permission d-flex">
														<a class="check <?= (in_array('post,add_category,'.$type_post.','.($i+1), $list_permission)) ? "active" : "" ?>">
															<input type="checkbox" name="permission[]" value="post,add_category,<?=$type_post_level?>,<?=($i+1)?>" <?php if(@$list_permission) echo (in_array('post,add_category,'.$type_post_level.','.($i+1), $list_permission)) ? "checked" : "" ?>>
														</a>
														<label>Thêm</label>
													</div>
													<div class="check-permission d-flex">
														<a class="check <?= (in_array('post,edit_category,'.$type_post.','.($i+1), $list_permission)) ? "active" : "" ?>">
															<input type="checkbox" name="permission[]" value="post,edit_category,<?=$type_post_level?>,<?=($i+1)?>" <?php if(@$list_permission) echo (in_array('post,edit_category,'.$type_post_level.','.($i+1), $list_permission)) ? "checked" : "" ?>>
														</a>
														<label>Sửa</label>
													</div>
													<div class="check-permission d-flex">
														<a class="check <?= (in_array('post,delete_category,'.$type_post.','.($i+1), $list_permission)) ? "active" : "" ?>">
															<input type="checkbox" name="permission[]" value="post,delete_category,<?=$type_post_level?>,<?=($i+1)?>" <?php if(@$list_permission) echo (in_array('post,delete_category,'.$type_post_level.','.($i+1), $list_permission)) ? "checked" : "" ?>>
														</a>
														<label>Xóa</label>
													</div>
												</div>
											</div>
										<?php } ?>
									<?php } ?>
								<?php } ?>
								<div class="form-group row item-permission">
									<label class="col-sm-2 col-form-label d-flex">
										<a class="check PermissionTitle"></a>
										<span><?=$value['title']?></span>
									</label>
									<div class="col-sm-10 d-flex flex-wrap">
										<div class="check-permission d-flex">
											<a class="check <?= (in_array('post,man,'.$type_post.',0', $list_permission)) ? "active" : "" ?>">
												<input type="checkbox" name="permission[]" value="post,man,<?=$type_post?>,0" <?php if(@$list_permission) echo (in_array('post,man,'.$type_post.',0', $list_permission)) ? "checked" : "" ?>>
											</a>
											<label>Xem</label>
										</div>
										<div class="check-permission d-flex">
											<a class="check <?= (in_array('post,add,'.$type_post.',0', $list_permission)) ? "active" : "" ?>">
												<input type="checkbox" name="permission[]" value="post,add,<?=$type_post?>,0" <?php if(@$list_permission) echo (in_array('post,add,'.$type_post.',0', $list_permission)) ? "checked" : "" ?>>
											</a>
											<label>Thêm</label>
										</div>
										<div class="check-permission d-flex">
											<a class="check <?= (in_array('post,edit,'.$type_post.',0', $list_permission)) ? "active" : "" ?>">
												<input type="checkbox" name="permission[]" value="post,edit,<?=$type_post?>,0" <?php if(@$list_permission) echo (in_array('post,edit,'.$type_post.',0', $list_permission)) ? "checked" : "" ?>>
											</a>
											<label>Sửa</label>
										</div>
										<div class="check-permission d-flex">
											<a class="check <?= (in_array('post,delete,'.$type_post.',0', $list_permission)) ? "active" : "" ?>">
												<input type="checkbox" name="permission[]" value="post,delete,<?=$type_post?>,0" <?php if(@$list_permission) echo (in_array('post,delete,'.$type_post.',0', $list_permission)) ? "checked" : "" ?>>
											</a>
											<label>Xóa</label>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			<?php } ?>
			<?php if(@count($config['static'])>0) { ?>
				<div class="col-12">
					<div class="card card-outline card-danger">
						<div class="card-header">
							<h3 class="card-title d-flex">
								<a class="check PermissionGroup"></a>
								<span>Trang Tĩnh</span>
							</h3>
						</div>
						<div class="card-body">
							<?php foreach($config['static'] as $type_static => $value) { ?>
								<div class="form-group row item-permission">
									<label class="col-sm-2 col-form-label d-flex">
										<a class="check PermissionTitle"></a>
										<span><?=$value['title']?></span>
									</label>
									<div class="col-sm-10 d-flex flex-wrap">
										<div class="check-permission d-flex">
											<a class="check <?= (in_array('static,man,'.$type_static.',0', $list_permission)) ? "active" : "" ?>">
												<input type="checkbox" name="permission[]" value="static,man,<?=$type_static?>,0" <?php if(@$list_permission) echo (in_array('static,man,'.$type_static.',0', $list_permission)) ? "checked" : "" ?>>
											</a>
											<label>Sửa</label>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			<?php } ?>
			<?php if(@count($config['photo_static'])>0 || count($config['photo_multi'])>0) { ?>
				<div class="col-12">
					<div class="card card-outline card-danger">
						<div class="card-header">
							<h3 class="card-title d-flex">
								<a class="check PermissionGroup"></a>
								<span>Hình ảnh<?=(@$config['photo_multi']['video']) ? " - Video" : "" ?></span>
							</h3>
						</div>
						<div class="card-body">
							<?php foreach($config['photo_static'] as $type_photo_static => $value) { ?>
								<div class="form-group row item-permission">
									<label class="col-sm-2 col-form-label d-flex">
										<a class="check PermissionTitle"></a>
										<span><?=$value['title']?></span>
									</label>
									<div class="col-sm-10 d-flex flex-wrap">
										<div class="check-permission d-flex">
											<a class="check <?= (in_array('photo,man_static,'.$type_photo_static.',0', $list_permission)) ? "active" : "" ?>">
												<input type="checkbox" name="permission[]" value="photo,man_static,<?=$type_photo_static?>,0" <?php if(@$list_permission) echo (in_array('photo,man_static,'.$type_photo_static.',0', $list_permission)) ? "checked" : "" ?>>
											</a>
											<label>Sửa</label>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			<?php } ?>
			<?php if(@count($config['newsletter'])>0) { ?>
				<div class="col-12">
					<div class="card card-outline card-danger">
						<div class="card-header">
							<h3 class="card-title d-flex">
								<a class="check PermissionGroup"></a>
								<span>Email</span>
							</h3>
						</div>
						<div class="card-body">
							<?php foreach($config['newsletter'] as $type_newsletter => $value) { ?>
								<div class="form-group row item-permission">
									<label class="col-sm-2 col-form-label d-flex">
										<a class="check PermissionTitle"></a>
										<span><?=$value['title']?></span>
									</label>
									<div class="col-sm-10 d-flex flex-wrap">
										<div class="check-permission d-flex">
											<a class="check <?= (in_array('newsletter,man,'.$type_newsletter.',0', $list_permission)) ? "active" : "" ?>">
												<input type="checkbox" name="permission[]" value="newsletter,man,<?=$type_newsletter?>,0" <?php if(@$list_permission) echo (in_array('newsletter,man,'.$type_newsletter.',0', $list_permission)) ? "checked" : "" ?>>
											</a>
											<label>Xem</label>
										</div>
										<div class="check-permission d-flex">
											<a class="check <?= (in_array('newsletter,delete,'.$type_newsletter.',0', $list_permission)) ? "active" : "" ?>">
												<input type="checkbox" name="permission[]" value="newsletter,delete,<?=$type_newsletter?>,0" <?php if(@$list_permission) echo (in_array('newsletter,delete,'.$type_newsletter.',0', $list_permission)) ? "checked" : "" ?>>
											</a>
											<label>Xóa</label>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			<?php } ?>
			<?php if(@count($config['seo'])>0) { ?>
				<div class="col-12">
					<div class="card card-outline card-danger">
						<div class="card-header">
							<h3 class="card-title d-flex">
								<a class="check PermissionGroup"></a>
								<span>Seopage</span>
							</h3>
						</div>
						<div class="card-body">
							<?php foreach($config['seo']['page'] as $type_seo => $value_seo) { ?>
								<div class="form-group row item-permission">
									<label class="col-sm-2 col-form-label d-flex">
										<a class="check PermissionTitle"></a>
										<span><?=$value_seo?></span>
									</label>
									<div class="col-sm-10 d-flex flex-wrap">
										<div class="check-permission d-flex">
											<a class="check <?= (in_array('seo,man,'.$type_seo.',0', $list_permission)) ? "active" : "" ?>">
												<input type="checkbox" name="permission[]" value="seo,man,<?=$type_seo?>,0" <?php if(@$list_permission) echo (in_array('seo,man,'.$type_seo.',0', $list_permission)) ? "checked" : "" ?>>
											</a>
											<label>Sửa</label>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			<?php } ?>
			<?php if(@count($config['company'])>0) { ?>
				<div class="col-12">
					<div class="card card-outline card-danger">
						<div class="card-header">
							<h3 class="card-title d-flex">
								<a class="check PermissionGroup"></a>
								<span>Quản lý Website</span>
							</h3>
						</div>
						<div class="card-body">
							<div class="form-group row item-permission">
								<label class="col-sm-2 col-form-label d-flex">
									<a class="check PermissionTitle"></a>
									<span>Cấu hình Website</span>
								</label>
								<div class="col-sm-10 d-flex flex-wrap">
									<div class="check-permission d-flex">
										<a class="check <?= (in_array('company,man,,0', $list_permission)) ? "active" : "" ?>">
											<input type="checkbox" name="permission[]" value="company,man,,0" <?php if(@$list_permission) echo (in_array('company,man,,0', $list_permission)) ? "checked" : "" ?>>
										</a>
										<label>Sửa</label>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
		<div class="cover-button d-flex">    
			<input type="hidden" name="id" value="<?=@$item['id']?>" />	
			<button type="button" class="btn btn-primary" onclick="submit_admin()"><i class="far fa-save mr-1"></i>Hoàn tất</button>
			<button type="button" class="btn btn-danger"><a href="index.php"><i class="fas fa-sign-out-alt mr-1"></i>Thoát</a></button>
		</div>
	</form>
</div>