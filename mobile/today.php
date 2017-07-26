<?php
/*
time:2015/11/30
who ：xiaolv
rel : index.htm,today.htm
add:新增今日摘要
*/
require 'common.inc.php';
$tables = array('tc_mall','tc_job','tc_resume','tc_brand_13','tc_article_21','tc_quote','tc_photo_12','tc_sell_5','tc_news','tc_know');
$moduleids = array(16,9,24,13,21,7,12,5,29,10);
$pagesize = 5;
$lists = array();
foreach ($tables as $k => $table) {
	$condition = "status=3";	
	$r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE $condition", '');
	$items = $r['num'];
	$pages = mobile_pages($items, $page, $pagesize);
	if($items) {
		$order = $MOD['order'];
		$time = strpos($MOD['order'], 'add') !== false ? 'addtime' : 'edittime';
		$result = $db->query("SELECT * FROM {$table} WHERE $condition ORDER BY $time desc LIMIT $offset,$pagesize",'',0);
		
		while($r = $db->fetch_array($result)) {
			$item_id = $r['itemid'];
			$p = $db->get_one("SELECT COUNT(*) AS num FROM {$DT_PRE}comment WHERE item_mid=4 AND item_id=$item_id AND status=3");
			if ($moduleids[$k]==24) {
				$r['linkurl'] = mobileurl(9, 0, $r['itemid'],'resume');
			}else{
				$r['linkurl'] = mobileurl($moduleids[$k], 0, $r['itemid']);
			}
			$r['moduleid'] = $moduleids[$k];
			$r['comments'] = $p['num'];			
			$r['stitle'] = dsubstr($r['title'], $len);
			$r['date'] = timetodate($r[$time], (time()-$r[$time]) < 31536000 ? 2 : 3);
			$lists[] = $r;
		}
		$db->free_result($result);
	}
}
foreach ($lists as $k => $v) {
    $times[$k] = $v['edittime'];
}
array_multisort($times,SORT_DESC,$lists);
include template('today', 'mobile');
?>