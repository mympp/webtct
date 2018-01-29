<?php
namespace models\helpers\query;

class HonorQuery extends BaseQuery
{
    const TABLE_NAME = 'honor';
    const CHECKED_STATUS = 3;

    /**
     * 获取指定用户的荣誉证书
     * @param $username
     * @param string $field
     * @param int $page
     * @param int $pagesize
     * @return mixed
     */
    public function getHonor($username , $field = '*',$page = 1,$pagesize = 10){
        $start = ($page - 1)*$pagesize;
        return $this->getDb(self::TABLE_NAME)
            ->field($field)
            ->where(['username' => $username])
            ->limit($start,$pagesize)->select();
    }
}

?>