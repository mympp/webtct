<?php
defined('IN_DESTOON') or exit('Access Denied');

if(!isset($callbackparams)) exit('-1');
if(!isset($move)) exit('-1');
$pagesize = isset($pagesize) ? $pagesize : 10;
$page = isset($page) ? $page : 1;
$type = isset($type) ? $type : 0;	//0逾期确认订单，1逾期完成订单

$start = ($page-1)*$pagesize;

require DT_ROOT.'/include/tcdb.class.php';
switch($move){
	case 'search':
		$setting_db = new tcdb('setting');
		$check_limit = $setting_db->where(['item_key'=>'order_wait_check'])->all();
		$finish_limit = $setting_db->where(['item_key'=>'order_wait_finish'])->all();
		$mall_order_db = new tcdb('mall_order');
		$condition['mid'] = 16;
		$condition['status'] = 0;
		$condition['kefu_status'] = 0;
		$nowtime = time();

		$check_condition["( $nowtime - addtime)"] =  $type == 0 ? $check_limit['item_value'] * 3600 : $finish_limit['item_value'] * 3600;
		$result = $mall_order_db->field('itemid,buyer,seller,title,buyer_name,buyer_address,buyer_phone,buyer_mobile,addtime,updatetime,price,number,note')->where($condition)->where($check_condition,'>')->limit($start,$pagesize)->select();
		$count = $mall_order_db->field('count(*) as c')->where($condition)->where($check_condition,'>')->one();
		$data['sum'] = $count['c'];
		$data['data'] = $result;
		echo $callbackparams.'('.json_encode($data,JSON_UNESCAPED_UNICODE).')';
		
	break;
	case 'update':
	
	break;
	default:
		exit('-1');
}

?>