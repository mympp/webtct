<?php
namespace models\helpers\query;

//友情链接处理类
class LinkQuery extends BaseQuery
{
    const CHECKED_STATUS = 3;
    const TABLE_NAME = 'link';

    /**
     * 获取友情链接列表
     * @param int $moduleid
     * @param int $pagesize
     * @param string $field
     * @return mixed
     */
    public function getLinks($moduleid = 0 ,$pagesize = 10 , $field = 'title,linkurl')
    {
        $linkDb = $this->getDb(self::TABLE_NAME);
        $linkDb->field($field)->where(['status' => self::CHECKED_STATUS]);
        if(is_int($moduleid) && !empty($moduleid)){
            $linkDb->where(['link_moduleid' => $moduleid]);
        }
        return $linkDb->order('listorder asc')->limit(0,$pagesize)->select();
    }

    /**
     * 根据用户名获取友情链接
     * @param $username
     * @param string $field
     * @return mixed
     */
    public function getLinksByUser($username,$page = 1,$pagesize = 10,$field = '*'){
        $start = ($page - 1)*$pagesize;
        return $this->getDb(self::TABLE_NAME)
            ->field($field)->where(['username' => $username , 'status' => self::CHECKED_STATUS])
            ->limit($start , $pagesize)
            ->select();
    }
}