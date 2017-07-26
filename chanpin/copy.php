<?php
require 'config.inc.php';
require '../common.inc.php';
$oid=$_REQUEST["itemid"];
if ($_userid!=""){
$sql="SELECT * FROM {$DT_PRE}member WHERE userid=".$_userid;$B = $db->get_one($sql);
$sql="SELECT * FROM {$DT_PRE}mall WHERE itemid=".$oid;$A = $db->get_one($sql);
$sql="SELECT * FROM {$DT_PRE}mall WHERE username='".$_username."' and title='".$A['title']."'";$z = $db->get_one($sql);
$sql="SELECT * FROM {$DT_PRE}mall_data WHERE itemid=".$oid;$C = $db->get_one($sql);
if ($z["title"]==""){
$db->query("INSERT INTO {$DT_PRE}mall (catid,areaid,elite,title,style,fee,introduce,model,standard,brand,price,amount,tag,keyword,thumb,thumb1,thumb2,username,groupid,company,vip,validated,truename,telephone,mobile,address,email,msn,qq,ali,skype,editor,edittime,editdate,addtime,status,stype,bcatid,factoryid,factory,cates,catidname,kcatids) VALUES (".$A['catid'].",".$A['areaid'].",".$A['elite'].",'".$A['title']."','".$A['style']."',".$A['fee'].",'".$A['introduce']."','".$A['model']."','".$A['standard']."','".$A['brand']."',0,".$A['amount'].",'".$A['tag']."','".$A['keyword']."','".$A['thumb']."','".$A['thumb1']."','".$A['thumb2']."','".$_username."',".$_groupid.",'".$_company."',".$A['vip'].",".$A['validated'].",'".$_truename."','".$B['telephone']."','".$B['mobile']."','".$B['address']."','".$_email."','".$B['msn']."','".$B['qq']."','".$B['ali']."','".$B['skype']."','".$_username."',".$A['edittime'].",".$A['editdate'].",".$A['addtime'].",3,".$A['stype'].",".$A['bcatid'].",".$A['factoryid'].",'".$A['factory']."','".$A['cates']."','".$A['catidname']."','".$A['kcatids']."')"); 
$sql="SELECT itemid FROM {$DT_PRE}mall where username='".$_username."' order by itemid desc";$d = $db->get_one($sql)or die($sql);
$db->query("UPDATE {$DT_PRE}mall SET  linkurl='show-".$d['itemid'].".html' WHERE itemid=".$d['itemid']);
$db->query("INSERT INTO {$DT_PRE}mall_data (itemid,content) VALUES (".$d['itemid'].",'".$C['content']."')");
echo "<script>alert('数据：".$A['title']."|转载到网店成功')</script>";}
else{echo "<script>alert('数据：".$A['title']."|已经存在')</script>";}
}
else{echo "<script>alert('请先登陆,未注册请注册')</script>";}
?>