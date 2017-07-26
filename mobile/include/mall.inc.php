<?php
/*
	[Destoon B2B System] Copyright (c) 2008-2013 Destoon.COM
	This is NOT a freeware, use is subject to license.txt1
*/

/*
time:2015/10/27
who ：xiaolv
rel : mall.htm
update:17-18、30-35、48-50、70、79-89、106
*/
/*
time:2015/11/2
who ：xiaolv
升级：20-21、23-24、38-49、94、100-104
update:35-36、51-62、67-69、90、98-99、110-120
*/
defined('IN_DESTOON') or exit('Access Denied');
$table = $DT_PRE.$module;
$table_data = $DT_PRE.$module.'_data';
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
	//$content = nl2br($content);
	$imagesurl = array($thumb,$thumb1,$thumb2);
	if ($price <=0) $price ='面议';
	$total =  count(explode(",",get_cookie('cart')))-1;
	$editdate = timetodate($edittime, 5);
	$unit or $unit = $L['unit'];
	$RL = $relate_id ? get_relate($item) : array();
	$P1 = get_nv($n1, $v1);
	$P2 = get_nv($n2, $v2);
	$P3 = get_nv($n3, $v3);
	if($step) {
		extract(unserialize($step));
	} else {
		$a1 = 1;
		$p1 = $item['price'];
		$a2 = $a3 = $p2 = $p3 = '';
	}

	$update = '';
	include DT_ROOT.'/include/update.inc.php';
	$head_title = $title.$DT['seo_delimiter'].$MOD['name'].$DT['seo_delimiter'].$head_title;
	$head_name = $CAT['catname'];
	$back_link = 'javascript:Dback(\''.mobileurl($moduleid, $catid).'\', \''.$DT_REF.'\', \'share|comment|purchase|typeid\');';
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
	if($stype) $condition .= " AND stype=$stype";
	if($catid) $condition .= $CAT['child'] ? " AND catid IN (".$CAT['arrchildid'].")" : " AND catid=$catid";
	if($areaid) $condition .= $ARE['child'] ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$areaid";
	$r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE $condition", 'CACHE');
	$items = $r['num'];
	$pages = mobile_pages($items, $page, $pagesize);
	$lists = array();
	if($items) {
		$order = $MOD['order'];
		$order = 'addtime desc,edittime desc,vip desc,groupid desc';
		$time = strpos($MOD['order'], 'add') !== false ? 'addtime' : 'edittime';
		$result = $db->query("SELECT ".$MOD['fields'].",introduce,hits FROM {$table} WHERE $condition ORDER BY $order LIMIT $offset,$pagesize");
		while($r = $db->fetch_array($result)) {
			if($kw){$r['title'] = str_replace($kw, '<b class="f_red">'.$kw.'</b>', $r['title']);$r['introduce'] = str_replace($kw, '<b class="f_red">'.$kw.'</b>', $r['introduce']);}
			$r['linkurl'] = mobileurl($moduleid, 0, $r['itemid']);					
			$item_id = $r['itemid'];
			$p = $db->get_one("SELECT COUNT(*) AS num FROM {$DT_PRE}comment WHERE item_mid=$moduleid AND item_id=$item_id AND status=3");
			$r['comments'] = $p['num'];
			$r['stitle'] = dsubstr($r['title'], $len);			
			if ($r['price'] <=0) $r['price'] ='面议';
			$r['date'] = timetodate($r[$time], (time()-$r[$time]) < 31536000 ? 2 : 3);	
			$lists[] = $r;
		}
		$db->free_result($result);
	}
	$back_link = mobileurl($moduleid);
	if($kw) {
		$head_name = $stype==1 ? '配件中心'.$L['search'] : $MOD['name'].$L['search'];
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