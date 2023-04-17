setTimeout(function(){
	(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.8&appId=428440974009677";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
}, 1000);
$.fn.exists = function(){
	return this.length;
};
function alert(val, icon="warning")
{
	const Toast = Swal.fire({
		title: val,
		text: "",
		icon: icon,
		background: '#fff',
	});
};
function doEnter(evt)
{
	var key;
	if(evt.keyCode == 13 || evt.which == 13){
		onSearch(evt);
	}
};
function onSearch(evt) 
{
	var keyword = $('.keyword').val();
	if(_RESPONSIVE==true || _MOBILE==true)
	{
		var keyword_eq1 = $('.keyword:eq(0)').val();
		var keyword_eq2 = $('.keyword:eq(1)').val();
		if(keyword_eq1=='') keyword = keyword_eq2;
		else keyword = keyword_eq1;
	}
	if(keyword=='') alert(_PLACEHOLDER_SEARCH);
	else
	{
		location.href = "tim-kiem?keyword="+keyword;
		loadPage(document.location);
	}
};
_BASE.modal = function(){	
	$("body").on("click",".iframe-modal", function(){
		var name = $(this).attr('data-name');
		var src = $(this).attr('data-src');
		$("body").append(
			'<div class="modal fade" id="modal-video" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">\
				<div class="modal-dialog modal-lg" role="document">\
					<div class="modal-content">\
						<form class="frm-addMore modal-lg" name="frm-addMore" method="post" action="<?=$actionMore?>" enctype="multipart/form-data">\
							<div class="modal-header">\
								<h5 class="modal-title" id="exampleModalLabel">'+name+'</h5>\
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
							</div>\
							<div class="modal-body">\
								<iframe width="100%" height="350" src="'+src+'?autoplay=1"></iframe>\
							</div>\
						</form>\
					</div>\
				</div>\
			</div>'
		);
		$('#modal-video').modal('show');
		$('#modal-video').on('hidden.bs.modal', function(){
			$('#modal-video').remove();
		});
	});
};
_BASE.totop = function(){
	$(window).scroll(function(){
		if($(window).scrollTop() > 100) $('.totop').addClass('active');
		else $('.totop').removeClass('active');
	});
	$("body").on("click",".totop", function(){
		$('html, body').animate({scrollTop:0},500);
	});
};
_BASE.daterange = function(){
	$(document).ready(function () {
		$('.daterange').daterangepicker({
			callback: this.render,
			singleDatePicker: true,
			autoUpdateInput: false,
			locale: {
				format: 'D/M/Y',
			}
		});
		$('.daterange').on('apply.daterangepicker', function (ev, picker) {
			$(this).val(picker.startDate.format('D/M/Y'));
		});
		$('.daterange').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val(picker.startDate.format('D/M/Y'));
		});
	});
};
_BASE.hvrMenu = function(){
	$(".menu ul li").hover(function(){
		$(this).find('ul:first').addClass('active');
		$(this).find('ul li').addClass('backInLeft');
	}, function(){
		$(this).find('ul:first').removeClass('active');
		$(this).find('ul li').removeClass('backInLeft');
	});
};
_BASE.altImage = function(){
	$('img').each(function(index, element){
		if(!$(this).attr('alt') || $(this).attr('alt')=='') {
			$(this).attr('alt', _ALT_IMAGE);
		}
	});
};
_BASE.menuToggle = function(){
	var Nav = $('.nav-menu').hcOffcanvasNav({
		maxWidth: false,
		customToggle: $('.menu-mobile .bar'),
		// navTitle: 'Menu',
		// levelTitles: true,
		// pushContent: '.container',
		levelOpen:'overlap', // 'overlap, expand, false'
		levelSpacing: 0,
		insertClose: 0,
		closeLevels: false
	});
};
_BASE.slider = function(){
	$('.nivo-slider').nivoSlider();
};
_BASE.slickData = function(obj){
	// :lg-item="4" :md-item="3" :sm-item="2" :xs-item="1"
	if(obj.length > 0)
	{
		var slidesToShow = Number(obj.attr(':show'));
		var autoplay = (obj.attr(':autoplay')=="false") ? false : true;
		var infinite = (obj.attr(':infinite')=="false") ? false : true;
		var arrows = (obj.attr(':arrows')=="true") ? true : false;
		var dots = (obj.attr(':dots')=="true") ? true : false;
		var vertical = (obj.attr(':vertical')=="true") ? true : false;
		var fade = (obj.attr(':fade')=="true") ? true : false;
		var lg_item = Number(obj.attr(':lg-item'));
		var md_item = Number(obj.attr(':md-item'));
		var sm_item = Number(obj.attr(':sm-item'));
		var xs_item = Number(obj.attr(':xs-item'));
		var responsive = [];

		if((_RESPONSIVE==true || _MOBILE==true) && (lg_item && md_item && sm_item && xs_item))
		{
			responsive = [
				{breakpoint: 1024,settings:{slidesToShow: lg_item,}},
				{breakpoint: 992,settings:{slidesToShow: md_item,}},
				{breakpoint: 768,settings:{slidesToShow: sm_item,}},
				{breakpoint: 480,settings:{slidesToShow: xs_item,}},
			];
		}
		obj.slick({
			slidesToShow: slidesToShow,
			autoplay: autoplay,
			infinite: infinite,
			arrows: arrows,
			dots: dots,
			vertical: vertical,
			fade: fade,
			responsive: responsive,
			// prevArrow: '<p class="left-arrow">←</p>',
			// nextArrow: '<p class="right-arrow">→</p>',
		});
	};
};
_BASE.slickPage = function(){
	if($(".slick__page").exists())
	{
		if($('.slick__page.slider').exists())
		{
			var class_name = $('.slider');
			var slides = class_name.find('.item-slider');

			class_name.on('init', function(e, slick) {
				var $firstAnimatingElements = $('.item-slider:first-child').find('[data-animation]');
				doAnimations($firstAnimatingElements);
			});

			class_name.on('beforeChange', function(event, slick, currentSlide, nextSlide) {
				var	animate_str = class_name.attr(':animate');
				var animate_arr = animate_str.split(",");
				var random = Math.floor(Math.random() * animate_arr.length);
				var animate = animate_arr[random];
				var $animatingElements = $('.item-slider[data-slick-index="' + nextSlide + '"]').find('[data-animation]');
				doAnimations($animatingElements);
				slides.removeClass(animate);
				slides.eq(nextSlide).addClass(animate);
			});

			function doAnimations(elements) {
				var animationEndEvents = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
				elements.each(function() {
					var $this = $(this);
					var $animationDelay = $this.attr('data-delay');
					var $animationType = $this.attr('data-animation');
					$this.css({
						'animation-delay': $animationDelay,
						'-webkit-animation-delay': $animationDelay
					});
					$this.addClass($animationType).one(animationEndEvents, function() {
						$this.removeClass($animationType);
					});
				});
			}
		}

		$(".slick__page").each(function(){
			_BASE.slickData($(this));
		});
	}
	$('.video').one('DOMSubtreeModified', function(){
		_BASE.slickData($('.slick-video'));
	});
};
_BASE.fixedMenu = function(){
	$(window).bind("scroll", function() {
		var cach_top = $(window).scrollTop();
		var height = $('.cover-header').height();

		if(cach_top >= height)
		{
			if(!$('.cover-menu').hasClass('fixed'))
			{
				$('.cover-menu').addClass('fixed position-fixed');
			}
		}
		else
		{
			$('.cover-menu').removeClass('fixed position-fixed');
		}
	});
};
function loadPagingAjax(url='',eShow='',rowCount=0,scroll='')
{
	if($(eShow).length && url)
    {
        $.ajax({
            url: url,
            type: "GET",
            data: {rowCount: rowCount,eShow: eShow,},
			dataType: "html",
			success: function (result) {
                $(eShow).html(result);
                if(scroll)
                {
                	scrollPoint = $(eShow).parent().offset().top;
                	$('body,html').animate({
                		scrollTop: scrollPoint
                	}, 500);
                	return false;
                }
			}
        });
    }
};
$(document).ready(function () {
    if(_SOURCE_INDEX)
	{
    	$(".paging-product").each(function( index ) {
			var type = $(this).attr('data-type');
    		loadPagingAjax("ajax/ajax_paging.php?perpage="+_COUNT_PRODUCT+"&type="+type,'.paging-product',0);
		});
    	// $('body').on("click",".item-category",function(){
    	// 	$this = $(this);
    	// 	var id_lv1 = $this.attr("data-idLv1");
    	// 	var id_lv2 = $this.attr("data-idLv2");
    	// 	var type = $this.attr("data-type");
    	// 	$(this).parent().find(".item-category").removeClass('active');
    	// 	$(this).addClass('active');
    	// 	loadPagingAjax("ajax/ajax_paging.php?perpage="+_COUNT_PRODUCT+"&type="+type+"&id_lv1="+id_lv1+"&id_lv2="+id_lv2,'.paging-category-'+id_lv1,0);
    	// });
    }
    _BASE.daterange();
    _BASE.modal();
    _BASE.totop();
    _BASE.hvrMenu();
    _BASE.altImage();
    _BASE.slickPage();
    if(_RESPONSIVE==true || _MOBILE==true) _BASE.menuToggle();
    // _BASE.fixedMenu();
});