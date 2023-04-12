<?php
	include ("ajax_config.php");
	if(!empty($_GET))
	{
		@$url = $func->decode($_GET['url']);
		@$width = $func->decode($_GET['width']);
		@$height = $func->decode($_GET['height']);
		@$type = $func->decode($_GET['type']);
		@$kind = $func->decode($_GET['kind']);
	}
?>

<?php if(!empty($_GET)) { ?>
	<?php if($type == 'fanpage-timeline' || $type == 'fanpage-messages') { ?>
		<div class="fb-page" data-href="<?=$url?>" data-width="<?=$width?>" data-height="<?=$height?>" data-tabs="<?=str_replace('fanpage-', '', $type)?>" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
			<div class="fb-xfbml-parse-ignore">
				<blockquote cite="<?=$url?>">
					<a href="<?=$url?>"></a>
				</blockquote>
			</div>
		</div>
		<?php if($type == 'fanpage-messages') { ?>
			<script type="text/javascript">
				$(document).ready(function(e) {
					$('.close-icon').hide();
					$('body').on("click",".icon-face",function(){
						if($(this).parent().hasClass('active'))
						{
							$(this).parent().removeClass('active');
							$(this).find('i').show();
							if($(this).find('.close-icon').hide()) $(this).parent().find(".fanpage-messages").fadeOut(200);
						}
						else
						{
							$(this).parent().addClass('active');
							$(this).find('i').hide();
							if($(this).find('.close-icon').show()) $(this).parent().find(".fanpage-messages").fadeIn(200);
						}
					});
				});
			</script>
		<?php } ?>
	<?php } ?>

	<?php if($type == 'video') { ?>	
		<?php $video = $d->rawQuery("select id, name$lang as name, link from #_photo where type=? and FIND_IN_SET('display', status) order by number, id desc", array('video')); ?>
		<div class="row-1 line-height-0">
			<iframe class="video-iframe" title="<?=$video[0]['name']?>" src="//www.youtube.com/embed/<?=$func->getYoutubeIdFromUrl($video[0]['link'])?>" width="<?=$width?>" height="<?=$height?>" frameborder="0" allowfullscreen></iframe>
		</div>

		<?php if($kind == 'slick') { ?>	
			<div class="row-video mt-1">
				<div class="row mx-n1 slick-video" :show="3">
					<?php foreach ($video as $i => $item) { ?>
						<a class="item-video p-1 pointer" data-src="<?=$func->getYoutubeIdFromUrl($item['link'])?>">
							<img src="//img.youtube.com/vi/<?=$func->getYoutubeIdFromUrl($item['link'])?>/0.jpg"/>
						</a>
					<?php } ?>
				</div>
			</div>
			<script type="text/javascript">
				$(document).ready(function(e) {
					$('body').on("click",".item-video",function(){
						var src = '//www.youtube.com/embed/'+$(this).attr('data-src');
						$('.video-iframe').attr('src', src);
						return false;
					});
				});
			</script>
		<?php } if($kind == 'select') { ?>
			<div class="row-2 mt-2">
				<select class="form-control" onchange="video_select(this.value)">
					<?php foreach ($video as $i => $item) { ?>
						<option value="<?=$func->getYoutubeIdFromUrl($item['link'])?>"><?=$item['name']?></option>
					<?php } ?>
				</select>
			</div>
			<script type="text/javascript">
				function video_select(val) {
					var src = '//www.youtube.com/embed/'+val;
					$('.video-iframe').attr('src',src);
					return false;
				}
			</script>
		<?php } ?>
	<?php } ?>

	<?php if($type == 'map') {
		$setting = $d->rawQueryOne("select options from #_setting");
		$optsetting = (isset($setting['options']) && $setting['options'] != '') ? json_decode($setting['options'],true) : null;
		echo $func->decode($optsetting[$url]);
	} ?>
<?php } ?>