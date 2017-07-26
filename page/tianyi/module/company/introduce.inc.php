<?php
defined('IN_DESTOON') or exit('Access Denied');
$table = $DT_PRE.'page';
$table_data = $DT_PRE.'page_data';
$table_honor = $DT_PRE.'honor';
//echo '<pre />';
if($itemid) {
	$item = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid");
	if(!$item || $item['status'] < 3 || $item['username'] != $username) dheader($MENU[$menuid]['linkurl']);
	extract($item);
	$t = $db->get_one("SELECT content FROM {$table_data} WHERE itemid=$itemid");
	$content = $t['content'];
	if(!$DT_BOT) $db->query("UPDATE LOW_PRIORITY {$table} SET hits=hits+1 WHERE itemid=$itemid", 'UNBUFFERED');
	$head_title = $title.$DT['seo_delimiter'].$head_title;
	$head_keywords = $title.','.$COM['company'];
	$head_description = get_intro($content, 200);
	if($EXT['mobile_enable']) $head_mobile = $EXT['mobile_url'].'index.php?moduleid=4&username='.$username.'&action='.$file.'&itemid='.$itemid;
} else {
	$content_table = content_table(4, $userid, is_file(DT_CACHE.'/4.part'), $DT_PRE.'company_data');
	$t = $db->get_one("SELECT content FROM {$content_table} WHERE userid=$userid");
	$content = $t['content'];
	$COM['starttime']>0?$COM['starttime']=date('Y年m月d日',$COM['starttime']):$COM['starttime']='';
	$COM['endtime']>0?$COM['endtime']=date('Y年m月d日',$COM['endtime']):$COM['endtime']='长期';
	$COM['retime']>0?$COM['retime']=date('Y年m月d日',$COM['retime']):$COM['retime']='数据非法';
	$COM['thumb'] = $COM['thumb'] ? $COM['thumb'] : DT_SKIN.'image/company.jpg';
	if($EXT['mobile_enable']) $head_mobile = $EXT['mobile_url'].'index.php?moduleid=4&username='.$username.'&action='.$file;
}
$TYPE = array();
$result = $db->query("SELECT itemid,title,style FROM {$table} WHERE status=3 AND username='$username' ORDER BY listorder DESC,addtime DESC");
while($r = $db->fetch_array($result)) {
	$r['alt'] = $r['title'];
	$r['title'] = set_style($r['title'], $r['style']);
	$r['linkurl'] = DT_PATH."/mall/show.php?itemid=$r[itemid]";
	$TYPE[] = $r;
}
//var_dump($username);
$condition = "username='$username' AND status=3";
$honor = $db->query("SELECT * FROM {$table_honor} WHERE $condition ORDER BY addtime DESC");
$lists = array();
while($r = $db->fetch_array($honor)) {
    $r['title'] = $r['title'];
    $r['image'] = str_replace('.thumb.'.file_ext($r['thumb']), '', $r['thumb']);
    $lists[] = $r;
}
$db->free_result($result);

//var_dump($lists);
include template('introduce', $template);
?>