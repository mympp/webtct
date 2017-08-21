<?php
header("Cache-Control:no-cache,must-revalidate");
/*
	[Destoon B2B System] Copyright (c) 2008-2015 www.destoon.com
	This is NOT a freeware, use is subject to license.txt
*/
define('RE_WRITE', 0);
define('DT_MOBILE', true);
require substr(str_replace("\\", '/', dirname(__FILE__)), 0, -7).'/common.inc.php';
if(DT_CHARSET != 'UTF-8') header("Content-type:text/html; charset=utf-8");
require DT_ROOT.'/mobile/include/global.func.php';
include load('mobile.lang');
$EXT['mobile_enable'] or mobile_msg($L['msg_mobile_close']);
$UA = strtoupper($_SERVER['HTTP_USER_AGENT']);
//移动pc切换设置
// if(strpos($UA, 'WINDOWS NT') !== false && !DT_DEBUG) dheader($EXT['mobile_url'].'mobile.php?action=device');
$_mobile = get_cookie('mobile');
if($_mobile == '' || $_mobile == 'pc') {
	set_cookie('mobile', 'touch', $DT_TIME + 30*86400);
}
$back_link = $head_link = $head_name = '';
$mobile_modules = array('member', 'sell', 'buy', 'quote', 'company', 'exhibit', 'article', 'info', 'job', 'know', 'brand', 'mall', 'group', 'video', 'photo', 'club','resume','weixin');
$pages = '';
$areaid = isset($areaid) ? intval($areaid) : 0;
$site_name = $head_title = $EXT['mobile_sitename'] ? $EXT['mobile_sitename'] : $DT['sitename'].$L['mobile_version'];
$kw = $kw ? decrypt($kw) : '';
if(strlen($kw) < $DT['min_kw'] || strlen($kw) > $DT['max_kw']) $kw = '';
$keyword = $kw ? str_replace(array(' ', '*'), array('%', '%'), $kw) : '';
$MURL = $MODULE[2]['linkurl'];
if($DT_MOB['browser'] == 'screen' && $_username) $MURL = 'mobile.php?action=sync&auth='.encrypt($_username.'|'.$DT_IP.'|'.$DT_TIME).'&goto=';
$_cart = isset($MODULE[16]) ? intval(get_cookie('cart')) : 0;
$MOB_MODULE = array();
$MOB_MODULE_NAME = array(3=>'扩展', 9=>'维修', 2=>'会员', 1=>'核心', 24=>'工程师', 13=>'招商', 16=>'产品', 4=>'企业', 5=>'供求', 6=>'招标', 21=>'资讯', 15=>'资料共享', 7=>'科研', 10=>'知道', 11=>'专题专区', 12=>'科室', 27=>'资质信息', 28=>'人才', 29=>'分享');
foreach($MODULE as $k=> $v) {
	$v['name'] = $MOB_MODULE_NAME[$k];
	if(in_array($v['module'], $mobile_modules) && $v['module'] != 'member' && $v['ismenu']) $MOB_MODULE[] = $v;
}
$foot = 'channel';
//自定义
$EXT['comment_module'].=',24,29';//新增微信分享，工程师评论
//获取微信接口配置--2016/2/2
//require_once DT_ROOT.'/api/weixin/init.inc.php';
?>