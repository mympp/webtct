<?php 

defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
require DT_ROOT.'/include/post.func.php';
require DT_ROOT.'/models/opensearch/cloudSearch.class.php';

$keyword=isset($_GET['keyword'])?$_GET['keyword']:'';
$type=isset($_GET['type'])?$_GET['type']:'';
$page=isset($_GET['page'])?$_GET['page']:1;
$type=isset($_POST['type'])?$_POST['type']:$type;
$page=isset($_POST['page'])?$_POST['page']:$page;
$start = ($page - 1)*$pagesize;
$keyword = isset($_POST['keyword'])?$_POST['keyword']:$keyword;
$keyword = str_replace('"','',$keyword);
$keyword = str_replace("'",'',$keyword);
$keyword = str_replace('\\','',$keyword);

if($keyword==''){
	header('Location:'.SO_PATH);
	exit;
}

$sword=getSegmentation($keyword);   //对搜索字符词进行分词
$sword_str=implode("','",$sword);     //分词数组组成字符�?
if(empty($sword_str)) $sword_str = trim($keyword);

//匹配内容
$cSearch = new cloudSearch();
$cSearch->setFilter(['status'=>3]);
if(!empty($type)){
	$cSearch->setFilter(['info_type'=>$type]);
}
$cSearch->setPageSize(10);
$result_items = $cSearch->search($keyword,$start);
$result_total = $cSearch->getResultNum();

//分页按钮
$pages=so_pages($result_total,$page,$pagesize,$keyword,$type);

//相关产品
$cSearch->setPageSize(6);
$cSearch->setFilter(['status'=>3,'info_type'=>1]);
$malls = $cSearch->search($keyword);
if($malls == false){
	//缓存中的最新产�?
	$malls = get_cache('recom_malls');
}

//推广信息
$spread_arr = getSpread($keyword,$type);

//进行搜索记录
if($page == '1'){
	setSearchRecord($keyword,$_username,$result_total,$type);
}

//seo设置
$seo = getSeo($keyword,$type,$result_total);
$seo_title = $seo['title'];
$seo_description = $seo['description'];
$seo_keyword = $seo['keyword'];

include template($template, $module);

?>
