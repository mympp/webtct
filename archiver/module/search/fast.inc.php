<?php
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
require_once DT_ROOT.'/module/'.$module.'/info.class.php';

if(!isset($_GET['itemid'])){
        header('Location:index.php');
}
$infoid=$_GET['itemid'];
$type=isset($_GET['type'])?$_GET['type']:'';
$keyword=isset($_GET['type'])?$_GET['keyword']:'';

if(!isset($_GET['itemid'])){
        header('Location:index.php');
}
$infoid=$_GET['itemid'];
$type=isset($_GET['type'])?$_GET['type']:'';
$keyword=isset($_GET['type'])?$_GET['keyword']:'';

$info=new info();
$info_data=$info->get_one($itemid);
extract($info_data);

$info_type_result=$db->query("select * from {$db->pre}sogex_info_type");
$info_type_lists=array();
while($r=$db->fetch_array($info_type_result)){
	$info_type_lists[]=$r;
}

include template('fast', $module);
?>
