<?php
namespace  models\helpers\query;

class MallArticleTagsQuery extends BaseQuery
{
    const TABLE_NAME = 'mall_article_tags';

    public function getTagIdByArticle($articleid){
        $tags = $this->getDb(self::TABLE_NAME)->field('tagsid')->where(['articleid' => $articleid])->all();
        $result = [];
        foreach($tags as $id){
            $result[] = $id['tagsid'];
        }
        return $result;
    }

    public function getArticleIdByTag($tagid){
        $articleIds = $this->getDb(self::TABLE_NAME)->field('articleid')->where(['tagsid' => $tagid])->all();
        $result = [];
        foreach($articleIds as $article){
            $result[] = $article['articleid'];
        }
        return $result;
    }
}
?>