<?php
use models\helpers\query\MallArticleCategoryQuery;
use models\helpers\view\pagination;
use models\helpers\view\Navigation;
use models\helpers\view\searchSelector;
use models\helpers\widget\redirect\pc_to_wap;

include DT_ROOT.'/module/mall/news.common.inc.php';

$wapurl = pc_to_wap::forword('chanpin/news_list_'.$catid.'.html');

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
        $cateId[] = $cate['catid'];
    }
    $cateId[] = $catid;
    $pageCate = $maCategory->getOne($catid);
    if(!empty($pageCate['catname'])) $catname = $pageCate['catname'];

    $keywordLink = empty($pageCate['keywordLink']) ? '#' : $pageCate['keywordLink'];

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

$listsData = $newsModule->getLists($pagesize,'itemid,title,thumb,description,addtime,hits,keywords,pushtime',$cateId,(int)$page);
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
if(!empty($pageCate['parentid'])){
    $brotherCate = $maCategory->getChildCategory($pageCate['parentid']);
    foreach($brotherCate as $cate){
        $secondCate[$cate['catid']] = $cate['catname'];
    }
}else{
    foreach($childCate as $cate){
        $secondCate[$cate['catid']] = $cate['catname'];
    }
}
$searchSelector = new searchSelector();
$searchSelector->setModule($newsModule);
$searchSelector->setCurrentTip(['class' => 'current']);
$searchSelector->setSelectedKey(['catid' => $catid]);
$searchSelector->setLinkTitle('{catid}知识',['catid' => '产品']);
//设置选择框显示内容
$selectorView = $searchSelector->begin(['class' => 'selector']);
$selectorView .= $searchSelector->secondItem(
    'catid',
    ['产品知识分类','class' => 'sl-key pull-left'],
    [   'data' => $firstCate ,
        'additions' => ['class' => 'sl-value',],
        'ul' => ['class' => 'sl-v-list sl-v-list-row2 sl-v-list-qixie']
    ],
    [   'data' => $secondCate ,
        'closeUnlimitButton' => true,
        'ul' => ['class' => 'sl-v-list sl-v-sub-list'],
    ] ,
    ['class' => 'sl-wrap' ]);
$selectorView .= $searchSelector->end();


//seo设置
$head_title = $catname.'_医械知识库';
$head_keyword = "{$catname}, {$catname}知识大全";
$head_description = "天成为您提供详尽的{$catname}知识大全，为您列明{$catname}的使用方法与注意事项等{$catname}的知识";

include template('news_list','mall');
?>