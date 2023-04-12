<?php if($funcCart->countSession()) { ?>
	<section class="cover-pay">
		<form class="form" method="post" enctype="multipart/form-data">
			<div class="row">
				<div class="pay-info col-md-8">
					<div class="row justify-content-between">
						<div class="col-md-6 mb-2 address">
							<p class="title-cart"><?=_thongtinkhachhang?></p>

							<div class="form-group">
								<label><?=_hoten?></label>
								<input type="text" class="form-control" name="data_cart[name]" required>
							</div>

							<div class="form-group">
								<label><?=_dienthoai?></label>
								<input type="text" class="form-control" name="data_cart[phone]" required>
							</div>

							<div class="form-group">
								<label>Email</label>
								<input type="text" class="form-control" name="data_cart[email]" required>
							</div>

							<div class="form-group">
								<label><?=_tinhthanhpho?></label>
								<select class="form-control id_city" name="data_cart[id_city]" onchange="change_place('id_city', 'dist')" required>
									<option value=""><?=_tinhthanhpho?></option>
									<?php for($i=0; $i < count($city); $i++){ ?>
										<option value="<?=$city[$i]['id']?>">
											<?=$city[$i]['name']?>
										</option>
									<?php } ?>
								</select>
							</div>

							<div class="form-group">
								<label><?=_quanhuyen?></label>
								<select class="form-control ajax-dist" name="data_cart[id_dist]" required>
									<option value=""><?=_quanhuyen?></option>
									<?php for($i=0; $i < count($dist); $i++){ ?>
										<option value="<?=$dist[$i]['id']?>">
											<?=$dist[$i]['name']?>
										</option>
									<?php } ?>
								</select>
							</div>

							<div class="form-group">
								<label><?=_diachi?></label>
								<input type="text" class="form-control" name="data_cart[address]" required>
							</div>
						</div>
						<div class="col-md-6 mb-2 payments">
							<p class="title-cart">Thanh toán</p>
							<div class="box mt-2">
								<?php foreach ($payments as $i => $item) { ?>
									<div class="item-payments <?=($i==0) ? "active" : ""?>" data-id="<?=$item['id']?>">
										<div class="info d-flex justify-content-between">
											<span class="radio"></span>
											<h3 class="name"><?=$item['name']?></h3>
											<i class="far fa-money-bill-alt"></i>
										</div>
										<aside class="content"><?=$func->decode($item['content'])?></aside>
									</div>
								<?php } ?>
								<input type="hidden" name="data_cart[id_payments]" value="<?=$payments[0]['id']?>">
							</div>
						</div>
					</div>
				</div>
				<div class="pay-cart col-md-4">
					<p class="title-cart"><?=_sanpham?></p>
					<?php for($i=0; $i < count($_SESSION['cart']); $i++) { ?>
						<?php
							$id = $_SESSION['cart'][$i]['id'];
							$qty = $_SESSION['cart'][$i]['qty'];
							$code = $_SESSION['cart'][$i]['code'];
							$cart_photo = $funcCart->cart_detail($id, 'photo', UPLOAD_PRODUCT_L, "100x80x2/");
							$cart_name = $funcCart->cart_detail($id, 'name');
							$cart_price = $funcCart->cart_detail($id, 'price');
							$size = $d->rawQueryOne("select id, name$lang as name, attribute from #_attribute where id=?", array($_SESSION['cart'][$i]['size']));
							$color = $d->rawQueryOne("select id, name$lang as name, attribute from #_attribute where id=?", array($_SESSION['cart'][$i]['color']));
						?>

						<div class="item-cart d-flex justify-content-between flex-wrap">
							<div class="img"><?=$cart_photo?></div>
							<div class="info">
								<h3 class="name"><?=$cart_name?></h3>
								<?php if($size) { ?><div class="d-flex"><label class="mr-10">Size:</label><span><?=$size['name']?></span></div><?php } ?>
								<?php if($color) { ?><div class="d-flex"><label class="mr-10">Màu:</label><span><?=$color['name']?></span></div><?php } ?>
								<p class="price d-flex justify-content-between"><span><?=$func->money($cart_price)?></span><strong>x <?=$qty?></strong></p>
							</div>
						</div>
					<?php } ?>
					<div class="total-pay py-2">
						<div class="row py-2 info d-flex justify-content-between">
							<p>Tổng tiền</p>
							<p><?=$func->money($funcCart->get_order_total())?></p>
						</div>
						<div class="row py-2 ship none d-flex justify-content-between">
							<p>Phí vận chuyển</p>
							<p><?=$func->money(20000)?></p>
						</div>
						<div class="row py-2 amount d-flex justify-content-between">
							<p>Tổng thanh toán</p>
							<span><?=$func->money($funcCart->get_order_total())?></span>
						</div>
					</div>
					<div class="btn-pay">
						<div class="form-group">
							<textarea class="form-control" name="data_cart[content]" rows="4" placeholder="<?=_noidung?>"></textarea>
						</div>
						<input class="btn btn-danger py-2 px-5" name="btn-pay" type="submit" value="<?=_dathang?>">
					</div>				
				</div>
			</div>
		</form>
	</section>
<?php } else { ?>
	<section class="cart-empty p-4">
		<img src="<?=ASSETS?>images/img-empty.png">
		<p>Giỏ hàng của bạn còn trống</p>
		<a class="btn btn-basic" href="">Mua ngay</a>
	</section>
<?php } ?>