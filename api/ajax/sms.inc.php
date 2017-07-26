<?php
/*
who:chentao
date:2016/12
//针对创蓝短信，短信发送接口，接口需要验证用户名，
*/
defined('IN_DESTOON') or exit('Access Denied');

if(!isset($username)) exit('1');  //no username
if(!isset($mobile)) exit('2');	//no mobile

//验证文字验证码
if(strlen($captcha) < 4) exit('3');		//short captcha
$session = new dsession();
if(!isset($_SESSION['captchastr'])) exit('4'); //no captcha
$captcha = convert($captcha, 'UTF-8', DT_CHARSET);
if($_SESSION['captchastr'] != md5(md5(strtoupper($captcha).DT_KEY.$DT_IP))) exit('5');	//wrong captcha

require DT_ROOT.'/include/tcdb.class.php';
global $db;
$ip = get_env('ip');
$nowtime = time();
$sms_record = $db->get_one("select * from {$db->pre}register_sms where username = '$username' and mobile = '$mobile' and ip = '$ip' and endtime > $nowtime");
if($sms_record){
	exit('7');		//还存在激活状态下的短信验证码
}

$mobile_record = $db->get_one("select * from {$db->pre}member where mobile = '$mobile'");
if($mobile_record){
	exit('8');		//电话号码已被使用
}

require DT_ROOT.'/include/ChuanglanSmsApi.php';

$clapi  = new ChuanglanSmsApi();

$mobilecode = random(6, '123456789');	//不使用数字0，防止首位数字为0

$data['message'] = $clapi->buildMSG($mobilecode);

$result = $clapi->sendSMS($mobile, $data['message']);
$result = $clapi->execResult($result);

if(isset($result[1]) && $result[1]==0){
	$register_sms_db = new tcdb('register_sms');
	$data['ip'] = $ip;
	$data['username'] = $username;
	$data['mobile'] = $mobile;
	$data['code'] = $mobilecode;
	$data['addtime'] = time();
	$data['endtime'] = time()+180;	//默认短信验证码后端验证有效时间为3分钟
	$register_sms_db->add($data);
	exit('0');		//发送成功
}else{
	echo "6";		//send fail
}


?>