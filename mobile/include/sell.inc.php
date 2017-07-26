<?php
/*
	[Destoon B2B System] Copyright (c) 2008-2013 Destoon.COM
	This is NOT a freeware, use is subject to license.txt
*/

/*
time:2015/10/27
who ：xiaolv
rel : sell.htm
update:29-31、45、74、94
*/
/*
time:2015/11/3
who ：xiaolv
升级：20-21、34-51 V6.0无
update:32-33、53-54、58-60、80、87-89、95-105
*/
defined('IN_DESTOON') or exit('Access Denied');
$table = $DT_PRE.$module.'_'.$moduleid;
$table_data = $DT_PRE.$module.'_data_'.$moduleid;
if($itemid) {
	$item = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid and status = 3");
	if(empty($item)) mobile_msg($L['msg_not_exist']);
	extract($item);
	$CAT = get_cat($catid);
	if(!check_group($_groupid, $MOD['group_show']) || !check_group($_groupid, $CAT['group_show'])) mobile_msg($L['msg_no_right']);
	$member = array();
	$fee = get_fee($item['fee'], $MOD['fee_view']);
	require $action == 'pay' ? 'pay.inc.php' : 'contact.inc.php';
	$content_table = content_table($moduleid, $itemid, $MOD['split'], $table_data);
	$t = $db->get_one("SELECT content FROM {$content_table} WHERE itemid=$itemid");
	$content = video5($t['content']);
	$content = nl2br($content);

	$imagesurl = array($thumb,$thumb1,$thumb2);
	$editdate = timetodate($edittime, 5);
	$could_purchase = (SELL_ORDER && $price > 0 && $minamount > 0 && $amount > 0 && $unit && $username && $username != $_username) ? 1 : 0;
	$could_inquiry = ($user_status == 3 && $username && $username != $_username) ? 1 : 0;
	$update = '';
	include DT_ROOT.'/include/update.inc.php';
	$head_title = $title.$DT['seo_delimiter'].$MOD['name'].$DT['seo_delimiter'].$head_title;
	$head_name = $CAT['catname'];
	$back_link = 'javascript:Dback(\''.mobileurl($moduleid, $catid).'\', \''.$DT_REF.'\', \'share|comment|purchase\');';
	$foot = '';
} else {
	if($kw) {
		check_group($_groupid, $MOD['group_search']) or mobile_msg($L['msg_no_search']);
	} else if($catid) {
		$CAT or mobile_msg($L['msg_not_cate']);
		if(!check_group($_groupid, $MOD['group_list']) || !check_group($_groupid, $CAT['group_list'])) {
			mobile_msg($L['msg_no_right']);
		}
	} else {
		check_group($_groupid, $MOD['group_index']) or mobile_msg($L['msg_no_right']);
	}
	$head_title = $MOD['name'].$DT['seo_delimiter'].$head_title;
	if($kw) $head_title = $kw.$DT['seo_delimiter'].$head_title;
	$condition = "status=3";
	if($keyword) $condition .= " AND (keyword LIKE '%$keyword%'  or introduce like '%$keyword%' )";
	if($username) $condition .= " AND username='$username'";
	if($catid) $condition .= $CAT ? " AND catid IN (".$CAT['arrchildid'].")" : " AND catid=$catid";
	if($areaid) $condition .= $ARE['child'] ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$areaid";
	$r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE $condition", 'CACHE');
	$items = $r['num'];
	$pages = mobile_pages($items, $page, $pagesize);
	$lists = array();
	if($items) {
		$order = $MOD['order'];
		$time = strpos($MOD['order'], 'add') !== false ? 'addtime' : 'edittime';
		$result = $db->query("SELECT ".$MOD['fields'].", hits  FROM {$table} WHERE $condition ORDER BY $order LIMIT $offset,$pagesize");
		while($r = $db->fetch_array($result)) {
			if($kw){$r['title'] = str_replace($kw, '<b class="f_red">'.$kw.'</b>', $r['title']);$r['introduce'] = str_replace($kw, '<b class="f_red">'.$kw.'</b>', $r['introduce']);}
			$r['linkurl'] = mobileurl($moduleid, 0, $r['itemid']);
			$r['stitle'] = dsubstr($r['title'], $len);			
			$r['date'] = timetodate($r[$time], 5);
			$lists[] = $r;
		}
		$db->free_result($result);
	}
	$back_link = mobileurl($moduleid);
	if($kw) {
		$head_name = $MOD['name'].$L['search'];
		$back_link = 'javascript:Dback();';
	} else if($catid) {
		$head_name = $CAT['catname'];
		if($CAT['parentid']) $back_link = mobileurl($moduleid, $CAT['parentid']);
	} else {
		$head_name = $MOD['name'];
	}
}
include template($module, 'mobile');
?>