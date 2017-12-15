<?php
namespace models\helpers\query;

class TagsQuery extends BaseQuery
{
    const CHECKED_STATUS = 3;
    const TABLE_NAME = 'tags';

    public function getNewTags($pagesize = 10){
        return $this->getDb(self::TABLE_NAME)->order('itemid desc')
            ->where(['status' => self::CHECKED_STATUS])
            ->limit(0,$pagesize)->select();
    }

    public function getHotTags($pagesize = 10){
        return $this->getDb(self::TABLE_NAME)
            ->where(['status' => self::CHECKED_STATUS])
            ->order('hits desc')->limit(0,$pagesize)->select();
    }

    public function getOne($tagid){
        return $this->getDb(self::TABLE_NAME)->where(['itemid' => $tagid])->one();
    }

    public function updateHits($tagid, $hits){
        return $this->getDb(self::TABLE_NAME)->where(['itemid' => $tagid])->edit(['hits' => $hits]);
    }
}
?>