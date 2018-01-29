<?php
namespace models\module;

use models\helpers\query\MemberQuery;
use models\helpers\query\CompanyQuery;
use models\helpers\query\CompanyValidateQuery;
use models\helpers\query\UpgradeQuery;

class memberModule extends baseModule
{
    public $errorMessage = '';

    function __construct(){
        global $MODULE;
        $this->moduleid = 2;
        $this->modulename = '会员';
        $this->title = '会员';
        $this->linkurl = $MODULE[$this->moduleid]['linkurl'];
    }

    /**
     * 构建帐号密码
     * @param $password
     * @param $salt
     * @return string
     */
    public function buildPassword($password,$salt){
        return md5((is_md5($password) ? md5($password) : md5(md5($password))).$salt);
    }

    //获取错误的提示信息
    public function getErrorMessage(){
        return $this->errorMessage;
    }

    /**
     * 检查必要数据
     * @param $data
     * @return bool|string
     */
    private function checkNeccessary(array $data)
    {
        if(empty($data['username'])) return '缺少用户名';
        if(empty($data['password'])) return '缺少密码';
        if(empty($data['truename'])) return '缺少真实姓名';
        if(empty($data['mobile'])) return '缺少联系电话';
        if(empty($data['email'])) return '缺少邮箱';
        if(empty($data['areaid'])) return '缺少地区选择';
        return true;
    }

    /**
     * 用户注册
     * @param array $data 用户数据
     * @return bool
     */
    public function register(array $data)
    {
        $result = $this->checkNeccessary($data);
        if(!$this->checkNeccessary($data) === true){
            $this->errorMessage = $result;
            return false;
        }
        $memberQuery = new MemberQuery();
        if($memberQuery->checkUsernameExist($data['username'])){
            $this->errorMessage = '用户名已存在';
            return false;
        }
        if($memberQuery->checkEmailExist($data['email'])){
            $this->errorMessage = '邮箱已存在';
            return false;
        }
        if($memberQuery->checkMobileExist($data['mobile'])){
            $this->errorMessage = '手机号码已存在';
            return false;
        }
        $data['groupid'] = MemberQuery::NORMAL_GROUPID; //只能注册普通用户
        $data['regid'] = MemberQuery::NORMAL_GROUPID;
        $data['passport'] = $data['username'];

        //密码信息
        $password = $data['password'];
        $data['passsalt'] = random(8);
        $data['paysalt'] = random(8);
        $data['password'] = $this->buildPassword($password, $data['passsalt']);
        $data['payword'] = $this->buildPassword($password, $data['paysalt']);

        //注册信息
        $data['regtime'] = time();
        $data['logintime'] = time();

        //基础默认信息
        $data['msn'] = $data['qq'] = $data['ali'] = $data['skype'] = $data['department'] = $data['career']
            = $data['role'] = $data['bank'] = $data['branch'] = $data['account'] = $data['black']
            = $data['auth'] = $data['authvalue'] = $data['trade'] = $data['support'] = $data['inviter']
            = $data['headpic'] = $data['comefrom'] = $data['note'] = '';
        $data['message'] = $data['chat'] = $data['avatar'] = $data['admin'] = $data['aid']
            = $data['sms'] = $data['credit'] = $data['money'] = $data['deposit'] = $data['banktype']
            = $data['edittime'] = $data['logintimes'] = $data['authtime'] = $data['vemail'] = $data['vtruename']
            = $data['vbank'] = $data['vcompany'] = $data['vtrade'] = $data['person'] = $data['locking']
            = $data['promotion'] = $data['forbid'] = 0;
        $data['sound'] = $data['online'] = $data['send'] = $data['vmobile'] = 1;

        $memberId = $memberQuery->addMember($data);
        if($memberId){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 处理个人会员升级成为企业会员
     * @param $userid
     * @param $username
     * @param $companyName
     * @param $memberInfo
     * @param $licenseInfo 企业证件信息
     * @return bool
     */
    public function upgradeToCompany($userid,$username,$companyName,$memberInfo,$licenseInfo){
        $companyQuery = new CompanyQuery();
        $result = $companyQuery->getCompanyInfo([
            'company' => $companyName
        ]);

        if($result){
            $this->errorMessage = '公司名已存在';
            return false;
        }

        $result = (new CompanyQuery())->addCompany($userid,$username,$companyName,$memberInfo);
        if(!$result){
            $this->errorMessage = '企业添加失败';
            return false;
        }

        $result = (new UpgradeQuery())->addUpgradeRecord($userid,$username,$companyName,$memberInfo);
        if(!$result){
            $this->errorMessage = '会员申请失败';
            return false;
        }

        $result = (new CompanyValidateQuery())->sendValidate($userid,$licenseInfo);
        if(!$result){
            $this->errorMessage = '证件资料上传失败';
            return false;
        }

        $result = (new MemberQuery())->getDb(MemberQuery::TABLE_NAME)
            ->where(['userid' => $userid])->edit(['company' => $companyName]);
        if(!$result){
            $this->errorMessage = '用户信息修改失败';
            return false;
        }

        return true;
    }

}
?>