<?php
defined('IN_DESTOON') or exit('Access Denied');

global $db;

if(empty($_REQUEST['module']) || empty($_REQUEST['verify']) || empty($_REQUEST['auth']) || empty($_REQUEST['move']) || empty($_REQUEST['time'])){
	$result = array('status'=>'1','error'=>'缺少必要参数');
	exit(json_encode($result));
}

if($_REQUEST['auth'] != md5($_REQUEST['move'].$_REQUEST['time'])){
	$result = array('status'=>'2','error'=>'auth参数错误');
	exit(json_encode($result));
}

$time = $_REQUEST['time'];
$now_time = time();
if(intval($time) < (intval($now_time)-(3600*24)) || intval($time) > (intval($now_time)+(3600*24)) ){
	$result = array('status'=>'3','error'=>'time参数错误');
	exit(json_encode($result));
}

$hash_code = 'tecenet_hash_code';
if ($_REQUEST['verify'] != md5($hash_code.$_REQUEST['move'].$_REQUEST['auth']))
{
    $result = array('status'=>'4', 'error'=>'verify参数错误');
    exit(json_encode($result));
}

$table = array('mall'=>'mall','company'=>'company','article'=>'article_21','job'=>'job','resume'=>'resume','sell'=>'sell_5','tech'=>'quote');
if(!isset($table[$_REQUEST['module']])){
	$result = array('status'=>'5','error'=>'move参数错误');
	exit(json_encode($result));
}

switch($_REQUEST['move']){
	case 'search':
		$limit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 6;
		$limit = is_numeric($limit) ? $limit : 6 ; 
		if(!empty($_REQUEST['keyword']) && $_REQUEST['keyword']!= ''){
			$keyword = $_REQUEST['keyword'];
			$data = $db->query('select itemid,title,thumb,linkurl from '.$db->pre.$table[$_REQUEST['module']]." where status = 3  and title like '%$keyword%' order by itemid desc limit 0 , $limit");
			if($data){ 
				$result = array();
				$mid = array();
				while($message = $db->fetch_array($data)){
					$mid['url'] = DT_PATH.$message['linkurl'];
					$mid['title'] = $message['title'];
					$mid['thumb'] = $message['thumb'];
					$result[] = $mid;
				}
				exit(json_encode($result));
				
			}
		}
		$data = $db->query('select itemid,title,thumb,linkurl from '.$db->pre.$table[$_REQUEST['module']].' where status = 3 order by itemid desc limit 0 , '.$limit);
		$result = array();
		$mid = array();
		while($message = $db->fetch_array($data)){
			$mid['url'] = DT_PATH.$message['linkurl'];
			$mid['title'] = $message['title'];
			$mid['thumb'] = $message['thumb'];
			$result[] = $mid;
		}
		exit(json_encode($result));
	break;
	default:
		$result = array('status'=>'6','error'=>'move参数错误');
		exit(json_encode($result));
}

?>