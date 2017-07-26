<?php 
defined('IN_DESTOON') or exit('Access Denied');
login();
isset($MODULE[6]) or dheader($MODULE[2]['linkurl']);
require DT_ROOT.'/module/'.$module.'/common.inc.php';
require DT_ROOT.'/include/post.func.php';
$timenow = timetodate($DT_TIME, 3);
$memberurl = $MOD['linkurl'];
$myurl = userurl($_username);
$table = $DT_PRE.'buy_pur_6';
if($action == 'update') {
	$itemid or message();
	$td = $db->get_one("SELECT * FROM {$table} a,{$DT_PRE}buy_pur_data_6 b WHERE a.itemid=b.itemid and a.itemid=$itemid");
	$td or message($L['group_msg_null']);
	if($td['touser'] != $_username) message($L['group_msg_deny']);
	$td['adddate'] = timetodate($td['addtime'], 5);
	$td['updatedate'] = timetodate($td['updatetime'], 5);
	$td['linkurl'] = $EXT['linkurl'].'redirect.php?mid=6&itemid='.$td['buyitemid'];
	$nav = $_username == $td['buyer_name'] ? 'action_order' : 'action';
	switch($step) {
		case 'detail'://详细内容
			$db->query("UPDATE {$table} SET status=2,updatetime=$DT_TIME WHERE itemid=$itemid and status=1");
			$td['total'] = $td['amount'];
			$head_title = '收到的采购招标的订单信息';
		break;
		case 'save'://保存采购修改内容
			$status=$post['status'];
			$forward='purchase.php';
			$send_type=$post['send_type'];
			$send_no=$post['send_no'];
			$send_time=strtotime($post['send_time']);
			$send_note=$post['send_note'];
			if($td['status']==2&&$post['status']==2){$status=3;}
			if($send_no){$status=3;}
			$db->query("UPDATE {$table} SET send_type='$send_type',send_no='$send_no',send_time=$send_time,send_note='$send_note',status=$status,updatetime=$DT_TIME WHERE itemid=$itemid");
		    if($td['send_no']!=$send_no&&$send_no){//确定发货按发货单号为准
				$title=$td['title'].'的采购单，中标方已经发货，请注意查收！';
				$content='天成医疗网会员：'.$td['touser'].'针对'.$td['title'].'-已经确定订单，并发货！请及时查收！如若双方无误，未及时在线确认，30天后系统会将订单自动成交并结束！<br><div  class="addsupply"><a href="my.php?mid=6&action=purlist">点击进入采购招标管理</a></div>';
				$db->query("update {$DT_PRE}buy_6 SET step=3 WHERE itemid=".$td['buyitemid']);
				send_message($td['username'],$title,$content, 4, $_username);
			}
			message('更新采购订单信息成功', $forward);
		break;
	}
} 
if($action == 'supply') {//查看应标供应信息
	$buyitemid = $post['buyitemid'];
		$condition = ' and itemid>0 ';
			if($kw) $condition .= " AND title LIKE '%$kw%'";
			if($buyitemid) $condition .= " AND buyitemid=$buyitemid";
					$r = $db->get_one("SELECT COUNT(*) AS num FROM {$DT_PRE}buy_supplyinfo_6 ");
					$pages = pages($r['num'], $page, $pagesize);
					$lists = array();
					$result = $db->query("SELECT * FROM {$DT_PRE}buy_supplyinfo_6  where  fromuser='$_username' ".$condition." ORDER BY itemid DESC LIMIT $offset,$pagesize");
					while($r = $db->fetch_array($result)) {
						$itemid = $r['buyitemid'];
						$d = $db->get_one("SELECT * FROM {$DT_PRE}buy_6  WHERE itemid=$itemid");
						$r['buycode']=$d['buycode'];
						$r['bitemid']=$d['itemid'];
						$r['btitle']=$d['title'];
						$r['bselitemid']=$d['selitemid'];
						$r['step']=$d['step'];
						$r['linkurl'] = $MOD['linkurl'].$d['linkurl'];
						$lists[] = $r;
					}
}elseif($action == 'supplyinfo') {//应标详细内容
						$condition = ' and itemid='.$itemid;
						$t = $db->get_one("SELECT * FROM {$DT_PRE}buy_supplyinfo_6  WHERE itemid>0 and fromuser='$_username'".$condition);
						if($t){$c = $db->get_one("SELECT * FROM {$DT_PRE}buy_6  WHERE itemid=".$t['buyitemid']);}
}else {
	$dfields = array('title', 'amount', 'buyer', 'buyer_name', 'buyer_address', 'buyer_postcode', 'buyer_mobile', 'buyer_phone', 'send_type', 'send_no', 'note');
	(isset($buyer) && check_name($buyer)) or $buyer = '';
	isset($fields) && isset($dfields[$fields]) or $fields = 0;
	isset($fromtime) or $fromtime = '';
	isset($totime) or $totime = '';
	$fields_select = dselect($sfields, 'fields', '', $fields);
	$buyitemid = $post['buyitemid'];
	$condition = "touser='$_username'";
	if($keyword) $condition .= " AND title LIKE '%$keyword%'";
	if($fromtime) $condition .= " AND addtime>".(strtotime($fromtime.' 00:00:00'));
	if($totime) $condition .= " AND addtime<".(strtotime($totime.' 23:59:59'));
	if($status != '') $condition .= " AND status='$status'";
	if($itemid) $condition .= " AND itemid=$itemid";
	if($buyitemid) $condition .= " AND buyitemid=$buyitemid";
	if($buyer) $condition .= " AND buyer_name='$buyer'";
	$r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE $condition");
	$pages = pages($r['num'], $page, $pagesize);		
	$groups = array();
	$result = $db->query("SELECT * FROM {$table} WHERE $condition ORDER BY itemid DESC LIMIT $offset,$pagesize");
	$amount = $fee = $money = 0;
	while($r = $db->fetch_array($result)) {
		$r['addtime'] = str_replace(' ', '<br/>', timetodate($r['addtime'], 5));
		$r['updatetime'] = str_replace(' ', '<br/>', timetodate($r['updatetime'], 5));
		$r['linkurl'] = $EXT['linkurl'].'redirect.php?mid=6&itemid='.$r['buyitemid'];
		$amount += $r['amount'];
		$money = $r['price'];
		$groups[] = $r;
	}
	$money = number_format($money, 2, '.', '');
	$forward = urlencode($DT_URL);
	$head_title = '收到的采购招标的订单信息';
}
include template('purchase', $module);
?>