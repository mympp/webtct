<?php
defined('DT_ADMIN') or exit('Access Denied');
$menus = array (
    array('商品管理', '?moduleid='.$moduleid),
    array('订单管理', '?moduleid='.$moduleid.'&file='.$file),
    array('快递管理', '?moduleid='.$moduleid.'&file='.$file.'&action=express'),
    array('统计报表', '?moduleid='.$moduleid.'&file='.$file.'&action=stats'),
);
include load('order.lang');
$_status = $L['trade_status'];
$dstatus = $L['trade_dstatus'];
$_send_status = $L['send_status'];
$dsend_status = $L['send_dstatus'];
$STARS = $L['star_type'];
$table = $DT_PRE.'mall_order';
if($action == 'refund' || $action == 'show' || $action == 'comment') {
	$itemid or msg('未指定记录');
	$td = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid");
	$td or msg('记录不存在');
	$td['mid'] == $moduleid or msg('记录不存在');
	$td['linkurl'] = DT_PATH.'api/redirect.php?mid='.$td['mid'].'&itemid='.$td['mallid'];
	$td['money'] = $td['amount'] + $td['fee'];
	$td['adddate'] = timetodate($td['addtime'], 6);
	$td['updatedate'] = timetodate($td['updatetime'], 6);
	$td['eprice_time'] = timetodate($td['eprice_time'], 6);
	$td['confirm_time'] = timetodate($td['confirm_time'], 6);
	$td['send_time'] = timetodate($td['send_time'], 6);
	$td['par'] = '';
	if(strpos($td['note'], '|') !== false) list($td['note'], $td['par']) = explode('|', $td['note']);
}
switch($action) {
	case 'stats':
		$year = isset($year) ? intval($year) : date('Y', $DT_TIME);
		$year or $year = date('Y', $DT_TIME);
		$month = isset($month) ? intval($month) : date('n', $DT_TIME);
		isset($seller) or $seller = '';
		$chart_data = '';
		$T1 = $T2 = $T3 = 0;
		if($month) {
			$L = date('t', strtotime($year.'-'.$month.'-01'));
			for($i = 1; $i <= $L; $i++) {
				if($i > 1) $chart_data .= '\n';
				$chart_data .= $i;
				$F = strtotime($year.'-'.$month.'-'.$i.' 00:00:00');
				$T = strtotime($year.'-'.$month.'-'.$i.' 23:59:59');
				$condition = "mid=$moduleid AND addtime>=$F AND addtime<=$T";
				if($seller) $condition .= " AND seller='$seller'";
				$t = $db->get_one("SELECT SUM(`amount`) AS num1,SUM(`fee`) AS num2 FROM {$table} WHERE {$condition} AND status=4");
				$num1 = $t['num1'] ? dround($t['num1']) : 0;
				$num2 = $t['num2'] ? dround($t['num2']) : 0;
				$num = $num1 + $num2;
				$chart_data .= ';'.$num;
				$T1 += $num;
				$t = $db->get_one("SELECT SUM(`amount`) AS num1,SUM(`fee`) AS num2 FROM {$table} WHERE {$condition} AND status=6");
				$num1 = $t['num1'] ? dround($t['num1']) : 0;
				$num2 = $t['num2'] ? dround($t['num2']) : 0;
				$num = $num1 + $num2;
				$chart_data .= ';'.$num;
				$T2 += $num;
				$t = $db->get_one("SELECT SUM(`amount`) AS num1,SUM(`fee`) AS num2 FROM {$table} WHERE {$condition} AND status=7");
				$num1 = $t['num1'] ? dround($t['num1']) : 0;
				$num2 = $t['num2'] ? dround($t['num2']) : 0;
				$num = $num1 + $num2;
				$chart_data .= ';'.$num;
				$T3 += $num;
			}
			$title = $year.'年'.$month.'月交易报表';
			if($seller) $title = '['.$seller.'] '.$title;
		} else {
			for($i = 1; $i < 13; $i++) {
				if($i > 1) $chart_data .= '\n';
				$chart_data .= $i;
				$F = strtotime($year.'-'.$i.'-01 00:00:00');
				$T = strtotime($year.'-'.$i.'-'.date('t', $F).' 23:59:59');
				$condition = "mid=$moduleid AND addtime>=$F AND addtime<=$T";
				if($seller) $condition .= " AND seller='$seller'";
				$t = $db->get_one("SELECT SUM(`amount`) AS num1,SUM(`fee`) AS num2 FROM {$table} WHERE {$condition} AND status=4");
				$num1 = $t['num1'] ? dround($t['num1']) : 0;
				$num2 = $t['num2'] ? dround($t['num2']) : 0;
				$num = $num1 + $num2;
				$chart_data .= ';'.$num;
				$T1 += $num;
				$t = $db->get_one("SELECT SUM(`amount`) AS num1,SUM(`fee`) AS num2 FROM {$table} WHERE {$condition} AND status=6");
				$num1 = $t['num1'] ? dround($t['num1']) : 0;
				$num2 = $t['num2'] ? dround($t['num2']) : 0;
				$num = $num1 + $num2;
				$chart_data .= ';'.$num;
				$T2 += $num;
				$t = $db->get_one("SELECT SUM(`amount`) AS num1,SUM(`fee`) AS num2 FROM {$table} WHERE {$condition} AND status=7");
				$num1 = $t['num1'] ? dround($t['num1']) : 0;
				$num2 = $t['num2'] ? dround($t['num2']) : 0;
				$num = $num1 + $num2;
				$chart_data .= ';'.$num;
				$T3 += $num;
			}
			$title = $year.'年交易报表';
			if($seller) $title = '['.$seller.'] '.$title;
		}
		include tpl('order_stats', $module);
	break;
	case 'refund':
		if($td['status'] != 5) msg('此交易无需受理');
		if($submit) {
			isset($status) or msg('请指定受理结果');
			strlen($content) > 5 or msg('请填写操作理由');
			$content .= '[网站]';
			clear_upload($content);
			$content = dsafe(addslashes(save_remote(save_local(stripslashes($content)))));
			if($status == 6) {//已退款，买家胜 退款
				money_add($td['buyer'], $td['money']);
				money_record($td['buyer'], $td['money'], $L['in_site'], 'system', '订单退款', '单号:'.$itemid.'[网站]');
				$_msg = '受理成功，交易状态已经改变为 已退款给买家';
				//更新商品数据 增加库存
				if($td['mid'] == 16) {
					$db->query("UPDATE {$DT_PRE}mall SET orders=orders-1,sales=sales-$td[number],amount=amount+$td[number] WHERE itemid=$itemid");
				} else {
					$db->query("UPDATE ".get_table($td['mid'])." SET amount=amount+$td[number] WHERE itemid=$itemid");
				}
			} else if($status == 4) {//已退款，卖家胜 付款
				money_add($td['seller'], $td['money']);
				money_record($td['seller'], $td['money'], $L['in_site'], 'system', '交易成功', '单号:'.$itemid.'[网站]');
				//网站服务费
				$G = $db->get_one("SELECT groupid FROM {$DT_PRE}member WHERE username='".$td['seller']."'");
				$SG = cache_read('group-'.$G['groupid'].'.php');
				if($SG['commission']) {
					$fee = dround($money*$SG['commission']/100);
					if($fee > 0) {
						money_add($td['seller'], -$fee);
						money_record($td['seller'], -$fee, $L['in_site'], 'system', $L['trade_fee'], $L['trade_order_id'].$itemid);	
					}
				}
				$_msg = '受理成功，交易状态已经改变为 交易成功';
			} else {
				msg();
			}
			$db->query("UPDATE {$table} SET status=$status,editor='$_username',updatetime=$DT_TIME,refund_reason='$content' WHERE itemid=$itemid");
			$msg = isset($msg) ? 1 : 0;
			$eml = isset($eml) ? 1 : 0;
			$sms = isset($sms) ? 1 : 0;
			$wec = isset($wec) ? 1 : 0;
			if($msg == 0) $sms = $wec = 0;
			if($msg || $eml || $sms || $wec) {
				$reason = $content;
				$linkurl = $MODULE[2]['linkurl'].'trade.php?action=update&step=detail&itemid='.$itemid;

				$result = ($status == 6 ? '退款成功' : '退款失败');
				$subject = '您的[订单]'.dsubstr($td['title'], 30, '...').'(单号:'.$td['itemid'].')'.$result;
				$content = '尊敬的会员：<br/>您的[订单]'.$td['title'].'(单号:'.$td['itemid'].')'.$result.'！<br/>';
				if($reason) $content .= '操作原因：<br/>'.$reason.'<br/>';
				$content .= '请点击下面的链接查看订单详情：<br/>';
				$content .= '<a href="'.$linkurl.'" target="_blank">'.$linkurl.'</a><br/>';
				$content .= '如果您对此操作有异议，请及时与网站联系。<br/>';
				$user = userinfo($td['buyer']);
				if($msg) send_message($user['username'], $subject, $content);
				if($eml) send_mail($user['email'], $subject, $content);
				if($sms) send_sms($user['mobile'], $subject.$DT['sms_sign']);
				if($wec) send_weixin($user['username'], $subject);

				$result = ($status == 6 ? '已经退款给买家' : '未退款给买家，交易成功');
				$subject = '您的[订单]'.dsubstr($td['title'], 30, '...').'(单号:'.$td['itemid'].')'.$result;
				$content = '尊敬的会员：<br/>您的[订单]'.$td['title'].'(单号:'.$td['itemid'].')'.$result.'！<br/>';
				if($reason) $content .= '操作原因：<br/>'.$reason.'<br/>';
				$content .= '请点击下面的链接查看订单详情：<br/>';
				$content .= '<a href="'.$linkurl.'" target="_blank">'.$linkurl.'</a><br/>';
				$content .= '如果您对此操作有异议，请及时与网站联系。<br/>';
				$user = userinfo($td['seller']);
				if($msg) send_message($user['username'], $subject, $content);
				if($eml) send_mail($user['email'], $subject, $content);
				if($sms) send_sms($user['mobile'], $subject.$DT['sms_sign']);
				if($wec) send_weixin($user['username'], $subject);
			}
			msg($_msg, $forward, 3);
		} else {
			include tpl('order_refund', $module);
		}
	break;
	case 'show':
		if($td['mid'] == 16) {
			$cm = $db->get_one("SELECT * FROM {$DT_PRE}mall_comment WHERE itemid=$itemid");
		} else {
			$cm = array();
		}
		include tpl('order_show', $module);
	break;
	case 'comment':
		$td['mid'] == 16 or msg('此订单不支持评价');
		$cm = $db->get_one("SELECT * FROM {$DT_PRE}mall_comment WHERE itemid=$itemid");
		$cm or msg('评论不存在');
		$mallid = $td['mallid'];
		$post['seller_ctime'] = $post['seller_ctime'] ? strtotime($post['seller_ctime']) : 0;
		$post['seller_rtime'] = $post['seller_rtime'] ? strtotime($post['seller_rtime']) : 0;
		$post['buyer_ctime'] = $post['buyer_ctime'] ? strtotime($post['buyer_ctime']) : 0;
		$post['buyer_rtime'] = $post['buyer_rtime'] ? strtotime($post['buyer_rtime']) : 0;
		if($cm['seller_star'] != $post['seller_star']) {
			$s = $post['seller_star'];
			$s1 = 's'.$cm['seller_star'];
			$s2 = 's'.$post['seller_star'];
			$db->query("UPDATE {$DT_PRE}mall_order SET seller_star=$s WHERE itemid=$itemid");
			$db->query("UPDATE {$DT_PRE}mall_stat SET `$s2`=`$s2`+1 WHERE mallid=$mallid");
			if($cm['seller_star']) $db->query("UPDATE {$DT_PRE}mall_stat SET `$s1`=`$s1`-1 WHERE mallid=$mallid");
		}
		if($cm['buyer_star'] != $post['buyer_star']) {
			$s = $post['buyer_star'];
			$s1 = 'b'.$cm['buyer_star'];
			$s2 = 'b'.$post['buyer_star'];
			$db->query("UPDATE {$DT_PRE}mall_order SET buyer_star=$s WHERE itemid=$itemid");
			$db->query("UPDATE {$DT_PRE}mall_stat SET `$s2`=`$s2`+1 WHERE mallid=$mallid");
			if($cm['buyer_star']) $db->query("UPDATE {$DT_PRE}mall_stat SET `$s1`=`$s1`-1 WHERE mallid=$mallid");
		}
		$sql = '';
		foreach($post as $k=>$v) {
			$sql .= ",$k='$v'";
		}
        $sql = substr($sql, 1);
	    $db->query("UPDATE {$DT_PRE}mall_comment SET $sql WHERE itemid=$itemid");
		money_record($username, $amount, $bank, $_username, $reason, $note);
		money_add($username, -$amount);
		msg('修改成功', '?moduleid='.$moduleid.'&file='.$file.'&action=show&itemid='.$itemid.'#comment1');
	break;
	case 'delete':
		$itemid or msg('未选择记录');
		$itemids = is_array($itemid) ? implode(',', $itemid) : $itemid;
		$db->query("DELETE FROM {$table} WHERE itemid IN ($itemids) AND mid=$moduleid");
		dmsg('删除成功', $forward);
	break;
	case 'upf':
		$itemid or msg('未选择记录');
	    $payto=$_REQUEST['payto'];
		if($payto>0&&$status>0){
		$db->query("UPDATE {$DT_PRE}mall_order SET f_content='$f_content',f_send=f_send+$payto WHERE itemid=$itemid");
        $db->query("UPDATE {$DT_PRE}mall_order SET status=2 WHERE itemid=$itemid and status=1");
		money_record($buyer,$payto,'现金', $_username,'财务已经将订单T'.$itemid.'的回款信息回馈给您','充值');
		money_add($buyer,$payto);
		money_record($buyer,-$payto,'现金', $_username,'财务已经将您的账号根据订单T'.$itemid.'的回款进行扣减','扣减');
		money_add($buyer,-$payto);
		money_record($touser,$payto,'现金', $_username,'财务已经将订单T'.$itemid.'的回款信息回馈给您','锁定');
		money_lock($touser,$payto);
		send_message($touser,'财务已经将订单T'.$itemid.'的回款信息回馈给您!','点击链接查看详细内容:<a href="trade.php?itemid='.$itemid.'">订单T'.$itemid.'的回款信息</a>');
		msg('提交成功', '?moduleid='.$moduleid.'&file='.$file.'&action=show&itemid='.$itemid);
		}
		else
	   {msg('提交失败！回款为零或卖家未确认订单！', '?moduleid='.$moduleid.'&file='.$file.'&action=show&itemid='.$itemid);}
		
	break;
	case 'upt':
		$itemid or msg('未选择记录');
	    $payto=$_REQUEST['payto'];
		$db->query("UPDATE {$DT_PRE}mall_order SET f_pay=1 WHERE itemid=$itemid");
		send_message($touser,'财务已经将订单T'.$itemid.'的支配单回馈给您!','已经进行了支配单的相关操作，详情请看天成币流水');
		msg('提交成功', '?moduleid='.$moduleid.'&file='.$file.'&action=show&itemid='.$itemid);	
	break;
	case 'express':
		$sfields = array('按条件', '商品名称', '卖家', '买家', '订单金额', '附加金额', '附加名称', '买家名称', '买家地址', '买家邮编', '买家电话', '买家手机', '发货快递', '发货单号', '备注');
		$dfields = array('title', 'title', 'seller', 'buyer', 'amount', 'fee', 'fee_name', 'buyer_name', 'buyer_address', 'buyer_postcode', 'buyer_phone', 'buyer_mobile', 'send_type', 'send_no', 'note');
		isset($fields) && isset($dfields[$fields]) or $fields = 0;
		$status = isset($status) && isset($dsend_status[$status]) ? intval($status) : '';
		$itemid or $itemid = '';
		$mallid = isset($mallid) && $mallid ? intval($mallid) : '';
		isset($seller) or $seller = '';
		isset($buyer) or $buyer = '';
		isset($send_no) or $send_no = '';
		$fields_select = dselect($sfields, 'fields', '', $fields);
		$status_select = dselect($dsend_status, 'status', '状态', $status, '', 1, '', 1);
		$condition = "mid=$moduleid AND send_no<>''";
		if($keyword) $condition .= " AND $dfields[$fields] LIKE '%$keyword%'";
		if($status !== '') $condition .= " AND send_status='$status'";
		if($seller) $condition .= " AND seller='$seller'";
		if($buyer) $condition .= " AND buyer='$buyer'";
		if($itemid) $condition .= " AND itemid=$itemid";
		if($mallid) $condition .= " AND mallid=$mallid";
		if($send_no) $condition .= " AND send_no='$send_no'";
		if($page > 1 && $sum) {
			$items = $sum;
		} else {
			$r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE $condition");
			$items = $r['num'];
		}
		$pages = pages($items, $page, $pagesize);	
		$lists = array();
		$result = $db->query("SELECT * FROM {$table} WHERE $condition ORDER BY itemid DESC LIMIT $offset,$pagesize");
		while($r = $db->fetch_array($result)) {
			$r['addtime'] = timetodate($r['addtime'], 5);
			$r['updatetime'] = timetodate($r['updatetime'], 5);
			$lists[] = $r;
		}
		include tpl('order_express', $module);
	break;
	case 'edit':
		$itemid or msg('未选择记录');
		if($submit){
			$status = isset($edit['status']) ? $edit['status'] : 0;
			$item_str = '';
			if(is_array($itemid)){
				$item_str = implode(',',$itemid);
				$edit['status'] = $status;
				$edit['kefu_result'] = '';
				$forward = '?moduleid='.$moduleid.'&file='.$file;
			}else{
				$item_str = $itemid;
				$forward = '?moduleid='.$moduleid.'&file='.$file.'&action=show&itemid='.$itemid;
			}
			$db->query("update {$table} set status = $edit[status],kefu_status = $edit[kefu_status],kefu_remark='$edit[kefu_remark]',kefu_result='$edit[kefu_result]' where itemid in ($item_str)");
			msg('修改成功', $forward);	
		}else{
			dmsg('地址错误');
		}
		
	break;
	default:
		$sfields = array('按条件', '商品名称', '卖家', '买家', '订单金额', '附加金额', '附加名称', '买家名称', '买家地址', '买家邮编', '买家电话', '买家手机', '发货快递', '发货单号', '备注');
		$dfields = array('title', 'title', 'seller', 'buyer', 'amount', 'fee', 'fee_name', 'buyer_name', 'buyer_address', 'buyer_postcode', 'buyer_phone', 'buyer_mobile', 'send_type', 'send_no', 'note');
		$sorder  = array('排序方式', '下单时间降序', '下单时间升序', '更新时间降序', '更新时间升序', '商品单价降序', '商品单价升序', '购买数量降序', '购买数量升序', '订单金额降序', '订单金额升序', '附加金额降序', '附加金额升序');
		$dorder  = array('itemid DESC', 'addtime DESC', 'addtime ASC', 'updatetime DESC', 'updatetime ASC', 'price DESC', 'price ASC', 'number DESC', 'number ASC', 'amount DESC', 'amount ASC', 'fee DESC', 'fee ASC');
		isset($fields) && isset($dfields[$fields]) or $fields = 0;
		$status = isset($status) && isset($dstatus[$status]) ? intval($status) : '';
		$itemid or $itemid = '';
		$mallid = isset($mallid) && $mallid ? intval($mallid) : '';
		$id = isset($id) ? intval($id) : 0;
		$seller_star = isset($seller_star) ? intval($seller_star) : 0;
		$buyer_star = isset($buyer_star) ? intval($buyer_star) : 0;
		isset($seller) or $seller = '';
		isset($buyer) or $buyer = '';
		isset($amounts) or $amounts = '';
		isset($fromtime) or $fromtime = '';
		isset($totime) or $totime = '';
		isset($dfromtime) or $dfromtime = '';
		isset($dtotime) or $dtotime = '';
		isset($timetype) or $timetype = 'addtime';
		isset($mtype) or $mtype = 'money';
		isset($minamount) or $minamount = '';
		isset($maxamount) or $maxamount = '';
		isset($order) && isset($dorder[$order]) or $order = 0;
		$fields_select = dselect($sfields, 'fields', '', $fields);
		$status_select = dselect($dstatus, 'status', '状态', $status, 'style="width:200px;"', 1, '', 1);
		$order_select = dselect($sorder, 'order', '', $order);
		$condition = "mid=$moduleid";
		if($keyword) $condition .= " AND $dfields[$fields] LIKE '%$keyword%'";
		if($fromtime) $condition .= " AND $timetype>".(strtotime($fromtime.' 00:00:00'));
		if($totime) $condition .= " AND $timetype<".(strtotime($totime.' 23:59:59'));
		if($status !== '') $condition .= " AND status='$status'";
		if($seller) $condition .= " AND seller='$seller'";
		if($buyer) $condition .= " AND buyer='$buyer'";
		if($itemid) $condition .= " AND itemid=$itemid";
		if($mallid) $condition .= " AND mallid=$mallid";
		if($id) $condition .= " AND mallid=$id";
		if($seller_star) $condition .= " AND seller_star=$seller_star";
		if($buyer_star) $condition .= " AND buyer_star=$buyer_star";
		if($mtype == 'money') $mtype = "`amount`+`fee`";
		if($minamount != '') $condition .= " AND $mtype>=$minamount";
		if($maxamount != '') $condition .= " AND $mtype<=$maxamount";
		
		//判断是否显示查看过期限未确认的订单
		if($over_check == '1'){
			$wait_hours = $MOD['order_wait_check'];
			$wait_time = (int)$wait_hours * 3600;
			$nowtime = time();
			$condition .= " AND status = 0";
			$condition .= " AND ($nowtime - addtime) > $wait_time";
		} 
		//判断是否显示查看完成时限内未结束的订单
		if($over_finish == '1'){
			$wait_hours = $MOD['order_wait_finish'];
			$wait_time = (int)$wait_hours * 3600;
			$nowtime = time();
			$condition .= " AND status not in (0,4,8,9)";
			$condition .= " AND ($nowtime - updatetime) > $wait_time";
		}
		if($kefu_status){
			$condition .=" AND kefu_status = $kefu_status";
		}elseif($kefu_status == '0'){
			$condition .=" AND kefu_status = 0";
		}
		
		if($page > 1 && $sum) {
			$items = $sum;
		} else {
			$r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE $condition");
			$items = $r['num'];
		}
		$pages = pages($items, $page, $pagesize);	
		$lists = array();
		$result = $db->query("SELECT * FROM {$table} WHERE $condition ORDER BY $dorder[$order] LIMIT $offset,$pagesize");
		$amount = $fee = $money = 0;
		while($r = $db->fetch_array($result)) {
			if($over_check == '1'){
				$wait_hours = $MOD['order_wait_check'];
				$wait_time = (int)$wait_hours * 3600;
				$endtime = (int)$r['addtime'] + $wait_time;
				$r['endtime'] = str_replace(' ','<br/>',timetodate($endtime,5));
			}
			if($over_finish == '1'){
				$wait_hours = $MOD['order_wait_finish'];
				$wait_time = (int)$wait_hours * 3600;
				$endtime = (int)$r['updatetime'] + $wait_time;
				$r['endtime'] = str_replace(' ','<br/>',timetodate($endtime,5));
			}
			
			$r['addtime'] = str_replace(' ', '<br/>', timetodate($r['addtime'], 5));
			$r['updatetime'] = str_replace(' ', '<br/>', timetodate($r['updatetime'], 5));
			$r['linkurl'] = DT_PATH.'api/redirect.php?mid='.$r['mid'].'&itemid='.$r['mallid'];
			$r['dstatus'] = $_status[$r['status']];
			$r['money'] = $r['amount'] + $r['fee'];
			
			$amount += $r['amount'];
			$fee += $r['fee'];
			$lists[] = $r;
		}
		$money = $amount + $fee;
		include tpl('order', $module);
	break;
}
?>