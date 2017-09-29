<?php
namespace models\helpers\query;

use models\helpers\data\tcdb;

class CompanyValidateQuery
{
    const COMPANY_VALIDATED_STATUS = 1;
    const VALIDATED_STATUS = 3;
    const CHECK_STATUS = 2;
    const UNVALIDATE_STATUS = 0;
    const FORBID_STATUS = 4;
    private $_companyDb;
    private $_memberDb;
    private $_companyValidateDb;

    /**
     * tc_company表操作对象
     */
    private function getCompanyDb()
    {
        if (empty($this->_companyDb))    $this->_companyDb = new tcdb('company');
        return $this->_companyDb;
    }

    private function getMemberDb()
    {
        if(empty($this->_memberDb)) $this->_memberDb = new tcdb('member');
        return $this->_memberDb;
    }

    private function getCompanyValidateDb(){
        if(empty($this->_companyValidateDb)) $this->_companyValidateDb = new tcdb('company_validate');
        return $this->_companyValidateDb;
    }

    /**
     * 判断商家是否已进行验证
     * @param $userid
     * @return bool
     */
    public function getValidateStatus($userid, $username = '')
    {
        $company = $this->getCompanyDb()->field('validated')
            ->where(['userid' => $userid])->one();
        //原始destoon判断商家验证的条件1：判断tc_company表的validated值是否为1
        if ($company['validated'] == self::COMPANY_VALIDATED_STATUS) {
            return self::COMPANY_VALIDATED_STATUS;
        }

        $member = $this->getMemberDb()->field('username,vcompany')
            ->where(['userid' => $userid])->one();
        if ($member['vcompany'] == self::COMPANY_VALIDATED_STATUS) {
            //原始destoon判断商家验证条件2：判断tc_member表vcompany是否为1
            return self::COMPANY_VALIDATED_STATUS;
        }

        $validateDb = new tcdb('validate');
        $validate = $validateDb->field('status')
            ->where(['username' => $username, 'type' => 'company', 'status' => self::VALIDATED_STATUS])->one();
        if (!empty($validate)) {
            if ($validate['status'] == self::VALIDATED_STATUS) {
                //原始destoon判断商家验证条件3：判断tc_validate表是否存在对应用户名，type为company，状态为3的信息
                return self::COMPANY_VALIDATED_STATUS;
            } elseif ($validate['status'] == self::CHECK_STATUS) {
                //原始验证状态
                return self::CHECK_STATUS;
            }
        }

        $companyValidateDb = $this->getCompanyValidateDb();
        $companyValidate = $companyValidateDb->field('status')->where(['userid' => $userid])->one();
        if (!empty($companyValidate)) {
            if ($companyValidate['status'] == self::VALIDATED_STATUS) {
                //新版商家验证条件:判断company_validate表是否存在对应用户id，状态为3的信息
                return self::VALIDATED_STATUS;
            } elseif ($companyValidate['status'] == self::CHECK_STATUS) {
                return self::CHECK_STATUS;
            }
        }
        return self::UNVALIDATE_STATUS;
    }

    /**
     * 用户申请商家验证
     * @param $userid
     * @param $data
     * @return bool|\mysqli_result
     */
    public function sendValidate($userid, $data)
    {
        $companyValidateDb = $this->getCompanyValidateDb();
        $data['userid'] = $userid;
        $data['status'] = self::CHECK_STATUS;
        $data['addtime'] = time();
        $data['ip'] = $_SERVER['REMOTE_ADDR'];
        if ($companyValidateDb->where(['userid' => $userid])->one()) {
            $companyValidateDb->restart();
            return $companyValidateDb->where(['userid' => $userid])->edit($data);
        } else {
            return $companyValidateDb->add($data);
        }
    }

    /**
     * 获取认证信息
     * @param $userid
     * @param string $field
     * @return string
     */
    public function getData($userid,$field = '*')
    {
        $companyValidateDb = $this->getCompanyValidateDb();
        return $companyValidateDb->field($field)->where(['userid'=>$userid])->one();
    }

    /**
     * 获取多个商家审核信息
     * @param $condition
     * @param int $page
     * @param int $pagesize
     * @param string $order
     * @return array|bool
     */
    public function getListData($condition = [], $page = 1, $pagesize = 20, $order = '')
    {
        $start = ($page - 1) * $pagesize;
        return $this->getCompanyValidateDb()->where($condition)->order($order)->limit($start, $pagesize)->select();
    }

}
?>