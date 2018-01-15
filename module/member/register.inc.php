<?php
defined('IN_DESTOON') or exit('Access Denied');

use models\module\baseModule;
use models\helpers\query\RegisterSmsQuery;

if ($_userid) dheader($MOD['linkurl']);
require DT_ROOT . '/module/' . $module . '/common.inc.php';

require_once DT_ROOT . '/models/autoload.php';

require DT_ROOT . '/module/' . $module . '/member.class.php';
require DT_ROOT . '/include/post.func.php';
require_once DT_ROOT . '/include/tcdb.class.php';
$session = new dsession();
if (!$MOD['enable_register']) message($L['register_msg_close'], DT_PATH);
if ($MOD['defend_proxy']) {
    if ($_SERVER['HTTP_X_FORWARDED_FOR'] || $_SERVER['HTTP_VIA']
        || $_SERVER['HTTP_PROXY_CONNECTION'] || $_SERVER['HTTP_USER_AGENT_VIA']
        || $_SERVER['HTTP_CACHE_INFO'] || $_SERVER['HTTP_PROXY_CONNECTION']) {
        message(lang('include->defend_proxy'));
    }
}
if ($MOD['banagent']) {
    $banagent = explode('|', $MOD['banagent']);
    foreach ($banagent as $v) {
        if (strpos($_SERVER['HTTP_USER_AGENT'], $v) !== false) message($L['register_msg_agent'], DT_PATH, 5);
    }
}

if (isset($_SERVER['HTTP_REFERER'])) $_SESSION['reg_referer'] = $_SERVER['HTTP_REFERER'];    //保存进入注册页前的页面地址

if (!isset($step) && isset($_GET['step'])) $step = $_GET['step'];
if ($submit) {
    $username = $post['username'];
    //非移动端判断两次密码是否相同
    if ($post['password'] !== $post['password_second'] && !isMobile()) errorMessage('两次密码不相同', 'register.php');
    if (empty($post['password'])) errorMessage('用户密码不能为空', 'register.php');
    //验证短信验证码
    /*
    $registerSms = new RegisterSmsQuery();
    if (!$registerSms->checkRegisterCode($post['username'], $post['sms_code'], $post['mobile']))
        errorMessage($registerSms->getErrorMessage(), 'register.php');
    */
    if (empty($post['truename'])) errorMessage('请填写真实姓名', 'register.php');
    if (empty($post['email'])) errorMessage('请填写邮箱', 'register.php');
    if (empty($post['areaid'])) errorMessage('请选择所在地区', 'register.php');

    unset($post['password_second']);
    unset($post['captcha']);
    unset($post['sms_code']);
    $post['regip'] = $DT_IP;
    $post['loginip'] = $DT_IP;

    $memberModule = baseModule::moduleInstance('member');
    $result = $memberModule->register($post);
    if ($result == false) {
        errorMessage($memberModule->getErrorMessage(), 'register.php');
    }else{
        //注册成功

        //注册赠送积分
        if ($MOD['credit_register'] > 0) {
            $post['credit'] = $MOD['credit_register'];
            credit_add($username, $MOD['credit_register']);
            credit_record($username, $MOD['credit_register'], 'system', $L['member_record_reg'], $DT_IP);
        }
        //注册赠送天成币
        if ($MOD['money_register'] > 0) {
            $post['money'] = $MOD['money_register'];
            money_add($username, $MOD['money_register']);
            money_record($username, $MOD['money_register'], $L['in_site'], 'system', $L['member_record_reg'], $DT_IP);
        }
        //注册赠送短信
        if ($MOD['sms_register'] > 0) {
            $post['sms'] = $MOD['sms_register'];
            sms_add($username, $MOD['sms_register']);
            sms_record($username, $MOD['sms_register'], 'system', $L['member_record_reg'], $DT_IP);
        }

        if (isset($_SESSION['oauth_clientid'])) {    //第三方注册标记存在
            //登记登陆状态
            //$do = new member();
            $cookietime = $DT_TIME + (86400 * 7);
            $user = $do->get_one($username);
            $auth = encrypt($user['userid'] . "\t" . $user['username'] . "\t" . $user['groupid'] . "\t" . $user['password'] . "\t" . $user['admin']);
            set_cookie('auth', $auth, $cookietime);
            set_cookie('username', $user['username'], $DT_TIME + 30 * 86400);
            //跳转第三方转换页面
            header('Location:' . DT_PATH . 'member/oauth2.0/authorize.php?response_type=code&client_id='
                . $_SESSION['oauth_clientid'] . '&redirect_uri=' . $_SESSION['oauth_redirect'] . '&state='
                . rand(1000, 9999) . '&scope=' . $_SESSION['oauth_scope'] . '&register=1');
            $_SESSION['oauth_clientid'] = null;
            $_SESSION['oauth_redirect'] = null;
            $_SESSION['oauth_scope'] = null;
            exit;
        }

        //跳转注册成功页面
        $_SESSION['reg_success_username'] = $username;    //step3标记session
        if (isMobile()) {
            header('Location:' . DT_PATH);        //移动端没有指向地址时，跳到首页
            exit;
        }
        header('Location:' . DT_PATH . 'member/regsuccess.php?');
        exit;

    }


}else{
    $reg = new registerPage();
    $template = isMobile() ? 'wap-register':'register';
    $reg->view($template);
}

class registerPage
{
    var $msg;

    function __construct()
    {
    }

    public function view($view, $module_name = '')
    {
        global $MOD, $cityid, $auth, $forward, $module, $L, $MODULE;
        global $response_type, $client_id, $redirect_uri, $state, $scope, $register;

        if ($module_name == '') $module_name = $module;
        $COM_TYPE = explode('|', $MOD['com_type']);
        $COM_SIZE = explode('|', $MOD['com_size']);
        $COM_MODE = explode('|', $MOD['com_mode']);
        $MONEY_UNIT = explode('|', $MOD['money_unit']);
        $mode_check = dcheckbox($COM_MODE, 'post[mode][]', '', 'onclick="check_mode(this);"', 0);
        $auth = isset($auth) ? rawurldecode($auth) : '';
        $username = $password = $email = $passport = '';
        if ($auth) {
            $auth = decrypt($auth, DT_KEY . 'UC');
            $auth = explode('|', $auth);
            $passport = $auth[0];
            if (check_name($passport)) $username = $passport;
            $password = $auth[1];
            $email = is_email($auth[2]) ? $auth[2] : '';
            if ($email) $_SESSION['regemail'] = md5(md5($email . DT_KEY . $DT_IP));
        }
        $areaid = $cityid;
        set_cookie('forward_url', $forward);
        $head_title = $L['register_title'];

        //判断是否来自天成第三方注册
        if ($response_type == 'code' && !empty($client_id) && !empty($redirect_uri) && !empty($state)
            && strpos($scope, 'register') !== false && $register == '1') {
            $oauth_clients = new tcdb('oauth_clients');
            $oauth_clients->table = 'oauth_clients';
            $clientid = $oauth_clients->where(['client_id' => $client_id])->one();
            if ($clientid) {
                $session = new dsession();
                $_SESSION['oauth_clientid'] = $client_id;
                $_SESSION['oauth_redirect'] = $redirect_uri;
                $_SESSION['oauth_scope'] = $scope;
            }
        } else {
            $session = new dsession();
            $_SESSION['oauth_clientid'] = null;
            $_SESSION['oauth_redirect'] = null;
            $_SESSION['oauth_scope'] = null;
        }

        include template($view, $module_name);
    }
}

?>
