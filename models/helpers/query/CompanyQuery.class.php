<?php
namespace models\helpers\query;

class CompanyQuery extends BaseQuery
{
    const VIP_GROUPID = 7;

    const TABLE_NAME = 'company';

    /**
     * 获取推荐企业
     * @param int $pagesize
     * @param string $field
     * @return mixed
     */
    public function getRecommendCompanys($pagesize = 10,$field = ''){
        if(empty($field)) $field = 'userid,linkurl,company,thumb';

        return $this->getDb(self::TABLE_NAME)->field($field)->where(['groupid'=>self::VIP_GROUPID])
            ->order('pnum desc')->limit(0,$pagesize)->select();
    }


    public function addCompany(){

    }
}
?>