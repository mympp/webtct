<?php
defined('IN_DESTOON') or exit('Access Denied');
$resutl = [];
if(empty($clientid)){
	$result['status'] = -1;
	$result['message'] = '缺少clientid';
	exit(json_encode($result));
}
if(empty($timestamp)){
	$result['status'] = -1;
	$result['message'] = '缺少时间戳';
	exit(json_encode($result));
}
if(empty($auth)){
	$result['status'] = -1;
	$result['message'] = '缺少auth值';
	exit(json_encode($result));
}

$time = $timestamp - time();

if(abs($time) > 1800 ){
	$result['status'] = -1;
	$result['message'] = '时间戳过期';
	exit(json_encode($result));
}

require DT_ROOT.'/include/tcdb.class.php';
$oauth_clients = new tcdb('oauth_clients');
$oauth_clients->setTableName('oauth_clients');
$client = $oauth_clients->where(['client_id'=>$clientid])->one();
if(empty($client)){
	$result['status'] = -1;
	$result['message'] = '不存在的clientid';
	exit(json_encode($result));
}

$check_auth = md5($clientid.$client['client_secret'].$timestamp);
if($check_auth != $auth){
	$result['status'] = -1;
	$result['message'] = 'auth值错误';
	exit(json_encode($result));
}

$page = empty($page) ? 1 : $page;
$pagesize = empty($pagesize) ? 10 : $pagesize;
$start = ($page - 1)*$pagesize;
$tender = new tcdb('tender');
$tender->setTableName('tender');
$data = $tender->field('title,description,keywords,content,province,city,add_time')->order('itemid desc')->limit($start,$pagesize)->select();
$result['status'] = 1;
$result['data'] = $data;
exit(json_encode($result));


?>