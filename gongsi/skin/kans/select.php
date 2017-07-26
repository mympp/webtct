<?php
require '../../config.inc.php';
require '../../../common.inc.php';
require DT_ROOT.'/include/tc_mail.class.php';
$mail_body='';
$book=$_REQUEST['book'];
$product='产品类型：'.$_REQUEST['wfproduct'].'<br>';
$price='产品价格：'.$_REQUEST['wfprice'].'<br>';
$truename='联系人：'.$_REQUEST['wfname'].'<br>';
$mobile='联系手机：'.$_REQUEST['wfmob'].'<br>';
$qq='联系QQ：'.$_REQUEST['wfqq'].'<br>';
$weixin='微信号码：'.$_REQUEST['wfweixin'].'<br>';
$province='省份：'.$_REQUEST['wfprovince'].'<br>';
$city='城市：'.$_REQUEST['wfcity'].'<br>';
$area='地区：'.$_REQUEST['wfarea'].'<br>';
$address='联系地址：'.$_REQUEST['wfaddress'].'<br>';
$pay='付款方式：'.$_REQUEST['wfpay'].'<br>';
$guest='客户留言：'.$_REQUEST['wfguest'].'<br>';

if($book=='liuyan'){
$mail_subject='咨询加盟韩束信息'.$truename;
$mail_body=$truename.$mobile.$qq.$weixin.$guest;
}
if($book=='dinggou'){
$mail_subject='订购韩束五件套'.$truename;
$mail_body=$product.$price.$pcount.$truename.$mobile.$qq.$weixin.$province.$city.$area.$address.$pay.$guest;
}
if($mail_body){
$smtp='smtp.126.com';
$mail_pass='93645493';
$mail_from='qq93645493@126.com';
$mail_to='1837074165@qq.com';
	$TCmail = new TcMail();
		$TCmail->setServer($smtp,$mail_from,$mail_pass,465,true); //设置smtp服务器，普通连接方式
	$TCmail->setFrom($mail_from); //设置发件人
	$TCmail->setReceiver($mail_to); //设置收件人，多个收件人，调用多次
	$TCmail->setMail($mail_subject, $mail_body); //设置邮件主题、内容
	$TCmail->sendMail(); 
	echo $mail_subject.$mail_body."<br><b>提交成功！感谢您的参与！本站客服会在一小时内与您联系！请保持手机通畅状态！</b>";
	echo "<script>alert('提交成功！感谢您的参与！本站客服会在一小时内与您联系！请保持手机通畅状态！');window.parent.closebox('jobbox');</script>";
}
?>
