<?php
/*
	[Destoon B2B System] Copyright (c) 2008-2013 Destoon.COM
	This is NOT a freeware, use is subject to license.txt
*/
/*
time:2015/10/27
who ：xiaolv
rel : company.htm、company4.htm
update:19-20、35、39-160、201
*/
/*
time:2015/11/2
who ：xiaolv
升级 : 20、25-26、
update:19-20、35、39-160、201
*/
defined('IN_DESTOON') or exit('Access Denied');

$table = $DT_PRE.$module;
$userid = isset($userid) ? intval($userid) : 0;
$username = isset($username) ? trim($username) : '';
check_name($username) or $username = '';
if($userid || $username){
	include DT_ROOT.'/module/member/global.func.php';
	include DT_ROOT.'/wap/init.inc.php';
	
	if($userid) $username = get_user($userid, 'userid', 'username');
	$item = userinfo($username);
	$item or mobile_msg($L['msg_not_corp']);
	$item['groupid'] > 5 or mobile_msg($L['msg_not_corp']);
	unset($item['keyword']);
	extract($item);	
	$could_contact = check_group($_groupid, $MOD['group_contact']);
	
	if($username == $_username) $could_contact = true;
	
	if($TP == 'touch') {
		$head_link = 'index.php?moduleid='.$moduleid.'&amp;userid='.$userid;
		$head_name = $company;
		$back_link = 'index.php?moduleid='.$moduleid;
	}


	if($page == 1) $db->query("UPDATE {$table} SET hits=hits+1 WHERE userid=$userid");	
	$pagesize = 10;	

	//公司新闻
	if($action == 'news') {
		$table_news = $DT_PRE.'news';
		$table_data = $DT_PRE.'news_data';
				
		$condition_news = "username='$username' AND status>1";	
		$r_news = $db->get_one("SELECT COUNT(*) AS num FROM {$table_news} WHERE $condition_news", 'CACHE');
		$total_news = ceil($r_news['num']/$pagesize);
		if($page <= 1 || $page > $total_news) $offset = 0;		
		else $offset = ($page-1)*$pagesize;

		$pages_news = wap_pages($r_news['num'], $page, $pagesize);
		$lists_news = array();
		$result = $db->query("SELECT * FROM {$table_news} INNER JOIN {$table_data} on {$table_news}.itemid = {$table_data}.itemid  WHERE $condition_news ORDER BY addtime DESC LIMIT $offset,$pagesize");
		while($r_news = $db->fetch_array($result)) {
			// $r_news['title'] = dsubstr($r_news['title'], $len);
			$r_news['content'] = strip_tags($r_news['content']);
			$lists_news[] = $r_news;
		}
	}
	//友情链接
	if($action == 'link') {
		$table_link = $DT_PRE.'link';
				
		$condition_link = "username='$username' AND status=3";			
		$r_link = $db->get_one("SELECT COUNT(*) AS num FROM {$table_link} WHERE $condition_link", 'CACHE');
		$total_link = ceil($r_link['num']/$pagesize);
		if($page <= 1 || $page > $total_link) $offset = 0;		
		else $offset = ($page-1)*$pagesize;

		$pages_link = wap_pages($r_link['num'], $page, $pagesize);
		$lists_link = array();
		$result = $db->query("SELECT * FROM {$table_link} WHERE $condition_link ORDER BY addtime DESC LIMIT $offset,$pagesize");
		while($r_link = $db->fetch_array($result)) {
			$r_link['introduce'] = strip_tags($r_link['introduce']);
			$lists_link[] = $r_link;
		}
	}
	//供应产品
	if($action == 'mall') {
		$table_mall = $DT_PRE.'mall';
		$table_data = $DT_PRE.'mall_data';
				
		$condition_mall = "username='$username' AND status=3";
		if($kw) 
			$condition_mall .= " AND title LIKE '%$keyword%'";		
		
		$r_mall = $db->get_one("SELECT COUNT(*) AS num FROM {$table_mall} WHERE $condition_mall", 'CACHE');
		$total_mall = ceil($r_mall['num']/$pagesize);
		if($page <= 1 || $page > $total_mall) $offset = 0;		
		else $offset = ($page-1)*$pagesize;

		$pages_mall = wap_pages($r_mall['num'], $page, $pagesize);
		$lists_mall = array();
		$result = $db->query("SELECT * FROM {$table_mall} INNER JOIN {$table_data} on {$table_mall}.itemid = {$table_data}.itemid  WHERE $condition_mall ORDER BY addtime DESC LIMIT $offset,$pagesize");
		while($r_mall = $db->fetch_array($result)) {
			$r_mall['title'] = dsubstr($r_mall['title'], $len);
			$r_mall['content'] = strip_tags($r_mall['content']);
			if ($r_mall['price'] <=0) $r_mall['price'] ='面议';
			$lists_mall[] = $r_mall;
		}
	}
	//供应信息
	if($action == 'sell') {	
		$table_sell = $DT_PRE.'sell_5';
		$table_data = $DT_PRE.'sell_data_5';

		$condition_sell = "username='$username' AND status=3";
		if($keyword) 
			$condition_sell .= " AND keyword LIKE '%$keyword%'";

		$r_sell = $db->get_one("SELECT COUNT(*) AS num FROM {$table_sell} WHERE $condition_sell", 'CACHE');
		$total_sell = ceil($r_sell['num']/$pagesize);
		
		if($page < 1 || $page > $total_sell) $offset = 0;
		else $offset = ($page-1)*$pagesize;

		$pages_sell = wap_pages($r_sell['num'], $page, $pagesize);
		$lists_sell = array();
		$result_sell = $db->query("SELECT * FROM {$table_sell} WHERE $condition_sell ORDER BY edittime DESC LIMIT $offset,$pagesize");
		while($r_sell = $db->fetch_array($result_sell)) {
			$r_sell['stitle'] = dsubstr($r_sell['title'], $len);
			$r_sell['date'] = timetodate($r_sell['edittime'], 5);
			$lists_sell[] = $r_sell;
		}
	}
	//在线留言
	if ($action == 'message_send') {
		if($submit) {
			if(!$fromuser || !$tel || !$content) mobile_msg('留言信息请填写完整', 'index.php?moduleid=4&amp;username='.$username.'&amp;action=message_send');
			require DT_ROOT.'/include/post.func.php';
			require DT_ROOT.'/module/member/message.class.php';
			$do = new message;
			$message = array();
			$message['typeid'] = 0;
			$message['touser'] = $touser;
			$message['title'] = $title;
			$message['username'] = $fromuser;
			$message['content'] = '联系方式：'.$tel.'</br>'.$content;
			$message = convert($message, 'utf-8', DT_CHARSET);
			if($do->send($message)) {
				mobile_msg($L['send_success'], 'index.php?moduleid=4&amp;username='.$username.'&amp;action=message_send');
			} else {
				mobile_msg($do->errmsg);
			}
		}
	}

	//公司简介
		$content_table = content_table(4, $userid, is_file(DT_CACHE.'/4.part'), $DT_PRE.'company_data');
		$content = $db->get_one("SELECT content FROM {$content_table} WHERE userid=$userid");
		$content = $content['content'];
		
		$content = strip_tags($content);
		$content = preg_replace("/\&([^;]+);/i", '', $content);		
		$intro = dsubstr($content,200,'',0);
		$intro = str_replace("公司简介", "",$intro);	
		$head_title = $DT['seo_delimiter'].$company.$L['wap_version'];
		include template('company4', $TP);
}else {
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
	$condition = "groupid>5";
	if($keyword) $condition .= " AND keyword LIKE '%$keyword%'";
	if($catid) $condition .= " AND catids LIKE '%,".$catid.",%'";
	if($areaid) $condition .= $ARE['child'] ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$areaid";
	$r = $db->get_one("SELECT COUNT(userid) AS num FROM {$table} WHERE $condition", 'CACHE');
	$items = $r['num'];
	$pages = wap_pages($items, $page, $pagesize);
	$lists = array();
	if($items) {
		$order = $MOD['order'];
		$result = $db->query("SELECT * FROM {$table} WHERE $condition ORDER BY $order LIMIT $offset,$pagesize");
		while($r = $db->fetch_array($result)) {
			$lists[] = $r;
		}
		$db->free_result($result);
	}
	if($TP == 'touch') {
		if($catid) {
			$head_link = 'index.php?moduleid='.$moduleid.'&amp;catid='.$catid;
			$head_name = $CAT['catname'];
			$back_link = $CAT['parentid'] ? 'index.php?moduleid='.$moduleid.'&amp;catid='.$CAT['parentid'] : 'index.php?moduleid='.$moduleid;
		} else {
			$head_link = 'index.php?moduleid='.$moduleid;
			$head_name = $MOD['name'];
			$back_link = 'index.php';
		}
	}
	include template('company', $TP);
}
	
