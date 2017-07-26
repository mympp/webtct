<?php
/*
	[Destoon B2B System] Copyright (c) 2008-2013 Destoon.COM
	This is NOT a freeware, use is subject to license.txt
*/
/*
time:2015/10/27
who ：xiaolv
rel : *
update:14-28、32-34、39-63、80-93
*/
define('DT_MEMBER', true);
define('DT_WAP', true);
header('P3P: CP=CAO PSA OUR');
header("Expires:-1");
header("Last-Modified:".gmdate ("D, d M Y H:i:s")."GMT"); 
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT ");
header("Cache-Control:no-cache,must-revalidate");
header("Pragma:no-cache");
header("Content-type:text/html; charset=utf-8");
require '../common.inc.php';
$CFG['db_expires'] = 0;
$CFG['tag_expires'] = 0;
if($_GET['action']=='adduser'){
	$module = 'member';
	require DT_ROOT.'/wap/register.inc.php';
	exit;
}
require DT_ROOT.'/include/module.func.php';
require 'global.func.php';
include load('wap.lang');
	if($moduleid==29){$_COOKIE['clt']='touch';setcookie('clt',$_COOKIE['clt'],time()+3600*24,$CFG['cookie_path'],$CFG['cookie_domain']);}
if($_COOKIE['clt']=='pc'&&!$itemid){header("location: ".DT_PATH);exit;}
if($_COOKIE['clt']=='pc'&&$itemid){header("location: ".$MODULE[$moduleid][linkurl].'show.php?itemid='.$itemid);exit;}
if($DT_BOT) {
	$TP = 'touch';
} else {
	$UA = strtoupper($_SERVER['HTTP_USER_AGENT']);
	if(strpos($UA, 'WINDOWS NT')){
	}
	$TP = 'wap';
	$CK = get_cookie('mobile');
	if($CK == 'wap') {
		$TP = 'touch';
	} else if($CK == 'touch') {
		$TP = 'touch';
	} else {	
		if(preg_match("/(IPONE|IPAD|IPOD|ANDROID)/i", $UA)) $TP = 'touch';
	}
}
$TP = 'touch';
if($TP == 'touch') {
	$back_link = $head_link = $head_name = '';
}
if ($_GET['moduleid'] == '全站搜索') {
	include template('search',$TP);
}else if ($_GET['moduleid'] == '9&action=resume'){
	$DT_URL = convert(urldecode($DT_URL), 'utf-8', $CFG['charset']);	
	header("Location: $DT_URL");
}else if ($_GET['moduleid'] == '16&stype=1'){
	$DT_URL = convert(urldecode($DT_URL), 'utf-8', $CFG['charset']);	
	header("Location: $DT_URL");	 	
}else{
$wap_modules = array('member', 'sell', 'buy', 'quote', 'company', 'exhibit', 'article', 'info', 'job', 'know', 'brand', 'mall', 'group', 'video', 'photo','down','weixin');
$pagesize = $EXT['wap_pagesize'] ? $EXT['wap_pagesize'] : 10;
$offset = ($page-1)*$pagesize;
$maxlength = $EXT['wap_maxlength'] ? $EXT['wap_maxlength'] : 500;
$pages = '';
$areaid = isset($areaid) ? intval($areaid) : 0;
$head_title = $DT['sitename'].$L['wap_version'];
$kw = $kw ? trim($kw) : '';
if(strtolower($CFG['charset'] != 'utf-8') && $kw) {
	$kw = convert($kw, 'utf-8', $CFG['charset']);
	$DT_URL = convert(urldecode($DT_URL), 'utf-8', $CFG['charset']);
}
if(strlen($kw) < $DT['min_kw'] || strlen($kw) > $DT['max_kw']) $kw = '';
$keyword = $kw ? str_replace(array(' ', '*'), array('%', '%'), $kw) : '';
$len = 30;//title length
$WAP_MODULE = array();
	$module_id6 = array("moduleid"=>"6","name"=>"招标采购");
	$module_id5 = array("moduleid"=>"5","name"=>"供应信息");
	$module_id9_resume = array("moduleid"=>"9","name"=>"工程师","action"=>"resume");
	$module_id16_stype = array("moduleid"=>"16","name"=>"配件中心","stype"=>"1");
	// $module_id29 = array("moduleid"=>"29","name"=>"微信分享");
	array_push($WAP_MODULE,$module_id6,$module_id5,$module_id9_resume,$module_id16_stype);

foreach($MODULE as $v) {
	if(in_array($v['module'], $wap_modules) && $v['module'] != 'member' && $v['ismenu']) $WAP_MODULE[] = $v;
}
if ($action == 'category_all') {
	include template('category_all', 'touch');		
	exit();
}

if(in_array($module, $wap_modules)) {
	if(in_array($action, array('category', 'area'))) {
		include $action.'.inc.php';
	} else {
		include $module.'.inc.php';
	}
} else {
	if(in_array($action, array('about'))) {
		include $action.'.inc.php';
	} else {
		if($TP == 'touch') {
			$head_name = $DT['sitename'];
			$head_link = 'index.php';
		}
		include template('index', $TP);
	}
}
wap_output();
}
?>