<?php
define('DT_REWRITE', true);
require 'config.inc.php';
require '../common.inc.php';

/**
* 新版功能处理
*/
require DT_ROOT.'/module/'.$module.'/common.inc.php';
if(!check_group($_groupid, $MOD['group_search'])) include load('403.inc');
require DT_ROOT.'/include/post.func.php';

if(!empty($kw)) header('Location:'.$MOD['linkurl'].'keyword.php?kw='.$kw);		//跳转到关键词页面

$first_cat = $second_cat = [];	//第一级分类,第二级分类
$cat_arrchild ;		//当前子分类
foreach($CAT as $v){		//$CAT数据读于common.inc.php文件
	if($v['parentid'] == 0) $first_cat[$v['catid']] = $v;
	if(!empty($catid) && $v['parentid'] == $catid) $second_cat[$v['catid']] = $v;
	if(!empty($catid) && $v['catid'] == $catid){
		 $cat_arrchild = $v['arrchildid'];
		 $cat_parentid = $v['parentid'];
	}
}
if(empty($second_cat) && !empty($catid)){
	foreach($CAT as $v){
		if($cat_parentid == $v['parentid']) $second_cat[$v['catid']] = $v;
	}
}
$selector = [];		//存放搜索条件
$condition = $inCondition  = $likeCondition = [];  	//搜索条件
$rinCondition = [];		//推荐产品搜索条件
if(!empty($catid)){
	$selector['catid'] = $catid;
	$rinCondition['catid'] = $inCondition['catid'] = $cat_arrchild;
}
if(!empty($stype)){
	$selector['stype'] = $stype;
	$condition['stype'] = $stype;
}
if(!empty($validated)){
	$selector['validated'] = $validated;
	$condition['groupid'] = 7;
}
if(!empty($kw)){
	$selector['kw'] = $kw;
	$likeCondition['keyword'] = $kw;
}
$action = 'search'; 
$pagination_func = 'mall_rewrite';
$template = 'search';
$pagesize = 28;

require DT_ROOT.'/module/'.$module.'/search.inc.php';
?>