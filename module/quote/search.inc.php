<?php 
/*
who:chentao
when:2015-10-26
where:行68-72，125-136，见--15/10/26/chentao--标签
what:添加子分类搜索
relation:
*/
defined('IN_DESTOON') or exit('Access Denied');
//if( $_POST) dhttp(403);
require DT_ROOT.'/module/'.$module.'/common.inc.php';
if(!check_group($_groupid, $MOD['group_search'])) include load('403.inc');
require DT_ROOT.'/include/post.func.php';
include load('search.lang');
$CP = $MOD['cat_property'] && $catid && $CAT['property'];
if(!$areaid && $cityid && strpos($DT_URL, 'areaid') === false) {
	$areaid = $cityid;
	$ARE = $AREA[$cityid];
}
$fromdate = isset($fromdate) && is_date($fromdate) ? $fromdate : '';
$fromtime = $fromdate ? strtotime($fromdate.' 0:0:0') : 0;
$todate = isset($todate) && is_date($todate) ? $todate : '';
$totime = $todate ? strtotime($todate.' 23:59:59') : 0;
$pid = isset($pid) ? intval($pid) : 0;
$stype= isset($stype) ? intval($stype) : 0;       //--16/1/11/chentao--//修改stype默认值
$catid=	isset($catid)&&$catid!=0 ? intval($catid): $project_catid;     //--16/1/11/chentao--//设置catid默认值
$level= isset($level) ? intval($level) : 0;
$sfields = array($L['by_auto'], $L['by_title'], $L['by_content']);
$dfields = array('keyword', 'title', 'content');
$sorder  = array($L['order'], $L['order_auto'], $L['order_addtime'], $L['order_hits']);
$dorder  = array($MOD['order'], '', 'addtime DESC', 'addtime asc', 'hits DESC', 'hits asc');
if(!$MOD['fulltext']) unset($sfields[2], $dfields[2]);
isset($fields) && isset($dfields[$fields]) or $fields = 0;
isset($order) && isset($dorder[$order]) or $order = 0;
$order_select  = dselect($sorder, 'order', '', $order);
$category_select = category_select('catid', $L['all_category'], $catid, $moduleid);
$area_select = ajax_area_select('areaid', $L['all_area'], $areaid);
$tags = array();
$items = 0;
if($DT_QST) {
	if($kw) {
		if(strlen($kw) < $DT['min_kw'] || strlen($kw) > $DT['max_kw']) message(lang($L['word_limit'], array($DT['min_kw'], $DT['max_kw'])), $MOD['linkurl'].'search.php');
		if($DT['search_limit'] && $page == 1) {
			if(($DT_TIME - $DT['search_limit']) < get_cookie('last_search')) message(lang($L['time_limit'], array($DT['search_limit'])), $MOD['linkurl'].'search.php');
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
	if($catid) $condition .= ($CAT['child']) ? " AND catid IN (".$CAT['arrchildid'].")" : " AND catid=$catid";
	//--15/10/26/chentao--start
	if($stype) {
		$condition .=" AND stype=$stype";
	}elseif($stype==0){
		$condition .=" AND stype=0";
	}//--15/10/26/chentao--end
	if($qixie) $condition .=" AND qixie=$qixie";
	if($cooperate) $condition .="AND cooperate=$cooperate";
	if($areaid) $condition .= ($ARE['child']) ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$areaid";
	if($pid) $condition .= " AND pid=$pid";
	if($level) $condition .= " AND level>0";
	if($fromtime) $condition .= " AND addtime>=$fromtime";
	if($totime) $condition .= " AND addtime<=$totime";
	if($dfields[$fields] == 'content') {
		if($keyword && $MOD['fulltext'] == 1) $condition .= " AND $dfields[$fields] LIKE '%$keyword%'";
		$condition = str_replace('AND ', 'AND i.', $condition);
		$condition = str_replace('i.content', 'd.content', $condition);
		$condition = "i.status=3 AND i.itemid=d.itemid".$condition;
		if($keyword && $MOD['fulltext'] == 2) $condition .= " AND MATCH(`content`) AGAINST('$kw'".(preg_match("/[+-<>()~*]/", $kw) ? ' IN BOOLEAN MODE' : '').")";
		$table = $table.' i,'.$table_data.' d';
		$fds = 'i.'.str_replace(',', ',i.', $fds);
	} else {
		if($keyword) $condition .= " AND $dfields[$fields] LIKE '%$keyword%'";
		if($pptsql) $condition .= $pptsql;//PPT
		$condition = "status=3".$condition;
	}
	if($itemid)$condition = "status=3 and itemid=".intval($kw);
	$pagesize = 10;
	$offset = ($page-1)*$pagesize;
	$ite=$db->get_one("select count(*) as c from $table where $condition");
	$items=$ite['c'];
	$pages = pages($items, $page, $pagesize);
	if($items) {
		$order = $dorder[$order] ? " ORDER BY $dorder[$order]" : ' ';
		$result = $db->query("SELECT $fds FROM {$table} WHERE {$condition}{$order} LIMIT {$offset},{$pagesize}", $DT['cache_search'] && $page == 1 ? 'CACHE' : '', $DT['cache_search']);
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
$target = '_blank';
$cols = 5;
$class = '';
$seo_file = 'search';
//--15/10/26/chentao--      //start
$qixie_arr=array();  //器械类别
$qixie_arr[0]='不限';
$qixie_arr[1]='I类';
$qixie_arr[2]='II类';
$qixie_arr[3]='III类';
$qixie_arr[4]='其他';
$level_arr=array();   //所处阶段
$level_arr[1]='研发阶段';
$level_arr[2]='完成小试';
$level_arr[3]='完成中试';
$level_arr[4]='完成临床试验';
$level_arr[5]='可量产';
$level_arr[6]='已量产';
//搜索子类型
$project_child_catid=$db->get_one("select arrchildid as child from {$db->pre}category where catid={$project_catid}");
$clinic_child_catid=$db->get_one("select arrchildid as child from {$db->pre}category where catid={$clinic_catid}");
//--15/10/26/chentao--end
include DT_ROOT.'/include/seo.inc.php';
include template('search', $module);
if($MOD['quote_auto'] && $kw && $items) update_quote();
?>