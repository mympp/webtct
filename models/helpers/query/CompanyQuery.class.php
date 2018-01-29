<?php
namespace models\helpers\query;

class CompanyQuery extends BaseQuery
{
    const VIP_GROUPID = 7;
    const COMPANY_GROUPID = 6;
    const TABLE_NAME = 'company';
    const VALIDATED = 1;        //已验证状态
    const UNVALIDATED = 0;      //未验证状态
    const CLOSESHOP = 1;        //商店未开启状态
    const OPENSHOP = 0;         //商店已开启状态

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

    /**
     * 获取企业信息
     * @param array $condition
     * @return mixed
     */
    public function getCompanyInfo(array $condition){
        return $this->getDb(self::TABLE_NAME)->where($condition)->one();
    }

    /**
     * 添加企业信息
     * @param $userid
     * @param $username
     * @param $company
     * @param array $companyInfo    附加企业信息
     * @return mixed
     */
    public function addCompany($userid , $username , $company , array $companyInfo = []){
        if($this->getDb(self::TABLE_NAME)->field('userid')->where(['userid' => $userid])->one()){
            $editData = $companyInfo;
            $editData['company'] = $company;
            $editData['closeshop'] = self::CLOSESHOP;
            $editData['validated'] = self::UNVALIDATED;
            $editData['groupid'] = self::COMPANY_GROUPID;
            return $this->getDb(self::TABLE_NAME)->where(['userid' => $userid])->edit($editData);
        }else{
            $insertData = $companyInfo;
            $insertData['userid'] = $userid;
            $insertData['username'] = $username;
            $insertData['company'] = $company;
            $insertData['closeshop'] = self::CLOSESHOP;
            $insertData['validated'] = self::UNVALIDATED;
            $insertData['groupid'] = self::COMPANY_GROUPID;
            return $this->getDb(self::TABLE_NAME)->add($insertData);
        }
    }
    
}
?>