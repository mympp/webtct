<?php
/*
time:2015/10/27
who ：xiaolv
rel : resume.htm
add:工程师模块
*/
defined('IN_DESTOON') or exit('Access Denied');
$CATEGORY = cache_read('category-'.$moduleid.'.php');
$TYPE = explode('|', trim($MOD['type']));
$GENDER = explode('|', trim($MOD['gender']));
$MARRIAGE = explode('|', trim($MOD['marriage']));
$EDUCATION = explode('|', trim($MOD['education']));
$SITUATION = explode('|', trim($MOD['situation']));
$table = $DT_PRE.'resume';
$table_data = $DT_PRE.'resume_data';
// var_dump($_SERVER['QUERY_STRING']);die();
if($moduleid ==24) $moduleid =9;
if(isset($make_job)&&$make_job){
	include template("make_job", $TP);
}else {
	if($itemid) {		
		$p = $db->get_one("SELECT COUNT(*) AS num FROM {$DT_PRE}resume_comment WHERE item_id = '$itemid'");
		$items = $p['num'];

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

		$imagesurl = array($thumb,$thumb1,$thumb2);
		$editdate = timetodate($edittime, 5);
		$parentid = $CATEGORY[$catid]['parentid'] ? $CATEGORY[$catid]['parentid'] : $catid;
		$update = '';
		include DT_ROOT.'/include/update.inc.php';
		$head_title = $title.$DT['seo_delimiter'].$MOD['name'].$DT['seo_delimiter'].$head_title;
		$head_name = $CAT['catname'];
		$back_link = 'javascript:Dback(\''.mobileurl($moduleid,$catid,0,'resume').'\', \''.$DT_REF.'\', \'share|comment\');';
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
			$order = " edittime desc ";
			$the_query = "SELECT itemid,title,areaid,introduce,edittime,hits,talent,school FROM ".$table." WHERE $condition ORDER BY $order LIMIT $offset,$pagesize";
			$result = $db->query($the_query);
			while($r = $db->fetch_array($result)) {
				if($kw) $r['title'] = str_replace($kw, '<b class="f_red">'.$kw.'</b>', $r['title']);
				$r['linkurl'] = mobileurl($moduleid, $catid, $r['itemid'], 'resume');				
				$item_id = $r['itemid'];
				$p = $db->get_one("SELECT COUNT(*) AS num FROM {$DT_PRE}comment WHERE item_mid=$moduleid AND item_id=$item_id AND status=3");
				$r['comments'] = $p['num'];
				$r['stitle'] = dsubstr($r['title'], $len);
				$r['date'] = timetodate($r[$time], (time()-$r[$time]) < 31536000 ? 2 : 3);
				$lists[] = $r;
			}
			$db->free_result($result);
		}
		$back_link = mobileurl($moduleid, 0, 0,'resume');
		if($kw) {
			$head_name = $MOD['name'].$L['search'];
			$back_link = 'javascript:Dback();';
		} else if($catid) {
			$head_name = $CAT['catname'];
			if($CAT['parentid']) $back_link = mobileurl($moduleid, $CAT['parentid'], 0, 'resume');
		} else {
			$head_name = '工程师';
		}
	}
	include template('resume', 'mobile');	
}
?>