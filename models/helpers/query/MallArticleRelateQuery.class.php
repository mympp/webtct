<?php
namespace models\helpers\query;

class MallArticleRelateQuery extends BaseQuery
{
    const TABLE_NAME = 'mall_article_related';

    public function getMallIdByArticle($articleid){
        $mallid = $this->getDb(self::TABLE_NAME)->field('mallid')->where(['articleid' => $articleid])->all();
        $result = [];
        foreach($mallid as $id){
            $result[] = $id['mallid'];
        }
        return $result;
    }

    public function getArticleIdByMall($mallid){
        $articleid = $this->getDb(self::TABLE_NAME)->field('articleid')->where(['mallid' => $mallid])->all();
        $result = [];
        foreach($articleid as $id){
            $result[] = $id['articleid'];
        }
        return $result;
    }
}
?>