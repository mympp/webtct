<?php
namespace models\helpers\query;

class RegisterSmsQuery extends BaseQuery
{
    const TABLE_NAME = 'register_sms';

    private $errorMessage = '';

    public function getErrorMessage(){
        return $this->errorMessage;
    }

    /**
     * 验证注册的短信验证码
     * @param $username
     * @param $code
     * @param $mobile
     * @return bool
     */
    public function checkRegisterCode($username,$code,$mobile){
        $record = $this->getDb(self::TABLE_NAME)->where(['username' => $username, 'mobile' => $mobile])
            ->order('itemid desc')->one();
        if(empty($record)){
            $this->errorMessage = '没有短信验证记录';
            return false;
        }
        if ($record['code'] != $code){
            $this->errorMessage = '短信验证码错误';
            return false;
        }
        if (time() > (int)$record['endtime']){
            $this->errorMessage = '短信验证码超时';
            return false;
        }
        return true;
    }
}
?>