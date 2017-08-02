<?php 
defined('IN_DESTOON') or exit('Access Denied');
define('MD_ROOT', DT_ROOT.'/module/'.$module);
require MD_ROOT.'/global.func.php';
require DT_ROOT.'/include/module.func.php';

$table = $DT_PRE.$module.'_'.$moduleid;
$table_data = $DT_PRE.$module.'_data_'.$moduleid;
$TYPE = explode('|', trim($MOD['type']));

$CATEGORY = getBuyCategory();
$CAT = [];
foreach($CATEGORY as $k=>$v){
	$CAT[$v['catid']] = $v['catname'];
}
$AREA or $AREA = cache_read('area.php');
$main_area = [];
foreach($AREA as $k=>$v){
	if($v['parentid'] == 0){
		$main_area[] = $v;
	}
}

$logo_title = '招标';
$logo_url = 'www.tecenet.com/zhaobiao/';

?>