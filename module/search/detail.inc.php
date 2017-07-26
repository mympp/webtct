<?php
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
require_once DT_ROOT.'/module/'.$module.'/common.func.php';
require_once DT_ROOT.'/module/'.$module.'/info.class.php';
require_once DT_ROOT.'/include/tcdb.class.php';
if(!isset($_GET['itemid'])){
	header('Location:index.php');exit;
}
$infoid=$_GET['itemid'];
$type=isset($_GET['type'])?$_GET['type']:'';
$keyword=isset($_GET['keyword'])?$_GET['keyword']:'';

$from = isset($from) ? $from : 's';
if($from == 's'){		//显示数据来源医搜表
	$sogex_table = [
		1 => 'sogex_info_mall',
		2 => 'sogex_info_company',
		3 => 'sogex_info_news',
		4 => 'sogex_info_fuwu',
		5 => 'sogex_info_job',
		6 => 'sogex_info_gongqiu',
		7 => 'sogex_info_tech',
	];
	$from_table = $sogex_table[$infotype];
	$sogex_db = new tcdb($from_table);
	$data = $sogex_db->where(['itemid'=>$itemid])->one();
	if(empty($data)){
		header('Location:404.php');exit;
	}
	extract($data);
}else{			//显示数据来源天成表
	$tc_table = [
		'2'=>'company',
		'1'=>'mall',
		'3'=>'article_21',
		'6'=>'sell_5',
		'5'=>'resume',
		'7'=>'quote',
		'4'=>'job'
	];
	$tc_data_table = [
		'2'=>'company_data',
		'1'=>'mall_data',
		'3'=>'article_data_21',
		'6'=>'sell_data_5',
		'5'=>'resume_data',
		'7'=>'quote_data',
		'4'=>'job_data'
	];
	$tc_module_id = [
		'2'=>'4',
		'1'=>'16',
		'3'=>'21',
		'6'=>'5',
		'5'=>'24',
		'7'=>'7',
		'4'=>'24'
	];
	$search_keyword = $keyword;
	$tc_db = new tcdb($tc_table[$infotype]);
	$tc_data_db = new tcdb($tc_data_table[$infotype]);
	if($infotype == '2'){
		$condition = ['userid'=>$itemid];
	}else{
		$condition = ['itemid'=>$itemid];
	}
	$data = $tc_db->where($condition)->one();
	$content_data = $tc_data_db->where($condition)->one();
	extract($data);
	extract($content_data);
	$keyword = $search_keyword;
	if($infotype == '2'){
		$web_title = $company;
		$title = $company;
		$url = $linkurl;
		
	}else{
		$web_title = $title;
		$url = $tc_module_id[$infotype].$linkurl;
	}
}
if($infotype == '2'){
	//搜索公司相关产品
	require DT_ROOT.'/models/opensearch/cloudSearch.class.php';
	//匹配内容
	$cSearch = new cloudSearch();
	$cSearch->setFilter(['status'=>3]);
	$cSearch->setFilter(['info_type'=>1]);
	$cSearch->setPageSize(10);
	$result_items = $cSearch->search($company,0);
	$result_total = $cSearch->getResultNum();
}

//if(empty($_username) && $infotype == '6') $content = screenNumber($content,5);
//修改点击次数
$post['hits'] = intval($hits)+1;
//$info->update($post,$itemid);

$hot_news = get_cache('hot_news');
include template($page_template, $module);
?>
