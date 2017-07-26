<?php
/*
time:2015/10/27
who ：xiaolv
rel : login.htm
add:会员注册
*/
$_groupid = 5;
define('MT_ROOT', DT_ROOT.'/module/member');
require MT_ROOT.'/global.func.php';
require DT_ROOT.'/include/module.func.php';
require MT_ROOT.'/member.class.php';
require DT_ROOT.'/include/post.func.php';
require DT_ROOT.'/lang/zh-cn/member.inc.php';

$do = new member;
$wap = true;

//captcha($captcha, 3, false, $MODULE[1]['linkurl'].'wap/index.php?moduleid=2&action=login&register=1',$wap);

if($submit) {
	$MOD['minusername'] = $MOD['maxusername'] = $MOD['banusername'] = $MOD['banemail'] = $MOD['minpassword'] = $MOD['maxpassword'] = $MOD['sound'] = $MOD['introduce_length'] = $MOD['credit_register'] = $MOD['money_register'] = $MOD['sms_register'] = '';
	$MOD['introduce_clear'] = $MOD['introduce_save'] =true;
	$member['sound'] = 1;
	if(!$member['username']){$exusername = explode('@',$member['email']);$member['username'] = $exusername[0];}
	if(!$member['truename']){$member['truename'] = $member['username'];}
	$member['groupid'] = $member['regid'];
	if($member['groupid'] == 5) $member['company'] = $member['truename'];
	$member['passport'] = $member['passport'] ? $member['passport'] : $member['username'];
	$member['edittime'] = $member['edittime'] ? $DT_TIME : 0;
	$member['inviter'] = $member['username'];
	if($do->add($member)) {
		if(is_mobile($member['mobile'])) {
			$message = lang('sms->wel_reg', array($member['truename'], $DT['sitename'], $member['username'], $member['password']));
			$message = strip_sms($message);
			send_sms($member['mobile'], $message);
		}
		$post = $member;		
		$username = $member['username'];
		$email = $member['email'];
		$title = $L['register_msg_welcome'];
		$content = ob_template('welcome', 'mail');
		send_message($username, $title, $content);
			$user = $do->login($username, $member['password'], 86400*365);
			if($user) {
				$cookietime = $DT_TIME + ($login_cookietime ? intval($login_cookietime) : 86400*7);
				$auth = encrypt($user['userid']."\t".$user['username']."\t".$user['groupid']."\t".$user['password']."\t".$user['admin']."\t".$childusername);
				set_cookie('auth', $auth, $cookietime);
				set_cookie('userid', $user['userid'], $cookietime);
				set_cookie('username', $user['username'], $DT_TIME + 86400*365);
			}
		if($DT['mail_type'] != 'close') send_mail($email, $title, $content);
		message('注册成功，正在重新进入', $_POST['forward'],3,$wap);
	} else {
		message($do->errmsg,$_POST['forward'],3,$wap);
	}
} else {
	include tpl('member_add', $module);
}
?>