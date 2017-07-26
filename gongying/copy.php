<?php
require 'config.inc.php';
require '../common.inc.php';
$oid=$_REQUEST["itemid"];
if ($_userid!=""){
$sql="SELECT * FROM {$DT_PRE}member WHERE userid=".$_userid;$B = $db->get_one($sql);
$sql="SELECT * FROM {$DT_PRE}sell WHERE itemid=".$oid;$A = $db->get_one($sql);
$sql="SELECT * FROM {$DT_PRE}sell WHERE username='".$_username."' and title='".$A['title']."'";$z = $db->get_one($sql);
$sql="SELECT * FROM {$DT_PRE}sell_data WHERE itemid=".$oid;$C = $db->get_one($sql);
if ($z["title"]==""){
$db->query("INSERT INTO {$DT_PRE}sell (catid,typeid,areaid,elite,title,style,fee,introduce,model,standard,brand,unit,price,minamount,amount,days,tag,keyword,pptword,thumb,thumb1,thumb2,username,groupid,company,vip,validated,truename,telephone,mobile,address,email,msn,qq,ali,skype,totime,editor,edittime,editdate,addtime,status) VALUES (".$A['catid'].",".$A['typeid'].",".$A['areaid'].",".$A['elite'].",'".$A['title']."','".$A['style']."',".$A['fee'].",'".$A['introduce']."','".$A['model']."','".$A['standard']."','".$A['brand']."','".$A['unit']."',".$A['price'].",".$A['minamount'].",".$A['amount'].",".$A['days'].",'".$A['tag']."','".$A['keyword']."','".$A['pptword']."','".$A['thumb']."','".$A['thumb1']."','".$A['thumb2']."','".$_username."',".$A['groupid'].",'".$_company."',".$A['vip'].",".$A['validated'].",'".$_truename."','".$B['telephone']."','".$B['mobile']."','".$B['address']."','".$_email."','".$B['msn']."','".$B['qq']."','".$B['ali']."','".$B['skype']."',".$A['totime'].",'".$_username."',".$A['edittime'].",".$A['editdate'].",".$A['addtime'].",2)"); 
$sql="SELECT itemid FROM {$DT_PRE}Sell order by itemid desc";$d = $db->get_one($sql)or die($sql);
$db->query("INSERT INTO {$DT_PRE}sell_data (itemid,content) VALUES (".$d['itemid'].",'".$C['content']."')");
echo "<script>alert('数据：".$A['title']."|添加到商铺成功')</script>";}
else{echo "<script>alert('数据：".$A['title']."|已经存在')</script>";}
}else{echo "<script>alert('请先登陆')</script>";}
?>