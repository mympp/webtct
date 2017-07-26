<?php
/*
time:2015/10/27
who ：xiaolv
rel : select_job.htm
add:工程师选定功能
*/
require '../common.inc.php';
$query = "SELECT username FROM ".$DT_PRE."resume WHERE itemid = '$resumeid'";
$resume = $db->get_one($query);

$query = "SELECT itemid,title FROM ".$DT_PRE."job WHERE username = '$_username'";
$res = $db->query($query);
while ($result = $db->fetch_array($res)) {
	$query = "SELECT jobid FROM ".$DT_PRE."job_apply WHERE jobid = '$result[itemid]' AND  apply_username='$resume[username]'";
	$resume_user = $db->get_one($query);
	$resume_user?$result['select'] = true:$result['select'] = false;

	$query = "SELECT jobid FROM ".$DT_PRE."job_apply WHERE jobid = '$result[itemid]' AND  apply_username!='$resume[username]'";
	$resume_user = $db->get_one($query);
	$resume_user?$result['select_other'] = true:$result['select_other'] = false;

	$lists[] = $result; 
}
require DT_ROOT.'/wap/wap.inc.php';
include template('select_job','touch');
?>