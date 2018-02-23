<?php
namespace models\module;

use models\helpers\query\MallArticleCategoryQuery;
use models\helpers\query\MallArticleQuery;
use models\config\Config;
use models\helpers\widget\sitemap\siteMap;

//产品文章模块模型类，封装业务逻辑操作
class mallArticleModule extends baseModule
{

    function __construct()
    {
        global $MODULE;
        $this->moduleid = 16;
        $this->modulename = '医械知识库';
        $this->title = '医械知识库';
        $this->linkurl = $MODULE[$this->moduleid]['linkurl'];
    }

    private function buildShowLinkurl($artiles, $keyName = 'linkurl')
    {
        $result = [];
        foreach ($artiles as $key => $item) {
            if (isset($item['itemid'])) {
                $item[$keyName] = $this->linkurl . $this->showLinkurl($item['itemid']);
            }
            if (isset($item['thumb']) && strpos($item['thumb'], 'http') == false) {
                $item['thumb'] = Config::getConfig('apiUrl') . $item['thumb'];
            }
            $result[] = $item;
        }
        return $result;
    }

    private function buildCateLinkurl($categorys, $keyName = 'linkurl')
    {
        $result = [];
        foreach ($categorys as $cate) {
            if (isset($cate['catid'])) {
                $cate['linkurl'] = $this->linkurl . $this->searchRewrite(['catid' => $cate['catid']]);
                $result[] = $cate;
            }
        }
        return $result;
    }

    //分类伪静态地址规则
    public function searchRewrite($selector)
    {
        $catid = isset($selector['catid']) && !empty($selector['catid']) ? '_' . $selector['catid'] : '';
        $page = isset($selector['page']) && !empty($selector['page']) ? '_' . $selector['page'] : '';
        return 'news_list' . $catid . $page . '.html';
    }

    //内容页面伪静态地址规则
    public function showLinkurl($itemid)
    {
        return 'news_' . $itemid . '.html';
    }

    public function getMenu()
    {
        $mallArticleCategoryQuery = new MallArticleCategoryQuery();
        $categorys = $mallArticleCategoryQuery->getCategory(0);
        return $this->buildCateLinkurl($categorys);
    }

    //获取首页幻灯片数据
    public function getIndexSlide($pagesize = 5)
    {
        $mallArticle = new MallArticleQuery();
        $articles = $mallArticle->getTopArticles($pagesize, true, 'itemid,title,thumb,description');
        return $this->buildShowLinkurl($articles);
    }

    //获取设置的热门分类
    public function getTopCategorys($pagesize = 0)
    {
        $maCategoryQuery = new MallArticleCategoryQuery();
        $categorys = $maCategoryQuery->getTopCategory($pagesize);
        return $this->buildCateLinkurl($categorys);
    }

    //获取热点文章
    public function getHotArticles($pagesize = 10, $withImage = false,
                                   $dayLimit = 0, $field = 'itemid,title,thumb', $catid = 0)
    {
        $articles = (new MallArticleQuery())->getHotArticles($pagesize, $withImage, $dayLimit, $field, $catid);
        return $this->buildShowLinkurl($articles);
    }

    //获取最新文章
    public function getNewArticles($pagesize = 10, $withImage = false,
                                   $field = 'itemid,title,thumb', $catid = 0, $page = 1)
    {
        $articles = (new MallArticleQuery())->getNewArticles($pagesize, $withImage, $field, $catid, $page);
//        var_dump($articles);exit;
        return $this->buildShowLinkurl($articles);
    }

    //获取搜索页面数据
    public function getLists($pagesize = 10, $field = 'itmeid,title,thumb', $catid = 0, $page = 1)
    {
        $result = (new MallArticleQuery())->getLists($pagesize, $field, $catid, $page);
        $lists = $this->buildShowLinkurl($result['list']);
        $result['list'] = $lists;
        return $result;
    }

    //根据id获取文字内容
    public function getListsById(array $itemid, $field = '*')
    {
        $articles = (new MallArticleQuery())->getListsById($itemid, $field);
        return $this->buildShowLinkurl($articles);
    }

    public function buildSiteMap()
    {
        $size = siteMap::MAX_URL_NUM;
        $query = new MallArticleQuery();
        $siteMap =new siteMap();
        $count = $query->getCount(['status'=> MallArticleQuery::CHECKED_STATUS],'itemid');
        for($i=0;($i*$size)<$count['itemid'];$i++){  //生成产品知识库详情sitemap
            $params =[
                'status' => MallArticleQuery::CHECKED_STATUS,
                'page' => ($i+1),
                'pageSize' => $size,
                'field' => 'itemid'
            ];
            $res = $query->mallArticleIds($params);
            $url = [];
            if(!empty($res)){
                foreach($res as $id){
                    $url[] = $this->linkurl . $this->showLinkurl($id['itemid']);
                }
                $siteMap->buildSiteMap($url,'mallArticle','item',$i+1,'Daily');  //生成每天的
            }
        }
        $url =[];
        $catQuery = new MallArticleCategoryQuery();
        $catRes = $catQuery->getAllCatId();  //查出所有分类
        if(!empty($catRes)){
            foreach($catRes as $cat){
                $url[] = $this->linkurl . $this->searchRewrite(['catid' => $cat['catid']]);
            }
        }
        $siteMap->buildSiteMap($url,'mallArticle','cate',1,'Daily');  //生成分类sitemap
    }
}

?>