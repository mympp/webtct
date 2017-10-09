<?php
use models\module\baseModule;

defined('IN_DESTOON') or exit('Access Denied');
login();
require DT_ROOT.'/module/'.$module.'/common.inc.php';
require_once DT_ROOT.'/models/autoload.php';

$MOD['vmember'] or dheader($MOD['linkurl']);
require MD_ROOT.'/member.class.php';
require DT_ROOT.'/include/post.func.php';
$do = new member;
$do->userid = $_userid;
$user = $do->get_one();
$username = $_username;
$auth = isset($auth) ? trim($auth) : '';

$companyModule = baseModule::moduleInstance('company');

switch($action) {
	case 'email':
		$MOD['vemail'] or dheader($MOD['linkurl']);
		if($DT['mail_type'] == 'close') message($L['send_mail_close']);
		$head_title = $L['validate_email_title'];
		if($user['vemail']) {
			$action = 'v'.$action;
			include template('validate', $module);
			exit;
		}
		if($auth) {
			if($auth == $user['auth']) {
				auth_time($user['authtime']);
				$email = $user['authvalue'];
				$r = $db->get_one("SELECT userid FROM {$DT_PRE}member WHERE email='$email' AND userid<>$_userid");
				if($r) message($L['validate_email_exist'], $MOD['linkurl']);
				$db->query("UPDATE {$DT_PRE}member SET email='$email',vemail=1,auth='',authvalue='',authtime=0 WHERE username='$username'");	
				$db->query("INSERT INTO {$DT_PRE}validate (type,username,ip,addtime,status,title,editor,edittime) VALUES ('email','$username','$DT_IP','$DT_TIME','3','$email','system','$DT_TIME')");
				message($L['validate_email_success'], $MOD['linkurl']);
			}
			dalert($L['check_auth'], DT_PATH);
		} else {
			if($submit) {				
				captcha($captcha);
				is_email($email) or message($L['validate_email_bad']);
				$r = $db->get_one("SELECT userid FROM {$DT_PRE}member WHERE email='$email' AND userid<>$_userid");
				if($r) message($L['validate_email_exist']);
				$auth = make_auth($username);
				$db->query("UPDATE {$DT_PRE}member SET auth='$auth',authvalue='$email',authtime='$DT_TIME' WHERE username='$username'");
				$authurl = $MOD['linkurl'].'validate.php?action='.$action.'&auth='.$auth;
				$title = $L['validate_email_mail'];
				$content = ob_template('validate', 'mail');
				send_mail($email, $title, stripslashes($content));
				dheader($MOD['linkurl'].'goto.php?action='.$action.'&email='.$email);
			} else {
				include template('validate', $module);
			}
		}
	break;
	case 'mobile':
		$MOD['vmobile'] or dheader($MOD['linkurl']);
		$DT['sms'] or message($L['send_sms_close']);
		$head_title = $L['validate_mobile_title'];
		if($user['vmobile']) {
			$action = 'v'.$action;
			include template('validate', $module);
			exit;
		}
		if($auth) {
			if($auth == $user['auth']) {
				auth_time($user['authtime'], 1);
				$mobile = $user['authvalue'];
				$r = $db->get_one("SELECT userid FROM {$DT_PRE}member WHERE mobile='$mobile' AND vmobile=1 AND userid<>$_userid");
				if($r) message($L['validate_mobile_exist'], $MOD['linkurl']);
				$db->query("UPDATE {$DT_PRE}member SET mobile='$mobile',vmobile=1,auth='',authvalue='',authtime=0 WHERE username='$username'");
				$db->query("INSERT INTO {$DT_PRE}validate (type,username,ip,addtime,status,title,editor,edittime) VALUES ('mobile','$username','$DT_IP','$DT_TIME','3','$mobile','system','$DT_TIME')");
				message($L['validate_mobile_success'], $MOD['linkurl']);
			}
			message($L['validate_mobile_code_error']);
		} else {
			if($submit) {
				is_mobile($mobile) or message($L['validate_mobile_bad']);
				$r = $db->get_one("SELECT userid FROM {$DT_PRE}member WHERE mobile='$mobile' AND vmobile=1 AND userid<>$_userid");
				if($r) message($L['validate_mobile_exist']);
				if(max_sms($mobile)) message($L['sms_msg_max']);
				$auth = random(6, '0123456789');
				$content = lang('sms->sms_code', array($auth, $MOD['auth_days']*10)).$DT['sms_sign'];
				$sms_code = send_sms($mobile, $content);
				if(strpos($sms_code, $DT['sms_ok']) !== false) {
					$db->query("UPDATE {$DT_PRE}member SET auth='$auth',authvalue='$mobile',authtime='$DT_TIME' WHERE username='$username'");
					dheader('?code=1&action='.$action);
				} else {
					message($L['send_mobile_fail']);
				}
			}
			include template('validate', $module);
		}
	break;
	case 'truename':
		$MOD['vtruename'] or dheader($MOD['linkurl']);
		$head_title = $L['validate_truename_title'];
		$va = $db->get_one("SELECT * FROM {$DT_PRE}validate WHERE type='$action' AND username='$username'");
		if($user['vtruename'] || $va) {
			$action = 'v'.$action;
			include template('validate', $module);
			exit;
		}
		if($submit) {
			if(!$truename) message($L['validate_truename_name']);
			if(!$thumb) message($L['validate_truename_image']);
			clear_upload($thumb.$thumb1.$thumb2);
			$truename = dhtmlspecialchars($truename);
			$thumb = dhtmlspecialchars($thumb);
			$thumb1 = dhtmlspecialchars($thumb1);
			$thumb2 = dhtmlspecialchars($thumb2);
			$db->query("INSERT INTO {$DT_PRE}validate (type,username,ip,addtime,status,editor,edittime,title,thumb,thumb1,thumb2) VALUES ('$action','$username','$DT_IP','$DT_TIME','2','system','$DT_TIME','$truename','$thumb','$thumb1','$thumb2')");
			dmsg($L['validate_truename_success'], '?action='.$action);
		} else {
			include template('validate', $module);
		}
	break;
    case 'vcompany':
        $validateData = $companyModule->getValidateData($_userid);
        $isRejectValidate = $companyModule->isRejectValidated($_userid,$_username);
        include template('validate', $module);
        exit;
        break;
	case 'company':
		$MOD['vcompany'] or dheader($MOD['linkurl']);
		$head_title = $L['validate_company_title'];

        $isValidated = $companyModule->isValidated($_userid,$_username);
        $isWaitValidate = $companyModule->isWaitValidated($_userid,$_username);
        $isRejectValidate = $companyModule->isRejectValidated($_userid,$_username);

		if($isValidated || $isWaitValidate) {
			$action = 'v'.$action;
            $validateData = $companyModule->getValidateData($_userid);
			include template('validate', $module);
			exit;
		}
		if($submit) {
			if(!$post['business_license']) message('请上传营业执照');
			if(!$post['product_license']) message('请上传生产/经营许可证');
			clear_upload($post['business_license'].$post['product_license']);

            $post['business_license'] = dhtmlspecialchars($post['business_license']);
            $post['product_license'] = dhtmlspecialchars($post['product_license']);

            if(!empty($post['business_license_totime']))
                $post['business_license_totime'] = strtotime($post['business_license_totime']);
            if(!empty($post['product_license_totime']))
                $post['product_license_totime'] = strtotime($post['product_license_totime']);

			if($companyModule->sendValidate($_userid,$post)){
                dmsg($L['validate_company_success'], '?action='.$action);
            }else{
                message('证件上传失败，可联系网站客服跟进！');
            }
		} else {
			include template('validate', $module);
		}
	break;
	case 'bank':
		$head_title = $L['validate_bank_title'];
		include template('validate', $module);
	break;
	case 'list':
		$head_title = '会员相关认证';
		$do->userid = $_userid;
		$d = $do->get_one();
		extract($d);
		include template('validate', $module);
	break;
	default:
		dheader($MOD['linkurl']);
	break;
}
?>
