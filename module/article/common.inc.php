<?php 
defined('IN_DESTOON') or exit('Access Denied');
define('MD_ROOT', DT_ROOT.'/module/'.$module);
require DT_ROOT.'/include/module.func.php';
require MD_ROOT.'/global.func.php';
require_once DT_ROOT . '/models/autoload.php';
require_once DT_ROOT.'/include/tcdb.class.php';
$table = $DT_PRE.$module.'_'.$moduleid;
$table_data = $DT_PRE.$module.'_data_'.$moduleid;


$logo_title = '资讯';
$logo_url = $MODULE[21]['linkurl'];


?>