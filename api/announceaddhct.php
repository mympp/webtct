<?php
require '../common.inc.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title></title>
</head>
<body>
<?php
/*
火车头添加QQ群供应信息（黄金药场网站在用http://www.hjyc.com/xw/Index/5.html）
*/
$checkPower = $_REQUEST["check"];
if($checkPower == 'hekw07'){
	global $DT_TIME;
	$title = $_REQUEST["title"];
	$content = $_REQUEST["content"];
	$db->query("INSERT INTO tc_announce (itemid,typeid,areaid,level,title,style,content,hits,addtime,fromtime,totime,editor,edittime,islink,linkurl,listorder,template) VALUES ('','','0','0','$title','','$content','0','$DT_TIME','0','0','','$DT_TIME','0','','0','')");
}else{exit("Error!");}
?>
</body>
</html>