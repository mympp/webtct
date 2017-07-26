<?php 
require_once '../common.inc.php';
require_once '../include/tcdb.class.php';
require_once 'common.inc.php';

$module_arr=array(16=>'产品',9=>'维修',6=>'招标',7=>'科技',5=>'供求',13=>'品牌',4=>'网店',21=>'资讯',15=>'共享',10=>'问答');
$page =isset($page)?$page:1;

$mid = empty($mid) ? 16 : $mid; 	//默认mid为16

$keyword_db = new tcdb('keyword');
$count = $keyword_db->where(['moduleid'=>$mid,'status'=>3])->count('c');
$pagesize=80;
if($page){
	$start=$pagesize*$page;
}
$start=$page==0?0:($pagesize*($page-1));

$pages = pagination($page,$count['c'],$pagesize,DT_PATH.'hot/index.php',['mid'=>$mid,'page'=>$page],'hot_rewrite',DT_PATH.'hot/');
//$pages = pages($count[c], $page, $pagesize,'category-'.$mid.'-{destoon_page}');			//分页按钮
$keyword_arr = $keyword_db->where(['moduleid'=>$mid,'status'=>3])->order('month_search desc,updatetime desc')->limit($start,$pagesize)->select();	//关键词列表

//seo设置
$module_word = $module_arr[$mid];
$ztitle = "$module_word 热门关键词大全，最新 $module_word 排行榜，最新 $module_word 热搜词查询 - 天成医疗网";
$zdescription="天成 $module_word 热搜词是医疗搜索的风向标，它统计了几十万用户在天成医疗网上的每次对 $module_word 的关键词搜索。在这里你可以对 $module_word 热搜词进行查询，查看 $module_word 热搜词排行榜。";
$zkeywords=" $module_word 热门关键词大全, $module_word 热搜词排行榜, $module_word 热搜词查询";

function hot_rewrite($selector){
	$mid = isset($selector['mid']) ? $selector['mid'] : '16';
	$page = isset($selector['page']) ? '-'.$selector['page'] : '';
	return 'category-'.$mid.$page;
}

include DT_ROOT.'/hot/template/index.php';
?>