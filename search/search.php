<?php
define('DT_REWRITE', true);
require '../common.inc.php';
require 'common.inc.php';
require 'config.inc.php';
if(isMobile()){ 
	if(DT_PATH == 'http://www.tecenet.com/') {header('Location:'.SO_PATH.'msearch.php?type='.$_GET['type'].'&keyword='.$_GET['keyword'].'&page='.$_GET['page']);exit;}
	header('Location: '.DT_PATH.'search/msearch.php?type='.$_GET['type'].'&keyword='.$_GET['keyword'].'&page='.$_GET['page']);		//检测移动端跳转
	exit;
}
$module='search';
$template = 'search';
require DT_ROOT.'/module/search/search.inc.php';
?>