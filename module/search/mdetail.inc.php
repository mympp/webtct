<?php
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
require_once DT_ROOT.'/module/'.$module.'/common.func.php';
require_once DT_ROOT.'/module/'.$module.'/info.class.php';
if(!isset($_GET['itemid'])){
	header('Location:index.php');
}
$infoid=$_GET['itemid'];
$type=isset($_GET['type'])?$_GET['type']:'';
$keyword=isset($_GET['keyword'])?$_GET['keyword']:'';

$sogex_info_type = get_cache('info_type');

$info=new info($sogex_info_type[$infotype]['catname']);
$info_data=$info->get_one($itemid);
if(empty($info_data)){
	 header('Location:404.php');exit;
}

extract($info_data);
//if(empty($_username) && $infotype == '6') $content = screenNumber($content,5);

//修改点击次数
$post['hits'] = intval($hits)+1;
$info->update($post,$itemid);

$hot_news = get_cache('hot_news');
if($sogex_info_type[$infotype]['catname'] == 'mall'){
	include template('mdetail-product',$module);
}elseif($sogex_info_type[$infotype]['catname'] == 'company'){
	include template('mdetail-company',$module);
}else{
	include template('mdetail',$module);
}

?>
