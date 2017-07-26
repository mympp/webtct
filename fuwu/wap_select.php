<?php
define('DT_REWRITE', true);
header('P3P: CP=CAO PSA OUR');
header("Expires:-1");
header("Last-Modified:".gmdate ("D, d M Y H:i:s")."GMT"); 
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT ");
header("Cache-Control:no-cache,must-revalidate");
header("Pragma:no-cache");
header("Content-type:text/html; charset=utf-8");
require 'config.inc.php';
require '../common.inc.php';
defined('IN_DESTOON') or exit('Access Denied');
if($DT_BOT) dhttp(403);
$wap? $wap_forward = DT_PATH.'wap/index.php?moduleid=9&action=resume&itemid='.$itemid:'';
$itemid or dheader(DT_PATH.'wap/index.php?moduleid=9&action=resume');
$wap?login($wap):login();
if(!check_group($_groupid, $MOD['group_apply'])) include load('403.inc');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
include load('misc.lang');

$L['resume_not_exists'] = '服务信息不存在';
$L['job_not_exists'] = '请创建服务需求';
$L['select_again'] = '已经选定合作,请不要重复选择';
$L['select_success'] = '选定成功';
$L['select_yourself'] = '你不可以选定自己';

//判断是否是用户自己的服务
$query = "SELECT username FROM ".$DT_PRE."resume WHERE itemid = '$itemid'";
$_user_resume = $db->query($query);
if($_user_resume['username']== $_username) message($L['select_yourself'],$wap_forward,3,$wap);

//判断用户已经创建需求
$job = $db->get_one("SELECT * FROM ".$DT_PRE."job WHERE username = '$_username' AND status='3'");
$job or $wap?message($L['job_not_exists'],$wap_forward.'&make_job=true',3,$wap):message($L['job_not_exists']);

//判断服务是否有效
$resume = $db->get_one("SELECT * FROM {$DT_PRE}resume WHERE itemid=$itemid");
$resume or $wap?message($L['resume_not_exists'],$wap_forward,3,$wap):message($L['resume_not_exists']);

if($resume['totime'] && $DT_TIME > $resume['totime']) $wap?message($L['has_expired'],$wap_forward,3,$wap):message($L['has_expired']);
$resume['status'] == 3 or $wap?message($L['resume_not_exists'],$wap_forward,3,$wap):message($L['resume_not_exists']);
$resume['username'] or $wap?message($L['com_not_member'],$wap_forward,3,$wap):message($L['com_not_member']);

if($submit){
	if(empty($jobsid)) message('请选定合作项目',DT_PATH.'/wap/wap_select.php?resumeid='.$itemid,3,$wap);
	foreach ($jobsid as $key => $jobid) {
	
		if($_groupid!=1){
			$app = $db->get_one("SELECT * FROM {$DT_PRE}job_apply WHERE jobid='$jobid' AND apply_username='$resume[username]'");
			if($app) $wap?message($L['select_again'],$wap_forward,3,$wap):message($L['select_again']);
		}

		$query = "SELECT jobid FROM ".$DT_PRE."job_apply WHERE jobid = '$jobid'";
		$selected = $db->get_one($query);
		$selected ? $query = "UPDATE {$DT_PRE}job_apply SET resumeid='$itemid',apply_username='$resume[username]',applytime='$DT_TIME',status='3' WHERE jobid = '$jobid'" : $query = "INSERT INTO {$DT_PRE}job_apply (jobid,resumeid,job_username,apply_username,applytime,status) VALUES ('$jobid','$itemid','$_username','$resume[username]','$DT_TIME','3')";
		$db->query($query);
	
		$db->query("UPDATE {$DT_PRE}job SET apply=apply+1 WHERE itemid='$jobid'");
		$db->query("UPDATE {$DT_PRE}resume SET talent=talent+1 WHERE itemid=$itemid");

		$all_j[] = $db->get_one("SELECT * FROM {$DT_PRE}job WHERE itemid='$jobid'");
	}
	$r = $db->get_one("SELECT * FROM {$DT_PRE}resume WHERE itemid='$resume[itemid]'");
	$j = $all_j[0];
	$job_title='';
	foreach ($all_j as $key => $value) {
		$job_title .= $value['title'].',';
	}
	$tojobtitle='您的服务需求信息'.$job_title.'已由管理员协助选定工程师.邮件中有联系方式！';
	$toresumetitle='恭喜！您的技术服务供应被'.$job_title.'所选定进行服务，邮件中有联系方式！';
	$content=$j['truename']."  和  ".$r['truename'].'二位:你们好！这是天成医疗网客服所发的关于服务需求的邮件！<br>首先恭喜二位，经过我们客服系统协助匹配,你们的供需关系是最合适的，现经天成客服协助，将服务需求信息“'.$job_title."”选定了“".$r['title']."”进行服务以下是双方联系方式，祝合作成功！";
	$content=$content."<br>服务需求发布者 ".$j['truename']." 联系方式：";
	$content=$content."<br>电话 ".$j['telephone'];
	$content=$content."<br>QQ ".$j['qq'];
	$content=$content."<br>手机 ".$j['mobile'];
	$content=$content."<br>邮箱 ".$j['email'];
	$content=$content."<br><hr>";
	$content=$content."<br>技术服务供应商 ".$r['truename']." 联系方式：";
	$content=$content."<br>电话 ".$r['telephone'];
	$content=$content."<br>QQ ".$r['qq'];
	$content=$content."<br>手机 ".$r['mobile'];
	$content=$content."<br>邮箱 ".$r['email'];
	$content=$content."<br><hr>";
	$content=$content."<br>有任何疑问可咨询 天成客服热线 4000521617";

	send_message($_username,$tojobtitle, $content , 4, '');
	send_message($resume['username'],$toresumetitle, $content , 4, '');
	$wap?message($L['select_success'],$wap_forward,3,$wap):message($L['select_success']);	
}else{
	dheader(DT_PATH.'wap/wap_select.php?resumeid='.$itemid);
}


?>