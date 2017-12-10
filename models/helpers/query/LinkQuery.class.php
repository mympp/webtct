<?php
namespace models\helpers\query;

//友情链接处理类
class LinkQuery extends BaseQuery
{
    const CHECKED_STATUS = 3;

    //获取友情链接列表
    public function getLinks($moduleid = 0 ,$pagesize = 10 , $field = 'title,linkurl')
    {
        $linkDb = $this->getDb('link');
        $linkDb->field($field)->where(['status' => self::CHECKED_STATUS]);
        if(is_int($moduleid) && !empty($moduleid)){
            $linkDb->where(['link_moduleid' => $moduleid]);
        }
        return $linkDb->order('listorder asc')->limit(0,$pagesize)->select();
    }
}