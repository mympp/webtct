<?php
use models\helpers\query\MallArticleQuery;
use models\helpers\query\MallArticleContentQuery;

include DT_ROOT.'/module/mall/news.common.inc.php';

if(empty($itemid)){
    include load('404.inc');
    exit;
}

$article = (new MallArticleQuery())->getOne($itemid);
if(empty($article)){
    include load('404.inc');
    exit;
}

$content = (new MallArticleContentQuery())->getContent($itemid);

//seo设置
$head_title = "{$article['title']}_天成医疗网";
$head_keyword = $article['keywords'];
$head_description = $article['description'];

include template('news_show','mall');
?>