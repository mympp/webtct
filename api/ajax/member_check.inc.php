<?php
defined('IN_DESTOON') or exit('Access Denied');
isset($job) or exit('wrong params');
isset($value) or exit('wrong params');
$value = convert($value, 'UTF-8', DT_CHARSET);
require DT_ROOT.'/module/member/member.class.php';
$session = new dsession();
$do = new member;
switch($job) {
	case 'username_exists':
		if(!$do->is_username($value)){
			exit( '用户名已存在');
		}else{
			exit;
		}
	break;
	case 'mobile_exists':
		if($do->mobile_exists($value)){
			exit('手机号码已存在');
		}else{
			exit;
		}
	break;
	case 'email_exists':
		if($do->email_exists($value)){
			exit('邮箱已存在');
		}else{
			exit;
		}
	break;
	case 'company_exists':
		if($do->company_exists($value)){
			exit('公司名称已存在');
		}else{
			exit;
		}
	break;
	case 'linkurl_exists':
		if(!isset($_SESSION['initial_reg_member'])) exit('操作超时，请重新登陆');
		if($value == $_SESSION['initial_reg_member']) exit;	//子域名与账号名一致，不必判断
		require DT_ROOT.'/include/tcdb.class.php';
		$company = new tcdb('company');
		$result = $company->where(['username'=>$value])->one();		//
		if($result){
			exit('已被使用为用户名');		//已存在用户名
		}elseif($company->where(['linkurl'=>str_replace('www',$value,DT_PATH)])->one()){
			exit('子域名已存在');		//已被用作子域名
		}else{
			exit;
		}
	break;
	case 'username_or_mobile_exists':
		$from = isset($from)? $from : '';
		$wrongTip = $from == 'mobile' ? '手机号码已存在' : '用户名已存在';
		if(!$do->is_username($value)){
			exit($wrongTip);
		}elseif($do->mobile_exists($value)){
			exit($wrongTip);
		}else{
			exit;
		}
	break;
}
?>