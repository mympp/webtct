<?php
/*
time:2015-12-2
who:周创杰
where:简历导出功能
relation:template\tc\member\my_hr_resume.htm,template\tc\member\my_hr_job.htm,tiancheng\member\derive.php,tiancheng\module\member\derive.inc.php
*/
	require 'config.inc.php';
	require '../common.inc.php';
	$itemid=$_GET['itemid'];
	require DT_ROOT.'/module/'.$module.'/derive.inc.php';
	//echo $itemid;
?>