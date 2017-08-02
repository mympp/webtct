<?php 
defined('IN_DESTOON') or exit('Access Denied');
$CFG['db_expires'] = 0;
$CFG['tag_expires'] = 0;
if($DT_BOT) dhttp(403);
define('MD_ROOT', DT_ROOT.'/module/'.$module);
require MD_ROOT.'/global.func.php';
require DT_ROOT.'/include/module.func.php';
memberpath('member');
if(defined('DT_ADMIN')) {
	$GROUP = cache_read('group.php');
} else {
	if($submit) {
		check_post() or dalert($L['bad_data']);//safe
		$BANWORD = cache_read('banword.php');
		if($BANWORD && isset($post)) {
			$keys = array('title', 'tag', 'introduce', 'content');
			foreach($keys as $v) {
				if(isset($post[$v])) $post[$v] = banword($BANWORD, $post[$v]);
			}
		}
	}
	$group_editor = $MG['editor'];
	in_array($group_editor, array('Default', 'Destoon', 'Simple', 'Basic')) or $group_editor = 'Destoon';
	$show_menu = $MOD['show_menu'] ? true : false;
	$show_oauth = $MOD['oauth'];

	$MYMODS = array();
	if(isset($MG['moduleids']) && $MG['moduleids']) {
		$MYMODS = explode(',', $MG['moduleids']);
	}
	if($MYMODS) {
		foreach($MYMODS as $k=>$v) {
			$v = abs($v);
			if(!isset($MODULE[$v])) unset($MYMODS[$k]);
		}
	}
	$MENUMODS = $MYMODS;
	if($show_menu) {
		$MENUMODS = array();
		foreach($MODULE as $m) {
			if($m['islink']) continue;
			if($m['moduleid'] > 4 && $m['moduleid'] != 11) $MENUMODS[] = $m['moduleid'];
			if($m['moduleid'] == 9 && in_array(-9, $MYMODS)) $MENUMODS[] = -9;
		}
	}
}
isset($admin_user) or $admin_user = false;
//$AREA = cache_read('area.php');
$table = $DT_PRE.'member';
$table_company = $DT_PRE.'company';
require DT_ROOT.'/module/'.$module.'/power.inc.php';
models('member');

function isMobile(){
	// 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])){
        return true;
    } 
    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA']) && stristr($_SERVER['HTTP_VIA'], "wap")){ 
        return true;
    } 
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT']))
    {
        $clientkeywords = array ('nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile' ); 
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
        {
            return true;
        } 
    } 
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT']))
    { 
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
        {
            return true;
        } 
    } 
    return false;
}

//登录注册用提示内容
function errorMessage($tip,$forward = ''){
	set_cookie('errorTip',$tip);
	dheader($forward);
}
?>