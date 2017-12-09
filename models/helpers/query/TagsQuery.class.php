<?php
namespace models\helpers\query;

class TagsQuery extends BaseQuery
{
    const CHECKED_STATUS = 3;

    public function getNewTags($pagesize = 10){
        return $this->getDb('tags')->order('itemid desc')
            ->where(['status' => self::CHECKED_STATUS])
            ->limit(0,$pagesize)->select();
    }

    public function getHotTags($pagesize = 10){
        return $this->getDb('tags')
            ->where(['status' => self::CHECKED_STATUS])
            ->order('hits desc')->limit(0,$pagesize)->select();
    }
}
?>