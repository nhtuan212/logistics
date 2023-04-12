<div class="form-group">
	<label>Đường dẫn</label>
	<input type="text" id="slug" class="form-control border-primary" value="<?=@$item['tenkhongdau']?>" name="data[tenkhongdau]"/>
	<input type="hidden" id="idSlug" value="<?=@$id?>"/>
	<p class="notification-slug mt-2"></p>
	<div class="current-link mt-2">
		<p class="text-danger font-weight-bold">Đường dẫn hiện tại: <a href="<?=$config_url_http.$item['tenkhongdau']?>" class="font-weight-normal text-primary" target="blank"><?=$config_url_http?><span class="font-weight-bold"><?=$item['tenkhongdau']?></span></a>
		</p>
	</div>
</div>
<div class="form-group">
	<div class="custom-control custom-checkbox">
		<input class="custom-control-input" type="checkbox" id="customCheckbox1" name="slug"onclick="checkSlug('check')">
		<label for="customCheckbox1" class="custom-control-label text-primary">Sử dụng đường dẫn theo tên mới nhất</label>
	</div>
</div>