<?php
defined('IN_DESTOON') or exit('Access Denied');
require_once DT_ROOT.'/module/search/common.inc.php';
require_once DT_ROOT.'/include/post.func.php';
require_once DT_ROOT.'/models/opensearch/cloudSearch.class.php';

$keyword=isset($_GET['keyword'])?$_GET['keyword']:'';
$type=isset($_GET['type'])?$_GET['type']:'';
$page=isset($_GET['page'])?$_GET['page']:'';
$keyword=isset($_POST['keyword'])?$_POST['keyword']:$keyword;

$keyword = str_replace('"','',$keyword);
$keyword = str_replace("'",'',$keyword);
$keyword = str_replace('\\','',$keyword);

if($keyword==''){
	echo 0;exit;
}
$type=isset($_POST['type'])?$_POST['type']:$type;
$page=isset($_POST['page'])?$_POST['page']:$page;

$cSearch = new cloudSearch();
$cSearch->setFilter(['status'=>3]);
if(!empty($type)){
	$cSearch->setFilter(['info_type'=>$type]);
}
$cSearch->setPageSize(1);
$result_items = $cSearch->search($keyword,$start);
$result_total = $cSearch->getResultNum();

if($result_total){
	echo $result_total;
}else{
	echo 0;
}

?>
