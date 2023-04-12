function alertCart(val, icon, page="", toast=false, position="center")
{
	const Toast = Swal.fire({
		toast: toast,
		position: position,
		title: val,
		text: "",
		icon: icon,
		timer: 3000,
		background: '#fff',
		timerProgressBar: true,
		showCloseButton: true,
		showCancelButton: false,
		showConfirmButton: false,
		confirmButtonColor: "",
		confirmButtonText: "",
	});
	if(page != "")
	{
		Toast.then(function(result) {
			if (result) {
				location.href = page;
			};
		});
	}
};
function onchange_quantity(id, code, type)
{
	var val = parseFloat($(".quantity-"+code).find("input").val());
	if(type == 'up') qty = val + 1;
	if(type == 'down')
	{
		if(val-1 <= 0) qty = 1;
		else qty = val - 1;
	};
	if(type == 'change')
	{
		if(val <= 0) qty = 1;
		else qty = val;
	};			
	$.ajax({
		type: "POST",
		url: "ajax/ajax_cart.php",
		dataType: 'json',
		data: {id:id, code:code, qty:qty, act:'update'},
		success: function(rs){
			if(rs)
			{
				$('.total-cart .price').html(rs.total);
				$('.total-cart .total').html(rs.total);
				var val = parseFloat($(".quantity-"+code).find("input").val(qty));
				// location.href = _GET_CURRENT_PAGE;
			}
		}
	});
};
function delete_cart(id, code)
{
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: 'btn btn-success',
			cancelButton: 'btn btn-danger mr-2',
		},
		buttonsStyling: false
	});
	swalWithBootstrapButtons.fire({
		title: "",
		text: "Bạn có muốn xóa sản phẩm này ?",
		icon: 'warning',
		showCloseButton: false,
		showCancelButton: true,
		confirmButtonText: 'Yes, delete it!',
		cancelButtonText: 'No, cancel!',
		reverseButtons: true,
	}).then((result) => {
		if(result.value){
			$.ajax({
				type: "POST",
				url: "ajax/ajax_cart.php",
				dataType: 'json',
				data: {id:id, code:code, act:'delete'},
				success: function(rs){
					if(rs)
					{
						// $('.row-'+code).fadeOut(500);
						document.location.href = _GET_CURRENT_PAGE;
					}
				}
			});
		}
	});
};
function change_place(attr, type)
{
	var id = $("."+attr).val();
	$.ajax({
		type:'post',
		url:'ajax/ajax_place.php',
		data:{id:id, attr:attr, type:type},
		success:function(rs){
			$('.ajax-'+type).html(rs);
		}
	});
};
_CART.addCart = function(obj){
	$('#modal-cart').on('hidden.bs.modal', function(e){
		$('#modal-cart').find('.modal-body').html("");
	});

	$("body").on('click', '.btn-cart', function(){
		var id = $(this).attr('data-id');
		var kind = $(this).attr('data-kind');
		var qty = ($('.quantity') === "") ? $('.quantity').val() : 1;
		var size = 0;
		var color = 0;
		if($('.template').val()=='product_detail') qty = $('.quantity input').val();
		if($('.size').length > 0)
		{
			if($('.size .product-attribute.active').length > 0) size = $('.size .product-attribute.active').attr('data-id');
			else{alertCart(_CHOSE_SIZE, "error");return false;}
		};
		if($('.color').length > 0)
		{
			if($('.color .product-attribute.active').length > 0) color = $('.color .product-attribute.active').attr('data-id');
			else{alertCart(_CHOSE_COLOR, "error");return false;}
		};
		$.ajax({
			type:'post',
			url:'ajax/ajax_cart.php',
			dataType:'json',
			data:{id:id, qty:qty, size:size, color:color, act:'add'},
			success:function(rs)
			{
				$.ajax({
					type: "POST",
					url: 'gio-hang?modal=1',
					dataType: 'html',
					success: function(result){
						if(kind == 'modal')
						{
							$("body").append(
								'<div class="modal fade" id="modal-cart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">\
									<div class="modal-dialog modal-lg" role="document">\
										<div class="modal-content">\
											<form class="frm-addMore modal-lg" name="frm-addMore" method="post" action="<?=$actionMore?>" enctype="multipart/form-data">\
												<div class="modal-header">\
													<h5 class="modal-title" id="exampleModalLabel">Giỏ hàng của bạn</h5>\
													<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
												</div>\
												<div class="modal-body"></div>\
											</form>\
										</div>\
									</div>\
								</div>'
							);
							$('#modal-cart').find('.modal-body').html(result);
							$('#modal-cart').modal('show');
						}
						if(kind == 'add') alertCart(_SUCCESS_ADD_CART, "success", _GET_CURRENT_PAGE, true, "bottom-end");
						if(kind == 'buy') document.location.href='gio-hang';
					}
				});				
			}
		});		
	});
};
_CART.payments = function(){
	$("body").on("click",".item-payments", function() {
		var id = $(this).attr("data-id");
		$(".item-payments").removeClass("active");
		$(this).addClass("active");
		$(this).parent().find("input").val(id);
	});
};
_CART.quantity = function(){
	$("body").on("click",".quantity span", function() {
		var val = parseFloat($(this).parent().find("input").val());
		var up = $(this).hasClass('quantity-up');
		var down = $(this).hasClass('quantity-down');
		if(up) var result = val + 1;
		else
		{
			if(val > 1) var result = val - 1;
			else var result = 1;
		}
		$(this).parent().find("input").val(result);
	});
};
_CART.attribute = function(){
	$('.product-attribute').click(function(){
		$(this).parents('.option-detail').find('.product-attribute').removeClass('active');
		$(this).addClass('active');
	});
};
$(document).ready(function(){
	if(_TEMPLATE == 'product/product_detail')
	{
	    _CART.quantity();
	    _CART.attribute();
	}
	if(_SOURCE == 'cart') _CART.payments();
	_CART.addCart();
});