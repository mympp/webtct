<?php
if(!isset($_GET['other'])){
    if ($_userid && !$MOD['passport']) dheader($MOD['linkurl']);
}else{
    set_cookie('auth', '', -1);
    set_cookie('username', '', -1);
    $_SESSION['authorize_login'] = 'authorize';
}
require DT_ROOT . '/module/' . $module . '/common.inc.php';
require MD_ROOT . '/member.class.php';
require DT_ROOT . '/include/post.func.php';
require DT_ROOT . '/include/tcdb.class.php';

$do = new member;
$forward = $forward ? linkurl($forward) : DT_PATH;
if ($submit && $MOD['captcha_login'] && strlen($captcha) < 4) $submit = false;
isset($auth) or $auth = '';
if ($_userid) $auth = '';
if ($auth) {
    $auth = decrypt($auth, DT_KEY . 'LOGIN');
    $_auth = explode('|', $auth);
    if ($_auth[0] == 'LOGIN' && check_name($_auth[1]) && strlen($_auth[2]) >= $MOD['minpassword'] && $DT_TIME >= intval($_auth[3]) && $DT_TIME - intval($_auth[3]) < 30) {
        $submit = 1;
        $username = $_auth[1];
        $password = $_auth[2];
        $MOD['captcha_login'] = $captcha = 0;
    }
}
$action = 'login';

if ($submit) {
	//2017-1-13登陆新流程--start
	//验证验证码
	$session = new dsession();
	if(!isset($_SESSION['captchastr'])) errorMessage('验证码过期','login.php');
	$captcha = convert($captcha, 'UTF-8', DT_CHARSET);
	if($_SESSION['captchastr'] != md5(md5(strtoupper($captcha).DT_KEY.$DT_IP))) errorMessage('验证码错误','login.php');
	
	//验证用户名和密码长度
	$username = trim($username);
    $password = trim($password);
    if (strlen($username) < 3) errorMessage($L['login_msg_username'],'login.php');
    if (strlen($password) < 5) errorMessage($L['login_msg_password'],'login.php');
    
    $cookietime = isset($cookietime) ? 86400 * 30 : 0;
    $login_success = false;
    $real_username = '';	//用于保存用户真实的用户名
    $user;
    $tc_member = new tcdb('member');
    //验证是否用户名登陆
    $check_username = $do->username_exists($username);		//判断用户名是否存在输入值
    if($check_username){	//用户名存在输入值，验证登陆
    	$real_username = $username;
		$user = $do->login($username,$password,$cookietime,false,false);
		if($user) $login_success = true;	//标记用户名登陆成功
	}
	
	//验证是否邮箱登陆
	if(!$login_success && is_email($username) && $do->email_exists($username)){		//未登陆成功，判断是否使用邮箱登陆
		//输入格式为邮箱，且存在于数据表中
		$real_username = $email_username = $tc_member->field('username')->where(['email'=>$username])->one();
		$user = $do->login($email_username['username'],$password,$cookietime,false,false);
		if($user) $login_success = true;	//标记用户名登陆成功
	}
	
	//验证是否手机号码登陆
	if(!$login_success && $do->mobile_exists($username)){	
		$real_username = $mobile_username = $tc_member->field('username')->where(['mobile'=>$username])->one();
		$user = $do->login($mobile_username['username'],$password,$cookietime,false,false);
		if($user) $login_success = true;
	}
	
	if(!$login_success) errorMessage('登陆失败，请确认输入用户名/邮箱/手机和密码是否正确','login.php');
	
	//未提示错误表示登陆成功
	if($user['forbid'] == '1'){
		//用户状态为未激活，注销登陆，跳转到注册的step2页面
        $do->logout();
        $_SESSION['initial_reg_member'] = $user['username'];
		header('Location:'.DT_PATH.'member/register.php?step=2');
		exit;
	}
	
	if(isMobile()){
		if(!empty($forward)){
			header('Location:'.$forward);
			exit;
		}elseif(!empty($backto)){
			header('Location:'.$backto);
			exit;
		}else{
			header('Location:index.php');
			exit;
		}
	}else{
		if(!empty($forward)) message('登陆成功',$forward);
		if(!empty($backto)) message('登陆成功',$backto);
		message('登陆成功','index.php');
	}
    
	//2017-1-13登陆新流程--end	
} else {
    #if($DT_TOUCH) dheader($EXT['mobile_url'].'login.php?forward='.urlencode($forward));
    isset($username) or $username = $_username;
    isset($password) or $password = '';
    $register = isset($register) && $username ? 1 : 0;
    $username or $username = get_cookie('username');
    check_name($username) or $username = '';
    $OAUTH = cache_read('oauth.php');
    $oa = 0;
    foreach ($OAUTH as $v) {
        if ($v['enable']) {
            $oa = 1;
            break;
        }
    }
    set_cookie('forward_url', $forward);
    //set_cookie('errorTip','验证码错误');
    //var_dump(get_cookie('errorTip'));
    $head_title = $register ? $L['login_title_reg'] : $L['login_title'];
    $template = isMobile() ? 'wap-login' : 'login';
    include template($template, $module);
}

?>
