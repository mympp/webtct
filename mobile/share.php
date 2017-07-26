<?php
require 'common.inc.php';
if(in_array($module, $mobile_modules) && $moduleid >= 4 && $itemid) {
	$table = $action = '0';
	if ($moduleid ==29) {
		$table = 'tc_news';
	}elseif ($moduleid == 24) {
		$table = 'tc_resume';
		$action = 'resume';
		$moduleid = 9;
	}else{
		$table = get_table($moduleid);
	}
	$item = $db->get_one("SELECT * FROM $table WHERE itemid=$itemid");
	($item && $item['status'] > 2) or mobile_msg($L['msg_not_exist']);
	$linkurl = $EXT['mobile_url'].mobileurl($moduleid, 0, $itemid, $action);
	$auth = urlencode(str_replace('amp;', '', $linkurl));
} else {
	mobile_msg($L['share_not_support']);
}
$sms = 'sms:?body='.$linkurl;
if(preg_match("/(iPhone|iPod|iPad)/i", $UA)) $sms = 'sms: &body='.$item['title'].$linkurl;
$foot = '';
$head_title = $L['share_title'].$DT['seo_delimiter'].$head_title;
include template('share', 'mobile');
if(DT_CHARSET != 'UTF-8') toutf8();
?>