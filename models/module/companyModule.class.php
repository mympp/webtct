<?php
namespace models\module;

use models\helpers\query\CompanyValidateQuery;

//企业模块模型类，封装业务逻辑操作
class companyModule extends baseModule
{
    private $_companyValidate;
    private $_validateStaus ;

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
     * tc_company表操作对象
     */
    private function getCompanyValidate()
    {
        if (empty($this->_companyValidate))    $this->_companyValidate = new CompanyValidateQuery();
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
    private function getValidateStatus($userid,$username = '')
    {
        if(!isset($this->_validateStaus[$userid])){
            $status = $this->getCompanyValidate()->getValidateStatus($userid,$username);
            $this->_validateStaus[$userid] = $status;
        }
        return $this->_validateStaus[$userid];
    }

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
    public function isValidated($userid,$username = '')
    {
        $status = $this->getValidateStatus($userid,$username);
        if($status == CompanyValidateQuery::VALIDATED_STATUS) {
            return true;
        }elseif($status == CompanyValidateQuery::COMPANY_VALIDATED_STATUS){
            return true;
        }else{
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
    public function isRejectValidated($userid,$username = ''){
        if($this->getValidateStatus($userid,$username) == CompanyValidateQuery::FORBID_STATUS){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 用户申请商家验证
     * @param $userid
     * @param $data
     * @return bool|\mysqli_result
     */
    public function sendValidate($userid, $data)
    {
        return $this->getCompanyValidate()->sendValidate($userid,$data);
    }
}

?>