<?php
namespace models\module;

use models\helpers\query\MallArticleCategoryQuery;
use models\helpers\query\MallArticleQuery;

//产品文章模块模型类，封装业务逻辑操作
class mallArticleModule extends baseModule{

    function __construct(){
        global $MODULE;
        $this->moduleid = 16;
        $this->modulename = '医械知识库';
        $this->title = '医械知识库';
        $this->linkurl = $MODULE[$this->moduleid]['linkurl'];
    }

    private function buildShowLinkurl($artiles , $keyName = 'linkurl')
    {
        $result = [];
        foreach($artiles as $key => $item){
            if(isset($item['itemid'])){
                $item[$keyName] = $this->linkurl . $this->showLinkurl($item['itemid']);
                $result[] = $item;
            }
        }
        return $result;
    }

    private function buildCateLinkurl($categorys , $keyName = 'linkurl'){
        $result = [];
        foreach($categorys as $cate){
            if(isset($cate['catid'])){
                $cate['linkurl'] = $this->linkurl . $this->searchRewrite(['catid' => $cate['catid']]);
                $result[] = $cate;
            }
        }
        return $result;
    }

    public function searchRewrite($selector){
        $catid = isset($selector['catid']) && !empty($selector['catid']) ? '_'.$selector['catid'] : '';
        $page = isset($selector['page']) && !empty($selector['page']) ? '_'.$selector['page']:'';
        return 'news_list'.$catid.$page.'.html';
    }

    public function showLinkurl($itemid){
        return 'news_'.$itemid.'.html';
    }

    public function getMenu(){
        $mallArticleCategoryQuery = new MallArticleCategoryQuery();
        $categorys = $mallArticleCategoryQuery->getCategory(0);
        return $this->buildCateLinkurl($categorys);
    }

    //获取首页幻灯片数据
    public function getIndexSlide($pagesize = 5){
        $mallArticle = new MallArticleQuery();
        $articles = $mallArticle->getTopArticles($pagesize,true,'itemid,title,thumb,description');
        return $this->buildShowLinkurl($articles);
    }

    //获取设置的热门分类
    public function getTopCategorys($pagesize = 0){
        $maCategoryQuery = new MallArticleCategoryQuery();
        $categorys = $maCategoryQuery->getTopCategory($pagesize);
        return $this->buildCateLinkurl($categorys);
    }

    //获取热点文章
    public function getHotArticles($pagesize = 10,$withImage = false,
                                   $dayLimit = 0 ,$field = 'itemid,title,thumb',$catid = 0)
    {
        $articles = (new MallArticleQuery())->getHotArticles($pagesize, $withImage, $dayLimit ,$field,$catid);
        return $this->buildShowLinkurl($articles);
    }

    //获取最新文章
    public function getNewArticles($pagesize = 10,$withImage = false,
                    $field = 'itemid,title,thumb',$catid = 0 , $page = 1)
    {
        $articles = (new MallArticleQuery())->getNewArticles($pagesize, $withImage ,$field,$catid,$page);
        return $this->buildShowLinkurl($articles);
    }

    //获取搜索页面数据
    public function getLists($pagesize = 10,$field = 'itmeid,title,thumb',$catid = 0,$page =1){
        $result =  (new MallArticleQuery())->getLists($pagesize,$field,$catid,$page);
        $lists = $this->buildShowLinkurl($result['list']);
        $result['list'] = $lists;
        return $result;
    }

    //根据id获取文字内容
    public function getListsById(array $itemid , $field = '*'){
        $articles = (new MallArticleQuery())->getListsById($itemid,$field);
        return $this->buildShowLinkurl($articles);
    }
}
?>