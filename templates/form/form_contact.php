<?php
	$options = (isset($data['options']) && $data['options'] != '') ? json_decode($data['options'],true) : null;
    $info_name = $options['name'];
    $info_email = $options['email'];
    $info_phone = $options['phone'];
    $info_address = $options['address'];
    $info_topic = $options['topic'];
    $info_content = $options['content'];

    $info = '';
    if($info_name) $info.='Tên: <span style="text-transform:capitalize">'.$info_name.'</span><br>';
    if($info_email) $info.='Email: <a href="mailto:'.$info_email.'" target="_blank">'.$info_email.'</a><br>';
    if($info_address) $info.='Địa chỉ: '.$info_address.'<br>';
    if($info_phone) $info.='Tel: '.$info_phone.'';

	$messages = '
		<section style="width:100%!important;background-color:#f2f2f2;margin:0;padding:20px;font-size:12px;color:#444;font-family:Arial,Helvetica,sans-serif;line-height:18px;">
			<aside style="max-width:600px;margin:auto;background-color:#fff;padding-bottom:10px;">
				<div style="padding:10px 20px;">
					'.$mailer->formHeader().'					
					<div style="margin: 20px 0;">
						<h1 style="font-size:17px;font-weight:bold;color:#444;padding:0 0 5px 0;margin:0">Kính chào Quý khách,</h1>
						<p style="margin:4px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal">Thông tin liên hệ của quý khách đã được tiếp nhận. '.$mailer->website.' sẽ phản hồi trong thời gian sớm nhất.</p>
					</div>
					<table>
						<thead>
							<tr>
								<h3 style="font-size:13px;font-weight:bold;color:'.$mailer->color_form.';text-transform:uppercase;margin:20px 0 0 0;padding: 0 0 5px;border-bottom:1px solid #ddd">Thông tin liên hệ <span style="font-size:12px;color:#777;text-transform:none;font-weight:normal">(Ngày '.date('d',$mailer->time).' tháng '.date('m',$mailer->time).' năm '.date('Y H:i:s',$mailer->time).')</span></h3>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td style="padding:3px 0px;border-top:0;border-left:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal" valign="top">'.$info.'</td>
							</tr>
							<tr>
								<td colspan="2" style="border-top:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444" valign="top">&nbsp;
									<p style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal;margin-top:0"><strong>Tiêu đề: </strong> '.$info_topic.'<br>
								</td>
							</tr>
							<tr>
								<td>
									<p style="margin:4px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal"><i>'.$info_content.'</i></p>
								</td>
							</tr>
							<tr>
								<td>&nbsp;
									<p style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal;border:1px '.$mailer->color_form.' dashed;padding:10px;list-style-type:none">Bạn cần được hỗ trợ ngay? Chỉ cần gửi mail về <a href="mailto:'.$mailer->email.'" style="color:'.$mailer->color_form.';text-decoration:none" target="_blank"> <strong>'.$mailer->email.'</strong> </a>, hoặc gọi về hotline <strong style="color:'.$mailer->color_form.'">'.$mailer->phone.'</strong> '.$mailer->website.' luôn sẵn sàng hỗ trợ bạn bất kì lúc nào.</p>
								</td>
							</tr>
							<tr>
								<td>&nbsp;
									<p style="font-family:Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;line-height:18px;color:#444;font-weight:bold">Một lần nữa '.$mailer->website.' cảm ơn quý khách.</p>
									<p style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal;text-align:right"><strong><a href="'.$mailer->home.'" style="color:'.$mailer->color_form.';text-decoration:none;font-size:14px" target="_blank">'.$mailer->name.'</a> </strong></p>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</aside>
		</section>';
	$arr_email = array(
		"dataEmail" => array(
			"name" => $info_name,
			"email" => $info_email,
		),
	);
	$mailer->sendEmail($arr_email, $messages, "Gửi liên hệ thành công", "Gửi liên hệ thất bại");
?>