<?php
namespace models\module;

use models\helpers\query\TagsQuery;
use models\helpers\query\MallArticleTagsQuery;
use models\helpers\query\MallTagsQuery;

class tagsModule extends baseModule
{
    public function __construct()
    {
        $this->moduleid = 0;
        $this->modulename = '标签';
        $this->linkurl = DT_PATH . 'tag';
    }

    private function buildShowLinkurl($tags){
        $result = [];
        foreach($tags as $tag){
            if(isset($tag['itemid'])){
                $tag['linkurl'] = $this->linkurl . '/' . $this->searchRewrite(['tagid' => $tag['itemid']]);
            }
            $result[] = $tag;
        }
        return $result;
    }

    //获取展示地址伪静态改写
    public function searchRewrite($selector)
    {
        $tagid = (isset($selector['tagid'])) ? '_'.$selector['tagid'] : '';
        return 'show'.$tagid.'.html';
    }

    //获取热搜的标签词
    public function getHotTags($pagesize = 10){
        $hotTags = (new TagsQuery())->getHotTags(10);
        return $this->buildShowLinkurl($hotTags);
    }

    //获取产品文章相关标签
    public function getTagsByMallArticle($articleid , $field = '*'){
        $tagIds = (new MallArticleTagsQuery())->getTagIdByArticle($articleid);
        if($tagIds){
            $tagsQuery = new TagsQuery();
            $tagsDb = $tagsQuery->getDb(TagsQuery::TABLE_NAME);
            $relateTags = $tagsDb
                ->field($field)
                ->where(['itemid' => implode(',',$tagIds)],'in')
                ->where(['status' => TagsQuery::CHECKED_STATUS])->all();
            return $this->buildShowLinkurl($relateTags);
        }else{
            return [];
        }
    }

    //获取标签关联的知识库文章内容
    public function getRelateMallArticles($tagid , $field = '*'){
        $articleIds = (new MallArticleTagsQuery())->getArticleIdByTag($tagid);
        $mallArticleModule = $this->moduleInstance('mallArticle');
        return $mallArticleModule->getListsById($articleIds , $field);
    }

    //获取标签关联的产品
    public function getRelateMalls($tagid , $field = '*'){
        $mallIds = (new MallTagsQuery())->getMallIdsByTag($tagid);
        $mallModule = $this->moduleInstance('mall');
        return $mallModule->getListsById($mallIds ,$field);
    }
}

?>
