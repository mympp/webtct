<?php
use models\module\baseModule;
use models\helpers\query\TagsQuery;

require_once DT_ROOT.'/models/autoload.php';


$newsModule = baseModule::moduleInstance('mallArticle');

//一级分类
$MENU = $newsModule->getCache('getMenu',[],3600);

//右侧内容
$topCategorys = $newsModule->getCache('getTopCategorys',['pagesize' => 10]);
$hotTags = (new TagsQuery())->getHotTags(10);
$hotMalls = baseModule::moduleInstance('mall')->getCache('getHotMalls',['pagesize' => 5 ,'catid' => 0 ,'dayLimit'=>0]);
$hotArticles = $newsModule->getCache('getHotArticles',[
    'pagesize' => 10 ,
    'withImage' => false,
    'dayLimit' => 14 ,
    'field' => 'title,itemid,hits']);

//友情链接
$links = $newsModule->getCache('getLinks',['pagesize' => 30]);

?>