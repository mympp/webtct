<?php 
/*
who:chentao
date:2015/12/26
what:修改简历搜索的条件
where:见-------2015/12/26/chentao-----------备注标签

who:chetao
date:2016/1/20
what:添加用户状态判断，记录在$user_status
where：见--2016/1/20/chentao--标签
*/
defined('IN_DESTOON') or exit('Access Denied');
if($DT_BOT || $_POST) dhttp(403);
require DT_ROOT.'/module/'.$module.'/common.inc.php';
$group_search = $action == 'resume' ? $MOD['group_search_resume'] : $MOD['group_search'];
if(!check_group($_groupid, $group_search)) include load('403.inc');
require DT_ROOT.'/include/post.func.php';
include load('search.lang');
if(!$action)$action='job';
$CP = $MOD['cat_property'] && $catid && $CAT['property'];
$thumb = isset($thumb) ? intval($thumb) : 0;
$level = isset($level) ? intval($level) : 0;
$vip = isset($vip) ? intval($vip) : 0;
$gender = isset($gender) ? intval($gender) : 0;
$type = isset($type) ? intval($type) : 0;
$marriage = isset($marriage) ? intval($marriage) : 0;
$education = isset($education) ? intval($education) : 0;
$experience = isset($experience) ? intval($experience) : 0;
//-----------------2015/12/26/chentao-----start-------
//定义工资期望，学历类型，性别，工作经验,更新时间搜索选择内容
$hope=isset($hope)?intval($hope):0;
$update=isset($update)?intval($update):0;
$educationname=explode('|',$MOD['education']);
$typename=explode('|',$MOD['type']);
$updatename=array('不限','3天内','7天内','15天内','30天内');
$hopename=array('不限','1.5K以下','1.5K-3K','3K-6K','6K-8K','8K-10K','10K以上');
$gendername=explode('|',$MOD['gender']);
$experience_type=array('应届','1年以上','3年以上','5年以上','8年以上','10年以上');
//-----------------2015/12/26/chentao-----end--------
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
if($DT_QST||$action) {
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
		//-----------------2015/12/26/chentao-----start-------
	if($hope){           //增加期望工资搜索条件
		switch($hope){
			case '1':$maxsalary=1500;break;
			case '2':$minsalary=1500;$maxsalary=3000;break;
			case '3':$minsalary=3000;$maxsalary=6000;break;
			case '4':$minsalary=6000;$maxsalary=8000;break;
			case '5':$minsalary=8000;$maxsalary=10000;break;
			case '6':$minsalary=10000;break;
		}
	}
	if($experience){               //工作经验选项对应工作年限
		switch($experience){
		case '1':$experiences=1;break;
		case '2':$experiences=3;break;
		case '3':$experiences=5;break;
		case '4':$experiences=8;break;
		case '5':$experiences=10;break;
		}
	}
	if($update){
		switch($update){              //更新时间选项对应更新时间
			case '1':$updatetime=(time()-(60*60*24*3));break;
			case '2':$updatetime=(time()-(60*60*24*5));break;
			case '3':$updatetime=(time()-(60*60*24*7));break;
			case '4':$updatetime=(time()-(60*60*24*15));break;
		}
	}
	//-----------------2015/12/26/chentao-----end--------
	//--16/1/20/chentao--start
if(check_group($_groupid, $MOD['group_contact_resume'])) {
	if($MG['fee_mode'] && $MOD['fee_mode']) {
		$user_status = 3;
	} else {
		if($fee) {
			$mid = -$moduleid;
			if($_userid) {
				if(check_pay($mid, $itemid)) {
					$user_status = 3;
				} else {
					$user_status = 2;
					$item['title'] = lang($L['resume_title'], array($truename));
					$fee_back = 0;
					$pay_url = $MODULE[2]['linkurl'].'pay.php?mid='.$mid.'&itemid='.$itemid.'&username='.$username.'&fee_back='.$fee_back.'&fee='.$fee.'&currency='.$currency.'&sign='.crypt_sign($_username.$mid.$itemid.$username.$fee.$fee_back.$currency.$linkurl.$title).'&title='.rawurlencode($title).'&forward='.urlencode($linkurl);
				}
			} else {
				$user_status = 0;
			}
		} else {
			$user_status = 3;
		}
	}
} else {
	$user_status = $_userid ? 1 : 0;
}
if($_username && $_username == $item['username']) $user_status = 3;
$baomi=$user_status>1?0:1;
	//对关键词搜索限制
	if($keyword){
		if($baomi){
			$condition .=" AND major LIKE '%$keyword%'";        //个人会员和游客只对专业进行匹配
		}else{
			$condition .= " AND keyword LIKE '%$keyword%'";      //企业会员和管理员对关键词匹配
		}
	}
	//--16/1/20/chentao--end
	if($catid) $condition .= ($CAT['child']) ? " AND catid IN (".$CAT['arrchildid'].")" : " AND catid=$catid";
	if($areaid) $condition .= ($ARE['child']) ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$areaid";
	if($thumb) $condition .= " AND thumb<>''";
	if($vip) $condition .= " AND level>0";
	if($minsalary)  $condition .= " AND minsalary>$minsalary";
	if($maxsalary)  $condition .= " AND maxsalary<$maxsalary";
	if($fromtime) $condition .= " AND edittime>=$fromtime";
	if($totime) $condition .= " AND edittime<=$totime";
	if($level) $condition .= " AND level=$level";
	if($gender) $condition .= " AND gender=$gender";
	if($type) $condition .= " AND type=$type";
	if($marriage) $condition .= " AND marriage=$marriage";
	if($education) $condition .= " AND education>=$education";
	if($experiences) $condition .= " AND experience>=$experiences";          //--2015/12/26/chentao--修改工作经验的查询，变量experience改为experiences
	if($minsalary) $condition .= " AND minsalary>=$minsalary";
	if($maxsalary){ $condition .= " AND maxsalary<=$maxsalary";$condition .=" AND maxsalary<>0";}//--2015/12/26/chentao--最高薪资搜索存在时，增加最高薪金不为0的添加
	if($updatetime) $condition .= " AND edittime>=$updatetime";             //--2015/12/26/chentao--增加更新时间搜索
	$GENDER[0] = $L['all_gender'];
	$TYPE[0] = $L['all_work'];
	$MARRIAGE[0] = $L['all_marriage'];
	$EDUCATION[0] = $L['all_education'];
	$pagesize = $MOD['pagesize'];
	$offset = ($page-1)*$pagesize;
	if($itemid) $condition = "  itemid LIKE '%$keyword%'";
	if($action == 'resume') {
		$condition .= " AND open=3";
		require MD_ROOT.'/resume.class.php';
		$do = new resume($moduleid);
		$resorder='edittime desc';
		if($resumeorder==1){$resorder='education desc';}
		if($resumeorder==2){$resorder='education asc';}
		if($resumeorder==3){$resorder='hits desc';}
		if($resumeorder==4){$resorder='hits asc';}
		if($resumeorder==5){$resorder='level desc';}
		if($resumeorder==6){$resorder='level asc';}
		$tags = $do->get_list($condition, $resorder, $DT['cache_search'] ? 'CACHE' : '');
		if($page == 1 && $kw) keyword($kw, $items, -$moduleid);
	}
	elseif($action == 'gs') {
		require MD_ROOT.'/job.class.php';
		$do = new job($moduleid);
		if($keyword) $condition = " company LIKE '%$keyword%'";
		$tags = $do->get_list($condition, $MOD['order'], $DT['cache_search'] ? 'CACHE' : '',30);
		if($page == 1 && $kw) keyword($kw, $items, -$moduleid);
	}elseif($action == 'news') {
		require MD_ROOT.'/job.class.php';
		$do = new job($moduleid);
		if(!$catid){$catid='2165';
			$CATEGORY = cache_read('category-21.php');
			$childs=get_catarrchildid($catid,$CATEGORY);
			$condition .= ($childs) ? " AND catid IN (".$childs.")" : " AND catid=$catid";
		}
		//echo $condition;
		if($keyword) $condition .= "keyword LIKE '%$keyword%'";
		$tags = $do->news_list($condition, $MOD['order'], $DT['cache_search'] ? 'CACHE' : '',30);
		if($page == 1 && $kw) keyword($kw, $items, -$moduleid);
	}else {
		if($pptsql) $condition .= $pptsql;//PPT
		require MD_ROOT.'/job.class.php';
		$do = new job($moduleid);
		$tags = $do->get_list($condition, $MOD['order'], $DT['cache_search'] ? 'CACHE' : '');
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
include DT_ROOT.'/include/seo.inc.php';
include template('search', $module);
?>