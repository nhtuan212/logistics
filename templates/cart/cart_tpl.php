<?php if($funcCart->countSession()) { ?>
	<section class="cover-cart">
		<?=(empty($modal)) ? '<p class="title-cart"><?=_giohang?></p>' : ""?>		
		<form name="frm-cart" method="post" enctype="multipart/form-data">
			<div class="row">
				<div class="shopping-cart <?=(empty($modal)) ? "col-md-9" : "col-12"?>" border="0" cellpadding="5px" cellspacing="1px">
					<?php if(is_array($_SESSION['cart'])) { ?>
						<?php for($i=0; $i < $funcCart->countSession(); $i++) { ?>
							<?php
								$id = $_SESSION['cart'][$i]['id'];
								$qty = $_SESSION['cart'][$i]['qty'];
								$code = $_SESSION['cart'][$i]['code'];
								$cart_photo = $funcCart->cart_detail($id, 'photo', UPLOAD_PRODUCT_L, "120x100x1/");
								$cart_name = $funcCart->cart_detail($id, 'name');
								$cart_price = $funcCart->cart_detail($id, 'price');
								$size = $d->rawQueryOne("select id, name$lang as name, attribute from #_attribute where id=?", array($_SESSION['cart'][$i]['size']));
								$color = $d->rawQueryOne("select id, name$lang as name, attribute from #_attribute where id=?", array($_SESSION['cart'][$i]['color']));
							?>

							<div class="item-cart item-cart row-<?=$code?>">
								<div class="row align-items-end">
									<div class="col-2">
										<div class="img"><?=$cart_photo?></div>
									</div>
									<div class="col-10">
										<div class="info d-flex justify-content-between align-items-end flex-wrap">
											<div class="col-cart col-6 box">
												<h3 class="name"><?=$cart_name?></h3>
												<?php if($size) { ?><div class="d-flex"><label class="mr-10">Size:</label><span><?=$size['name']?></span></div><?php } ?>
												<?php if($color) { ?><div class="d-flex"><label class="mr-10">Màu:</label><span><?=$color['name']?></span></div><?php } ?>
												<a class="cart-delete pointer" onclick="delete_cart('<?=$id?>', '<?=$code?>');"><i class="far fa-trash-alt"></i></a>
											</div>
											<div class="col-cart col-2 price"><?=$func->money($cart_price)?></div>
											<div class="col-cart col-2 quantity d-flex quantity-<?=$code?>">
												<span class="quantity-down" onclick="onchange_quantity('<?=$id?>','<?=$code?>','down');"><i class="fas fa-minus"></i></i></span>
												<input onchange="onchange_quantity('<?=$id?>','<?=$code?>','change');" type="number" min="1" value="<?=$qty?>"/>
												<span class="quantity-up" onclick="onchange_quantity('<?=$id?>','<?=$code?>','up');"><i class="fas fa-plus"></i></span>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
					<?php } ?>
				</div>

				<div class="total-cart <?=(empty($modal)) ? "col-md-3" : "col-12"?>">
					<div class="info d-flex justify-content-between">
						<p>Tạm tính: </p>
						<span class="price ml20"><?=$func->money($funcCart->get_order_total())?></span>
					</div> 
					<div class="amount d-flex justify-content-between">
						<p>Thành tiền: </p>
						<span class="total ml20"><?=$func->money($funcCart->get_order_total())?>
					</div> 
					<a class="btn btn-basic checkout" href="thanh-toan"><?=_dathang?></a>
				</div>
			</div>
		</form>
	</section>

<?php } else { ?>

	<section class="cart-empty py-4">
		<img src="<?=ASSETS?>images/img-empty.png">
		<p>Giỏ hàng của bạn còn trống</p>
		<a class="btn btn-basic" href="">Mua ngay</a>
	</section>

<?php } ?>