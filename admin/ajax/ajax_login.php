<?php
	session_start();
	include ("ajax_config.php");
	$username = $func->decode($_POST['username']);
	$password = $func->decode($_POST['password']);
	$ip = $statistic->getRealIPAddress();

	//Kiểm tra có IP bị khóa login hay không
	$checkIP = $d->rawQueryOne("select id, login_ip, login_attempts, attempt_time, locked_time from #_user_limit WHERE login_ip=?", array($ip));
	if($checkIP)
	{
		$id_login = $checkIP['id'];
		$time_now = time();
	   	//Kiểm tra thời gian bị khóa đăng nhập
		if($checkIP['locked_time']>0)
		{
			$locked_time = $checkIP['locked_time'];
			$delay_time = $config['login']['delay'];
			$interval = $time_now  - $locked_time;
			if($interval <= $delay_time*60)
			{
				$time_remain = $delay_time*60 - $interval;
				$msg = "Xin lỗi..!Vui lòng thử lại sau ". round($time_remain/60)." phút..!";
				echo('{"failed":"'.$msg.'"}');
				return false;
			}
			else $d->rawQuery("update #_user_limit set login_attempts = 0, attempt_time=? , locked_time = 0 where id=?", array($time_now, $id_login));
		}
	}

	$login = $d->rawQueryOne("select * from #_user where username=?", array($username));
	$options = (isset($item['options']) && $item['options'] != '') ? json_decode($item['options'],true) : null;
	if($login && $login['password'] == $func->encrypt_password($config['login']['salt'], $password))
	{
		//dang nhap thanh cong
		$timenow = time();
		$id_user = $login['id'];
		$ip = $statistic->getRealIPAddress();
		$user_agent = $_SERVER['HTTP_USER_AGENT'];

		//Ghi log truy cập thành công
		$data['id_user'] = $id_user;
		$data['ip'] = $ip;
		$data['timelog'] = $timenow;
		$data['user_agent'] = $user_agent;
		$d->insert('user_log', $data);

		//Tạo token và login session	
		$cookiehash = md5(sha1($login['password'].$login['username']));
		$token = md5(time());
		$d->rawQuery("update #_user SET login_session=?, lastlogin=?, user_token=? WHERE id=?", array($cookiehash, $timenow, $token, $id_user));

		$_SESSION[$login_admin] = true;
		$_SESSION['login_session'] = $cookiehash;
		$_SESSION['login_token'] = $token;
		$_SESSION['login_admin']['id'] = $login['id'];
		$_SESSION['login_admin']['id_permission'] = $login['id_permission'];
		$_SESSION['login_admin']['username'] = $username;
		$_SESSION['login_admin']['password'] = $password;
		$_SESSION['login_admin']['name'] = $options['name'];
		$_SESSION['login_admin']['role'] = $login['role'];
		$_SESSION['login_admin']['type'] = $login['type'];

		//Login thành công thì reset số lần login sai và thời gian khóa
		$resetLogin = $d->rawQueryOne("select id, login_ip, login_attempts, attempt_time, locked_time from #_user_limit where login_ip=?", array($ip));
		if($resetLogin) $d->rawQueryOne("update #_user_limit set login_attempts=0,locked_time=0 where id=?", array($resetLogin['id']));
		$success = true;
	}
	else
	{
		//dang nhap sai
		$loginWrong = $d->rawQueryOne("select id, login_ip, login_attempts, attempt_time, locked_time from #_user_limit where login_ip=?", array($ip));
		if($loginWrong)
		{
			//Trường hơp đã tồn tại trong database
			$id_login = $loginWrong['id'];
			$attempt =$loginWrong['login_attempts'];//Số lần thực hiện
			$noofattmpt = $config['login']['attempt'];//Số lần giới hạn
			if($attempt<$noofattmpt)
			{
				//Trường hợp còn trong giới hạn
				$attempt = $attempt +1;	
				$d->rawQuery("update #_user_limit set login_attempts=? where id=?", array($attempt, $id_login));	
				$no_ofattmpt =  $noofattmpt+1;
				$remain_attempt = $no_ofattmpt - $attempt;
				$msg = 'Tên đăng nhập hoặc mật khẩu không đúng.<br> Còn '.$remain_attempt.' lần thử!';
			}
			else
			{
				//Trường hợp vượt quá giới hạn
				if($loginWrong['locked_time']==0)
				{
					$attempt = $attempt +1;
					$timenow = time();
					$d->rawQuery("update #_user_limit set login_attempts=?, locked_time=? where id=?", array($attempt, $timenow, $id_login));
				}
				else
				{
					$attempt = $attempt +1;
					$d->rawQuery("update #_user_limit set login_attempts=? where id=?", array($attempt, $id_login));
				}

				$delay_time = $config['login']['delay'];
				$msg = "Bạn đã nhập quá số lần quy định.<br> Vui lòng thử lại sau ".$delay_time." phút!";
			}
		}
		else
		{
			//Trường hợp IP lần đầu tiên đăng nhập sai
			$timenow = time();
			$data['login_ip'] = $ip;
			$data['login_attempts'] = 1;
			$data['attempt_time'] = $timenow;
			$data['locked_time'] = 0;
			$d->insert('user_limit', $data);
			
			$remain_attempt = $config['login']['attempt'];
			$msg = 'Tên đăng nhập hoặc mật khẩu không đúng.<br> Còn '.$remain_attempt.' lần thử!';
		}
		$failed = $msg;
	}

	$data = array('success' => @$success, 'failed' => @$failed);
	echo json_encode($data);
?>