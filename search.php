<?php
/*
	[Destoon B2B System] Copyright (c) 2008-2011 Destoon.COM
	This is NOT a freeware, use is subject to license.txt
*/
define('DT_NONUSER', true);
require 'common.inc.php';
if(!empty($keyid)){
	$sql = "select * from ".$DT_PRE."keyword where itemid = $keyid";
	$result = $db->get_one($sql);
	if($result){
		$kw_letter = $kw;
		$kw = $result['keyword'];
		$keyid = $result['itmeid'];
	}
}

if(!isset($kw_letter)){
	$kw_letter = false;
}
$ztitle = $kw.'【厂家 价格  维修公司】_天成医疗网';
$zkeywords = $kw.'厂家、'.$kw.'价格、'.$kw.'维修公司';
$zdescription = $kw.'厂家 价格 维修公司,天成医疗网 提供更多'.$kw.'公司、厂家、耗材配件 维修公司工程师等信息。更多医疗器械、医疗仪器、医疗设备等供应、采购、招标、安装、维护、调试、询价、技术咨询等需求服务，请登录天成医疗网！';
require DT_ROOT.'/include/module.func.php';
$URL = DT_PATH;
if($moduleid > 3 && !$MODULE[$moduleid]['islink']) {
	if($kw) {
		$qstr = str_replace('moduleid='.$moduleid.'&', '', $_SERVER['QUERY_STRING']);
		$qstr = str_replace('moduleid='.$moduleid, '', $qstr);
		$spread = isset($spread) ? intval($spread) : 0;
		if($spread) {
			$r = $db->get_one("SELECT tid FROM {$DT_PRE}spread WHERE mid=$moduleid AND word='$kw' AND fromtime<$DT_TIME AND totime>$DT_TIME ORDER BY price DESC,itemid ASC");
			if($r) {
				$id = $moduleid == 4 ? 'userid' : 'itemid';
				$t = $db->get_one("SELECT linkurl FROM ".get_table($moduleid)." WHERE `{$id}`=$r[tid]");
				if($t) dheader(strpos($t['linkurl'], '://') !== false ? $t['linkurl'] : $MOD['linkurl'].$t['linkurl']);
			}
			dheader($EXT['spread_url'].rewrite('index.php?kw='.urlencode($kw)));
		} else {
			$qstr = str_replace('spread=0', '', $qstr);
		}
		if($qstr) {
			if(substr($qstr, 0, 1) == '&') $qstr = substr($qstr, 1);
			$URL = $MOD['linkurl'].'search.php?'.$qstr;
		} else {
			$URL = $MOD['linkurl'].'search.php';
		}
	} else {
		$URL = $MOD['linkurl'].'search.php';
	}
dheader($URL);}
else{
	include template('search');
}
?>