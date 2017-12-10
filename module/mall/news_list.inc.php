<?php
use models\helpers\query\MallArticleCategoryQuery;
use models\helpers\view\pagination;

include DT_ROOT.'/module/mall/news.common.inc.php';

$catid = isset($catid) ? $catid : 0;
$page = isset($page)? $page : 1;
$pagesize = 10;

$cateId = [];
$maCategory = new MallArticleCategoryQuery();
$catename = $newsModule->title;
if(!empty($catid)){
    $childCate = $maCategory->getChildCategory($catid);
    foreach($childCate as $cate){
        $cateId['catid'] = $cate['catid'];
    }
    $cateId[] = $catid;
    $pageCate = $maCategory->getOne($catid);
    if(!empty($pageCate['catname'])) $catname = $pageCate['catname'];
}
$listsData = $newsModule->getLists($pagesize,'itemid,title,thumb,description,addtime,hits',$cateId,(int)$page);
$lists = $listsData['list'];

//分页按钮
$pagination = new pagination($page,$listsData['count'],$pagesize);
$pagination->setModule($newsModule);
$pagination->setCurrentTip('class="on"');
$paginationView = $pagination->show($newsModule->linkurl.'news_list.php',[
    'div' => ['class' => 'pagination'],
    'form' => ['id' => 'mallForm','method'=>'get'],
],['catid'=>$catid,'page'=>$page]);

include template('news_list','mall');
?>