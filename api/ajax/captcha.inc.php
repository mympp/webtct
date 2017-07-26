<?php
defined('IN_DESTOON') or exit('Access Denied');
$result = isset($result) ? $result : 'num';
if(strlen($captcha) < 4){ 
	$result == 'num' ? exit('1') : exit('验证码格式错误');
}
$session = new dsession();
if(!isset($_SESSION['captchastr'])) $result == 'num' ? exit('2') : exit('验证码过期');
$captcha = convert($captcha, 'UTF-8', DT_CHARSET);
if($_SESSION['captchastr'] != md5(md5(strtoupper($captcha).DT_KEY.$DT_IP))) $result == 'num' ? exit('3') : exit('验证码错误');
$result == 'num' ? exit('0') : exit('');
?>