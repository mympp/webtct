<?php
define('DT_REWRITE', true);
require 'config.inc.php';
require '../common.inc.php';
//require DT_ROOT.'/module/'.$module.'/list.inc.php';
if($catid){
	$s=isset($stype)?$stype:'0';
	header('Location:search.php?catid='.$catid.'&stype='.$s);
}else{
	header('Location:'.$MODULE[$moduleid]['linkurl']);
}
?>