<?php
require 'config.php';

$text = '';
$title = dhtmlspecialchars(trim($_POST['title']));
$truename = dhtmlspecialchars(trim($_POST['truename']));
$area = dhtmlspecialchars(trim($_POST['company']));
$telephone = dhtmlspecialchars(trim($_POST['telephone']));
$qq = dhtmlspecialchars(trim($_POST['qq']));
$content = dhtmlspecialchars(trim($_POST['content']));

if($truename) $text .= "真实姓名：$truename <br/>";
if($area) $text .= "所在地区：$area <br/>";
if($telephone) $text .= "联系电话：$telephone <br/>";
if($qq) $text .= "QQ/邮箱：$qq <br/>";
if($content) $text .= "留言：$content <br/>";

if(empty($text)){
	message('请填写提交内容');
}else{
	send_message(USERNAME,$title,$text,3,'',$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
	message('提交成功');
}

?>