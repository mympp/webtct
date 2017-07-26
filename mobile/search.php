<?php
header('Location: http://so.tecenet.com/mindex.php');
exit;

require 'common.inc.php';
$action = $saction ? $saction : $action;//为了避免与mod9、mod4中的action冲突
$action =  $action ? $action : 'searchall';
$club_post = (substr($action, 0, 4) == 'post' && isset($MODULE[18])) ? 1 : 0;
if(isset($ok) && isset($wd) && $wd) {
	if(in_array($action, array('message'))) {
		$url = $action.'.php?';
	} else if($club_post) {
		$catid = intval(substr($action, 4));
		$url = 'index.php?moduleid=18&catid='.$catid.'&';
	} else if($action=='searchall') {
		$url = 'index.php?searchall=searchall&';
	}else if($action=='parts') {
		$url = 'index.php?moduleid=16&stype=1&';
	} else {
		$moduleid = intval(str_replace('mod', '', $action));
		$url = 'index.php?moduleid='.$moduleid.'&';
	}

	$wd = input_trim($wd);
	$wd = convert($wd, 'UTF-8', DT_CHARSET);
	if($username)$url=$url.'&username='.$username.'&';
	dheader($url.'kw='.encrypt($wd));
}
$head_title = $L['search_title'].$DT['seo_delimiter'].$head_title;
$foot = 'channel';
include template('search', 'mobile');
if(DT_CHARSET != 'UTF-8') toutf8();
?>