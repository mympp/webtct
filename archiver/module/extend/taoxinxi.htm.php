<?php 
defined('IN_DESTOON') or exit('Access Denied');
if(!$MOD['announce_html'] || !$itemid) return false;
$item = $db->get_one("SELECT * FROM {$DT_PRE}taoxinxi WHERE itemid=$itemid AND islink=0");
if(!$item) return false;
extract($item);
$TYPE = get_type('taoxinxi', 1);
$adddate = timetodate($addtime, 3);
$fromdate = $fromtime ? timetodate($fromtime, 3) : $L['timeless'];
$todate = $totime ? timetodate($totime, 3) : $L['timeless'];

$head_title = $head_keywords = $head_description = $title.$DT['seo_delimiter'].$L['announce_title'];

$destoon_task = "moduleid=$moduleid&html=announce&itemid=$itemid";
$template = $item['template'] ? $item['template'] : 'taoxinxi';
ob_start();
include template($template, $module);
$data = ob_get_contents();
ob_clean();
return true;
?>