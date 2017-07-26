<?php
/*
	[Destoon B2B System] Copyright (c) 2008-2013 Destoon.COM
	This is NOT a freeware, use is subject to license.txt
*/
/*
time:2015/10/27
who ：xiaolv
rel : article.htm
update:16~22、36、38、69~71、81~85行
*/
/*
time:2015/11/2
who:xiaolv
升级：19-20、22-24、26、28、41-56 v6.0无
update:27、35、37-38、62-64、85、92、97、103、113
*/
defined('IN_DESTOON') or exit('Access Denied');
$table = $DT_PRE.$module.'_'.$moduleid;
$table_data = $DT_PRE.$module.'_data_'.$moduleid;
if($itemid) {
	if($status){
	$db->query("UPDATE {$table} SET status=$status WHERE itemid=$itemid");
	}
	$item = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid");
	if($_groupid!='1'&&$_groupid!='8'&&!get_cookie('pwd')){
		($item && $item['status'] > 1) or mobile_msg($L['msg_not_exist']);
	}
	extract($item);
	$CAT = get_cat($catid);
	if(!check_group($_groupid, $MOD['group_show']) || !check_group($_groupid, $CAT['group_show'])) mobile_msg($L['msg_no_right']);
	$description = '';
	$user_status = 3;
	$fee = get_fee($item['fee'], $MOD['fee_view']);
	require 'include/'.($action == 'pay' ? 'pay' : 'content').'.inc.php';
	$content_table = content_table($moduleid, $itemid, $MOD['split'], $table_data);
	$t = $db->get_one("SELECT content FROM {$content_table} WHERE itemid=$itemid");
	$content = video5($t['content']);
	$content = str_replace('<hr class="de-pagebreak" />', '', $content);
	if($user_status == 2) $description = get_description($content, $MOD['pre_view']);
	$editdate = timetodate($addtime, 5);
	$update = '';
	include DT_ROOT.'/include/update.inc.php';
	$head_title = $title.$DT['seo_delimiter'].$MOD['name'].$DT['seo_delimiter'].$head_title;
	$head_name = $CAT['catname'];
	$back_link = 'javascript:Dback(\''.mobileurl($moduleid, $catid).'\', \''.$DT_REF.'\', \'share|comment\');';
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
	$condition = "status>1";
	//if($_groupid==1||$_groupid==8||get_cookie('pwd')){$condition = "status in (2,3)";}
	if($keyword) $condition .= " AND (keyword LIKE '%$keyword%' or author LIKE '%$keyword%' )";
	if($catid) $condition .= $CAT ? " AND catid IN (".$CAT['arrchildid'].")" : " AND catid=$catid";
	if($areaid) $condition .= $ARE['child'] ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$areaid";
	$r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE $condition", 'CACHE');
	$items = $r['num'];
	$pages = mobile_pages($items, $page, $pagesize);
	$lists = array();
	if($items) {
		$order = $MOD['order'];
		$time = strpos($MOD['order'], 'add') !== false ? 'addtime' : 'edittime';
		$result = $db->query("SELECT ".$MOD['fields']." FROM {$table} WHERE $condition ORDER BY $order LIMIT $offset,$pagesize",'',0);
		while($r = $db->fetch_array($result)) {
			if($kw) $r['title'] = str_replace($kw, '<b class="f_red">'.$kw.'</b>', $r['title']);
			$item_id = $r['itemid'];
			$p = $db->get_one("SELECT COUNT(*) AS num FROM {$DT_PRE}comment WHERE item_mid=$moduleid AND item_id=$item_id AND status=3");
			$r['comments'] = $p['num'];			
			$r['stitle'] = dsubstr($r['title'], $len);
			$r['linkurl'] = mobileurl($moduleid, 0, $r['itemid']);
			$r['date'] = timetodate($r[$time], (time()-$r[$time]) < 31536000 ? 2 : 3);
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