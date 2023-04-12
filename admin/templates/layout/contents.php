<?php
	if(!empty($level)) $config_com = $com.'-lv'.$level;
	else $config_com = $com.$case;
?>
<?php if(!empty($config[$config_com][$type]['contents'])) { ?>
	<?php foreach($config[$config_com][$type]['contents'] as $attr => $value) { ?>
		<?php if($value['lang']==true) { ?>
			<div class="form-group">
				<label><?=$value['text']?></label>
				<?php if($value['type'] == 'textarea') { ?>
					<textarea id="<?=$attr.$lang?>" class="form-control <?php if($value['ckeditor']==true) echo "editor" ?> <?php if(@$value['validate']) echo "validate[required]" ?>" name="data_contents[<?=$attr.$lang?>]" rows="<?=$value['rows']?>"/><?=$func->decode(@$item_contents[$attr.$lang])?></textarea>
				<?php } ?>
				<?php if($value['type'] == 'input') { ?>
					<input id="<?=$attr.$lang?>" class="form-control <?php if($value['ckeditor']==true) echo "editor" ?> <?php if($value['validate']) echo "validate[required]" ?>" name="data_contents[<?=$attr.@$lang?>]" value="<?=@$item_contents[$attr.$lang]?>">
				<?php } ?>
			</div>
		<?php } ?>
	<?php } ?>
<?php } ?>