<script type="text/javascript">
	$(document).ready(function(e) {
		$('body').on('click', '.btn-newsletter', function() {
			var place_from = $('#place_from').val();
			var place_to = $('#place_to').val();
			var date_from = $('#date_from').val();
			var price = $('#price').val();
			var result = `san-pham?place_from=${place_from}&place_to=${place_to}&date_from=${date_from}&price=${price}`;
			if (place_from == 0 && place_to == 0 && !date_from && !price) return alert('Vui lòng chọn ít nhất 1 mục tìm kiếm');
			window.location = result;
		});
	});
</script>
<?php
$place = $d->rawQuery("select id, name$lang as name from #_place_city where " . $func->findInSet('display', 'status') . " order by number, id asc");
?>
<form class="frm-newsletter d-flex flex-wrap justify-content-between align-items-center" name="frm_newsletter" method="get" action="" enctype="multipart/form-data">
	<div class="form-group mb-0 newsletter-item">
		<select class="form-control" name="place_from" id="place_from">
			<option value="0">Nơi khởi hành</option>
			<?php for ($i = 0; $i < count($place); $i++) { ?>
				<option value="<?= $place[$i]['id'] ?>">
					<?= $place[$i]['name'] ?>
				</option>
			<?php } ?>
		</select>
	</div>
	<div class="form-group mb-0 newsletter-item">
		<select class="form-control" name="place_to" id="place_to">
			<option value="0">Nơi đến</option>
			<?php for ($i = 0; $i < count($place); $i++) { ?>
				<option value="<?= $place[$i]['id'] ?>">
					<?= $place[$i]['name'] ?>
				</option>
			<?php } ?>
		</select>
	</div>
	<div class="form-group mb-0 newsletter-item">
		<input type="text" id="date_from" class="form-control pointer daterange bg-white" readonly name="date_from" placeholder="Ngày khởi hành">
	</div>
	<div class="form-group mb-0 newsletter-item">
		<input type="text" id="price" class="form-control" name="price" placeholder="Giá tour">
	</div>
	<input type="hidden" name="data_newsletter[type]" value="newsletter">
	<div class="newsletter-item">
		<button type="button" class="btn btn-basic btn-newsletter" name="btn-newsletter"><?= _timkiem ?></button>
	</div>
	<?php /* ?><button type="button" class="btn btn-basic" onclick="document.frm_newsletter.reset();"><?=_nhaplai?></button><?php */ ?>
</form>