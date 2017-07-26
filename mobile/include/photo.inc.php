<?php
/*
	[Destoon B2B System] Copyright (c) 2008-2013 Destoon.COM
	This is NOT a freeware, use is subject to license.txt
*/
/*
	time:2015/11/2
	who:xiaolv
	升级：13-15、61-71
	update:22-39、45-46、56-58、77-79、106-107、114-124
*/
defined('IN_DESTOON') or exit('Access Denied');
$table = $DT_PRE.$module.'_'.$moduleid;
$table_item = $DT_PRE.$module.'_item_'.$moduleid;
$table_data = $DT_PRE.$module.'_data_'.$moduleid;
if($itemid) {
	$item = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid and status = 3");
	if(empty($item)) mobile_msg($L['msg_not_exist']);// && $item['items'] > 0 && $item['password'] == ''
	extract($item);
	$CAT = get_cat($catid);
	if(!check_group($_groupid, $MOD['group_show']) || !check_group($_groupid, $CAT['group_show'])) mobile_msg($L['msg_no_right']);
	if($open < 3) {
		$_key = $open == 2 ? $password : $answer;
		$str = get_cookie('photo_'.$itemid);
		$pass = $str == md5(md5($DT_IP.$open.$_key.DT_KEY));	
		if($_username && $_username == $username) $pass = true;
	} else {
		$pass = true;
	}
	if($action == 'verify') {
		if($pass) exit('ok');
		$_key = $open == 2 ? $password : $answer;
		$key = isset($key) ? convert(input_trim($key), 'UTF-8', DT_CHARSET) : '';
		if($key == $_key) {
			set_cookie('photo_'.$itemid, md5(md5($DT_IP.$open.$_key.DT_KEY)), $DT_TIME + 86400);
			exit('ok');
		}
		exit('ko');
	}
	$description = '';
	$user_status = 3;
	$fee = get_fee($item['fee'], $MOD['fee_view']);
	require $action == 'pay' ? 'pay.inc.php' : 'content.inc.php';
	$content_table = content_table($moduleid, $itemid, $MOD['split'], $table_data);
	$t = $db->get_one("SELECT content FROM {$content_table} WHERE itemid=$itemid");
	$content = video5($t['content']);
	if($user_status == 2) $description = get_description($content, $MOD['pre_view']);

	$T = array();
	$result = $db->query("SELECT itemid,thumb,introduce FROM {$table_item} WHERE item=$itemid ORDER BY listorder ASC,itemid ASC");
	while($r = $db->fetch_array($result)) {
		$r['middle'] = str_replace('.thumb.', '.middle.', $r['thumb']);
		$r['big'] = str_replace('.thumb.'.file_ext($r['thumb']), '', $r['thumb']);
		$T[] = $r;
	}
	$demo_url = mobileurl($moduleid, 0, $itemid);
	$next_photo = $page >= $items ? $demo_url : mobileurl($moduleid, 0, $itemid, $page + 1);
	$prev_photo = $page <= 1 ? mobileurl($moduleid, 0, $itemid, $items) : mobileurl($moduleid, 0, $itemid, $page - 1);
	$P = $T[$page-1];

	$content = strip_tags($content);
	$content = preg_replace("/\&([^;]+);/i", '', $content);
	$content = nl2br($content);

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
	$condition = "status=3";// AND items>0 AND password=''
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
		$result = $db->query("SELECT ".$MOD['fields']." FROM {$table} WHERE $condition ORDER BY $order LIMIT $offset,$pagesize");
		while($r = $db->fetch_array($result)) {
			if($kw) $r['title'] = str_replace($kw, '<b class="f_red">'.$kw.'</b>', $r['title']);
			$r['linkurl'] = mobileurl($moduleid, 0, $r['itemid']);			
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