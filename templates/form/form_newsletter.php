<?php
	$messages .= '
		<table>
			<tr>
				<th>Đăng ký nhận tin thành công từ website <a href="'.$_SERVER["SERVER_NAME"].'">'.$_SERVER["SERVER_NAME"].'</a></th>
			</tr>
			<tr>
				<td>Họ tên :</td><td>'.$data['name'].'</td>
			</tr>
			<tr>
				<td>Địa chỉ :</td><td>'.$data['address'].'</td>
			</tr>
			<tr>
				<td>Điện thoại :</td><td>'.$data['phone'].'</td>
			</tr>
			<tr>
				<td>Email :</td><td>'.$data['email'].'</td>
			</tr>
			<tr>
				<td>Nội dung :</td><td>'.$data['content'].'</td>
			</tr>
		</table>';

	$arr_email = array(
		"dataEmail" => array(
			"name" => $data['email'],
			"email" => $data['name'],
		),
	);
	$mailer->sendEmail($arr_email, $messages, _guiemailthanhcong, _guiemailthatbai);
?>