<?php
namespace models\helpers\query;

use models\helpers\data\tcdb;

abstract class BaseQuery
{
    protected static $dbList = [];

    //获取数据库操作对象
    public function getDb($dbTableName)
    {
        if (empty(self::$dbList[$dbTableName])) {
            $dbObject = new tcdb($dbTableName);
            if ($dbObject) {
                self::$dbList[$dbTableName] = $dbObject;
            } else {
                return false;
            }
        }else{
            self::$dbList[$dbTableName]->restart();
        }
        return self::$dbList[$dbTableName];
    }

}

?>