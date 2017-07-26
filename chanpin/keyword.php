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

$selector = [];		//存放搜索条件
$selector['kwid'] = $kwid;
$condition = $inCondition  = $likeCondition = [];  	//搜索条件
$rinCondition = [];		//推荐产品搜索条件

$keyword = $keyword_db->field('word')->where(['itemid'=>$kwid])->one();
$keyword_data_db = new tcdb('keyword_data');
$kcontent = $keyword_data_db->where(['itemid'=>$kwid])->one(); 

$likeCondition['keyword'] = $keyword['word'];

$action = 'keyword';
$pagination_func = 'keyword_rewrite';
$template = 'keyword';
$pagesize = 12;

require DT_ROOT.'/module/'.$module.'/search.inc.php';
?>