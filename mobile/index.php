<?php
use models\helpers\widget\wap2_to_wap;

require 'common.inc.php';
require_once '../models/autoload.php';

wap2_to_wap::forword($_GET);

if(in_array($module, $mobile_modules)) {
	$pages = '';
	if($cityid && !$areaid) {
		$areaid = $cityid;
		$ARE = $AREA[$cityid];
	}	

	if ($module != 'resume'&&$module != 'weixin') require DT_ROOT.'/module/'.$module.'/common.inc.php';	
	include 'include/'.$module.'.inc.php';
} else {
	$ads = array();
	$pid = intval($EXT['mobile_pid']);
	if($pid > 0) {
		$result = $db->query("SELECT * FROM {$DT_PRE}ad WHERE pid=$pid AND status=3 AND totime>$DT_TIME ORDER BY listorder ASC,addtime ASC LIMIT 10", 'CACHE');
		while($r = $db->fetch_array($result)) {
			$r['image_src'] = linkurl($r['image_src']);
			$r['url'] = $r['stat'] ? DT_PATH.'/api/redirect.php?aid='.$r['aid'] : linkurl($r['url']);
			$ads[] = $r;
		}
	}	
	$MOD_MY = array();
	$data = '';	
	$local = get_cookie('mobile_setting');
	if($local) {
		$data = $local;
	} else if($_userid) {
		$data = file_get(DT_ROOT.'/file/user/'.dalloc($_userid).'/'.$_userid.'/mobile.php');
		if($data) set_cookie('mobile_setting', $data, $DT_TIME + 30*86400);
	}	
	if($data) {
		$MOB_MOD = array();
		foreach($MOB_MODULE as $m) {
			$MOB_MOD[$m['moduleid']] = $m;
		}
		foreach(explode(',', $data) as $id) {
			if(isset($MOB_MOD[$id])) $MOD_MY[] = $MOB_MOD[$id];
		}
	}
	if(count($MOD_MY) < 2) $MOD_MY = $MOB_MODULE;	
	
	$lists = array("moduleid"=>"9&action=resume","module"=>"resume","name"=>"工程师","moduledir"=>"fuwu","listorder"=>"18","ismenu"=>"1");
	// array_push($MOD_MY, $lists);
	// echo "<pre>";var_dump($MOD_MY);die();
	$head_name = $EXT['mobile_sitename'] ? $EXT['mobile_sitename'] : $DT['sitename'];
	$foot = 'home';
	if($searchall=='searchall')
		include template($searchall, 'mobile');
	else
	include template('index', 'mobile');
}
if(DT_CHARSET != 'UTF-8') toutf8();
?>