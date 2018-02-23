<?php 
defined('IN_DESTOON') or exit('Access Denied');
define('MD_ROOT', DT_ROOT.'/module/'.$module);
require DT_ROOT.'/include/module.func.php';
require MD_ROOT.'/global.func.php';
$table = $DT_PRE.$module.'_'.$moduleid;
$table_data = $DT_PRE.$module.'_data_'.$moduleid;
$table_search = $DT_PRE.$module.'_search_'.$moduleid;
$TYPE = explode('|', trim($MOD['type']));
define('SELL_ORDER', $MOD['checkorder'] == 2 ? 0 : 1);

global $AREA;
$AREA or $AREA = cache_read('area.php');
$AREA[0]['areaname'] = '全国';

$logo_title = '供需';
$logo_url = $MODULE[5]['linkurl'];

?>