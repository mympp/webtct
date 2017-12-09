<?php
namespace models\module;

use models\helpers\query\MallArticleCategoryQuery;
use models\helpers\query\MallArticleQuery;

//产品文章模块模型类，封装业务逻辑操作
class mallArticleModule extends baseModule{

    function __construct(){
        global $MODULE;
        $this->moduleid = 16;
        $this->modulename = 'mallArticle';
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

    public function searchRewrite($selector){
        $catid = isset($selector['catid']) ? '_'.$selector['catid'] : '';
        return 'news_list'.$catid.'.html';
    }

    public function showLinkurl($itemid){
        return 'news_'.$itemid.'.html';
    }

    public function getMenu(){
        $mallArticleCategoryQuery = new MallArticleCategoryQuery();
        return $mallArticleCategoryQuery->getCategory(0);
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
        $result = [];
        foreach($categorys as $cate){
            $cate['linkurl'] = $this->linkurl . $this->searchRewrite(['catid' => $cate['catid']]);
            $result[] = $cate;
        }
        return $result;
    }

    //获取热点文章
    public function getHotArticles($pagesize = 10,$withImage = false,
                                   $dayLimit = 0 ,$field = 'itemid,title,thumb')
    {
        var_dump($withImage);
        var_dump($field);
        $mallArticleQuery = new MallArticleQuery();
        $articles = $mallArticleQuery->getHotArticles($pagesize, $withImage, $dayLimit ,$field);
        return $this->buildShowLinkurl($articles);
    }
}
?>