<?php
use models\helpers\query\TagsQuery;
use models\helpers\view\FriendLink;
use models\helpers\query\LinkQuery;

include DT_ROOT.'/module/tags/common.inc.php';

if(empty($itemid)){
    include load('404.inc');;
    exit;
}

$tagsQuery = new TagsQuery();
$tag = $tagsQuery->getOne($itemid);
if(!$tag){
    include load('404.inc');;
    exit;
}

//修改点击
$tagsQuery->updateHits($itemid,((int)$tag['hits']) + 1);

$hotTags = $tagsModule->getCache('getHotTags',[10]);
$relateMallArticles = $tagsModule->getRelateMallArticles($itemid);
$relateMalls = $tagsModule->getRelateMalls($itemid , 'itemid,title,thumb,linkurl,hits');

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


include template('show','tags');
?>