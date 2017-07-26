<?php
/*
time:2015/10/27
who ：xiaolv
rel : login.htm
add:新增忘记密码
*/
$moduleid = 2;
require_once '../common.inc.php';
require_once DT_ROOT.'/include/post.func.php';
require_once DT_ROOT.'/module/member/global.func.php';
require DT_ROOT.'/include/module.func.php';
require 'global.func.php';
include load('wap.lang');
include load('member.lang');
//$forward = DT_PATH.'wap/index.php?moduleid=2&action=login&type=get_password';
$forward = DT_PATH.'wap/index.php?moduleid=2&action=login';
$wap=true;
if($_SERVER['REQUEST_METHOD']=='POST'){
	// if($_POST['option']=='username'){

	// }elseif($_POST['option']=='mobile'){

	// }else{
	// 	dheader($forward);
	// }
	if($DT['mail_type'] == 'close') {
		message('邮件发送功能尚未开启',$forward,3,$wap);
		}
	if($submit) {
		//captcha($captcha, 3, false,$forward,$wap);
		$email = trim($email);
		if(!is_email($email)){ 
			message('请填写正确的邮箱',$forward,3,$wap);
			}
		if(strlen($password) > $MOD['maxpassword'] || strlen($password) < $MOD['minpassword']){
			message('密码长度为'.$MOD['minpassword'].'~'.$MOD['maxpassword'].'之间',$forward,3,$wap);
		}
		if($password != $cpassword) {
			message('两次输入的密码不一致',$forward,3,$wap);
		}
		$options = array('username', 'passport', 'email', 'mobile', 'company', 'qq', 'msn', 'ali', 'skype', 'userid');
		in_array($option, $options) or $option = 'username';
		// $r = $db->get_one("SELECT username,groupid email FROM ".$DT_PRE."member WHERE email='$email' AND `$option`='$username'");
		$r = $db->get_one("SELECT username,groupid email FROM ".$DT_PRE."member WHERE email='$email'");
		if($r) {
			$username = $r['username'];
			if($r['groupid'] == 4) {
				message('你的用户没有通过验证',$forward,3,$wap);
			}
			$authvalue = md5(md5($password));
			$auth = make_auth($username);
			$db->query("UPDATE ".$DT_PRE."member SET auth='$auth',authvalue='$authvalue',authtime='$DT_TIME' WHERE username='$username'");
			$authurl = $MODULE[2]['linkurl'].'send.php?auth='.$auth;
			$title = $L['send_password_mail'];
			$content = ob_template('password', 'mail');
			send_mail($email, $title, stripslashes($content));
			message('重置成功！请登录邮箱验证密码！', $_POST['forward'],3,$wap);
			//dheader($forward.'&email='.$email);
		}else{
			message('用户或邮箱不存在',$forward,3,$wap);
		}
	}
}else{
	dheader($forward);
}
?>