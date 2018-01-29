<?php
namespace models\helpers\query;

class NewsQuery extends BaseQuery
{
    const TABLE_NAME = 'news';
    const CHECKED_STATUS = 3;

    public function getList(array $condition,$page = 1, $pagesize = 10 ,$field = '*',$order = 'itemid desc'){
        $start = ($page - 1)*$pagesize;
        return $this->getDb(self::TABLE_NAME)
            ->field($field)
            ->where($condition)
            ->limit($start ,$pagesize)
            ->order($order)
            ->select();
    }
}

?>