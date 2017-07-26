<?php
require 'config.inc.php';
require '../common.inc.php';
require DT_ROOT.'/include/post.func.php';
$catid=$post['catid'];
$title=$post['title'];
$thumb=$post['thumb'];
if ($thumb=='')$thumb=DT_SKIN.'image/nopic.gif';
$homepage=$post['homepage'];
$content=$post['content'];
$close=$post['close'];
if ($_userid!=""){
$sql="SELECT * FROM {$DT_PRE}member WHERE userid=".$_userid;$B = $db->get_one($sql);
$sql="SELECT * FROM {$DT_PRE}brand_13 WHERE title='".$title."'";$A = $db->get_one($sql);
if ($A["title"]==""){
$db->query("INSERT INTO {$DT_PRE}brand_13 (catid,areaid,title,introduce,keyword,thumb,homepage,username,groupid,company,vip,validated,truename,telephone,mobile,address,email,msn,qq,ali,skype,editor,status,close) VALUES (".$catid.",0,'".$title."','".$title."','".$title."','".$thumb."','".$homepage."','".$_username."',".$_groupid.",'".$_company."',0,0,'".$_truename."','".$B['telephone']."','".$B['mobile']."','".$B['address']."','".$_email."','".$B['msn']."','".$B['qq']."','".$B['ali']."','".$B['skype']."','".$_username."',2,".$close.")"); 
$sql="SELECT itemid FROM {$DT_PRE}brand_13 where username='".$_username."' order by itemid desc";$d = $db->get_one($sql)or die($sql);
$db->query("UPDATE {$DT_PRE}brand_13 SET linkurl='show.php?itemid=".$d['itemid']."' WHERE itemid=".$d['itemid']);
$db->query("INSERT INTO {$DT_PRE}brand_data_13 (itemid,content) VALUES (".$d['itemid'].",'".$content."')");
echo "<script>alert('添加成功,还需审核')</script>";
$fname=$title;
include template('tree2','brand'); }
else{echo "<script>alert('数据已经存在无需再添加！')</script>";
$fname=$title;
include template('tree2','brand');}
}
else{echo "<script>alert('请先登陆,未注册请注册')</script>";}
?>