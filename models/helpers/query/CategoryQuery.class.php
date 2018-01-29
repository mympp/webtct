<?php
namespace models\helpers\query;

use models\helpers\data\category;

class CategoryQuery extends BaseQuery
{

    const TABLE_NAME = 'category';
    public function getMouleCate($moduleId = 0){
        if(empty($moduleId)) return null;
        return $this->getDb(self::TABLE_NAME)->field('catid')
            ->where(['moduleid' => $moduleId])
            ->all();
    }
}

?>