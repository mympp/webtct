<?php 
defined('IN_DESTOON') or exit('Access Denied');
define('MD_ROOT', DT_ROOT.'/module/'.$module);
require DT_ROOT.'/include/module.func.php';
require MD_ROOT.'/global.func.php';
$table = $DT_PRE.$module;
$table_member = $DT_PRE.'member';

global $AREA;
$AREA or $AREA = cache_read('area.php');

$logo_title = '厂商';
$logo_url = 'www.tecenet.com/gongsi/';
?>