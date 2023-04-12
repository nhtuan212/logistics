<?php if(!defined('SOURCE')) die("Error");
	if($func->isAjax() && !empty($_GET['modal']))
	{
		$modal = true;
		require_once TEMPLATE."cart/cart_tpl.php";
		exit;
	}
	if($com == 'thanh-toan') {
		@$info_user = $d->rawQueryOne("select * from #_user where id=?", array($_SESSION['login']['id']));
		@$city = $d->rawQuery("select id, name from #_place_city where FIND_IN_SET('display', status) order by number, id asc");
		@$payments = $d->rawQuery("select id, name$lang as name, content$lang as content FROM #_post WHERE type='payments' and FIND_IN_SET('display', status) order by number, id desc");
		
		if(isset($_POST['btn-pay']))
		{
			$data = $_POST['data_cart'];
			$total = $funcCart->get_order_total();
			$code = "#".time();
			$name_city = $func->get_place('table_place_city', $data['id_city']);
			$name_dist = $func->get_place('table_place_dist', $data['id_dist']);

			$data['ip'] = $statistic->getRealIPAddress();
			@$data['id_user'] = @$_SESSION['login']['id'];
			$data['date_created'] = time();
			$data['code'] = $code;
			$data['total'] = $total;
			$data['number'] = '1';
			$data['status'] = 'display';
			if($d->insert('order', $data))
			{
				$id_parent = $d->getLastInsertId();
				if(is_array($_SESSION['cart'])) {
					for($i=0; $i<count($_SESSION['cart']); $i++) {
						$id = $_SESSION['cart'][$i]['id'];
						$qty = $_SESSION['cart'][$i]['qty'];
						$cart_name = $funcCart->cart_detail($id, 'name');
						$cart_code = $funcCart->cart_detail($id, 'code');
						$cart_photo = $funcCart->cart_detail($id, 'photo');
						$cart_price = $funcCart->cart_detail($id, 'price');
						$size = $d->rawQueryOne("select id, name$lang as name, attribute from #_attribute where id=?", array($_SESSION['cart'][$i]['size']));
						$color = $d->rawQueryOne("select id, name$lang as name, attribute from #_attribute where id=?", array($_SESSION['cart'][$i]['color']));

						$data_order_detail['id_parent'] = $id_parent;
						$data_order_detail['id_product'] = $id;
						$data_order_detail['id_size'] = $size['id'];
						$data_order_detail['id_color'] = $color['id'];
						$data_order_detail['code'] = $code;
						$data_order_detail['product_code'] = $cart_code;
						$data_order_detail['name'] = $cart_name;
						$data_order_detail['photo'] = $cart_photo;
						$data_order_detail['qty'] = $qty;
						$data_order_detail['price'] = $cart_price;
						$data_order_detail['total'] = $total;
						$data_order_detail['date_created'] = time();
						$data_order_detail['number'] = 1;
						$data_order_detail['status'] = 'display';

						if(!$d->insert('order_detail', $data_order_detail)) $func->transfer("Đơn hàng của bạn chưa được gửi<br>Vui lòng điền đầy đủ thông tin lại<br>Cảm ơn", "gio-hang", "error");
					}
					$func->formOrder($data);
	            }
				else $func->transfer("Đơn hàng của bạn chưa có sản phẩm<br>Vui lòng chọn sản phẩm để đặt hàng<br>Cảm ơn", $config_url_http, "error");
			}
		}
	}
?>