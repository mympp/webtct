<?php
use models\module\baseModule;

require_once DT_ROOT.'/models/autoload.php';

$newsModule = baseModule::moduleInstance('mallArticle');
$logo_title = $newsModule->title;

//一级分类
$MENU = $newsModule->getCache('getMenu',[],3600);
$logo_url = $IndexUrl = $newsModule->linkurl .'news.html';

//右侧内容
$topCategorys = $newsModule->getCache('getTopCategorys',['pagesize' => 10]);
$hotTags = baseModule::moduleInstance('tags')->getCache('getHotTags',['pagesize' => 10]);
$hotMalls = baseModule::moduleInstance('mall')->getCache('getHotMalls',['pagesize' => 5 ,'catid' => 0 ,'dayLimit'=>0]);
$hotArticles = $newsModule->getCache('getHotArticles',[
    'pagesize' => 10 ,
    'withImage' => false,
    'dayLimit' => 14 ,
    'field' => 'title,itemid,hits']);

//友情链接
$links = $newsModule->getCache('getLinks',['pagesize' => 30]);

?>