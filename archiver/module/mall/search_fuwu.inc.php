<?php 
defined('IN_DESTOON') or exit('Access Denied');
//if($DT_BOT || $_POST) dhttp(403);
require DT_ROOT.'/module/'.$module.'/common.inc.php';
if(!check_group($_groupid, $MOD['group_search'])) include load('403.inc');
require DT_ROOT.'/include/post.func.php';
include load('search.lang');
$CP = $MOD['cat_property'] && $catid && $CAT['property'];
$thumb = isset($thumb) ? intval($thumb) : 0;
$price = isset($price) ? intval($price) : 0;
$bcatid = isset($bcatid) ? intval($bcatid) : 0;
$fid = isset($fid) ? intval($fid) : 0;
$vip = isset($vip) ? intval($vip) : 0;
$tc = isset($tc) ? intval($tc) : 9;
$stype = isset($stype) ? intval($stype) : 9;
$day = isset($day) ? intval($day) : 0;
$list = isset($list) ? intval($list) : 1;
$kcatid= isset($kcatid) ? intval($kcatid) : 0;
in_array($list, array(0, 1, 2)) or $list = 0;
$minprice = isset($minprice) ? dround($minprice) : '';
$minprice or $minprice = '';
$maxprice = isset($maxprice) ? dround($maxprice) : '';
$maxprice or $maxprice = '';
if(!$areaid && $cityid && strpos($DT_URL, 'areaid') === false) {
	$areaid = $cityid;
	$ARE = $AREA[$cityid];
}
if($day) $fromdate = timetodate($DT_TIME-$day*86400, 'Ymd');
$fromdate = isset($fromdate) && is_date($fromdate) ? $fromdate : '';
$fromtime = $fromdate ? strtotime($fromdate.' 0:0:0') : 0;
$todate = isset($todate) && is_date($todate) ? $todate : '';
$totime = $todate ? strtotime($todate.' 23:59:59') : 0;
$sfields = array($L['by_auto'], $L['by_title'], $L['by_content'], $L['by_company'], $L['by_brand']);
$dfields = array('keyword', 'title', 'content', 'company', 'brand');
$sorder  = array($L['order'], $L['order_auto'], $L['price_dsc'], $L['price_asc'], $L['vip_dsc'], $L['vip_asc'], $L['amount_dsc'], $L['amount_asc'], $L['minamount_dsc'], $L['minamount_asc']);
$dorder  = array($MOD['order'], '', 'price DESC', 'price ASC', 'vip DESC', 'vip ASC', 'amount DESC', 'amount ASC', 'orders DESC', 'orders ASC');
if(!$MOD['fulltext']) unset($sfields[2], $dfields[2]);
isset($fields) && isset($dfields[$fields]) or $fields = 0;
isset($order) && isset($dorder[$order]) or $order = 0;
$order_select  = dselect($sorder, 'order', '', $order);
$orderv=$order;
$category_select = ajax_category_select('catid', $L['all_category'], $catid, $moduleid);
$area_select = ajax_area_select('areaid', $L['all_area'], $areaid);
$tags = array();
$pid = 0;
if($DT_QST) {
	if($kw) {
		if(strlen($kw) < $DT['min_kw'] || strlen($kw) > $DT['max_kw']) message(lang($L['word_limit'], array($DT['min_kw'], $DT['max_kw'])), $MOD['linkurl'].'search_fuwu.php');
		if($DT['search_limit'] && $page == 1) {
			if(($DT_TIME - $DT['search_limit']) < get_cookie('last_search')) message(lang($L['time_limit'], array($DT['search_limit'])), $MOD['linkurl'].'search_fuwu.php');
			set_cookie('last_search', $DT_TIME);
		}
	}
	$pptsql = '';
	if($CP) {
		require DT_ROOT.'/include/property.func.php';
		$PPT = property_condition($catid);
		foreach($PPT as $k=>$v) {
			$PPT[$k]['select'] = '';
			$oid = $v['oid'];
			$tmp = 'ppt_'.$oid;
			if(isset($$tmp)) {
				$PPT[$k]['select'] = $tmp = $$tmp;
				if($tmp && in_array($tmp, $v['options'])) {
					$tmp = 'O'.$oid.':'.$tmp.';';
					$pptsql .= " AND pptword LIKE '%$tmp%'";
				}
			}
		}
	}
	$fds = $MOD['fields'];
	$condition = '';
	$sqls="";$l=explode(',',get_catarrchildid($catid,$CATEGORY));
	$b=substr_count(get_catarrchildid($catid,$CATEGORY),",");
	for($i=0;$i<=$b;$i++)
		{$sqls=$sqls." or cates like '%,".$l[$i].",%'";
	}
	if($catid) $condition .= ($CAT['child']) ? " AND (catid IN (".$CAT['arrchildid'].")".$sqls.")" : " AND (catid=$catid  or cates like '%,".$catid.",%')";
    if($kcatid) $condition .=" and kcatids like '%,".$kcatid.",%' ";
	if($areaid) $condition .= $ARE['child'] ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$areaid";
	if($thumb) $condition .= " AND thumb<>''";
	if($vip) $condition .= " AND vip>0";
	if($bcatid>0&&!$fid) $condition .= " AND bcatid=".$bcatid;
	if($fid>0){$t = $db->get_one("SELECT title FROM {$DT_PRE}brand_13 WHERE itemid=$fid");$fname=$t['title'];}
	if($tc=='1') $condition .= " AND (groupid=8 or groupid=1)";
	if($tc=='0') $condition .= " AND (groupid<8 and groupid>4)";
	if($fid) $condition .= " AND factoryid=".$fid;
	if($price) $condition .= " AND price>0";
	if($stype!=9&&$stype>=0) $condition .= " AND stype=".$stype;
	if($minprice)  $condition .= " AND price>=$minprice";
	if($maxprice)  $condition .= " AND price<=$maxprice";
	if($fromtime) $condition .= " AND edittime>=$fromtime";
	if($totime) $condition .= " AND edittime<=$totime";
	if($dfields[$fields] == 'content') {
		if($keyword && $MOD['fulltext'] == 1) $condition .= " AND $dfields[$fields] LIKE '%$keyword%'";
		$condition = str_replace('AND ', 'AND i.', $condition);
		$condition = str_replace('i.content', 'd.content', $condition);
		$condition = "i.status=3 AND i.itemid=d.itemid".$condition;
		if($keyword && $MOD['fulltext'] == 2) $condition .= " AND MATCH(`content`) AGAINST('$kw'".(preg_match("/[+-<>()~*]/", $kw) ? ' IN BOOLEAN MODE' : '').")";
		$table = $table.' i,'.$table_data.' d';
		$fds = 'i.'.str_replace(',', ',i.', $fds);
	} else {
		if($keyword) $condition .= " AND (username LIKE '%$keyword%' or $dfields[$fields] LIKE '%$keyword%' or itemid LIKE '%$keyword%' )";
		if($pptsql) $condition .= $pptsql;//PPT
		$condition = "status=3".$condition;
	}
	if($itemid)$condition = "status=3 and itemid=".intval($kw);
	$pagesize = $MOD['pagesize'];
	$offset = ($page-1)*$pagesize;
	$items = $db->count($table, $condition, $DT['cache_search']);
	$pages = pages($items, $page, $pagesize); 
	if($items) {
		$order = $dorder[$order] ? " ORDER BY $dorder[$order]" : '';
		$result = $db->query("SELECT $fds FROM {$table} WHERE {$condition}{$order} LIMIT {$offset},{$pagesize}", ($DT['cache_search'] && $page == 1) ? 'CACHE' : '', $DT['cache_search']);
		if($kw) {
			$replacef = explode(' ', $kw);
			$replacet = array_map('highlight', $replacef);
		}
		while($r = $db->fetch_array($result)) {
			$r['adddate'] = timetodate($r['addtime'], 5);
			$r['editdate'] = timetodate($r['edittime'], 5);
			if($lazy && isset($r['thumb']) && $r['thumb']) $r['thumb'] = DT_SKIN.'image/lazy.gif" original="'.$r['thumb'];
			$r['alt'] = $r['title'];
			$r['title'] = set_style($r['title'], $r['style']);
			if($kw) $r['title'] = str_replace($replacef, $replacet, $r['title']);
			$r['linkurl'] = $MOD['linkurl'].$r['linkurl'];
			$tags[] = $r;
		}
		$db->free_result($result);
		if($page == 1 && $kw) keyword($kw, $items, $moduleid);
	}
}
$showpage = 1;
$datetype = 5;
$seo_file = 'search_fuwu';
include DT_ROOT.'/include/seo.inc.php';
include template('search_fuwu', $module);
?>