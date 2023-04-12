<?php
	@$payments = $d->rawQueryOne("select id, name$lang as name, content$lang as content FROM #_post WHERE id=? and type=? and hienthi=? order by number, id desc", array($data['id_payments'], 'payments', '1'));

	@$info_code = $data['code'];
	@$info_name = $data['name'];
    @$info_email = $data['email'];
    @$info_phone = $data['dienthoai'];
    @$info_address = $data['diachi'];
    @$info_topic = $data['chude'];
    @$info_content = $data['content'];
    @$info_payments = $payments['name'];
    @$info_city = $func->get_place('table_place_city', $data['id_city']);
    @$info_dist = $func->get_place('table_place_dist', $data['id_dist']);
    @$total = $funcCart->get_order_total();
	@$cart_detail = "";

	for($i=0; $i<count($_SESSION['cart']); $i++) {
		$id = $_SESSION['cart'][$i]['id'];
		$qty = $_SESSION['cart'][$i]['qty'];
		$cart_name = $funcCart->cart_detail($id, 'name');
		$cart_price = $funcCart->cart_detail($id, 'price');
		$size = $d->rawQueryOne("select id, name$lang as name from #_attribute where id=?", array($_SESSION['cart'][$i]['size']));
		$color = $d->rawQueryOne("select id, name$lang as name from #_attribute where id=?", array($_SESSION['cart'][$i]['color']));

		$attr = '';
		if($size) $attr .= '<div>Size: '.$size['name'].'</div>';
		if($color) $attr .= '<div>Màu: '.$color['name'].'</div>';

		$cart_detail.='
			<tr>
				<td style="padding:3px 9px;">
					<div style="display: inline-block;vertical-align: middle;">
						<strong>'.$cart_name.'</strong>
						'.$attr.'
					</div>
				</td>
				<td style="padding:3px 9px">'.$func->money($cart_price).'</td>
				<td style="padding:3px 9px">'.$qty.'</td>
				<td align="right" style="padding:3px 9px">'.$func->money($cart_price*$qty).'</td>
			</tr>';
	}
	@$messages .= '
		<section style="width:100%!important;background-color:#f2f2f2;margin:0;padding:20px;font-size:12px;color:#444;font-family:Arial,Helvetica,sans-serif;line-height:18px;">
			<aside style="max-width:600px;margin:auto;background-color:#fff;padding-bottom:10px;">
				<div style="padding:10px 20px;">
					'.$mailer->formHeader().'
					<div>
						<h1 style="padding:0 0 5px 0; font-weight:bold; font-size:14px; color:#333;">
							Đơn đặt hàng từ website <a href="'.$mailer->website.'">'.$mailer->website.'</a></h1>
						</h1>
						<p>
							Chúng tôi đã tiếp nhận đơn hàng của quý khách '.$info_name.'
						</p>
						<h3 style="font-size:13px;font-weight:bold;color:'.$mailer->color_form.';text-transform:uppercase;margin:20px 0 0 0;border-bottom:1px solid #ddd">Thông tin đơn hàng '.$info_code.'</h3>
					</div>
					<table>
						<tbody>
							<tr>
								<th align="left" width="50%" style="padding:6px 9px 0px 9px;font: bold 12px Arial, Helvetica, sans-serif;color:#444;">Thông tin thanh toán</th>
								<th align="left" width="50%" style="padding:6px 9px 0px 9px;font: bold 12px Arial, Helvetica, sans-serif;color:#444;">Địa chỉ giao hàng</th>
							</tr>
							<tr>
								<td style="vertical-align: top;">
									<p style="margin:0;padding:6px 9px 0px 9px;">'.$info_name.'</p>
									<p style="margin:0;padding:6px 9px 0px 9px;">'.$info_email.'</p>
									<p style="margin:0;padding:6px 9px 0px 9px;">'.$info_phone.'</p>
									<p style="margin:0;padding:6px 9px 0px 9px;">'.$info_content.'</p>
								</td>
								<td style="vertical-align: top;">
									<p style="margin:0;padding:6px 9px 0px 9px;">'.$info_address.'</p>
									<p style="margin:0;padding:6px 9px 0px 9px;">Thành phố: '.$info_city.' - Quận/Huyện: '.$info_dist.'</p>
								</td>
							</tr>
							<tr>
								<td style="padding:3px 9px"><b>Hình thức thanh toán: </b>'.$info_payments.'</td>
							</tr>
							<tr>
								<td style="padding:3px 9px"><b>Tổng giá: </b>'.$func->money($total).'</td>
							</tr>
						</tbody>
					</table>

					<h2 style="margin:10px 0; padding-bottom:5px; font-size:13px; color:'.$mailer->color_form.'; text-align:left; border-bottom:1px solid #ddd;">CHI TIẾT ĐƠN HÀNG</h2>

					<table width="100%" border="0" cellpadding="0" cellspacing="0" style="background:#f5f5f5;border-collapse: collapse;">
						<thead>
							<tr>
								<th align="left" bgcolor="'.$mailer->color_form.'" style="padding:6px 9px; font: 12px/15px Arial, Helvetica, sans-serif; color:#fff; text-transform:uppercase;">Sản phẩm</th>
								<th align="left" bgcolor="'.$mailer->color_form.'" style="min-width: 30px;padding:6px 9px; font: 12px/15px Arial, Helvetica, sans-serif; color:#fff; text-transform:uppercase;">Giá</th>
								<th align="left" bgcolor="'.$mailer->color_form.'" style="min-width: 30px;padding:6px 9px; font: 12px/15px Arial, Helvetica, sans-serif; color:#fff; text-transform:uppercase;">SL</th>
								<th align="right" bgcolor="'.$mailer->color_form.'" style="min-width: 75px;padding:6px 9px; font: 12px/15px Arial, Helvetica, sans-serif; color:#fff; text-transform:uppercase;">Thành tiền</th>
							</tr>
						</thead>
						<tbody>'.$cart_detail.'<tbody>
						<tfoot>
							<tr bgcolor="#eee">
								<td colspan="3" align="right" style="padding:7px 9px">
									<strong><big>Tổng giá trị đơn hàng</big></strong>
								</td>
								<td align="right" style="padding:7px 9px">
									<strong><big>'.$func->money($total).'</big></strong>
								</td>
							</tr>
						<tfoot>
					</table>
				</div>
			</aside>
		</section>';
	
	unset($_SESSION['cart']);
	$arr_email = array(
		"dataEmail" => array(
			"name" => $info_name,
			"email" => $info_email,
		),
	);
	$mailer->sendEmail($arr_email, $messages, "Bạn đã đặt thành công đơn hàng ".$info_code.".<br> Chúng tôi sẽ liên hệ với bạn sớm nhất.", "Đặt hàng thất bại");
?>