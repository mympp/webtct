<?php
namespace models\helpers\query;

use models\helpers\data\tcdb;

abstract class BaseQuery
{
    protected $dbList = [];

    //获取数据库操作对象
    protected function getDb($dbTableName)
    {
        if (empty($this->dbList[$dbTableName])) {
            $dbObject = new tcdb($dbTableName);
            if ($dbObject) {
                $this->dbList[$dbTableName] = $dbObject;
            } else {
                return false;
            }
        }else{
            $this->dbList[$dbTableName]->restart();
        }
        return $this->dbList[$dbTableName];
    }
}

?>