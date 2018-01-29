<?php
namespace models\helpers\query;

class TypeQuery extends BaseQuery {

    const TABLE_NAME = 'type';

    /**
     * 获取用户自定义产品分类
     * @param $userid
     * @return array
     */
    public function getMallType($userid){
        return $this->getDb(self::TABLE_NAME)
            ->field('typeid,typename,parentid')
            ->where(['item' => 'mall-'.$userid])
            ->order('parentid asc,listorder asc')
            ->all();
    }
}

?>