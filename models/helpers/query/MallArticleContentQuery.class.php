<?php
namespace models\helpers\query;

class MallArticleContentQuery extends BaseQuery
{
    const TABLE_NAME = 'mall_article_content';

    public function getContent($itemid){
        return $this->getDb(self::TABLE_NAME)->where(['itemid'=>$itemid])->one();
    }
}

?>