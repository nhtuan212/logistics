<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
	include_once LIB."PHPMailer/PHPMailer.php";
	include_once LIB."PHPMailer/SMTP.php";
	include_once LIB."PHPMailer/Exception.php";

	class Mailer
	{
		private $setting = array();
		private $optsetting = '';

		function __construct($d)
		{
			$this->db = $d;
			$this->infoMailer();
		}

		private function infoMailer()
		{
			global $config_url_http, $lang;
			$this->setting = $this->db->rawQueryOne("select * from #_setting");
			$this->optsetting = (isset($this->setting['options']) && $this->setting['options'] != '') ? json_decode($this->setting['options'],true) : null;
			$this->home = $config_url_http;
			@$this->name = $this->setting['name'];
			@$this->address = $this->optsetting['address'];
			@$this->email = $this->optsetting['email'];
			@$this->phone = $this->optsetting['phone'];	
			@$this->website = $this->optsetting['website'];	
			$this->color_form = '#94130F';
			$this->time = time();
		}
		public function formHeader()
		{
			global $func;
			$logo = "<img src=".$this->home.$func->get_photoSelect('logo', '120x80x2').">";			
			$result = '
				<div style="display:flex;justify-content: space-between;align-items: flex-end;padding: 0 0 20px 0;border-bottom:2px solid '.$this->color_form.';">
					<a style="width:100px;" href="'.$this->home.'" target="_blank">'.$logo.'</a>
					<div style="width:calc(100% - 120px);text-align:right">
						<h3 style="margin-bottom:10px;font-weight:bold;font-size:20px;color:'.$this->color_form.'">'.$this->name.'</h3>
						<p>'.$this->address.'</p>
					</div>
				</div>';
			return $result;
		}
		public function sendEmail($arr_email=array(), $messages, $success, $failed, $redirect='index', $file=false)
		{
			global $func;
			$mail = new PHPMailer(true);
			$mail->IsSMTP();
			$mail->SMTPAuth = true;
			$mail->SMTPDebug = false;
			$mail->SMTPSecure = 'tls';
			$mail->Host = $this->optsetting['ip_host'];
			$mail->Port = 25;
			$mail->Username = $this->optsetting['email_host'];
			$mail->Password = $this->optsetting['pass_host'];
			$mail->SetFrom($this->optsetting['email_host'],$this->optsetting['name']);
			$mail->SMTPOptions = array('ssl' => array('verify_peer' => false,'verify_peer_name' => false,'allow_self_signed' => true));
			$mail->AddAddress($this->email, $this->name);
			$mail->AddReplyTo($this->email, $this->name);
			if(!empty($arr_email))
			{
				foreach($arr_email as $email_item)
				{
					$mail->AddAddress($email_item['email'],$email_item['name']);
				}
			}

			$mail->CharSet = "utf-8";
			$mail->AltBody = "To view the message, please use an HTML compatible email viewer!";
			$mail->Subject = "Xin chào ".$this->name;
			$mail->MsgHTML($messages);
			if($file==true) $mail->AddAttachment($_FILES[$file]["tmp_name"], $_FILES[$file]["name"]);
			if($mail->Send()) $func->transfer($success, $redirect, "success");
			else $func->transfer($failed, $redirect, "error");
		}
	}
?>