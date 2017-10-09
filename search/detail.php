<?php
define('DT_REWRITE', true);
require '../common.inc.php';
require 'common.inc.php';
require 'config.inc.php';
if(isMobile()){ 
	if(DT_PATH == 'http://www.tecenet.com/') {header('Location:'.SO_PATH.'mdetail.php?itemid='.$_GET['itemid'].'&infotype='.$_GET['infotype']);exit;}
	header('Location: '.DT_PATH.'search/mdetail.php?itemid='.$_GET['itemid'].'&infotype='.$_GET['infotype']);		//检测移动端跳转
	exit;
}

$module='search';
$page_template = 'detail';
require DT_ROOT.'/module/'.$module.'/detail.inc.php';
?>
