<?php
namespace models\extensions\chuanglan;

use models\config\Config;

class chuanglan
{
    //创蓝发送短信接口URL, 如无必要，该参数可不用修改
    private $API_SEND_URL;

    //创蓝短信余额查询接口URL, 如无必要，该参数可不用修改
    private $API_BALANCE_QUERY_URL;

    private $API_ACCOUNT;//创蓝账号 替换成你自己的账号

    private $API_PASSWORD;//创蓝密码 替换成你自己的密码

    public $API_SIGNNAME;	//用户签名，必须填写在发送内容的开始

    function __construct()
    {
        $config = Config::getExtensionConfig('chuanglan');
        $this->API_SEND_URL = $config['API_SEND_URL'];
        $this->API_BALANCE_QUERY_URL = $config['API_BALANCE_QUERY_URL'];
        $this->API_ACCOUNT = $config['API_ACCOUNT'];
        $this->API_PASSWORD = $config['API_PASSWORD'];
        $this->API_SIGNNAME = $config['API_SIGNNAME'];
    }

    /**
     * 通过CURL发送HTTP请求
     * @param string $url  //请求URL
     * @param array $postFields //请求参数
     * @return mixed
     */
    private function curlPost($url,$postFields){
        $postFields = http_build_query($postFields);
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_HEADER, 0 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $postFields );
        $result = curl_exec ( $ch );
        curl_close ( $ch );
        return $result;
    }

    /**
     * 处理返回值
     *
     */
    private function execResult($result){
        $result=preg_split("/[,\r\n]/",$result);
        return $result;
    }

    /**
     * 发送短信
     *
     * @param string $mobile 		手机号码
     * @param string $msg 			短信内容
     * @param string $needstatus 	是否需要状态报告
     */
    public function sendSMS( $mobile, $msg, $needstatus = 1) {
        //创蓝接口参数
        $postArr = array (
            'un' => $this->API_ACCOUNT,
            'pw' => $this->API_PASSWORD,
            'msg' => $msg,			//修改增加，用户签名
            'phone' => $mobile,
            'rd' => $needstatus
        );
        $result = $this->curlPost( $this->API_SEND_URL , $postArr);
        return $this->execResult($result);
    }

    /**
     * 查询额度
     * 查询地址
     */
    public function queryBalance() {
        //查询参数
        $postArr = array (
            'un' => $this->API_ACCOUNT,
            'pw' => $this->API_PASSWORD,
        );
        $result = $this->curlPost($this->API_BALANCE_QUERY_URL, $postArr);
        return $this->execResult($result);
    }
}

?>