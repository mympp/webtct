<?php
/*
	[Destoon B2B System] Copyright (c) 2008-2013 Destoon.COM
	This is NOT a freeware, use is subject to license.txt
*/
/*
time:2015/10/27
who ：xiaolv
rel : job.htm
update:7-10、26-31、46-59、91-99、
*/
/*
time:2015/11/7
who ：xiaolv
升级：18-21、24-34、36-37、50-65、102-106
update:48-49、71-73、93、100-101、111-121
*/
if($action=='resume'){
	require 'resume.inc.php';
	exit();
}
defined('IN_DESTOON') or exit('Access Denied');
$CATEGORY = cache_read('category-'.$moduleid.'.php');
$TYPE = explode('|', trim($MOD['type']));
$GENDER = explode('|', trim($MOD['gender']));
$MARRIAGE = explode('|', trim($MOD['marriage']));
$EDUCATION = explode('|', trim($MOD['education']));
$SITUATION = explode('|', trim($MOD['situation']));
$table = $DT_PRE.'job';
$table_data = $DT_PRE.'job_data';
if(isset($make_resume)&&$make_resume){
	include template("make_resume", $TP);
}else {
	if($itemid) {
		$r = $db->get_one("SELECT COUNT(*) AS num FROM {$DT_PRE}comment WHERE item_mid=$moduleid AND item_id=$itemid AND status=3");
		$items = $r['num'];

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
		$content = strip_tags($content);
		$content = preg_replace("/\&([^;]+);/i", '', $content);
		$content = nl2br($content);
		$editdate = timetodate($edittime, 5);
		$parentid = $CATEGORY[$catid]['parentid'] ? $CATEGORY[$catid]['parentid'] : $catid;
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
		$condition = "status=3";
		if($keyword) $condition .= " AND keyword LIKE '%$keyword%'";
		if($catid) $condition .= $CAT ? " AND catid IN (".$CAT['arrchildid'].")" : " AND catid=$catid";
		if($areaid) $condition .= $ARE['child'] ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$areaid";
		$r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE $condition", 'CACHE');
		$items = $r['num'];
		$pages = mobile_pages($items, $page, $pagesize);
		$lists = array();
		if($items) {
			$order = $MOD['order'];
			$time = strpos($MOD['order'], 'add') !== false ? 'addtime' : 'edittime';
			$result = $db->query("SELECT ".$MOD['fields'].", hits , apply FROM {$table} WHERE $condition ORDER BY $order LIMIT $offset,$pagesize");
			while($r = $db->fetch_array($result)) {
				if($kw) $r['title'] = str_replace($kw, '<b class="f_red">'.$kw.'</b>', $r['title']);
				$r['linkurl'] = mobileurl($moduleid, 0, $r['itemid']);				
				$item_id = $r['itemid'];
				$p = $db->get_one("SELECT COUNT(*) AS num FROM {$DT_PRE}comment WHERE item_mid=$moduleid AND item_id=$item_id AND status=3");
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
				$back_link = 'javascript:Dback();';
			} else if($catid) {
				$head_name = $CAT['catname'];
				if($CAT['parentid']) $back_link = mobileurl($moduleid, $CAT['parentid']);
			} else {
				$head_name = $MOD['name'];
			}
		}
		include template($module, 'mobile');

}
?>