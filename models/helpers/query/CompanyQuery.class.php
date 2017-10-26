<?php
namespace models\helpers\query;

class CompanyQuery extends BaseQuery
{
    const VIP_GROUPID = 7;

    //获取推荐企业
    /**
     * @param $pagesize 获取企业数目
     * @return array
     */
    public function getRecommendCompanys($pagesize = 10,$field = ''){
        if(empty($field)) $field = 'userid,linkurl,company,thumb';

        return $this->getDb('company')->field($field)->where(['groupid'=>self::VIP_GROUPID])
            ->order('pnum desc')->limit(0,$pagesize)->select();
    }
}
?>