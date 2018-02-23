<?php
use models\helpers\query\MallArticleCategoryQuery;
use models\helpers\widget\redirect\pc_to_wap;

include DT_ROOT.'/module/mall/news.common.inc.php';

$wapurl = pc_to_wap::forword('chanpin/news.html');

$topSlideArticles = $newsModule->getCache('getIndexSlide',['pagesize' => 5],(3600*12));

//分类最新文章
$maCategoryQuery = new MallArticleCategoryQuery();
$articleList = [];
foreach($MENU as $key => $cate){
    $item = [];
    $childCate = $maCategoryQuery->getChildCategory($cate['catid']);
    if(empty($childCate)) continue;
    $item['linkurl'] = $cate['linkurl'];
    $item['catname'] = $cate['catname'];
    $childCateId = [];
    foreach($childCate as $c){
        $childCateId[] = $c['catid'];
    }
    $item['list'] = $newsModule->getNewArticles(5,false,'title,itemid,description,thumb,hits,addtime,pushtime,keywords',$childCateId);
    $articleList[] = $item;
}

//seo设置
$head_title = '医械知识库';
$head_keyword = '医械知识库,医疗器械知识大全,医疗器械知识库';
$head_description = '天成医疗器械知识库，是全方位的医疗器械知识大全，值得信赖的医疗器械使用指南。';

include template('news','mall');
?>