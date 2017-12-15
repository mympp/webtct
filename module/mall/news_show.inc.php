<?php
use models\helpers\query\MallArticleQuery;
use models\helpers\query\MallArticleContentQuery;
use models\helpers\view\Navigation;
use models\helpers\query\MallArticleCategoryQuery;
use models\module\baseModule;
use models\helpers\query\MallArticleRelateQuery;
use models\helpers\query\MallQuery;
use models\helpers\query\MallArticleTagsQuery;
use models\helpers\query\TagsQuery;

include DT_ROOT.'/module/mall/news.common.inc.php';

if(empty($itemid)){
    include load('404.inc');
    exit;
}

$mallArticleQuery = new MallArticleQuery();
$article = $mallArticleQuery->getOne($itemid);
if(empty($article)){
    include load('404.inc');
    exit;
}
$content = (new MallArticleContentQuery())->getContent($itemid);

//修改点击次数
$mallArticleQuery->updateHits($itemid, ((int)$article['hits'] + 1));

//导航数据
$maCategory = new MallArticleCategoryQuery();
$category = $maCategory->getOne($article['catid']);
$navItem = [
    ['name'=>'天成医疗网' , 'url' => DT_PATH],
    ['name' => $newsModule->title ,'url' => $newsModule->linkurl.'news.html'],
    ['name' => $category['catname'] , 'url' => $newsModule->linkurl . $newsModule->searchRewrite(['catid'=>$article['catid']])],
    ['name' => $article['title'] , 'url' => '#']
];
$navigation = new Navigation();
$navigationView = $navigation->buildNavigation($navItem,[
    'div' => ['class' => 'pw-crumb']
]);

//相关产品
$maRelate = new MallArticleRelateQuery();
$mallid = $maRelate->getMallIdByArticle($itemid);
$mallQuery = new MallQuery();
$mallDb = $mallQuery->getDb(MallQuery::TABLE_NAME);
$relateMalls = $mallDb
    ->field('itemid,title,thumb,hits')
    ->where(['itemid' => implode(',',$mallid)],'in')
    ->where(['status' => MallQuery::CHECKED_STATUS])->all();

//相关标签
$tagsModule = baseModule::moduleInstance('tags');
$relateTags = $tagsModule->getTagsByMallArticle($itemid,'word,itemid');

//推荐文章内容
$articleModule = baseModule::moduleInstance('article');
$recomArticles = $articleModule->getCache('getHotArticles',[6, false,14,'itemid,title,linkurl',0]);

//seo设置
$head_title = "{$article['title']}_天成医疗网";
$head_keyword = $article['keywords'];
$head_description = $article['description'];

include template('news_show','mall');
?>