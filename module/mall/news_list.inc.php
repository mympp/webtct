<?php
use models\helpers\query\MallArticleCategoryQuery;
use models\helpers\view\pagination;
use models\helpers\view\Navigation;
use models\helpers\view\searchSelector;

include DT_ROOT.'/module/mall/news.common.inc.php';

$catid = isset($catid) ? $catid : 0;
$page = isset($page)? $page : 1;
$pagesize = 10;

//导航数据
$navItem = [
    ['name'=>'天成医疗网' , 'url' => DT_PATH],
    ['name' => $newsModule->title ,'url' => $newsModule->linkurl.'news.html'],
];

//列表数据
$cateId = [];
$maCategory = new MallArticleCategoryQuery();
$catename = $newsModule->title;
$childCate = [];
if(!empty($catid)){
    $childCate = $maCategory->getChildCategory($catid);
    foreach($childCate as $cate){
        $cateId['catid'] = $cate['catid'];
    }
    $cateId[] = $catid;
    $pageCate = $maCategory->getOne($catid);
    if(!empty($pageCate['catname'])) $catname = $pageCate['catname'];

    //导航数据
    if(!empty($pageCate['parentid'])){
        $parentCate = $maCategory->getOne($pageCate['parentid']);
        array_push($navItem,
            ['name' => $parentCate['catname'] ,
                'url' => $newsModule->linkurl . $newsModule->searchRewrite(['catid' => $parentCate['catid']])]
        );
    }
    array_push($navItem,
        ['name' => $catname ,'url' => $newsModule->linkurl . $newsModule->searchRewrite(['catid' => $catid])]
    );

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

//导航显示
$navigation = new Navigation();
$navigationView = $navigation->buildNavigation($navItem,[
    'div' => ['class' => 'pw-crumb']
]);

//分类选择框
$firstCate = [];
foreach($MENU as $cate){
    $firstCate[$cate['catid']] = $cate['catname'];
}
$secondCate = [];
foreach($childCate as $cate){
    $secondCate[$cate['catid']] = $cate['catname'];
}
$searchSelector = new searchSelector();
$searchSelector->setModule($newsModule);
$selectorView = $searchSelector->begin(['class' => 'selector']);
$searchSelector .= $searchSelector->secondItem('catid',
    '产品知识大全',
    ['data' => $firstCate],
    ['data' => $secondCate] ,
    []);
$selectorView .= $searchSelector->end();
var_dump($selectorView);


//seo设置
$head_title = $catname.'_医械知识库_天成医疗网';
$head_keyword = "{$catname}, {$catname}知识大全";
$head_description = "天成为您提供详尽的{$catname}知识大全，为您列明{$catname}的使用方法与注意事项等{$catname}的知识";

include template('news_list','mall');
?>