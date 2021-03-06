<?php
namespace models\helpers\query;

use models\helpers\data\tcdb;

//商家资质申请验证处理类
class CompanyValidateQuery extends BaseQuery
{
    const TABLE_NAME = 'company_validate';
    const COMPANY_VALIDATED_STATUS = 1; //企业表认证状态（旧版数据信息）
    const VALIDATED_STATUS = 3;     //企业资料已验证状态
    const CHECK_STATUS = 2;         //企业资料待审核状态
    const UNVALIDATE_STATUS = 0;    //企业资料不通过状态
    const FORBID_STATUS = 4;        //企业禁止状态
    private $_companyDb;
    private $_memberDb;
    private $_companyValidateDb;
    private $_listCount = 0;

    /**
     * tc_company表操作对象
     * @return  tcdb
     */
    private function _getCompanyDb()
    {
        if (empty($this->_companyDb)) {
            $this->_companyDb = new tcdb('company');
        }
        return $this->_companyDb;
    }

    /**
     * tc_company表操作对象
     * @return  tcdb
     */
    private function _getMemberDb()
    {
        if (empty($this->_memberDb)) {
            $this->_memberDb = new tcdb('member');
        }
        return $this->_memberDb;
    }

    /**
     *  获取tc_company_validate表操作对象
     *  @return  tcdb
     */
    private function _getCompanyValidateDb()
    {
        if (empty($this->_companyValidateDb)) {
            $this->_companyValidateDb = new tcdb('company_validate');
        }
        $this->_companyValidateDb = new tcdb('company_validate');
        return $this->_companyValidateDb;
    }

    /**
     * 判断商家是否已进行验证
     * @param $userid
     * @return bool
     */
    public function getValidateStatus($userid, $username = '')
    {
        /*
        $company = $this->getDb('company')->field('validated')
            ->where(['userid' => $userid])->one();
        //原始destoon判断商家验证的条件1：判断tc_company表的validated值是否为1
        if ($company['validated'] == self::COMPANY_VALIDATED_STATUS) {
            return self::COMPANY_VALIDATED_STATUS;
        }

        $member = $this->getDb('member')->field('username,vcompany')
            ->where(['userid' => $userid])->one();
        if ($member['vcompany'] == self::COMPANY_VALIDATED_STATUS) {
            //原始destoon判断商家验证条件2：判断tc_member表vcompany是否为1
            return self::COMPANY_VALIDATED_STATUS;
        }

        $validate = $this->getDb('validate')->field('status')
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
        */
        $companyValidateDb = $this->getDb('company_validate');
        $companyValidate = $companyValidateDb->field('status')->where(['userid' => $userid])->one();
        if (!empty($companyValidate)) {
            if ($companyValidate['status'] == self::VALIDATED_STATUS) {
                //新版商家验证条件:判断company_validate表是否存在对应用户id，状态为3的信息
                return self::VALIDATED_STATUS;
            } elseif ($companyValidate['status'] == self::CHECK_STATUS) {
                return self::CHECK_STATUS;
            } elseif ($companyValidate['status'] == self::FORBID_STATUS){
                return self::FORBID_STATUS;
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
        $companyValidateDb = $this->getDb('company_validate');
        $data['userid'] = $userid;
        $data['status'] = self::CHECK_STATUS;
        $data['addtime'] = time();
        $data['edittime'] = time();
        $data['ip'] = $_SERVER['REMOTE_ADDR'];
        if ($companyValidateDb->where(['userid' => $userid])->one()) {
            $companyValidateDb->restart();
            return $companyValidateDb->where(['userid' => $userid])->edit($data);
        } else {
            return $companyValidateDb->add($data);
        }
    }

    /**
     * 修改申请数据
     * @param $id
     */
    public function changeValidateStatus($id, $data)
    {
        $condition = [];
        if (is_array($id)) {
            $idStr = implode(',', $id);
            $conditionType = 'in';
        } else {
            $idStr = $id;
            $conditionType = '=';
        }
        $condition['itemid'] = $idStr;
        $data['edittime'] = time();
        return $this->getDb('company_validate')->where($condition, $conditionType)->edit($data);
    }

    /**
     * 获取认证信息
     * @param $userid
     * @param string $field
     * @return string
     */
    public function getData($userid,$field = '*')
    {
        $companyValidateDb = $this->getDb('company_validate');
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
    public function getListData($condition = [], $page = 1, $pagesize = 20, $order = 'edittime desc')
    {
        $start = ($page - 1) * $pagesize;
        $count = $this->getDb('company_validate')->where($condition)->count('c');
        if(!empty($count['c'])){
            $this->_listCount = $count['c'];
            return $this->getDb('company_validate')->field('tc_member.username,tc_member.company,tc_company_validate.*')
                ->join('tc_member','tc_member.userid = tc_company_validate.userid')
                ->where($condition)->order($order)->limit($start, $pagesize)->select();
        }else{
            return false;
        }
    }

    /**
     * 获取查询结果数目
     * @return int
     */
    public function getListDataCount(){
        return $this->_listCount;
    }

    /**
     * 判断用户是否已上传有效的生产许可证
     * @param $userid
     * @return bool
     */
    public function hasProductLicense($userid){
        $result = $this->getDb(self::TABLE_NAME)
            ->field('userid')
            ->where(['userid' => $userid , 'status' => self::VALIDATED_STATUS])
            ->where(['product_license' => ''],'<>')->one();
        if($result){
            return true;
        }else{
            return false;
        }
    }


}
?>