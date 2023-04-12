<div class="content-wrapper">
	<section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1>Thông tin tài khoản</h1>
                </div>
            </div>
        </div>
    </section>

    <form class="frm-admin content" action="index.php?com=<?=$com?>&act=info&type=<?=$type?>" method="post" enctype="multipart/form-data">
		<div class="row">
			<div class="col-12">
				<div class="card card-outline card-danger">
					<div class="card-body row">
						<?php /* ?>
							<div class="col-sm-6">
								<div class="form-group">
									<?php include LAYOUT."photo.php";?>
								</div>
    						</div>
						<?php */ ?>
						<div class="form-group col-sm-3">
							<label>Username</label>
							<input type="text" class="form-control" name="" value="<?=@$item['username']?>" readonly/>
						</div>
						<div class="form-group col-sm-3">
							<label>Họ tên</label>
							<input type="text" class="form-control" name="data[options][name]" value="<?=@$options['name']?>"/>
						</div>
						<div class="form-group col-sm-3">
							<label>Email</label>
							<input type="text" class="form-control" name="data[options][email]" value="<?=@$options['email']?>"/>
						</div>
						<div class="form-group col-sm-3">
							<label>Điện thoại</label>
							<input type="text" class="form-control" name="data[options][phone]" value="<?=@$options['phone']?>"/>
						</div>
						<div class="form-group col-sm-12">
							<label>Địa chỉ</label>
							<input type="text" class="form-control" name="data[options][address]" value="<?=@$options['address']?>"/>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="cover-button d-flex justify-content-end">    
			<input type="hidden" name="id" value="<?=@$item['id']?>" />	
			<button type="button" class="btn btn-primary" onclick="submit_admin()"><i class="far fa-save mr-1"></i>Hoàn tất</button>
			<button type="button" class="btn btn-danger"><a href="index.php"><i class="fas fa-sign-out-alt mr-1"></i>Thoát</a></button>
		</div>
	</form>
</div>