<?php 
/*
* 修改日期2015-04-08
* 作者：吕保成
* 添加$wap判断,当$wap为真时，即手机版浏览时，传递wap的message函数变量
* 添加touch文件apply.htm
*/
defined('IN_DESTOON') or exit('Access Denied');
if($DT_BOT) dhttp(403);
$itemid or dheader($MOD['linkurl']);
$wap? $wap_forward = DT_PATH.'wap/index.php?moduleid=9&itemid='.$itemid:'';
$wap?login($wap):login();

if(!check_group($_groupid, $MOD['group_apply'])) include load('403.inc');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
include load('misc.lang');
$item = $db->get_one("SELECT * FROM {$DT_PRE}job WHERE itemid=$itemid");
$item or $wap?message($L['not_exists'],$wap_forward,3,$wap):message($L['not_exists']);
if($item['totime'] && $DT_TIME > $item['totime']) $wap?message($L['has_expired'],$wap_forward,3,$wap):message($L['has_expired']);
$item['status'] == 3 or $wap?message($L['not_exists'],$wap_forward,3,$wap):message($L['not_exists']);
$item['username'] or $wap?message($L['com_not_member'],$wap_forward,3,$wap):message($L['com_not_member']);
//$_username != $item['username'] or message($L['send_self']);
if($_groupid!=1){
	$app = $db->get_one("SELECT * FROM {$DT_PRE}job_apply WHERE jobid=$itemid AND apply_username='$_username'");
	if($app) $wap?message($L['apply_again'],$wap_forward,3,$wap):message($L['apply_again']);
}
$linkurl = $MOD['linkurl'].$item['linkurl'];
if($submit) {
	$resumeid = intval($resumeid);
	$resumeid or dheader($linkurl);
	$resume = $db->get_one("SELECT * FROM {$DT_PRE}resume WHERE itemid=$resumeid AND status=3 AND username='$_username'");
	$resume or $wap?message($L['not_resume'],$wap_forward,3,$wap):message($L['not_resume'], $linkurl);
	
	$db->query("INSERT INTO {$DT_PRE}job_apply (jobid,resumeid,job_username,apply_username,applytime,status) VALUES ('$itemid','$resumeid','$item[username]','$_username','$DT_TIME','1')");
	$db->query("UPDATE {$DT_PRE}job SET apply=apply+1 WHERE itemid=$itemid");
	$db->query("UPDATE {$DT_PRE}resume SET talent=talent+1 WHERE itemid=$itemid");
	$resumeurl = $MOD['linkurl'].$resume['linkurl'];
	send_message($item['username'], lang($L['apply_msg_title'], array(dsubstr($item['title'], 20, '...'))), lang($L['apply_msg_content'], array($resumeurl)));
	echo "<script>parent.document.getElementById('apply_success').style.display='block';parent.reload();</script>";
	$wap?message($L['apply_success'],$wap_forward,3,$wap):message($L['apply_success']);
	
} else {
	$lists = array();
	$result = $db->query("SELECT * FROM {$DT_PRE}resume WHERE username='$_username' AND status=3 ORDER BY edittime DESC");
	while($r = $db->fetch_array($result)) {
		$r['linkurl'] = $MOD['linkurl'].$r['linkurl'];
		$lists[] = $r;
	}
	if($lists) {
		if($wap){			
			$head_title = $L['apply_title'].$DT['seo_delimiter'].$item['title'].$DT['seo_delimiter'].$MOD['name'];
			include template('apply', 'touch');		
		}else {
			$head_title = $L['apply_title'].$DT['seo_delimiter'].$item['title'].$DT['seo_delimiter'].$MOD['name'];
			include template('apply', $module);
		}
	} else {
		if($_groupid==1){
			include template('apply', $module);
		}
		else{
			$wap?message($L['make_resume'],$wap_forward.'&make_resume=true',3,$wap):message($L['make_resume'], $MODULE[2]['linkurl'].$DT['file_my'].'?resume=1&action=add&mid='.$moduleid);
		}
	}
}

?>