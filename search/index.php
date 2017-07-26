<?php
define('DT_REWRITE', true);
require '../common.inc.php';
require 'common.inc.php';
require 'config.inc.php';
if(isMobile()){ 
	if(DT_PATH == 'http://www.tecenet.com/'){ header('Location:'.SO_PATH.'mindex.php');exit;}
	header('Location: '.DT_PATH.'search/mindex.php');		//检测移动端跳转
	exit;
}
$module='search';
require DT_ROOT.'/module/'.$module.'/index.inc.php';
?>