<?php
namespace models\helpers\query;

//用户表操作
class MemberQuery extends BaseQuery
{
    const TABLE_NAME = 'member';

    const VIP_GROUPID = 7;      //VIP用户会员组id
    const COMPANY_GROUPID = 6;  //企业用户会员组id
    const NORMAL_GROUPID = 5;    //普通用户会员组id
    const ADMIN_GROUPID = 1;    //管理员会员组id

    /**
     * 获取vip用户
     * @param string $field
     * @return mixed
     */
    public function getVipMember($field = '*'){
        return $this->getDb(self::TABLE_NAME)
            ->field($field)
            ->where(['groupid' => self::VIP_GROUPID])->all();
    }

    /**
     * 验证用户名是否已存在
     * @param $username
     * @return bool
     */
    public function checkUsernameExist($username){
        $count = $this->getDb(self::TABLE_NAME)->where(['username' => $username])->count();
        if(isset($count['count']) && $count['count'] > 0){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 验证邮箱是否已存在
     * @param $email
     * @return bool
     */
    public function checkEmailExist($email){
        $count = $this->getDb(self::TABLE_NAME)->where(['email' => $email])->count();
        if(isset($count['count']) && $count['count'] > 0){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 验证手机号码是否已存在
     * @param $mobile
     * @return bool
     */
    public function checkMobileExist($mobile){
        $count = $this->getDb(self::TABLE_NAME)->where(['mobile' => $mobile])->count();
        if(isset($count['count']) && $count['count'] > 0){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 添加用户信息
     * @param $data
     * @return bool
     */
    public function addMember(array $data){
        $result = $this->getDb(self::TABLE_NAME)->add($data);
        if($result){
            return $this->getDb(self::TABLE_NAME)->getInsertId();
        }else{
            return false;
        }
    }

    /**
     * 获取用户信息
     * @param array $condition 匹配条件
     * @param string $field
     * @return mixed
     */
    public function getMemberInfo(array $condition , $field = '*'){
        return $this->getDb(self::TABLE_NAME)->field($field)->where($condition)->one();
    }
}

?>