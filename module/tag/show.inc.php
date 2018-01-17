<?php
use models\helpers\query\TagsQuery;
use models\helpers\view\FriendLink;
use models\helpers\query\LinkQuery;
use models\helpers\widget\redirect\pc_to_wap;

include DT_ROOT.'/module/tag/common.inc.php';


if(empty($itemid)){
    include load('404.inc');;
    exit;
}

//跳转移动端
$wapurl = pc_to_wap::forword('tag/show_'.$itemid.'.html');

$tagsQuery = new TagsQuery();
$tag = $tagsQuery->getOne($itemid);
if(!$tag){
    include load('404.inc');;
    exit;
}

//修改点击
$tagsQuery->updateHits($itemid,((int)$tag['hits']) + 1);

$hotTags = $tagsModule->getCache('getHotTags',[10]);
$relateMallArticles = $tagsModule->getRelateMallArticles($itemid);      //关联产品知识库内容
$relateMalls = $tagsModule->getRelateMalls($itemid , 'itemid,title,thumb,linkurl,hits');    //关联产品内容

//友情链接
$linkData = (new LinkQuery())->getLinks(0,10);
$friendLink = new FriendLink();
$friendLink->setTitle('',[
    'class' => 'links-hd'
]);
$friendLink->setLinkData($linkData,[
    'div' => ['class' => 'links-bd'],
    'a' => ['target' => '_blank'],
]);
$friendLinkView = $friendLink->buildFriendLink([
    'div' => ['class' => 'layout links-layout']
]);

//seo设置
$ztitle = $tag['word'].'_相关知识_参数_报价_天成医疗网';
$zkeywords = "{$tag['word']}相关知识";
$zdescription = "天成医疗网所有{$tag['word']}的相关产品知识，并为你提供最新的相关产品参数和报价。";

include template('show','tags');
?>