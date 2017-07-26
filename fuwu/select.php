<?php
require 'config.inc.php';
require '../common.inc.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=7">
<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
<title>推荐给服务需求发布者你的供应信息</title>
<meta name="keywords" content="推荐给服务需求发布者你的供应信息"/>
<meta name="description" content="推荐给服务需求发布者你的供应信息"/>
<link rel="stylesheet" type="text/css" href="{DT_SKIN}style.css"/>
<link rel="stylesheet" type="text/css" href="{DT_SKIN}job.css"/>
<script type="text/javascript" src="{DT_PATH}lang/zh-cn/lang.js"></script>
<script type="text/javascript" src="{DT_STATIC}file/script/config.js"></script>
<script type="text/javascript" src="{DT_STATIC}file/script/jquery.js"></script>
<script type="text/javascript" src="{DT_STATIC}file/script/common.js"></script>
<script type="text/javascript" src="{DT_STATIC}file/script/page.js"></script>
<script type="text/javascript" src="{DT_STATIC}file/script/jsfunction.js"></script>
</head>
<body>
<?
if($action=='admin'){
$resumeid=intval($_GET['resumeid']);
$hpresumeid=htmlspecialchars($_GET['hpresumeid']);
$hpresumeid=str_replace($resumeid,'',$hpresumeid);
$hpresumeid=str_replace(',,',',',$hpresumeid);
$apply_username=htmlspecialchars($_GET['apply_username']);
$job_username=htmlspecialchars($_GET['job_username']);
$hpusername=htmlspecialchars($_GET['hpusername']);
$hpusername=str_replace($apply_username,'',$hpusername);
$hpusername=str_replace(',,',',',$hpusername);
$step=intval($_GET['step']);
$db->query("UPDATE {$DT_PRE}job SET step=$step,edittime='$DT_TIME' WHERE itemid=$itemid");//更新进程
//主要报名
if($resumeid)
{
$db->query("UPDATE {$DT_PRE}job_apply SET status=1 WHERE jobid=$itemid");//修改该服务需求的所有报名状态！
$r = $db->get_one("SELECT COUNT(*) AS num FROM {$DT_PRE}job_apply WHERE jobid=$itemid and resumeid=$resumeid");//获得选定人的报名情况
	if($r['num'])
		{$db->query("UPDATE {$DT_PRE}job_apply SET status=3,admin=1,updatetime='10' WHERE jobid=$itemid and resumeid=$resumeid");//有报名，则更新报名
		}
		else
		{//没报名的给他报个名，并设置为选定状态！
		$db->query("INSERT INTO {$DT_PRE}job_apply (jobid,resumeid,job_username,apply_username,status,applytime,updatetime,admin) VALUES('$itemid','$resumeid','$job_username','$apply_username',3,'$DT_TIME','10',1)");
		$db->query("INSERT INTO {$DT_PRE}job_talent (username,resumeid,jointime) VALUES('$job_username','$resumeid','$DT_TIME')");
		$db->query("UPDATE {$DT_PRE}resume SET talent=talent+1 WHERE itemid=$resumeid");
		}
}
//伙陪报名
if($hpresumeid){
$id= array();
$id= explode(",",$hpresumeid);$idn=explode(",",$hpusername);
$rids=count($id);
	for($i=0;$i<=$rids;$i++){//陪报名的给个报名信息！！
		if($id[$i]){
		$r = $db->get_one("SELECT COUNT(*) AS num FROM {$DT_PRE}job_apply WHERE jobid=$itemid and resumeid=$id[$i]");//获得伙陪人的报名情况
		if(!$r[num])
			{
			 $db->query("INSERT INTO {$DT_PRE}job_apply (jobid,resumeid,job_username,apply_username,status,applytime,updatetime,admin) VALUES('$itemid','$id[$i]','$job_username','$idn[$i]',1,'$DT_TIME','10',1)");
			}
		}
	}
}
$r = $db->get_one("SELECT COUNT(*) AS num FROM {$DT_PRE}job_apply WHERE jobid=$itemid");//获取服务需求的报名总数
$db->query("UPDATE {$DT_PRE}job SET apply=$r[num] WHERE itemid=$itemid");//更新报名需求统计
//管理员协助结束

if($step==3)
{
$j = $db->get_one("SELECT * FROM {$DT_PRE}job WHERE itemid=$itemid");//
$r = $db->get_one("SELECT * FROM {$DT_PRE}resume WHERE itemid=$resumeid");//
$tojobtitle='您的服务需求信息'.$j[title].'已由管理员协助选定工程师.邮件中有联系方式！';
$toresumetitle='恭喜！您的技术服务供应被'.$j[title].'所选定进行服务，邮件中有联系方式！';
$content=$j['truename']."  和  ".$r['truename'].'二位:你们好！这是天成医疗网客服所发的关于服务需求的邮件！<br>首先恭喜二位，经过我们客服系统协助匹配,你们的供需关系是最合适的，现经天成客服协助，将服务需求信息“'.$j['title']."”选定了“".$r['title']."”进行服务以下是双方联系方式，祝合作成功！";
$content=$content."<br>服务需求发布者 ".$j['truename']." 联系方式：";
$content=$content."<br>电话 ".$j['telephone'];
$content=$content."<br>QQ ".$j['qq'];
$content=$content."<br>手机 ".$j['mobile'];
$content=$content."<br>邮箱 ".$j['email'];
$content=$content."<br><hr>";
$content=$content."<br>技术技术工程师 ".$r['truename']." 联系方式：";
$content=$content."<br>电话 ".$r['telephone'];
$content=$content."<br>QQ ".$r['qq'];
$content=$content."<br>手机 ".$r['mobile'];
$content=$content."<br>邮箱 ".$r['email'];
$content=$content."<br><hr>";
$content=$content."<br>有任何疑问可咨询 天成客服热线 4000521617";
send_message($job_username,$tojobtitle, $content , 4, '');
send_message($apply_username,$toresumetitle, $content , 4, '');
}
echo "<h2>协助完成！</h2>";
if($step==3)
	{echo "<div>给".$job_username." 和 ".$apply_username."分别发去了邮件！邮件内容如下：<br>".$content."<br>";}
}
else{
$jobid=intval($_REQUEST["jobid"]);$action=$_REQUEST["action"];
if($jobid){$sql="SELECT *  FROM {$DT_PRE}job WHERE  itemid=".$jobid;$j = $db->get_one($sql);}
$resumeid=intval($_REQUEST["resumeid"]);
if ($_username!=""){
$sql="SELECT * FROM {$DT_PRE}job WHERE (username='".$_username."' or tobe='".$_username."' ) and step<3 ORDER BY itemid ASC LIMIT 0,100";
$B = $db->query($sql);
if ($resumeid!=""){$sql="SELECT * FROM {$DT_PRE}resume WHERE itemid=".$resumeid;$A = $db->get_one($sql);}
}
else{
echo "<script>alert('请先登陆')</script>";
}
if ($action=="save"&&$_username!=""&&$jobid==""&&$resumeid!=""){echo "<script>alert('您必须选一条你已经发布的设备技术服务需求！')</script>";}
if ($action=="save"&&$_username!=""&&$jobid!=""&&$resumeid!=""){
$sql="SELECT *  FROM {$DT_PRE}job_apply WHERE jobid=".$jobid." and resumeid=".$resumeid;$C = $db->get_one($sql);
if($C){
echo "<script>alert('选定该工程师成功！现在自动跳转到发封邮件给他！');top.document.location='".$MODULE[2]['linkurl'].$DT['file_my']."?mid=9&action=resume_invite&itemid=".$C['applyid']."&resumeid=".$C['resumeid']."&jobid=".$C['jobid']."'</script>";
}
else{
$db->query("INSERT INTO {$DT_PRE}job_apply (jobid,resumeid,job_username,apply_username,applytime,updatetime,status) VALUES (".$jobid.",".$resumeid.",'".$j['username']."','".$A['username']."',".$DT_TIME.",".$DT_TIME.",3)");
$sql="SELECT *  FROM {$DT_PRE}job_apply WHERE jobid=".$jobid." and resumeid=".$resumeid;$C = $db->get_one($sql);
$sql="SELECT COUNT(*) AS num FROM {$DT_PRE}job_talent WHERE resumeid=".$resumeid;$D = $db->get_one($sql);
if($D['num']==0){$db->query("INSERT INTO {$DT_PRE}job_talent (resumeid,username,jointime) VALUES (".$resumeid.",'".$_username."',".$DT_TIME.")");$db->query("UPDATE {$DT_PRE}resume SET talent=talent+1 WHERE itemid=".$resumeid);}
$db->query("UPDATE {$DT_PRE}job SET apply=apply+1,step=2 WHERE itemid=".$jobid);
echo "<script>alert('选定该工程师成功！现在自动跳转到发封邮件给他！');top.document.location='".$MODULE[2]['linkurl'].$DT['file_my']."?mid=9&action=resume_invite&itemid=".$C['applyid']."&resumeid=".$C['resumeid']."&jobid=".$C['jobid']."'</script>";
	}
}
?>
<div style="background:#fafafa;" class="autoheight pd10 mb10">
<FORM action="select.php" method="post" name="frmvote" >
<input type="hidden" name="action" value="save">
<table cellpadding="5" cellspacing="1" bgcolor="#e1ebee" align="center" style="font-size:12px;margin-bottom:10px;">
<tr bgcolor="#f2f5f9"><td width="640"><b>你所发布未有合适工程师的设备服务需求信息</b></td></tr>

<tr bgcolor="#FFFFFF">
<td align="left">
<?if ($admin_user){
$condition=' and step<2';
}
else
{
$condition=" and step<2 and username='".$_username."'";
}
?>
<?php  $tags = tag("moduleid=9&condition=status=3&pagesize=14&order=edittime desc&template=list-job-select&showcat=1&showpage=1&debug=0&page=$page");?>
</td>
</tr>

</table>
<?if ($_groupid!=1){?>
<?if ($c<1){echo "<div class='grayb graybg tc'><a href='/member/my.php?mid=9&action=add' target='_parent' style='font-size:18px;color:#222;'>你还没有发布服务需求信息，确定后进入发布页面！</a></div><script>alert('你还没有发布服务需求信息，确定后进入发布页面！');top.document.location='/member/my.php?mid=9&action=add'</script>";}?>
<?}?>
<div class="divline"></div>
<table cellpadding="5" cellspacing="1" bgcolor="#e1ebee" align="center" style="font-size:12px;">
<tr bgcolor="#f2f5f9"><td width="40" align="center"><b>选择</b></td><td width="590"><b>工程师</b></td>

<tr bgcolor="#FFFFFF">
<td width="40" align="center"><input type="radio" name="resumeid" value="<? echo $resumeid?>" checked="checked"></td><td width="590"><a href="<? echo $A["linkurl"]?>" target="_blank" class="color"><? echo xname($A["truename"],$A["baomi"])?>-<? echo $A["title"]?></a></td>
</tr>


<tr bgcolor="#FFFFFF"><td colspan="2" align="center" height=40>
<input type="submit" name="submit" value="确定<? echo xname($A["truename"],$A["baomi"])?>作为指定工程师并提交" class="botton" /></td>
</tr>

</table></FORM>
</div>
</body>
</html>
<?}?>