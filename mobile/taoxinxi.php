<?php
define('DT_REWRITE', true);
$moduleid = 3;
require '../common.inc.php';
$wap=true;
	$UA = strtoupper($_SERVER['HTTP_USER_AGENT']);
	if(strpos($UA, 'WINDOWS NT')){
		//header("location: ".DT_PATH);exit;
	}
require DT_ROOT.'/module/'.$module.'/taoxinxi.inc.php';
?>