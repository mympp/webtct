<?php
use models\helpers\query\MallArticleCategoryQuery;

include DT_ROOT.'/module/mall/news.common.inc.php';

$topSlideArticles = $newsModule->getCache('getIndexSlide',['pagesize' => 5],(3600*12));

//分类最新文章
$maCategoryQuery = new MallArticleCategoryQuery();
$articleList = [];
foreach($MENU as $key => $cate){
    $item = [];
    $item['linkurl'] = $cate['linkurl'];
    $item['catname'] = $cate['catname'];
    $childCate = $maCategoryQuery->getChildCategory($cate['catid']);
    $childCateId = [];
    foreach($childCate as $c){
        $childCateId[] = $c['catid'];
    }
    $item['list'] = $newsModule->getNewArticles(5,false,'title,itemid,description,thumb,hits,addtime',$childCateId);
    $articleList[] = $item;
}


include template('news','mall');
?>