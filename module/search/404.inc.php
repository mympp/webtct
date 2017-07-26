<?php 
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
dhttp(404,false);
if(isMobile()){ 
	include template('m404', $module);
}else{
	include template('404', $module);
}

?>
