<?php
/*
time:2015/10/27
who ：xiaolv
rel : weixin.htm
add:新增微信分享模块
*/
defined('IN_DESTOON') or exit('Access Denied');
$table = $DT_PRE.'news';
$table_data = $DT_PRE.'news_data';
if($itemid) {
	$db->query("UPDATE {$table} SET hits=hits+1 WHERE itemid=$itemid");
	if($status) $db->query("UPDATE {$table} SET status=$status WHERE itemid=$itemid");
	$item = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid");
	if($_groupid!='1'&&$_groupid!='3'&&!get_cookie('pwd')){
		($item && $item['status'] > 1) or mobile_msg($L['msg_not_exist']);
	}
	extract($item);
	$CAT = get_cat($catid);
	if(!check_group($_groupid, $MOD['group_show']) || !check_group($_groupid, $CAT['group_show'])) mobile_msg($L['msg_no_right']);
	$description = '';
	$user_status = 3;
	// $fee = get_fee($item['fee'], $MOD['fee_view']);	
	require $action == 'pay' ? 'pay.inc.php' : 'content.inc.php';
	$content_table = content_table($moduleid, $itemid, $MOD['split'], $table_data);
	$t = $db->get_one("SELECT content FROM {$content_table} WHERE itemid=$itemid");
	$content = video5($t['content']);
	$content = str_replace('[pagebreak]', '', $content);	
	if($user_status == 2) $description = get_description($content, $MOD['pre_view']);
	$editdate = timetodate($addtime, 3);	
	$head_title = $title.$DT['seo_delimiter'].'微信分享'.$DT['seo_delimiter'].$head_title;
	$head_name = $CAT['catname'];
	$back_link = 'javascript:Dback(\''.mobileurl($moduleid,$catid).'\', \''.$DT_REF.'\', \'share|comment\');';
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
	$head_title = '微信分享'.$DT['seo_delimiter'].$head_title;
	if($kw) $head_title = $kw.$DT['seo_delimiter'].$head_title;
	$condition = "status>1";
	//if($_groupid==1||$_groupid==8||get_cookie('pwd')){$condition = "status in (2,3)";}
	if($keyword) $condition .= " AND (keyword LIKE '%$keyword%' or author LIKE '%$keyword%' )";
	if($catid) $condition .= $CAT ? " AND catid IN (".$CAT['arrchildid'].")" : " AND catid=$catid";
	if($areaid) $condition .= $ARE['child'] ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$areaid";
	$r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE $condition", '');
	$items = $r['num'];
	$pages = mobile_pages($items, $page, $pagesize);
	$lists = array();
	if($items) {
		$order = $MOD['order'];
		$time = strpos($MOD['order'], 'add') !== false ? 'addtime' : 'edittime';
		$result = $db->query("SELECT * FROM {$table} WHERE $condition ORDER BY $time desc LIMIT $offset,$pagesize",'',0);
		
		while($r = $db->fetch_array($result)) {
			$item_id = $r['itemid'];
			$p = $db->get_one("SELECT COUNT(*) AS num FROM {$DT_PRE}comment WHERE item_mid=4 AND item_id=$item_id AND status=3");
			$r['linkurl'] = mobileurl($moduleid, $catid, $r['itemid']);
			$r['comments'] = $p['num'];			
			$r['stitle'] = dsubstr($r['title'], $len);
			$r['date'] = timetodate($r[$time], (time()-$r[$time]) < 31536000 ? 2 : 3);
			$lists[] = $r;
		}
		$db->free_result($result);
	}
	$back_link = mobileurl($moduleid);
	if($kw) {
		$head_name = $MOD['name'].$L['search'];
	} else if($catid) {
		$head_name = $CAT['catname'];
		if($CAT['parentid']) $back_link = mobileurl($moduleid, $CAT['parentid']);
	} else {
		$head_name = $MOD['name'];
	}
}
include template($module, 'mobile');
?>