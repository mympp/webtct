<?php
require 'config.inc.php';
require '../common.inc.php';
if ($_groupid==1||$admin_user){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=7">
<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
<title>品牌/公司合并信息</title>
<link rel="stylesheet" type="text/css" href="{DT_SKIN}style.css"/>
<script type="text/javascript" src="{DT_PATH}lang/zh-cn/lang.js"></script>
<script type="text/javascript" src="{DT_STATIC}file/script/config.js"></script>
<script type="text/javascript" src="{DT_STATIC}file/script/jquery.js"></script>
<script type="text/javascript" src="{DT_STATIC}file/script/common.js"></script>
<script type="text/javascript" src="{DT_STATIC}file/script/page.js"></script>
<script type="text/javascript" src="{DT_STATIC}file/script/jsfunction.js"></script>
</head>
<body>
<?
$username=htmlspecialchars($_REQUEST["username"]);
$action=$_REQUEST["action"];
$c=array();
if($username){
$sql="SELECT *  FROM {$DT_PRE}company WHERE username='".$username."'";
$c = $db->get_one($sql);
$sql="SELECT *  FROM {$DT_PRE}company_data WHERE username='".$username."'";
$cc = $db->get_one($sql);
if($cc){$c['content']=$cc['content'];}else{$c['content']=$c['introduce'].'No';}
}

if($_REQUEST["brand"]){$brand=$_REQUEST['brand'];}

if($username){
	if($brand)
	{$sql="SELECT *  FROM {$DT_PRE}brand_13 WHERE title like '%".$brand."%'";}
	else
	{$sql="SELECT *  FROM {$DT_PRE}brand_13 WHERE title like '%".$c['company']."%'";}
$b = $db->get_one($sql);
}
?>
<div style="background:#fafafa;" class="autoheight pd10 mb10">
<FORM action="select.php" method="post" name="frmvote" >

<table cellpadding="5" cellspacing="1" bgcolor="#e1ebee" align="center" style="font-size:12px;margin-bottom:10px;">
<tr bgcolor="#f2f5f9"><td width="80">网店名称</td><td width="400"><input type="text" name="company" value="<?echo $c['company'];?>" size=50></td></tr>
<tr bgcolor="#f2f5f9"><td width="80">网店介绍</td><td width="400">
<textarea name="companydata" rows="5" cols="40"><?echo $c['content'];?></textarea>
</td></tr>
<tr bgcolor="#f2f5f9"><td >品牌目录</td><td ><input type="text" name="brand" value="<?echo $b['title'];?>" size=50></td></tr>
<tr bgcolor="#f2f5f9"><td >保存数据</td><td ><input type="checkbox" name="action" value="save">保存共享数据！</td></tr>
</table>
</FORM>
</div>
</body>
</html>
<?}?>