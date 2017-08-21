<?php 
defined('IN_DESTOON') or exit('Access Denied');
if($_userid) dheader($MOD['linkurl']);
require DT_ROOT.'/module/'.$module.'/common.inc.php';
require DT_ROOT.'/module/'.$module.'/member.class.php';
require DT_ROOT.'/include/post.func.php';
require DT_ROOT.'/include/tcdb.class.php';
$session = new dsession();
if(!$MOD['enable_register']) message($L['register_msg_close'], DT_PATH);
if($MOD['defend_proxy']) {
	if($_SERVER['HTTP_X_FORWARDED_FOR'] || $_SERVER['HTTP_VIA'] || $_SERVER['HTTP_PROXY_CONNECTION'] || $_SERVER['HTTP_USER_AGENT_VIA'] || $_SERVER['HTTP_CACHE_INFO'] || $_SERVER['HTTP_PROXY_CONNECTION']) {
		message(lang('include->defend_proxy'));
	}
}
if($MOD['banagent']) {
	$banagent = explode('|', $MOD['banagent']);
	foreach($banagent as $v) {
		if(strpos($_SERVER['HTTP_USER_AGENT'], $v) !== false) message($L['register_msg_agent'], DT_PATH, 5);
	}
}
//if($MOD['iptimeout']) {
//	$timeout = $DT_TIME - $MOD['iptimeout']*3600;
//	$r = $db->get_one("SELECT userid FROM {$DT_PRE}member WHERE regip='$DT_IP' AND regtime>'$timeout'");
//	if($r) message(lang($L['register_msg_ip'], array($MOD['iptimeout'])), DT_PATH);
//}

if(isset($_SERVER['HTTP_REFERER'])) $_SESSION['reg_referer'] = $_SERVER['HTTP_REFERER'];	//保存进入注册页前的页面地址
$do = new member();
$reg = new register();

if(!isset($step) && isset($_GET['ste'])) $step = $_GET['step'];
if($submit){
	if($step != '2'){
		//处理step1提交的数据
		if($do->username_exists($post['username'])) errorMessage('用户名已存在','register.php');		//判断用户名是否存在
		if(!$do->is_username($post['username'])) errorMessage('用户名格式错误','register.php'); 		//判断用户名格式
		if($post['password'] !== $post['password_second'] && !isMobile()) errorMessage('两次密码不相同','register.php');	//非移动端判断两次密码是否相同
		if($do->mobile_exists($post['mobile'])) errorMessage('手机号码已存在','register.php');		//判断手机号码是否存在
		if(empty($post['password'])) errorMessage('用户密码不能为空','register.php');
		//if(!$reg->check_sms_code($post['sms_code'],$post['username'],$post['mobile'])) errorMessage($reg->msg,'register.php');		//验证短信验证码
		unset($post['password_second']);
		unset($post['captcha']);
		unset($post['sms_code']);
		$result = $reg->add_member($post);
		$company['username'] = $post['username'];
		$userid = $db->get_one("select userid from {$db->pre}member where username = '$post[username]'");
		$post['userid'] = $userid['userid'];

		$company_result = $reg->add_company($company,$post);
		
		if($result){
			$_SESSION['initial_reg_member'] = $post['username'];		//session保存完成第一步注册的用户名
			$username = $post['username'];
			$template = isMobile() ? 'wap-register-step2' : 'register-step2';
			include template($template,$module);
		}else{
			dalert('注册失败','','');
		}
	}else{
		//处理step2提交的数据
		if(!isset($_SESSION['initial_reg_member'])) errorMessage('操作超时，请在登录页面登录','register.php');
		if(empty($post['truename'])) errorMessage('请填写真实姓名','register.php');
		if(empty($post['email'])) errorMessage('请填写邮箱','register.php');
		if($do->email_exists($post['email'])) errorMessage('邮箱已被使用','register.php');
		if(empty($post['areaid'])) errorMessage('请选择所在地区','register.php');
		
		$post['groupid'] = 5;
		$post['regid'] = 5;
		//$username = $post['username'];
		$username = $_SESSION['initial_reg_member'];
		if($company['check'] == '1'){		//用户展开注册企业会员
			if(empty($company['company'])) errorMessage('请填写企业名','register.php');
			if($do->company_exists($company['company'])) errorMessage('企业名已存在;','register.php');
			if(empty($company['domain'])) errorMessage('请填写访问域名','register.php');
			if(empty($company['telephone'])) errorMessage('请填写业务电话','register.php');
			$post['company'] = $company['company'];
			$post['groupid'] = $company['groupid'] = $post['regid'] = 6;
			//$company['username'] = $username;
		}else{
			$company['company'] = '';
			$company['domain'] = '';
			$company['telephone'] = '';
			$company['type'] = '';
		}
		$company['areaid'] = $post['areaid'];
			
		$member = new tcdb('member');
		$post['forbid'] = 0;
		//注册赠送积分
		if($MOD['credit_register'] > 0) {
			$post['credit'] = $MOD['credit_register'];
			credit_add($username, $MOD['credit_register']);
			credit_record($username, $MOD['credit_register'], 'system', $L['member_record_reg'], $DT_IP);
		}
		//注册赠送天成币
		if($MOD['money_register'] > 0) {
			$post['money'] = $MOD['money_register'];
			money_add($username, $MOD['money_register']);
			money_record($username, $MOD['money_register'], $L['in_site'], 'system', $L['member_record_reg'], $DT_IP);
		}
		//注册赠送短信
		if($MOD['sms_register'] > 0) {
			$post['sms'] = $MOD['sms_register'];
			sms_add($username, $MOD['sms_register']);
			sms_record($username, $MOD['sms_register'], 'system', $L['member_record_reg'], $DT_IP);
		}
		$member_result = $member->where(['username'=>$username])->edit($post);
		//var_dump($member->errmsg);	//提示操作错误
		
		unset($company['check']);
		$userid = $member->field('userid')->where(['username'=>$username])->one();
		$post['userid'] = $userid['userid'];
		$company_db = new tcdb('company');
		$company_result = $company_db->where(['userid'=>$userid['userid']])->edit($company);
		//var_dump($company_db->errmsg);		//提示操作错误
		//$company_result = $reg->add_company($company,$post);	
		
		if(!$member_result || !$company_result){
			dalert('完善信息失败,请联系客服','','');exit;
		}
		
		//注册成功
		$_SESSION['initial_reg_member'] = null;	//注销step2标记session
		
		if(isset($_SESSION['oauth_clientid'])){ 	//第三方注册标记存在		
			//登记登陆状态
			//$do = new member();
			$cookietime = $DT_TIME + (86400*7);
			$user = $do->get_one($username);
			$auth = encrypt($user['userid']."\t".$user['username']."\t".$user['groupid']."\t".$user['password']."\t".$user['admin']);
			set_cookie('auth', $auth, $cookietime);
			set_cookie('username', $user['username'], $DT_TIME + 30*86400);
			//跳转第三方转换页面
			header('Location:'.DT_PATH.'member/oauth2.0/authorize.php?response_type=code&client_id='.$_SESSION['oauth_clientid'].'&redirect_uri='.$_SESSION['oauth_redirect'].'&state='.rand(1000,9999).'&scope='.$_SESSION['oauth_scope'].'&register=1');
			$_SESSION['oauth_clientid'] = null;
			$_SESSION['oauth_redirect'] = null;
			$_SESSION['oauth_scope'] = null;
			exit;
		}
		
		$_SESSION['reg_success_username'] = $username;	//step3标记session
		if(isMobile()){
			header('Location:'.DT_PATH);		//移动端没有指向地址时，跳到首页
			exit;
		}
		header('Location:'.DT_PATH.'member/regsuccess.php?');exit;
	}
}else{
	if($step == '2'){ 
		if(!isset($_SESSION['initial_reg_member'])) header('Location:'.DT_PATH.'member/register.php');
		$username = $_SESSION['initial_reg_member'];
		$member_db = new tcdb('member');
		if(!$member_db->where(['username'=>$username,'forbid'=>1])->one()) header('Location:'.DT_PATH.'member/register.php');
		$post['username'] = $username;
		$template = isMobile() ? 'wap-register-step2':'register-step2';
		include template($template,$module);
	}else{
		$template = isMobile() ? 'wap-register':'register';
		$reg->view($template);
	}
	
}

class register
{
	var $msg;
	function __construct(){}
	
	//添加企业用户
	public function add_company($company,$member){
		$company_db = new tcdb('company');
		$company['userid'] = $member['userid'];
		$company['areaid'] = $member['areaid'];
		$company['regyear'] = date('Y',time());
		$company['linkurl'] = str_replace('www',$company['username'],DT_PATH);
		unset($company['domain']);
		$company['catid'] = $company['catids'] = $company['mode'] = $company['regunit'] = $company['size'] = $company['regcity'] = $company['sell'] = $company['buy'] =
$company['business'] = $company['fax'] = $company['mail'] = $company['address'] = $company['postcode'] = $company['homepage'] = $company['thumb'] = $company['introduce'] = $company['keyword'] = $company['template'] = $company['skin'] = $company['m_template'] = $company['m_skin'] = $company['domain'] = $company['icp'] = $company['encompany'] = $company['validator'] = $company['contacts'] = $company['baidusqnum'] = $company['btitle'] = '';
		$company['level'] = $company['validated'] = $company['validtime'] =  $company['vip'] =  $company['vipt'] = $company['vipr'] = $company['capital'] = $company['fromtime'] = $company['totime'] = $company['styletime'] = $company['hits'] = $company['closeshop'] = $company['pnum'] = $company['brandid'] = $company['stype'] = 0;
		$company['baidusq'] = '';
		$result = $company_db->add($company);
		if($result){
			$company_data_db = new tcdb('company_data');
			$company_data_db->add(['userid'=>$company['userid'],'content'=>'']);
			return true;
		}else{
			//var_dump($company_db->errmsg);
			return false;
		}
}
	
	//添加用户信息
	public function add_member($post){
		global $MOD;
		$post['passport'] = isset($post['passport']) && $post['passport'] ? $post['passport'] : $post['username'];
		if($MOD['passport'] == 'uc') {
			$passport = convert($post['passport'], DT_CHARSET, $MOD['uc_charset']);
			require DT_ROOT.'/api/uc.inc.php';
			list($uid, $rt_username, $rt_password, $rt_email) = uc_user_login($passport, $post['password']);
			if($uid == -2) dalert($L['register_msg_passport'], '', 'parent.Dd("passport").focus();');
		}

		$inviter = get_cookie('inviter');
		$post['inviter'] = $inviter ? decrypt($inviter, DT_KEY.'INVITER') : '';
		check_name($post['inviter']) or $post['inviter'] = '';
		$password = $post['password'];
		$post['passsalt'] = random(8);
		$post['paysalt'] = random(8);
		$post['password'] = dpassword($password, $post['passsalt']);
		$post['payword'] = dpassword($password, $post['paysalt']);
		$post['regip'] = get_env('ip');
		$post['regtime'] = time();
		$post['loginip'] = get_env('ip');
		$post['logintime'] = time();
		//$post['email'] = null;	//email不添加数据
		$post['msn'] = $post['qq'] = $post['ali'] = $post['skype'] = $post['department'] = $post['career'] = $post['role'] = $post['bank'] = $post['branch'] = $post['account'] = $post['black'] = $post['auth'] = $post['authvalue'] = $post['trade'] = $post['support'] = $post['inviter'] = $post['headpic'] = $post['comefrom'] = $post['note'] = '';
		$post['message'] = $post['chat'] = $post['avatar'] = $post['admin'] = $post['aid'] = $post['areaid'] = $post['sms'] = $post['credit'] = $post['money'] = $post['deposit'] = $post['banktype'] = $post['edittime'] = $post['logintimes'] = $post['authtime'] = $post['vemail'] = $post['vtruename'] = $post['vbank'] = $post['vcompany'] = $post['vtrade'] = $post['person'] = $post['locking'] = $post['promotion'] = 0;
		$post['sound'] = $post['online'] = $post['gender'] = $post['send'] = $post['vmobile'] = $post['forbid'] = 1;
		
		
		$member = new tcdb('member');
		//不使用DT模版提供的验证和用户添加操作流程,直接添加用户信息
		
		$result = $member->add($post);
		//var_dump($member->errmsg);
		return $result;
	}

	//判断用户短信验证码是否正确，是否超时
	public function check_sms_code($code,$username,$mobile){
		$this->msg = '';
		$register_sms = new tcdb('register_sms');		//注册短信记录表
		$sms_record = $register_sms->where(['username'=>$username,'mobile'=>$mobile,'ip'=>get_env('ip')])->order('itemid desc')->one();
		if(empty($sms_record)) $this->msg = '没有短信验证记录';
		if($sms_record['code'] != $code) $this->msg = '短信验证码错误';
		if(time() > (int)$sms_record['endtime']) $this->msg = '短信验证码超时';
		if($this->msg == ''){
			return true;
		}else{
			return false;
		}
	}

	public function view($view,$module_name = ''){
		global $MOD,$cityid,$auth,$forward,$module,$L,$MODULE;
		global $response_type,$client_id,$redirect_uri,$state,$scope,$register;
		
		if($module_name == '') $module_name = $module;
		$COM_TYPE = explode('|', $MOD['com_type']);
		$COM_SIZE = explode('|', $MOD['com_size']);
		$COM_MODE = explode('|', $MOD['com_mode']);
		$MONEY_UNIT = explode('|', $MOD['money_unit']);
		$mode_check = dcheckbox($COM_MODE, 'post[mode][]', '', 'onclick="check_mode(this);"', 0);
		$auth = isset($auth) ? rawurldecode($auth) : '';
		$username = $password = $email = $passport = '';
		if($auth) {
			$auth = decrypt($auth, DT_KEY.'UC');
			$auth = explode('|', $auth);
			$passport = $auth[0];
			if(check_name($passport)) $username = $passport;
			$password = $auth[1];
			$email = is_email($auth[2]) ? $auth[2] : '';
			if($email) $_SESSION['regemail'] = md5(md5($email.DT_KEY.$DT_IP));
		}
		$areaid = $cityid;
		set_cookie('forward_url', $forward);
		$head_title = $L['register_title'];
		
		//判断是否来自天成第三方注册
		if($response_type == 'code' && !empty($client_id) && !empty($redirect_uri) && !empty($state) && strpos($scope,'register') !== false && $register == '1'){
			$oauth_clients = new tcdb('oauth_clients');
			$oauth_clients->table = 'oauth_clients';
			$clientid = $oauth_clients->where(['client_id'=>$client_id])->one();
			if($clientid){
				$session = new dsession();
				$_SESSION['oauth_clientid'] = $client_id;
				$_SESSION['oauth_redirect'] = $redirect_uri;
				$_SESSION['oauth_scope'] = $scope;
			}
		}else{
			$session = new dsession();
			$_SESSION['oauth_clientid'] = null;
			$_SESSION['oauth_redirect'] = null;
			$_SESSION['oauth_scope'] = null;
		}
		
		include template($view, $module_name);
	}
}
?>
