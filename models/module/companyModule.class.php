<?php
namespace models\module;

use models\helpers\query\CompanyValidateQuery;
use models\helpers\query\CompanyQuery;
use models\helpers\query\UpgradeQuery;
use models\helpers\query\MemberQuery;

//企业模块模型类，封装业务逻辑操作
class companyModule extends baseModule
{
    private $_companyValidate;
    private $_validateStaus;

    /**
     * 构造方法
     */
    function __construct()
    {
        global $MODULE;
        $this->moduleid = 4;
        $this->modulename = $MODULE[$this->moduleid]['name'];
        $this->linkurl = $MODULE[$this->moduleid]['linkurl'];
    }

    /**
     * tc_company_validate表操作对象
     */
    private function getCompanyValidate()
    {
        if (empty($this->_companyValidate)) $this->_companyValidate = new CompanyValidateQuery();
        return $this->_companyValidate;
    }

    /**
     * 企业模块伪静态地址重写
     * $selector  地址参数数组
     * @return  string
     */
    public function searchRewrite($selector)
    {
        //存在这两个参数的地址使用动态地址
        if (isset($selector['kw']) || isset($selector['vip'])) {
            return 'search.php?' . http_build_query($selector);
        } else {
            //伪静态地址处理 so-catid-areaid-mode-type-page.html
            $catid = isset($selector['catid']) ? '-' . $selector['catid'] : '-0';
            $areaid = isset($selector['areaid']) ? '-' . $selector['areaid'] : '-0';
            $mode = isset($selector['mode']) ? '-' . $selector['mode'] : '-0';
            $type = isset($selector['type']) ? '-' . $selector['type'] : '-0';
            $page = isset($selector['page']) ? '-' . $selector['page'] : '';
            return 'so' . $catid . $areaid . $mode . $type . $page . '.html';
        }
    }

    /**
     * 根据用户id获取验证状态
     * @param $userid
     * @param string $username
     * @return mixed
     */
    private function getValidateStatus($userid, $username = '')
    {
        if (!isset($this->_validateStaus[$userid])) {
            $status = $this->getCompanyValidate()->getValidateStatus($userid, $username);
            $this->_validateStaus[$userid] = $status;
        }
        return $this->_validateStaus[$userid];
    }

    /**
     * 获取企业验证资料
     * @param $userid
     * @return string
     */
    public function getValidateData($userid)
    {
        return $this->getCompanyValidate()->getData($userid);
    }

    /**
     * 判断商家是否已验证
     * @param $userid
     * @param string $username
     * @return bool
     */
    public function isValidated($userid, $username = '')
    {
        $status = $this->getValidateStatus($userid, $username);
        if ($status == CompanyValidateQuery::VALIDATED_STATUS) {
            return true;
        } elseif ($status == CompanyValidateQuery::COMPANY_VALIDATED_STATUS) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 判断商家是否待验证状态
     * @param $userid
     * @param string $username
     * @return bool
     */
    public function isWaitValidated($userid, $username = '')
    {
        if ($this->getValidateStatus($userid, $username) == CompanyValidateQuery::CHECK_STATUS) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 判断商家资质审核是否处于拒绝状态
     * @param $userid
     * @param string $username
     */
    public function isRejectValidated($userid, $username = '')
    {
        if ($this->getValidateStatus($userid, $username) == CompanyValidateQuery::FORBID_STATUS) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * 判断用户是否已上传有效的生产许可证
     * @param $userid
     * @return bool
     */
    public function hasProductLicense($userid){
        return $this->getCompanyValidate()->hasProductLicense($userid);
    }

    /**
     * 用户申请商家验证
     * @param $userid
     * @param $data
     * @return bool|\mysqli_result
     */
    public function sendValidate($userid, $data)
    {
        return $this->getCompanyValidate()->sendValidate($userid, $data);
    }

    //---------------- 用户升级流程处理

    /**
     * 修改用户升级状态
     * @param array $itemid upgrade表id
     * @param $upgradeStatus upgrade表status字段需要修改状态
     * @param $validateStatus companyValidate表status字段需要修改状态
     * @param $companyStatus company表validate字段需要修改状态
     * @param $shopStatus company表closeshop字段需要修改状态
     * @param $memberStatus member表groupid字段状态
     * @param $note 备注信息
     * @return bool
     */
    private function changeUpgradeStatus(array $itemid, $upgradeStatus, $validateStatus, $companyStatus,
                                         $shopStatus,$memberStatus ,$note = '')
    {
        //修改upgrade表状态
        $upgradeQuery = new UpgradeQuery();
        $db = $upgradeQuery->getDb(UpgradeQuery::TABLE_NAME);
        $editData = ['status' => $upgradeStatus];
        if(!empty($note)){
            $editData['note'] = $note;
        }
        $result = $db
            ->inWhere('itemid', $itemid)->edit($editData);
        if ($result) {
            $userid = $upgradeQuery->getDb(UpgradeQuery::TABLE_NAME)->field('userid')->inWhere('itemid', $itemid)->all();
            $userCondition = [];
            foreach ($userid as $value) {
                $userCondition[] = $value['userid'];
            }
            (new CompanyValidateQuery())->getDb(CompanyValidateQuery::TABLE_NAME)
                ->inWhere('userid', $userCondition)
                ->edit(['status' => $validateStatus]);
            (new CompanyQuery())->getDb(CompanyQuery::TABLE_NAME)
                ->inWhere('userid', $userCondition)
                ->edit(['validated' => $companyStatus, 'closeshop' => $shopStatus]);
            (new MemberQuery())->getDb(MemberQuery::TABLE_NAME)
                ->inWhere('userid',$userCondition)
                ->edit(['groupid' => $memberStatus]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * 通过用户升级
     * @param array $itemid
     * @return bool
     */
    public function allowUpgradeToCompany(array $itemid)
    {
        return $this->changeUpgradeStatus($itemid,
            UpgradeQuery::CHECKED_STATUS,
            CompanyValidateQuery::VALIDATED_STATUS,
            CompanyQuery::VALIDATED,
            CompanyQuery::OPENSHOP,
            MemberQuery::COMPANY_GROUPID
        );
    }

    /**
     * 拒绝用户升级
     * @param array $itemid
     * @return bool
     */
    public function rejectUpgradeToCompany(array $itemid , $note = '')
    {
        return $this->changeUpgradeStatus($itemid,
            UpgradeQuery::REJECT_STATUS,
            CompanyValidateQuery::FORBID_STATUS,
            CompanyQuery::UNVALIDATED,
            CompanyQuery::CLOSESHOP,
            MemberQuery::NORMAL_GROUPID,
            $note
        );
    }
}

?>