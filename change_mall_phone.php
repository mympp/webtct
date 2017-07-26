<?php
require_once 'common.inc.php';
error_reporting(E_ALL);
$sql = "SELECT itemid,telephone,mobile FROM tc_mall WHERE telephone=mobile AND length(mobile)>13 AND itemid>499999 AND itemid<550000 ";
$result = $db->query($sql);

while ($r = $db->fetch_array($result)) {
	$contact_arr = explode(' ', $r['mobile']);
	$contact_arr = array_filter($contact_arr);
	$arr_len = count($contact_arr);
	foreach ($contact_arr as $key => $value) {
		
	}
	if($arr_len>2&&$arr_len<5){
		$updates[] = $r; 
		$sql = "UPDATE tc_mall SET telephone = '".$contact_arr[0]."',mobile='".$contact_arr[$key]."' WHERE itemid='".$r['itemid']."'";
		$db->query($sql);
	}else if($arr_len>5){
		$deletes[] = $r;
		$sql = "DELETE FROM tc_mall WHERE itemid='".$r['itemid']."'";
		$db->query($sql);
	}else{
		$uns[] = $r;
	}
}

if(isset($updates)){
	$o_updates = file_get_contents('mall_u.txt');
	$o_updates = json_decode($o_updates);
	if(!empty($o_updates)){
		$updates = array_merge($updates,$o_updates);
	}	
	$file = fopen('mall_u.txt', 'w');
	$updates = json_encode($updates);
	file_put_contents('mall_u.txt', $updates);
	fclose($file);
}

if(isset($deletes)){
	$o_deletes = file_get_contents('mall_d.txt');
	$o_deletes = json_decode($o_deletes);
	if(!empty($o_deletes)){
		$deletes = array_merge($deletes,$o_deletes);
	}	
	$file = fopen('mall_d.txt', 'w');
	$deletes = json_encode($deletes);
	file_put_contents('mall_d.txt', $deletes);
	fclose($file);
}
if(isset($uns)){
	$o_uns = file_get_contents('mall_uns.txt');
	$o_uns = json_decode($o_uns);
	if(!empty($o_uns)){
		$uns = array_merge($uns,$o_uns);
	}	
	$file = fopen('mall_uns.txt', 'w');
	$uns = json_encode($uns);
	file_put_contents('mall_uns.txt', $uns);
	fclose($file);
}
?>