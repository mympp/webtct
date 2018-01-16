<?php
use models\helpers\widget\redirect\pc_to_wap;
use models\helpers\view\pagination;
use models\module\baseModule;

require_once '../common.inc.php';
require_once '../models/autoload.php';
require_once 'common.inc.php';

//跳转到对应移动端
$forwordModule = [
    '16' => 'mall',
    '6' => 'buy',
    '5' => 'sell',
    '4' => 'company',
    '21' => 'article',
];
$mid = empty($mid) ? 16 : $mid; 	//默认mid为16
$page =isset($page)?$page:1;
if(in_array($mid,array_keys($forwordModule))){
    $wapurl = pc_to_wap::forword('hot-'.$forwordModule[$mid].'-'.$page.'.html');
}

$pagesize=80;

//搜索列表
$hotModule = baseModule::moduleInstance('hot');
$keywordSearch = $hotModule->getList($mid , $page , $pagesize);
$count = $keywordSearch['count'];
$lists = $keywordSearch['lists'];

//分页按钮
$pagination = new pagination($page,$count,$pagesize);
$pagination->setModule($hotModule);
$pagination->setCurrentTip('class="on"');
$pages = $pagination->show($hotModule->linkurl,[
    'div' => ['class' => 'pagination'],
    'form' => ['id' => 'hotForm','method'=>'get'],
],['mid'=>$mid,'page'=>$page]);

//分类
$category = $hotModule->getCache('getCategory',[],(3600*24));

//seo设置
$module_word = $module_arr[$mid];
$ztitle = "$module_word 热门关键词大全，最新 $module_word 排行榜，最新 $module_word 热搜词查询 - 天成医疗网";
$zdescription="天成 $module_word 热搜词是医疗搜索的风向标，它统计了几十万用户在天成医疗网上的每次对 $module_word 的关键词搜索。在这里你可以对 $module_word 热搜词进行查询，查看 $module_word 热搜词排行榜。";
$zkeywords=" $module_word 热门关键词大全, $module_word 热搜词排行榜, $module_word 热搜词查询";

include template('index','hot');

?>