<div class="content-wrapper">
	<section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1>Thay đổi mật khẩu</h1>
                </div>
            </div>
        </div>
    </section>

    <form class="frm-admin content" action="index.php?com=<?=$com?>&act=password&type=<?=$type?>" method="post" enctype="multipart/form-data">
		<div class="row">
			<div class="col-12">
				<div class="card card-outline card-danger">
					<div class="card-body row">
						<div class="form-group col-12">
							<label>Tên đăng nhập</label>
							<input type="text" class="form-control" name="data[username]" value="<?=@$item['username']?>" readonly/>
						</div>
						<div class="form-group col-md-4">
							<label>Mật khẩu</label>
							<input type="password" class="form-control" name="password" value=""/>
						</div>
						<div class="form-group col-md-4">
							<label>Mật khẩu mới</label>
							<input type="password" class="form-control" name="new-pass" value=""/>
						</div>
						<div class="form-group col-md-4">
							<label>Xác nhận Mật khẩu mới</label>
							<input type="password" class="form-control" name="renew-pass" value=""/>
						</div>
						<?php if($config['login']['rand'] == true) { ?>
							<div class="form-group col-12">
								<button type="button" class="btn btn-danger" onclick="random_password(7)"><i class="fas fa-random mr-2"></i>Random</button>
								<span class="show-random ml10"></span>
							</div>
						<?php } ?>
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