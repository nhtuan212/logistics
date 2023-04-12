<?php
	include ("ajax_config.php");	
	@$id = $func->decode($_POST['id']);
	@$code = $func->decode($_POST['code']);
	@$qty = $func->decode($_POST['qty']);
	@$size = $func->decode($_POST['size']);
	@$color = $func->decode($_POST['color']);
	@$act = $func->decode($_POST['act']);

	if($act == 'add')
	{
		$funcCart->addCart($id, $qty, $size, $color);
		$data['cart'] = 'success';
	}
	if($act == 'update')
	{
		for($i=0; $i < $funcCart->countSession(); $i++)
		{
			if($code == $_SESSION['cart'][$i]['code'])
			{
				if($qty) $_SESSION['cart'][$i]['qty'] = $qty;
				break;
			}
		}
		$total = $func->money($funcCart->get_order_total());
		$data = array('price' => @$price, 'total' => $total);
	}
	if($act == 'delete')
	{
		$funcCart->remove_product($code);
		$total = $func->money($funcCart->get_order_total());

		$data = array('total' => $total);
	}
	echo json_encode($data);
?>