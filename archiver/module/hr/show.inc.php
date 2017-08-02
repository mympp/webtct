<?php 
/*
who:chentao
when:2016/1/29
what:修改招聘显示信息，添加招聘进程、公司性质，公司福利的显示
where：--2016/1/29/chentao--标签
*/
defined('IN_DESTOON') or exit('Access Denied');
$itemid or dheader($MOD['linkurl']);
if(!check_group($_groupid, $MOD['group_show'])) include load('403.inc');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
$item = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid");
if($item && $item['status'] > 2) {
	if($MOD['show_html'] && is_file(DT_ROOT.'/'.$MOD['moduledir'].'/'.$item['linkurl'])) d301($MOD['linkurl'].$item['linkurl']);
	extract($item);
} else {
	include load('404.inc');
}
$CAT = get_cat($catid);
if(!check_group($_groupid, $CAT['group_show'])) include load('403.inc');
$content_table = content_table($moduleid, $itemid, $MOD['split'], $table_data);
$t = $db->get_one("SELECT content FROM {$content_table} WHERE itemid=$itemid");
$content = $t['content'];
if($lazy) $content = img_lazy($content);
$CP = $MOD['cat_property'] && $CAT['property'];
if($CP) {
	require DT_ROOT.'/include/property.func.php';
	$options = property_option($catid);
	$values = property_value($moduleid, $itemid);
}
$expired = $totime && $totime < $DT_TIME ? true : false;
$adddate = timetodate($addtime, 3);
$editdate = timetodate($edittime, 3);
$todate = $totime ? timetodate($totime, 3) : $L['timeless'];
$linkurl = $MOD['linkurl'].$linkurl;
$parentid = $CATEGORY[$catid]['parentid'] ? $CATEGORY[$catid]['parentid'] : $catid;
$com_intro = '';
if($item['username']) {			
	$userid = get_user($item['username']);
	if($userid) {
		$com_table = content_table(4, $userid, is_file(DT_CACHE.'/4.part'), $DT_PRE.'company_data');
		$com_intro = $db->get_one("SELECT content FROM {$com_table} WHERE userid=$userid");
		$com_intro = $com_intro['content'];
	}
}
$member = array();
$update = '';
$fee = get_fee($item['fee'], $MOD['fee_view']);
if(check_group($_groupid, $MOD['group_contact'])) {
	if($fee) {
		$user_status = 4;
	} else {
		$user_status = 3;
		$member = $item['username'] ? userinfo($item['username']) : array();	
		if($item['totime'] && $item['totime'] < $DT_TIME && $item['status'] == 3) $update .= ",status=4";
		if($member) {
			foreach(array('groupid', 'vip','validated','company') as $v) {
				if($item[$v] != $member[$v]) $update .= ",$v='".addslashes($member[$v])."'";
			}
		}
	}
} else {
	$user_status = $_userid ? 1 : 0;
	if($_username && $item['username'] == $_username) {
		$member = userinfo($item['username']);
		$user_status = 3;
	}
}
if($member) {
	foreach(array('truename', 'telephone','mobile','address', 'msn', 'qq','ali','skype') as $v) {
		$member[$v] = $item[$v];
	}
	$member['mail'] = $item['email'];
	$member['gender'] = $item['sex'];
}
//--2016/1/29/chentao--start
function get_field_value($table_name,$field_name,$value){               //从表名、字段名和字段值获得字段值对应的文字
	global $db;
	$cat=$db->get_one("select option_value from {$db->pre}fields where tb='".$table_name."' and name='".$field_name."'");
	$row=explode('*',trim($cat['option_value']));
	foreach($row as $r){
		$cole=explode('|',trim($r));
		if($cole[0]==$value){
			return $cole[1];
		}
	}
	return '';
}
//--2016/1/29/chentao--end

include DT_ROOT.'/include/update.inc.php';
$seo_file = 'show';
include DT_ROOT.'/include/seo.inc.php';
if($EXT['mobile_enable']) $head_mobile = $EXT['mobile_url'].mobileurl($moduleid, 0, $itemid, $page);
$template = $item['template'] ? $item['template'] : ($CAT['show_template'] ? $CAT['show_template'] : 'show');
include template($template, $module);
?>