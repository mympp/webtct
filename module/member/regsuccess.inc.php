<?php 
defined('IN_DESTOON') or exit('Access Denied');
if($_userid) dheader($MOD['linkurl']);
require DT_ROOT.'/module/'.$module.'/common.inc.php';
require DT_ROOT.'/module/'.$module.'/member.class.php';
require DT_ROOT.'/include/post.func.php';
require DT_ROOT.'/include/tcdb.class.php';

$session = new dsession();
$forward = isset($_SESSION['reg_referer']) ? $_SESSION['reg_referer'] : '';
if(!isset($_SESSION['reg_success_username'])) header('Location:'.DT_PATH);		//跳转回首页
$username = $_SESSION['reg_success_username'];

//登记登陆状态
$do = new member();
$cookietime = $DT_TIME + (86400*7);
$user = $do->get_one($username);
$auth = encrypt($user['userid']."\t".$user['username']."\t".$user['groupid']."\t".$user['password']."\t".$user['admin']);
$member = new tcdb('member');
global $DT, $DT_TIME, $DT_IP;
$member->where(['userid'=>$user['userid']])->edit(['loginip'=>$DT_IP,'logintime'=>$DT_TIME,'logintimes'=>'1']);

set_cookie('auth', $auth, $cookietime);
set_cookie('username', $user['username'], $DT_TIME + 30*86400);

include template('regsuccess',$module);
?>
