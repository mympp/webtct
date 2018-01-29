<?php
namespace models\helpers\query;

//用户升级表对应类
class UpgradeQuery extends BaseQuery
{
    const TABLE_NAME = 'upgrade';
    const CHECKED_STATUS = 3; //已通过状态
    const WAIT_STATUS = 2;  //待审核状态
    const REJECT_STATUS = 1;    //拒绝状态

    /**
     * 添加申请记录
     * @param $userid
     * @param $username
     * @param $company
     * @param array $info
     * @return mixed
     */
    public function addUpgradeRecord($userid ,$username ,$company,array $info = []){
        $insertData = $info;
        $insertData['userid'] = $userid;
        $insertData['username'] = $username;
        $insertData['status'] = self::WAIT_STATUS;
        $insertData['addtime'] = time();
        $insertData['edittime'] = time();
        $insertData['groupid'] = MemberQuery::COMPANY_GROUPID;
        $insertData['company'] = $company;
        return $this->getDb(self::TABLE_NAME)->add($insertData);
    }

    /**
     * 根据状态获取升级记录
     * @param $status
     * @param int $page
     * @param int $pagesize
     * @return array|bool
     */
    public function getListsByStatus($status,$page = 1,$pagesize = 10){
        $start = ($page - 1)*$pagesize;

        $db = $this->getDb(UpgradeQuery::TABLE_NAME);
        $companyValidateTableName =$db->tb_pre . CompanyValidateQuery::TABLE_NAME;
        $upgradeTableName = $db->tb_pre .UpgradeQuery::TABLE_NAME;
        $lists = $db
            ->field("$companyValidateTableName.itemid as vitemid,$companyValidateTableName.business_license,
            $companyValidateTableName.business_license_starttime,$companyValidateTableName.business_license_totime,
            $companyValidateTableName.business_license_code,$upgradeTableName.*")
            ->join($companyValidateTableName,"{$companyValidateTableName}.userid = {$upgradeTableName}.userid")
            ->where(["{$upgradeTableName}.status" => $status])
            ->limit($start,$pagesize)->order("$upgradeTableName.itemid desc")->select();
        if(!$lists){
            return false;
        }
        $count = $db->where(['status' => $status])->count('c');
        return [
            'lists' => $lists,
            'totalCount' => $count['c'],
        ];
    }
}
?>