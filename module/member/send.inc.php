<?php 
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';

require DT_ROOT.'/include/post.func.php';
$auth = isset($auth) ? trim($auth) : '';
switch($action) {
	case 'check':
		if($_userid && $_groupid != 4) dheader($MOD['linkurl']);
		if($auth) {			
			$user = check_auth($auth);
			auth_time($user['authtime']);
			$username = $user['username'];
			$groupid = $user['regid'];
			$email = $user['email'];
			$db->query("UPDATE {$DT_PRE}member SET auth='',groupid=$groupid,vemail=1 WHERE username='$username'");
			$db->query("UPDATE {$DT_PRE}company SET groupid=$groupid WHERE username='$username'");
			userclean($username);
			if($MOD['welcome_message'] || $MOD['welcome_email']) {
				$title = $L['register_msg_welcome'];
				$content = ob_template('welcome', 'mail');
				if($MOD['welcome_message']) send_message($username, $title, $content);
				if($MOD['welcome_email'] && $DT['mail_type'] != 'close') send_mail($email, $title, $content);
			}
			if($MOD['vmember'] && $MOD['vemail']) $db->query("INSERT INTO {$DT_PRE}validate (type,username,ip,addtime,status,title,editor,edittime) VALUES ('email','$username','$DT_IP','$DT_TIME','3','$email','system','$DT_TIME')");
			require MD_ROOT.'/member.class.php';
			$do = new member;
			$do->login($username, '', 0, true);
			message($L['send_check_success'], $MOD['linkurl']);
		} else {
			if($DT['mail_type'] == 'close') message($L['send_mail_close']);
			if($MOD['checkuser'] != 2) dheader(DT_PATH);		
			if($submit) {				
				captcha($captcha);
				check_name($username) or message($L['send_check_username_bad']);
				$user = userinfo($username);
				if($user) {
					if($user['groupid'] != 4) dalert($L['send_check_deny'], DT_PATH);
					if($user['password'] != dpassword($password, $user['passsalt'])) message($L['send_check_password_bad']);
					$email = trim($email);
					if($email && $email != $user['email']) {
						is_email($email) or message($L['send_check_email_bad']);
						$r = $db->get_one("SELECT userid FROM {$DT_PRE}member WHERE email='$email'");
						if($r) message($L['send_check_email_repeat']);
						$db->query("UPDATE {$DT_PRE}member SET email='$email' WHERE username='$username'");
					} else {
						$email = $user['email'];
					}
					$auth = make_auth($username);
					$db->query("UPDATE {$DT_PRE}member SET auth='$auth',authtime='$DT_TIME' WHERE username='$username'");
					userclean($username);
					$authurl = $MOD['linkurl'].'send.php?action='.$action.'&auth='.$auth;
					$title = $L['send_check_mail'];
					$content = ob_template('check', 'mail');
					send_mail($email, $title, stripslashes($content));
					dheader($MOD['linkurl'].'goto.php?action='.$action.'&email='.$email);
				} else {
					message($L['send_check_username_null']);
				}
			} else {
				$head_title = $L['send_check_title'];
				include template('send', $module);
			}
		}
	break;
	case 'payword':
		login();
		$username = $_username;
		if($auth) {
			$user = check_auth($auth);
			auth_time($user['authtime']);
			$username == $user['username'] or dheader($MOD['linkurl']);
			$authvalue = $user['authvalue'];
			$db->query("UPDATE {$DT_PRE}member SET auth='',authvalue='',authtime=0,payword='$authvalue' WHERE username='$username'");
			userclean($username);
			message($L['send_payword_success'], $MOD['linkurl']);
		} else {
			if($DT['mail_type'] == 'close') message($L['send_mail_close']);
			if($submit) {
				if(!is_password($username, $password)) message($L['member_login_password_bad']);
				if(strlen($password) > $MOD['maxpassword'] || strlen($password) < $MOD['minpassword']) message(lang($L['member_payword_len'], array($MOD['minpassword'], $MOD['minpassword'])));
				if($password != $cpassword) message($L['member_payword_match']);
				$user = userinfo($username);
				$authvalue = dpassword($password, $user['paysalt']);
				$auth = make_auth($username);
				$db->query("UPDATE {$DT_PRE}member SET auth='$auth',authvalue='$authvalue',authtime='$DT_TIME' WHERE username='$username'");
				userclean($username);
				$authurl = $MOD['linkurl'].'send.php?action='.$action.'&auth='.$auth;
				$title = $L['send_payword_mail'];
				$content = ob_template('payword', 'mail');
				send_mail($_email, $title, stripslashes($content));
				dheader($MOD['linkurl'].'goto.php?action='.$action.'&email='.$_email);
			} else {
				$head_title = $L['send_payword_title'];
				include template('send', $module);
			}
		}
	break;
	case 'shensu':
			if($submit) {
				captcha($captcha);
				$atitle='提交申诉成功！请勿重复提交！本站客服会在24小时内处理您的诉求并与您联系！';
				$sendtype='yes';
				if(!$title){$atitle='申诉标题不能为空';$sendtype='no';}
				if(!$content){$atitle='申诉详细内容不能为空';$sendtype='no';}
				if($sendtype=='yes'){
				send_message('gztc',$title, $content , 4, $_username);
				}
				echo "<script>alert('".$atitle."')</script>";
			} 
			else{
				$head_title = $L['send_payword_title'];
				include template('send', $module);
			}
	break;
	case 'email':
		login();
		$username = $_username;
		if($auth) {
			$user = check_auth($auth);			
			auth_time($user['authtime']);
			$username == $user['username'] or dheader($MOD['linkurl']);
			$email = $user['authvalue'];
			$r = $db->get_one("SELECT email FROM {$DT_PRE}member WHERE email='$email'");
			if($r) message($L['send_email_exist'], '?action=email');
			$db->query("UPDATE {$DT_PRE}member SET auth='',authvalue='',authtime=0,email='$email',vemail=1 WHERE username='$username'");
			userclean($username);
			if($MOD['vmember'] && $MOD['vemail']) $db->query("INSERT INTO {$DT_PRE}validate (type,username,ip,addtime,status,title,editor,edittime) VALUES ('email','$username','$DT_IP','$DT_TIME','3','$email','system','$DT_TIME')");
			message($L['send_email_success'], $MOD['linkurl']);
		} else {			
			if($DT['mail_type'] == 'close') message($L['send_mail_close']);
			if($submit) {
				if(!is_email($email)) message($L['member_email_null']);
				if(!is_password($username, $password)) message($L['member_login_password_bad']);
				$r = $db->get_one("SELECT email FROM {$DT_PRE}member WHERE email='$email'");
				if($r) message($L['send_email_exist']);
				$authvalue = $email;
				$auth = make_auth($username);
				$db->query("UPDATE {$DT_PRE}member SET auth='$auth',authvalue='$authvalue',authtime='$DT_TIME' WHERE username='$username'");
				userclean($username);
				$authurl = $MOD['linkurl'].'send.php?action='.$action.'&auth='.$auth;
				$title = $L['send_email_mail'];
				$content = ob_template('editemail', 'mail');
				send_mail($email, $title, stripslashes($content));
				dheader($MOD['linkurl'].'goto.php?action='.$action.'&email='.$email);
			} else {
				$head_title = $L['send_email_title'];
				include template('send', $module);
			}
		}
	break;
	case 'mobile':
		login();
		$username = $_username;
		if($auth) {
			$user = $db->get_one("SELECT * FROM {$DT_PRE}member WHERE username='$username'");
			if($auth == $user['auth']) {
				auth_time($user['authtime'], 1);
				$mobile = $user['authvalue'];
				$r = $db->get_one("SELECT userid FROM {$DT_PRE}member WHERE mobile='$mobile' AND vmobile=1 AND userid<>$_userid");
				if($r) message($L['send_mobile_exist'], $MOD['linkurl']);
				$db->query("UPDATE {$DT_PRE}member SET mobile='$mobile',vmobile=1,auth='',authvalue='',authtime=0 WHERE username='$username'");
				userclean($username);
				$db->query("INSERT INTO {$DT_PRE}validate (type,username,ip,addtime,status,title,editor,edittime) VALUES ('mobile','$username','$DT_IP','$DT_TIME','3','$mobile','system','$DT_TIME')");
				message($L['send_mobile_success'], $MOD['linkurl']);
			}
			message($L['send_mobile_code_error']);
		} else {			
			$DT['sms'] or message($L['send_sms_close']);
			if($submit) {
				is_mobile($mobile) or message($L['send_mobile_bad']);
				if(!is_password($username, $password)) message($L['member_login_password_bad']);
				$r = $db->get_one("SELECT userid FROM {$DT_PRE}member WHERE mobile='$mobile' AND vmobile=1 AND userid<>$_userid");
				if($r) message($L['send_mobile_exist']);
				if(max_sms($mobile)) message($L['sms_msg_max']);
				$auth = random(6, '0123456789');
				$content = lang('sms->sms_code', array($auth, $MOD['auth_days']*10)).$DT['sms_sign'];
				$sms_code = send_sms($mobile, $content);
				if(1||strpos($sms_code, $DT['sms_ok']) !== false) {
					$db->query("UPDATE {$DT_PRE}member SET auth='$auth',authvalue='$mobile',authtime='$DT_TIME' WHERE username='$username'");
					userclean($username);
					dheader('?code=1&action='.$action.'&mobile='.$mobile);
				} else {
					message($L['send_mobile_fail']);
				}
			}
			(isset($mobile) && is_mobile($mobile)) or $mobile = '';
			$head_title = $L['send_passport_title'];
			include template('send', $module);
		}
	break;
	case 'passport':
		$_username == $_passport or dheader('edit.php');
		if($submit) {
			isset($npassport) or $npassport = '';
			require MD_ROOT.'/member.class.php';
			$do = new member;
			$do->userid = $_userid;
			if($do->edit_passport($_passport, $npassport, $_username)) {
				dmsg($L['op_edit_success'], 'edit.php');
			} else {
				message($do->errmsg);
			}
		} else {			
			$head_title = $L['send_passport_title'];
			include template('send', $module);
		}
	break;
	default:
		if($_userid) dheader($MOD['linkurl']);
		if($auth) {
			$user = check_auth($auth);
			auth_time($user['authtime']);
			$authvalue = $user['authvalue'];
			$username = $user['username'];
			$db->query("UPDATE {$DT_PRE}member SET auth='',authvalue='',authtime=0,password='$authvalue' WHERE username='$username'");
			userclean($username);
			message($L['send_password_success'], $MOD['linkurl'].$DT['file_login'].'?username='.$username);
		} else {
			if($DT['mail_type'] == 'close') message($L['send_mail_close']);
			if($submit) {
#2014-04-19
#tcDehe
#关联：
#	template\tc\member\send.htm （272至287行，300至320行）
#动作：DT原代码修改
#行：199至207；220至235 PS：当错误输入$MOD['login_times']次$userORemail后会在file\cache\ban生成$DT_IP.php文件（228行），$MOD['lock_hour']小时后删除该文件（231行）
				captcha($captcha);
				$error_message = $L['send_password_error'];
				if(strpos($userORemail,'@')){
					$error_message = '不存在的邮箱';
					$email = $userORemail;
					$email = trim($email);
					if(!is_email($email)) message($L['member_email_null']);
					$r = $db->get_one("SELECT username,groupid,passsalt FROM {$DT_PRE}member WHERE email='$email'");
				}else{
					$error_message = '不存在的用户名';
					$username = $userORemail;
					$r = $db->get_one("SELECT username,groupid,email,passsalt FROM {$DT_PRE}member WHERE username='$username'");
				}
				if($r) {
					$username = $r['username'];
					$email = $r['email'];
					if($r['groupid'] == 4) message($L['send_password_checking']);
					$authvalue = dpassword($password, $r['passsalt']);
					$auth = make_auth($username);
					$db->query("UPDATE {$DT_PRE}member SET auth='$auth',authvalue='$authvalue',authtime='$DT_TIME' WHERE username='$username'");
					userclean($username);
					$authurl = $MOD['linkurl'].'send.php?auth='.$auth;
					$title = $L['send_password_mail'];
					$content = ob_template('password', 'mail');
					send_mail($email, $title, stripslashes($content));
					dheader($MOD['linkurl'].'goto.php?action=password&email='.$email);
				} else {
					require MD_ROOT.'/member.class.php';
					$do = new member;
					$login_lock = ($MOD['login_times'] && $MOD['lock_hour']) ? true : false;
					$LOCK = array();
					if($login_lock) {
						$LOCK = cache_read($DT_IP.'.php', 'ban');
						if($LOCK) {
							if($DT_TIME - $LOCK['time'] < $MOD['lock_hour']*3600) {
								if($LOCK['times'] >= $MOD['login_times']) message("您输错了".$MOD['login_times']."次用户名或邮箱！请在".$MOD['lock_hour']."小时后再重新试找回用户密码！");
							} else {
								$LOCK = array();
								cache_delete($DT_IP.'.php', 'ban');
							}
						}
					}
					$do->lock($login_lock, $LOCK, $DT_IP, $DT_TIME);
					message($error_message);
				}
			} else {
				$head_title = $L['send_password_title'];
				include template('send', $module);
			}
		}
	break;
}
?>
