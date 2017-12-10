<?php
use models\helpers\query\MallArticleQuery;
use models\helpers\query\MallArticleContentQuery;

include DT_ROOT.'/module/mall/news.common.inc.php';

if(empty($itemid)){
    header('Location:'.$newsModule->linkurl.'/news.php');
    exit;
}

$article = (new MallArticleQuery())->getOne($itemid);
if(empty($article)){
    header('Location:'.$newsModule->linkurl.'/news.php');
    exit;
}

$content = (new MallArticleContentQuery())->getContent($itemid);

include template('news_show','mall');
?>