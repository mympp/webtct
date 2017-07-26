<?php
	define('DT_NONUSER', true);
	require '../common.inc.php';
	$db->query("UPDATE {$DT_PRE}setting SET item_value=item_value+1 WHERE item_key='page_trade'");
	$t = $db->get_one("SELECT item_value FROM {$DT_PRE}setting WHERE item_key='page_trade'",'',0);
	//返回格式化统计数据
	$data = number_format($t['item_value'],0,'.',',');
	$callback = $_GET['callbackdata'];
	echo $callback.'('.json_encode($data).')';
	exit;