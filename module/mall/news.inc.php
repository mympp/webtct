<?php
use models\helpers\query\TagsQuery;
use models\module\baseModule;

include DT_ROOT.'/module/mall/news.common.inc.php';

$topSlideArticles = $newsModule->getCache('getIndexSlide',['pagesize' => 5],(3600*12));
$topCategorys = $newsModule->getCache('getTopCategorys',['pagesize' => 10]);
$hotTags = (new TagsQuery())->getHotTags(10);
$hotMalls = baseModule::moduleInstance('mall')->getCache('getHotMalls',['pagesize' => 5 ,'catid' => 0 ,'dayLimit'=>0]);
$hotArticles = $newsModule->getCache('getHotArticles',[
    'pagesize' => 10 ,
    'withImage' => false,
    'dayLimit' => 14 ,
    'field' => 'title,itemid,hits']);

include template('news','mall');
?>