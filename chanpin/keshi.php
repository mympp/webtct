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
$first_cat = $second_cat = [];	//第一级分类,第二级分类

$selector = [];		//存放搜索条件
$condition = $inCondition  = $likeCondition = [];  	//搜索条件
$rinCondition = [];		//推荐产品搜索条件
if(!empty($kcatid)){
	$selector['kcatid'] = $kcatid;
	$likeCondition['kcatids'] = $kcatid;
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
$action = 'keshi';
$pagination_func = 'keshi_rewrite';
$template = 'search';
$pagesize = 28;

require DT_ROOT.'/module/'.$module.'/search.inc.php';
?>