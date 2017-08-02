<?php 
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
require DT_ROOT.'/include/post.func.php';

global $db;
if($submit){
	$ip = get_ip() ;
	$ip = empty($ip) ? '':$ip;
	$userid = $_userid ? $_userid : '';
	$username = $_username ? $_username : '';
	$module = 'sogex';
	$db->query("insert into {$db->pre}feekback (content,contact,username,userid,ip,module,addtime) values ('$content','$contact','$username','$userid','$ip','$module',".time().")");
	//message('反馈成功，谢谢您的意见','mindex',200);
	header('Location:mindex.php');
}else{
	include template('mfeekback', $module);
}


?>
