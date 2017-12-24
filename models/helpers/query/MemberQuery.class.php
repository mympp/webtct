<?php
namespace models\helpers\query;

class MemberQuery extends BaseQuery
{
    const TABLE_NAME = 'member';

    const VIP_GROUPID = 7;

    public function getVipMember($field = '*'){
        return $this->getDb(self::TABLE_NAME)
            ->field($field)
            ->where(['groupid' => self::VIP_GROUPID])->all();
    }
}

?>