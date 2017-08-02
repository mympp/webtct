<?php 
defined('IN_DESTOON') or exit('Access Denied');
//if($DT_BOT || $_POST) dhttp(403);
require DT_ROOT.'/module/'.$module.'/common.inc.php';
if(!check_group($_groupid, $MOD['group_search'])) include load('403.inc');
require DT_ROOT.'/include/post.func.php';

$down_db = new tcdb('down_15');

$pagesize = 30;
$page = isset($page) ? $page : 1;
$start = ($page - 1) * $pagesize;

$selector = [];
$condition = [];
if(!empty($catid)){
	$condition['catid'] = $catid;
	$selector['catid'] = $catid;
}

if(!empty($fileext)){
	$condition['fileext'] = $fileext;
	$selector['fileext'] = $fileext;
}

if($downtype !== null){
	$condition['downtype'] = $downtype;
	$selector['downtype'] = $downtype;
}

if(!empty($kw)){
	$likeCondition['keyword'] = $kw;
	$selector['kw'] = $kw;
}

$order_arr = [
	1 => 'itemid',
	2 => 'hits',
	3 => 'download',
];
if(!empty($order) && isset($order_arr[$order])){
	$selector['order'] = $order;
	$order_str = $order_arr[$order].' desc';
}else{
	$order_str = 'itemid desc';
}

$lists = $down_db->where(['status'=>3])->where($condition)->likeWhere($likeCondition)->limit($start,$pagesize)->order($order_str)->select();
$condition_str = $down_db->getCondition();
$count = $down_db->where($condition_str)->count('c');

$seo_file = 'list';
include DT_ROOT.'/include/seo.inc.php';
$template = 'search';
include template($template, $module);
?>