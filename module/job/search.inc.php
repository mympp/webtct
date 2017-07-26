<?php 
defined('IN_DESTOON') or exit('Access Denied');
//if($DT_BOT || $_POST) dhttp(403);
require DT_ROOT.'/module/'.$module.'/common.inc.php';
$group_search = $action == 'resume' ? $MOD['group_search_resume'] : $MOD['group_search'];
if(!check_group($_groupid, $group_search)) include load('403.inc');
require DT_ROOT.'/include/post.func.php';
include load('search.lang');
if($action=='resume'){$MOD['fields']= $MOD['fields'];}else{$MOD['fields']= $MOD['fields'].',step';}
$CP = $MOD['cat_property'] && $catid && $CAT['property'];
$thumb = isset($thumb) ? intval($thumb) : 0;
$level = isset($level) ? intval($level) : 0;
$vip = isset($vip) ? intval($vip) : 0;
$kstep = isset($kstep) ? intval($kstep) : 0;
$gender = isset($gender) ? intval($gender) : 0;
$height = isset($height) ? intval($height) : 0;
$type = isset($type) ? intval($type) : 0;
$resumeorder = isset($resumeorder) ? intval($resumeorder) : 0;
$joborder = isset($joborder) ? intval($joborder) : 0;
$validated = isset($validated) ? intval($validated) : 0;
$marriage = isset($marriage) ? intval($marriage) : 0;
$education = isset($education) ? intval($education) : 0;
$experience = isset($experience) ? intval($experience) : 0;
if(!$areaid && $cityid && strpos($DT_URL, 'areaid') === false) {
	$areaid = $cityid;
	$ARE = $AREA[$cityid];
}

$minsalary = isset($minsalary) ? intval($minsalary) : 0;
$maxsalary = isset($maxsalary) ? intval($maxsalary) : 0;
$areaid = isset($areaid) ? intval($areaid) : 0;
$fromdate = isset($fromdate) && is_date($fromdate) ? $fromdate : '';
$fromtime = $fromdate ? strtotime($fromdate.' 0:0:0') : 0;
$todate = isset($todate) && is_date($todate) ? $todate : '';
$totime = $todate ? strtotime($todate.' 23:59:59') : 0;
$category_select = ajax_category_select('catid', $L['all_jobtype'], $catid, $moduleid);
$area_select = ajax_area_select('areaid', $L['all_area'], $areaid);
$tags = array();
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

	$condition = 'status=3';
	if($keyword) $condition .= " AND (username LIKE '%$keyword%' or keyword LIKE '%$keyword%')";
   	if($action=="resume")
	{
	$sqls="";
	$l=explode(',',get_catarrchildid($catid,$CATEGORY));
	$b=substr_count(get_catarrchildid($catid,$CATEGORY),",");
	$sqls=" or cates like '%,".$catid.",%'";
	for($i=0;$i<=$b;$i++)
		{if($l[$i])$sqls=$sqls." or cates like '%,".$l[$i].",%'";
	}
	}
	if($catid) $condition .= ($CAT['child']) ? " AND (catid IN (".$CAT['arrchildid'].")".$sqls.")" : " AND (catid=$catid ".$sqls.")";

	if($areaid){
		if($action=='resume'){
		$sqls="";
		$l=explode(',',get_areaarrchildid($areaid,$AREA));
		$b=count($l);
		$sqls=" or areasid like '%,".$areaid.",%'";
			for($i=0;$i<=$b;$i++)
				{if($l[$i])$sqls=$sqls." or areasid like '%,".$l[$i].",%'";}
		  $condition .= ($ARE['child']) ? " AND (areaid IN (".$ARE['arrchildid'].")".$sqls.")" : " AND (areaid=$areaid ".$sqls.")";
		}
		else
		{
		 $condition .= ($ARE['child']) ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$areaid";
		}
	}

    //echo get_catarrchildid($catid,$CATEGORY);
	//echo $condition;
	//exit;
	if($thumb) $condition .= " AND thumb<>''";
	//if($vip) $condition .= " AND vip>0";
	if($minsalary)  $condition .= " AND (minsalary>=$minsalary or maxsalary>$minsalary)";
	if($maxsalary)  $condition .= " AND maxsalary>=$maxsalary";
	if($fromtime) $condition .= " AND edittime>=$fromtime";
	if($totime) $condition .= " AND edittime<=$totime";
	if($level) $condition .= " AND level=$level";
	if($gender) $condition .= " AND gender=$gender";
	if($type) $condition .= " AND type=$type";
	if($marriage) $condition .= " AND marriage=$marriage";
	if($education) $condition .= " AND education>=$education";
	if($experience) $condition .= " AND experience>=$experience";
	if($situation) $condition .= " AND situation=$situation";
	if($validated) $condition .= " AND validated=$validated";
	if($height) $condition .= " AND height=$height";
	if($kstep==3) $condition .= " AND step<3";
	if($kstep==4) $condition .= " AND step=4";
	if($kstep==5) $condition .= " AND step=5";
	$GENDER[0] = $L['all_gender'];
	$TYPE[0] = $L['all_work'];
	$MARRIAGE[0] = $L['all_marriage'];
	$EDUCATION[0] = $L['all_education'];
	//echo $condition;
	if($itemid)$condition = "status=3 and itemid=".intval($kw);
	$pagesize = $MOD['pagesize'];
	$offset = ($page-1)*$pagesize;
	if($action == 'resume') {
		require MD_ROOT.'/resume.class.php';
		$do = new resume($moduleid);
		$resorder='edittime desc';
		if($resumeorder==1){$resorder='talent desc';}
		if($resumeorder==2){$resorder='talent asc';}
		if($resumeorder==3){$resorder='hits desc';}
		if($resumeorder==4){$resorder='hits asc';}
		//echo $condition;
		$tags = $do->get_list($condition, $resorder, $DT['cache_search'] ? 'CACHE' : '');
		
		//chentao-20160905-start--
		//工程师修改搜索结果数目，将为通过简历数目加到结果数目上
		//已通过简历数目为$items
		//修改统计条件
		$replace_condition = str_replace('status=3','status in (2,3)',$condition);
		$replace_condition = str_replace('status = 3','status in (2,3)',$replace_condition);
		//已通过和未通过简历数目
		$resume_count = $db->get_one("select count(*) as num from {$DT_PRE}resume where $replace_condition");
		//修改显示统计数目
		$pages = str_replace($items,$resume_count['num'],$pages);
		//chentao-20160905--end
		if($page == 1 && $kw) keyword($kw, $items, -$moduleid);
	} else {
		if($pptsql) $condition .= $pptsql;//PPT
		require MD_ROOT.'/job.class.php';
		$do = new job($moduleid);
		$jorder=$MOD['order'];
		if($joborder==1){$jorder='maxsalary desc';}
		if($joborder==2){$jorder='maxsalary asc';}
		if($joborder==3){$jorder='apply desc';}
		if($joborder==4){$jorder='apply asc';}
		if($joborder==5){$jorder='type desc';}
		if($joborder==6){$jorder='type asc';}
	if($itemid)$condition = "status=3 and itemid=".intval($kw);
		$tags = $do->get_list($condition,$jorder , $DT['cache_search'] ? 'CACHE' : '');
		if($tags && $kw) {
			foreach($tags as $k=>$v) {
				$tags[$k]['title'] = str_replace($kw, '<span class="highlight">'.$kw.'</span>', $v['title']);
			}
			if($page == 1) keyword($kw, $items, $moduleid);
		}
	}
}

$showpage = 1;
$seo_file = 'search';

if($areaid&&!$catid&&!$kstep&&!$kw){
		if($action=='resume'){
		$r = $db->get_one("SELECT COUNT(*) AS num FROM {$DT_PRE}resume WHERE ".$condition);
		$rnum=$r['num'];
		$db->query("UPDATE {$DT_PRE}area SET resumecount=$rnum WHERE areaid=$areaid");//更新统计
		}
		else
		{
		$r = $db->get_one("SELECT COUNT(*) AS num FROM {$DT_PRE}job WHERE ".$condition);
		$jnum=$r['num'];
		$db->query("UPDATE {$DT_PRE}area SET jobcount=$jnum WHERE areaid=$areaid");//更新统计
		}
}
if(!$areaid&&$catid&&!$kstep&&!$kw){
		if($action=='resume'){
		$r = $db->get_one("SELECT COUNT(*) AS num FROM {$DT_PRE}resume WHERE ".$condition);
		$rnum=$r['num'];
		$db->query("UPDATE {$DT_PRE}category SET otheritem=$rnum WHERE catid=$catid");//更新统计
		}
}


include DT_ROOT.'/include/seo.inc.php';
include template('search', $module);
?>