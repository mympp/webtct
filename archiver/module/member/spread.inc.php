<?php 
defined('IN_DESTOON') or exit('Access Denied');
login();
require DT_ROOT.'/module/'.$module.'/common.inc.php';
require DT_ROOT.'/include/post.func.php';
$MG['spread'] or dalert(lang('message->without_permission_and_upgrade'), 'goback');
include load('extend.lang');


$this_month = date('n', $DT_TIME);
$this_year  = date('Y', $DT_TIME);
$next_month = $this_month == 12 ? 1 : $this_month + 1;
$next_year  = $this_month == 12 ? $this_year + 1 : $this_year;
$next_time = strtotime($next_year.'-'.$next_month.'-1');
$spread_max = $EXT['spread_max'] ? $EXT['spread_max'] : 10;
$currency = $EXT['spread_currency'];
$unit = $currency == 'money' ? $DT['money_unit'] : $DT['credit_unit'];
$month = $EXT['spread_month'] ? $EXT['spread_month'] : 1;
$step = $EXT['spread_step'];

$status = isset($status)? $status : 3;
if($status == 3) $stype = isset($stype) ? $stype : 1;

//包月类型的推广只能一个月
$buy_month = 1;
//点击扣费类型参数
$spend = isset($spend) ? $spend : '' ;
$least = isset($least) ? $least : '' ;

//信息类型
$type_data=$db->query("select * from {$db->pre}sogex_info_type");
$type=array();
while($v=$db->fetch_array($type_data)){
	$type[$v['catid']]=$v;
}

//排名价格
$index_data=$db->get_one("select * from {$db->pre}setting where item_key = 'spread_index_price'");
$index_price=$index_data['item_value'];
$all_data=$db->get_one("select * from {$db->pre}setting where item_key = 'spread_all_price'");
$all_price=$all_data['item_value'];
$type_data=$db->get_one("select * from {$db->pre}setting where item_key = 'spread_type_price'");
$type_price=$type_data['item_value'];


if($submit){
	switch($action){
		case 'add':
			$word = dhtmlspecialchars(trim($word));
			
			if($stype == '1'){
			$price=$index_price;          //起价
			switch($mid){
				case '99': $price = $index_price; break;
				case '0':  $price = $all_price; break;
				default:   $price = $type_price; break;
			}
			if(intval($buy_price )<intval($price) ) msg('出价不可比起价低');
			}
			
			//已经购买了该词，且还在使用
			$r = $db->get_one("SELECT * FROM {$DT_PRE}spread WHERE username='$_username' AND mid=$mid AND word='$word' AND fromtime>=$next_time");
			if($r) message($L['spread_msg_buy'], $EXT['spread_url']);
			
			//购买数量超过限制
			$r = $db->get_one("SELECT COUNT(*) AS num FROM {$DT_PRE}spread WHERE mid=$mid AND status=3 AND word='$word' AND fromtime>=$next_time");
			if($r['num'] > $spread_max) message(lang($L['spread_msg_over'], array($word)), $EXT['spread_url']);
			

			//计算不同类型的扣除费用
			if($stype == '1'){         //包月方式的费用计算
				if(($buy_price-$price)%$step != 0) message($L['spread_msg_step']);
				$buy_month = intval($buy_month);
				if($buy_month < 1 || $buy_month > $month) message($L['spread_msg_month']);
				$amount = $buy_price*$buy_month;
				//包月类型强制赋值least为1，spend为0，确保符合least 大于 spend
				$spend = 0;
				$least = 1;
			}elseif($stype == '2'){      //每条点击的费用计算
				$amount = $least;
			}

			if($currency == 'money') {
				if($amount > $_money) message($L['money_not_enough'], $MODULE[2]['linkurl'].'charge.php?action=pay&amount='.($amount-$_money));
				is_payword($_username, $password) or message($L['error_payword']);
			} else {
				if($amount > $_credit) message($L['credit_not_enough'], $MODULE[2]['linkurl'].'trade.php?action=credit');
			}
			$months = $next_month + $buy_month;
			$year = floor($months/12);
			if($months%12 == 0) {
				$to_month = 12;
				$to_year = $next_year + $year - 1;
			} else {
				$to_month = $months%12;
				$to_year = $next_year + $year;
			}
			$buy_tid=$ideaid;

			$idead = $db->get_one("select score from {$db->pre}sogex_ideas where ideas =  $ideaid");
			$total = intval($idead['score'])+intval($price);			

			$totime = strtotime($to_year.'-'.$to_month.'-1');
			$status = 2;
			if($currency == 'money') {
				money_add($_username, -$amount);
				money_record($_username, -$amount, $L['in_site'], 'system', $MODULE[$mid]['name'].$L['spread_title'], $word.'('.$L['spread_infoid'].$buy_tid.')');
			} else {
				credit_add($_username, -$amount);
				credit_record($_username, -$amount, 'system', $MODULE[$mid]['name'].$L['spread_title'], $word.'(ID:'.$buy_tid.')');
			}
			$db->query("INSERT INTO {$DT_PRE}spread (mid,tid,word,price,currency,company,username,addtime,fromtime,totime,status,total,spend,least,stype) VALUES ('$mid','$buy_tid','$word','$buy_price','$currency','$_company','$_username','$DT_TIME','$next_time','$totime','$status','$total','$spend','$least','$stype')");
			dmsg($L['spread_msg_success'], '?status='.$status);
			
		break;
		case 'edit':
			$word = dhtmlspecialchars(trim($word));
			$amount = $recharge;		//充值数目
			if($amount){	//处理充值
				if($currency == 'money') {
					if($amount > $_money) message($L['money_not_enough'], $MODULE[2]['linkurl'].'charge.php?action=pay&amount='.($amount-$_money));
					is_payword($_username, $password) or message($L['error_payword']);
				} else {
					if($amount > $_credit) message($L['credit_not_enough'], $MODULE[2]['linkurl'].'trade.php?action=credit');
				}
				if($currency == 'money') {
					money_add($_username, -$amount);
					money_record($_username, -$amount, $L['in_site'], 'system', $MODULE[$mid]['name'].$L['spread_title'], $word.'('.$L['spread_infoid'].$buy_tid.')');
				} else {
					credit_add($_username, -$amount);
					credit_record($_username, -$amount, 'system', $MODULE[$mid]['name'].$L['spread_title'], $word.'(ID:'.$buy_tid.')');
				}
			}
			$sp = $db->get_one("select least from {$DT_PRE}spread where itemid = $itemid");
			$least = intval($sp['least'])+intval($amount);
			$db->query("update {$DT_PRE}spread set mid = $mid,tid = $ideaid,word = '$word',status = 2,spend = $spend,least = $least where itemid = $itemid");
			dmsg('修改完成，请等待审核', '?status=2');
		break;
	}
}else{
	switch($action){
	case 'link':	//页面跳转
		$url=$db->get_one("select url from {$db->pre}sogex_ideas where ideaid = $itemid");
		header("Location:".$url['url']);
	break;
	case 'spread_change':	//修改推广的推广状态
		$db->query("update {$db->pre}spread set spread_status = $spread_status where itemid = $itemid");
		dmsg(($spread_status == '3'?'推广启动':'推广停用').'成功','spread.php?status=3&stype=2');
	break;
	case 'edit':	//排名充值
		$sp = $db->get_one("select * from {$db->pre}spread where itemid = $itemid");
		extract($sp);
		
	break;
	case 'delete':
		$sp = $db->get_one("select status from {$db->pre}spread where itemid = $itemid");
		if($sp['status'] == '1'){		//判断状态，只有状态为1表示被管理员拒绝才能删除，
			$db->query("delete from {$DT_PRE}spread where itemid = $itemid");
			dmsg('推广删除成功','spread.php?status=3');
		}
		dmsg('推广删除失败');
	break;
	case 'search':
		if($word){
		$condition = "status = 3 and stype = 1 and word = '$word'";
		$result = $db->query("SELECT * FROM {$DT_PRE}spread WHERE $condition ORDER BY itemid DESC LIMIT $offset,$pagesize");
		$mlists=array();
		while($r = $db->fetch_array($result)) {
			if($r['totime'] < $DT_TIME) {
				$r['process'] = $L['status_expired'];
			} else if($r['fromtime'] > $DT_TIME) {
				$r['process'] = $L['status_not_start'];
			} else {
				$r['process'] = $L['status_displaying'];
			}
				$r['days'] = $r['totime'] > $DT_TIME ? intval(($r['totime']-$DT_TIME)/86400) : 0;
			$mlists[] = $r;
		}
		
		$condition = "status = 3 and stype =2 and word = '$word'";
		$result = $db->query("SELECT * FROM {$DT_PRE}spread WHERE $condition ORDER BY itemid DESC LIMIT $offset,$pagesize");
		$slists=array();
		while($r = $db->fetch_array($result)){
			$slists[] = $r;
		}
		$r = $db->get_one("SELECT COUNT(*) AS num FROM {$DT_PRE}spread WHERE $condition");
		$pages = pages($r['num'], $page, $pagesize);
		
		}
	break;
	case 'record':
		$condition = "username = '$_username' and status = 3 ";
		$sid = $db->query("select itemid from {$db->pre}spread where $condition limit $offset , $pagesize");
		$sid_arr = array();
		while($v = $db->fetch_array($sid)){
			$sid_arr[] = $v['itemid'];
		}
		$sid_str = implode(',',$sid_arr);
		$sid_record = $db->query("select * from {$db->pre}spread_record where sid in ($sid_str)");
		$lists = array();
		while($v = $db->fetch_array($sid_record)){
			$lists[] = $v;
		}
		$r = $db->get_one("select count(*) as num from {$db->pre}spread_record where $condition");
		$pages = pages($r['num'],$page,$pagesize);
		
	break;
	case 'preview':
		$spread = $db->get_one("select * from {$db->pre}spread where itemid = $itemid");
		require_once DT_ROOT.'/module/search/common.func.php';	//引入通配符处理方法
		$idea = $db->get_one("select * from {$db->pre}sogex_ideas where ideaid = ".$spread['tid']);
		$kw = $spread['word'];
		include template('ideas_preview',$module);	
		exit;
	break;
	default:
	in_array($status, array(1,2,3)) or $status = 3;
	$condition = "username='$_username' AND status=$status";
	if(isset($stype)) $condition .=  " AND stype = $stype";
	$r = $db->get_one("SELECT COUNT(*) AS num FROM {$DT_PRE}spread WHERE $condition");
	$pages = pages($r['num'], $page, $pagesize);
	$lists = array();
	$result = $db->query("SELECT * FROM {$DT_PRE}spread WHERE $condition ORDER BY itemid DESC LIMIT $offset,$pagesize");
	while($r = $db->fetch_array($result)) {
		if($r['totime'] < $DT_TIME) {
			$r['process'] = $L['status_expired'];
		} else if($r['fromtime'] > $DT_TIME) {
			$r['process'] = $L['status_not_start'];
		} else {
			$r['process'] = $L['status_displaying'];
		}
			$r['days'] = $r['totime'] > $DT_TIME ? intval(($r['totime']-$DT_TIME)/86400) : 0;
		$lists[] = $r;
	}
	
	}
}

$head_title = $L['spread_title'];
$nums = array();
//统计推广数目

$n = $db->get_one("SELECT COUNT(*) AS num FROM {$DT_PRE}spread WHERE username='$_username' AND status=1");
$nums['reject'] = empty($n)? 0 : $n['num'];	//未通过推广
$n = $db->get_one("select count(*) as num from {$DT_PRE}spread where username = '$_username' and status = 2");
$nums['wait'] = empty($n) ? 0 : $n['num'];	//待审核数目
$n = $db->get_one("select count(*) as num from {$DT_PRE}spread where username='$_username' and status=3 and stype=1");
$nums['monthly']= empty($n) ? 0 : $n['num'];	//包月推广数目
$n = $db->get_one("select count(*) as num from {$DT_PRE}spread where username = '$_username' and status = 3 and stype = 2");
$nums['single'] = empty($n) ? 0 : $n['num'];  	//单条推广数目

include template('spread', $module);
?>
