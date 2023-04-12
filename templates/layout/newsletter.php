<?php
	if(isset($_POST['btn-newsletter']))
	{
		$data = $_POST['data_newsletter'];
		if($_POST['data_newsletter'])
		{
			foreach($_POST['data_newsletter'] as $column => $value)
			{
				if(is_array($value))
				{
					foreach($value as $opt => $options)
					{
						$info_options[$opt] = (!empty($options)) ? $options : "0";
					}
					$data[$column] = json_encode($info_options);
				}
				else
				{
					$data[$column] = $func->encode($value);
				}
			}
		}
		$data['date_created'] = time();
		$data['status'] = 'display';
		$data['number'] = 1;
		$data_options = json_decode($data['options'],true);

		$newsletter =  $d->rawQuery("select options FROM table_newsletter WHERE type = ?", array($data['type']));
		foreach($newsletter as $i => $item) {
			@$options = (isset($item['options']) && $item['options'] != '') ? json_decode($item['options'],true) : null;
			$duplicate = ($data_options['email'] == $options['email']) ? true : false;
			if(!empty($duplicate)) $func->transfer(_emaildadangky, "index", "error");
		}
		if($d->insert('newsletter', $data)) $func->transfer(_guiemailthanhcong, "index", "success");
		else $func->transfer(_guiemailthatbai, "index", "error");
	}
?>
<form class="frm-newsletter" name="frm_newsletter" method="post" action="" enctype="multipart/form-data">
	<div class="form-group">
		<label><?=_hoten?></label>
		<input type="text" class="form-control" name="data_newsletter[options][name]" placeholder="<?=_hoten?>" required>
	</div>
	<div class="form-group">
		<label><?=_dienthoai?></label>
		<input type="number" class="form-control" name="data_newsletter[options][phone]" placeholder="<?=_dienthoai?>" required>
	</div>
	<div class="form-group">
		<label>Email</label>
		<input type="email" class="form-control" name="data_newsletter[options][email]" placeholder="Email" required>
	</div>
	<div class="form-group">
		<label><?=_diachi?></label>
		<input type="text" class="form-control" name="data_newsletter[options][address]" placeholder="<?=_diachi?>" required>
	</div>
	<div class="form-group">
		<label><?=_noidung?></label>
		<textarea class="form-control" name="data_newsletter[options][content]" rows="3" placeholder="<?=_noidung?>" required></textarea>
	</div>
	<input type="hidden" name="data_newsletter[type]" value="newsletter">
	<button type="submit" class="btn btn-basic" name="btn-newsletter"><?=_gui?></button>
	<button type="button" class="btn btn-basic" onclick="document.frm_newsletter.reset();"><?=_nhaplai?></button>
</form>