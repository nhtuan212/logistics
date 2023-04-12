<h2 class="title"><?=$title?></h2>

<?php if ($com == 'lien-he') { ?>
	<div class="cover-contact">
		<div class="d-flex justify-content-between flex-wrap">
			<aside class="item-contactIns col-md-6 line-height-2"><?=$func->decode($contact['content'])?></aside>
			<div class="item-contactIns col-md-5">
				<form class="form" name="contact_form" method="post" action="" enctype="multipart/form-data">
					<div class="form-group">
						<label><?=_hoten?></label>
						<input type="text" class="form-control" name="data_contact[options][name]" required>
					</div>
					<div class="form-group">
						<label><?=_diachi?></label>
						<input type="text" class="form-control" name="data_contact[options][address]" required>
					</div>
					<div class="form-group">
						<label><?=_dienthoai?></label>
						<input type="text" class="form-control" name="data_contact[options][phone]" required>
					</div>
					<div class="form-group">
						<label>Email</label>
						<input type="email" class="form-control" name="data_contact[options][email]" required>
					</div>
					<div class="form-group">
						<label><?=_chude?></label>
						<input type="text" class="form-control" name="data_contact[options][topic]" required>
					</div>
					<div class="form-group">
						<label><?=_noidung?></label>
						<textarea class="form-control" name="data_contact[options][content]" rows="5" required></textarea>
					</div>

					<input type="hidden" name="data_contact[type]" value="contact">
					<input type="hidden" name="recaptcha_response" id="recaptchaResponse">
					<button type="submit" class="btn btn-basic" name="btn-contact"><?=_gui?></button>
					<button type="button" class="btn btn-basic" onclick="document.contact_form.reset();"><?=_nhaplai?></button>
				</form>
			</div>
			<div class="col-12 mt-3"><?=$addon->addonOnline("iframe",'100%',500,"map")?></div>
		</div>
	</div>
<?php } elseif ($com == 'video') { ?>
	<section class="row">
		<?php foreach ($video as $i => $item) { ?>
			<a class="item-custom item-product text-center iframe-modal pointer" data-name="<?=$item['name']?>" data-src="http://www.youtube.com/embed/<?=$func->getYoutubeIdFromUrl($item['link'])?>" href="javascript:void(0)">
				<img src="http://img.youtube.com/vi/<?=$func->getYoutubeIdFromUrl($item['link'])?>/0.jpg" alt="<?=$item['name']?>" />
				<h3 class="name mt-2"><?=$item['name']?></h3>
			</a>
		<?php } ?>
	</section>
	<div class="pagination"><?=$paging?></div>
<?php } else { ?>
	
	<?php if(empty($static_detail['content'])) { ?>
		<div class="empty-page">** Nội dung đang được cập nhật ...</div>
	<?php } else { ?>
		<aside>
			<?=$func->decode($static_detail['content'])?>   
			<div class="share-toolbox"></div>
		</aside>
	<?php } ?>
	
<?php } ?>