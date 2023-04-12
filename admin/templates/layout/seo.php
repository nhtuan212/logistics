<div class="card-seo">
	<?php /* ?>
	<div class="callout callout-warning">
		<h5 class="mb-3"><i class="fas fa-info mr-2"></i>Hiển thị trên google search</h5>
		<p><?=$config_url_http.@$item['tenkhongdau']?></p>
		<h4 class="text-primary font-weight-normal review-title-seo"><?=(@$item_seo['title']) ? $item_seo['title'] : "Title"?></h4>
		<p class="card-text review-description-seo"><?=(@$item_seo['description']) ? $item_seo['description'] : "Description"?></p>
	</div>
	<?php */ ?>

	<div class="form-group">
		<label>Title [<span><?=@strlen(utf8_decode($item_seo['title']))?></span>/70 ký tự]</label>
		<input type="text" id="title-seo" class="form-control form-seo title-seo" name="data_seo[title]" value="<?=@$item_seo['title']?>"/>
	</div>
	<div class="form-group">
		<label>Keywords</label>
		<input type="text" id="keywords-seo" class="form-control form-seo keywords-seo" name="data_seo[keywords]" value="<?=@$item_seo['keywords']?>"/>
	</div>
	<div class="form-group">
		<label>Description [<span><?=@strlen(utf8_decode($item_seo['description']))?></span>/160 ký tự]</label>
		<textarea id="description-seo" class="form-control form-seo description-seo" name="data_seo[description]" rows="5"/><?=@$item_seo['description']?></textarea>
	</div>
	<?php if($com != 'seo' && $com != 'setting') { ?>
		<button type="button" class="btn btn-success mb-2" onclick="(seoExist()) ? alertConfirm('Nội dung seo đã được thiết lập. Bạn muốn tạo lại seo mới ?', 'seoCreate') : seoCreate()"><i class="far fa-chart-bar mr-1"></i>Tạo seo</button>
	<?php } ?>
</div>