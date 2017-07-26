<?php 
/*
date:2015-12-2
who:chentao
what:修改线下付款的数据写入（行89），买家确定收货时判断支付方式再进行资金和流水操作（行291-297）
where:行89，291-297
*/
defined('IN_DESTOON') or exit('Access Denied');
login();
isset($MODULE[16]) or dheader($MODULE[2]['linkurl']);
require DT_ROOT.'/module/'.$module.'/common.inc.php';
require DT_ROOT.'/include/post.func.php';
include load('order.lang');
$_status = $L['trade_status'];
$dstatus = $L['trade_dstatus'];
$_send_status = $L['send_status'];
$dsend_status = $L['send_dstatus'];
$step = isset($step) ? trim($step) : '';
$timenow = timetodate($DT_TIME, 3);
$memberurl = $MOD['linkurl'];
$myurl = userurl($_username);
$table = $DT_PRE.'mall_order';
$mtable = $DT_PRE.'member';
$childusername=$_childusername;
$STARS = $L['star_type'];
if($action == 'update') {
	$order_mb_id or message();
	#$td = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid");
	$td = $db->get_one("SELECT * FROM {$table} WHERE order_mb_id=$order_mb_id");
	$td or message($L['trade_msg_null']);
	if($td['buyer'] != $_username && $td['seller'] != $_username) message($L['trade_msg_deny']);
	$td['adddate'] = timetodate($td['addtime'], 5);
	$td['updatedate'] = timetodate($td['updatetime'], 5);
	$td['linkurl'] = DT_PATH.'api/redirect.php?mid='.$td['mid'].'&itemid='.$td['mallid'];
	$td['par'] = '';
	if(strpos($td['note'], '|') !== false) list($td['note'], $td['par']) = explode('|', $td['note']);  //行25.26为20151015升级补丁
	$mallid = $td['mallid'];
	$nav = $_username == $td['buyer'] ? 'action_order' : 'action';
	switch($step) {
		case 'edit_price'://修改价格||确认订单||修改为货到付款
			if($td['status'] > 1 || $td['seller'] != $_username) message($L['trade_msg_deny']);
			if($DT['trade'] && $_trade == '') message(lang($L['trade_msg_pay_bind'], array($DT['trade_nm'])), '?action=bind');
			if($submit) {
				$fee = dround($fee);
				$fee or message($L['trade_price_fee_null']);
				/*if($fee < 0 && $fee < -$td['amount']) message(lang($L['trade_msg_less_fee'], array(-$td['amount'])));*/
			  $fee_name = dhtmlspecialchars(trim($fee_name));         //   行43,44为20151015升级补丁
				$fee_name or message($L['trade_price_fee_name']);
				$status = isset($confirm_order) ? 1 : 0;
				$cod = 0;
				if(isset($edit_cod)) {
					$cod = 1;
					$status = 7;
				}
				$itemid=$td['itemid'];
				$db->query("UPDATE {$table} SET fee='$fee',fee_name='$fee_name',status=$status,cod=$cod,eprice_chil='$childusername',eprice_time=$DT_TIME,updatetime=$DT_TIME WHERE itemid=$itemid");				
				if(isset($confirm_order)) {
					$touser = $td['buyer'];
					$title = lang($L['trade_message_t1'], array($itemid));
					$url = $memberurl.'trade.php?action=order&itemid='.$itemid;
					$content = lang($L['trade_message_c1'], array($myurl, $_username, $timenow, $url));
					$content = ob_template('messager', 'mail');
					send_message($touser, $title, $content);
					//send sms
					if($DT['sms'] && $_sms && $touser && isset($sendsms)) {
						$touser = userinfo($touser);
						if($touser['mobile']) {
							$message = lang('sms->ord_confirm', array($itemid));
							$message = strip_sms($message);
							$word = word_count($message);
							$sms_num = ceil($word/$DT['sms_len']);
							if($sms_num <= $_sms) {
								$sms_code = send_sms($touser['mobile'], $message, $word);
								if(strpos($sms_code, $DT['sms_ok']) !== false) {
									$tmp = explode('/', $sms_code);
									if(is_numeric($tmp[1])) $sms_num = $tmp[1];
									if($sms_num) sms_add($_username, -$sms_num);
									if($sms_num) sms_record($_username, -$sms_num, $_username, $L['trade_sms_confirm'], $itemid);
								}
							}
						}
					}
					//send sms
				}
				message($L['trade_price_edit_success'], $forward, 3);
			} else {
				$confirm = isset($confirm) ? 1 : 0;
				$head_title = $L['trade_price_title'];
			}
		break;
		case 'outline'://线下收款
			if($td['status'] > 1 || $td['seller'] != $_username) message($L['trade_msg_deny']);
				$fee = dround($fee);
				$money = $td['amount'] + $td['fee'];
				$db->query("UPDATE {$table} SET status=2,updatetime=$DT_TIME,pay_type=1 WHERE order_mb_id=$order_mb_id");    //线下付款添加pay_type=1
					$touser = $td['buyer'];
					$title = lang($L['trade_message_t1'], array($order_mb_id));
					$url = $memberurl.'trade.php?action=order&itemid='.$itemid;
					$content = lang($L['trade_message_c1'], array($myurl, $_username, $timenow, $url));
					$content = ob_template('messager', 'mail');
					send_message($touser, $title, $content);
					money_add($touser, $money);
						money_record($touser, $money, '线下付款', 'system', '线下汇款充值',$L['trade_order_id'].$order_mb_id);
					money_add($touser, -$money);
						money_record($touser, -$money, '线下付款','system', '确认订单扣费', $L['trade_order_id'].$order_mb_id);
					money_add($td['seller'], $money);
						money_record($td['seller'], $money, '线下付款', 'system', '收到订单汇款',$L['trade_order_id'].$order_mb_id);
					money_add($td['seller'], -$money);
						money_record($td['seller'], -$money, '线下付款', 'system', '订单金额提现', $L['trade_order_id'].$order_mb_id);
				message('线下付款确认成功', $forward, 3);
		break;
		case 'detail'://订单详情
			$td['total'] = $td['amount'] + $td['fee'];
			$auth = encrypt('mall|'.$td['send_type'].'|'.$td['send_no'].'|'.$td['send_status'].'|'.$td['itemid'], DT_KEY.'EXPRESS');
			$head_title = $L['trade_detail_title'];
		break;
		case 'print'://订单打印
			$td['total'] = $td['amount'] + $td['fee'];
			if($td['seller'] != $_username) message($L['trade_msg_deny']);
			include template('trade_print', $module);
			exit;
		break;
		case 'confirm_order'://确认订单
			if($td['status'] != 0 || $td['seller'] != $_username) message($L['trade_msg_deny']);
			if($DT['trade'] && $_trade == '') message('系统采用了'.$DT['trade_nm'].'担保交易，请先绑定您的'.$DT['trade_nm'].'帐号', '?action=bind');
			$db->query("UPDATE {$table} SET status=1,confirm_chil='$childusername',confirm_time=$DT_TIME,updatetime=$DT_TIME WHERE order_mb_id=$order_mb_id");
			$touser = $td['buyer'];
			$title = lang($L['trade_message_t1'], array($order_mb_id));
			$url = $memberurl.'trade.php?action=order&itemid='.$itemid;
			$content = lang($L['trade_message_c1'], array($myurl, $_username, $timenow, $url));
			$content = ob_template('messager', 'mail');
			send_message($touser, $title, $content);
			message($L['trade_confirm_success'], $forward, 3);
		break;
		case 'express'://快递追踪
			($td['send_type'] && $td['send_no']) or dheader('?action=update&step=detail&itemid='.$itemid);
			$auth = encrypt('mall|'.$td['send_type'].'|'.$td['send_no'].'|'.$td['send_status'].'|'.$td['itemid'], DT_KEY.'EXPRESS');
			$head_title = $L['trade_exprss_title'];
		break;
		case 'pay'://买家付款
			if($td['status'] == 0) message($L['trade_msg_confirm'], '?action=update&step=detail&itemid='.$itemid);
			if($td['status'] != 1 || $td['buyer'] != $_username) message($L['trade_msg_deny']);
			$money = $td['amount'] + $td['fee'];
			$seller = userinfo($td['seller']);
			if($DT['trade']) exit(include DT_ROOT.'/api/trade/'.$DT['trade'].'/update.inc.php');
			if($money > $_money) {
				set_cookie('tradeid', $itemid, $DT_TIME + 1800);
				dheader('charge.php?action=pay&amount='.($money-$_money));
			}
			if($submit) {
				is_payword($_username, $password) or message($L['error_payword']);
				$db->query("UPDATE {$DT_PRE}member SET money=money-$money,locking=locking+$money WHERE username='$_username'");  //使用旧版本的资金处理
				$db->query("UPDATE {$table} SET status=2,updatetime=$DT_TIME WHERE order_mb_id=$order_mb_id");

				$touser = $td['seller'];
				$title = lang($L['trade_message_t2'], array($order_mb_id));
				$url = $memberurl.'trade.php?itemid='.$itemid;
				$content = lang($L['trade_message_c2'], array($myurl, $_username, $timenow, $url));
				$content = ob_template('messager', 'mail');
				send_message($touser, $title, $content);			
				//send sms
				if($DT['sms'] && $_sms && $touser && isset($sendsms)) {
					$touser = userinfo($touser);
					if($touser['mobile']) {
						$message = lang('sms->ord_pay', array($order_mb_id, $money));
						$message = strip_sms($message);
						$word = word_count($message);
						$sms_num = ceil($word/$DT['sms_len']);
						if($sms_num <= $_sms) {
							$sms_code = send_sms($touser['mobile'], $message, $word);
							if(strpos($sms_code, $DT['sms_ok']) !== false) {
								$tmp = explode('/', $sms_code);
								if(is_numeric($tmp[1])) $sms_num = $tmp[1];
								if($sms_num) sms_add($_username, -$sms_num);
								if($sms_num) sms_record($_username, -$sms_num, $_username, $L['trade_sms_pay'], $itemid);
							}
						}
					}
				}
				//send sms
				//更新商品数据   //20151015版升级补丁
				if($td['mid'] == 16) {
					$db->query("UPDATE {$DT_PRE}mall SET orders=orders+1,sales=sales+$td[number],amount=amount-$td[number] WHERE itemid=$mallid");
				} else {
					$db->query("UPDATE ".get_table($td['mid'])." SET amount=amount-$td[number] WHERE itemid=$mallid");
				}
				message($L['trade_pay_order_success'], '?action=order&itemid='.$itemid, 5);
			} else {
				$head_title = $L['trade_pay_order_title'];
			}
		break;
		case 'refund'://买家退款
			if($DT['trade']) exit(include DT_ROOT.'/api/trade/'.$DT['trade'].'/update.inc.php');
			$gone = $DT_TIME - $td['updatetime'];
			if(!in_array($td['status'], array(2, 3)) || $td['buyer'] != $_username) message($L['trade_msg_deny']);
			if($td['status'] == 3 && $gone > ($MOD['trade_day']*86400 + $td['add_time']*3600)) message($L['trade_msg_deny']);      //20151015版升级补丁 
			$money = $td['amount'] + $td['fee'];
			if($submit) {
				$content or message($L['trade_refund_reason']);
				clear_upload($content);
				$content = dsafe(addslashes(save_remote(save_local(stripslashes($content)))));
				is_payword($_username, $password) or message($L['error_payword']);
				$db->query("UPDATE {$table} SET status=5,updatetime=$DT_TIME,buyer_reason='$content' WHERE itemid=$itemid");
				message($L['trade_refund_success'], $forward, 3);
			} else {
				$head_title = $L['trade_refund_title'];
			}
		break;
		case 'refund_agree'://卖家同意买家退款
			if($DT['trade']) exit(include DT_ROOT.'/api/trade/'.$DT['trade'].'/update.inc.php');
			if($td['status'] != 5 || $td['seller'] != $_username) message($L['trade_msg_deny']);
			$money = $td['amount'] + $td['fee'];
			if($submit) {
				$content .= $L['trade_refund_by_seller'];
				clear_upload($content);
				$content = dsafe(addslashes(save_remote(save_local(stripslashes($content)))));
				is_payword($_username, $password) or message($L['error_payword']);
				money_add($td['buyer'], $money);
				money_record($td['buyer'], $money, $L['in_site'], 'system', $L['trade_refund'], $L['trade_order_id'].':'.$itemid.$L['trade_refund_by_seller']);
				$db->query("UPDATE {$table} SET status=6,editor='$_username',updatetime=$DT_TIME,refund_reason='$content' WHERE itemid=$itemid");
				//更新商品数据 增加库存        //20151015版升级补丁
				if($td['mid'] == 16) {
					$db->query("UPDATE {$DT_PRE}mall SET orders=orders-1,sales=sales-$td[number],amount=amount+$td[number] WHERE itemid=$mallid");
				} else {
					$db->query("UPDATE ".get_table($td['mid'])." SET amount=amount+$td[number] WHERE itemid=$mallid");
				}
				message($L['trade_refund_agree_success'], $forward, 3);
			} else {
				$head_title = $L['trade_refund_agree_title'];
			}
		break;
		case 'remind'://买家提醒卖家发货			
			if($td['status'] != 2 || $td['buyer'] != $_username) message($L['trade_msg_deny']);
		break;
		case 'send_goods'://卖家发货     //行232-241为20151015版升级包的验证处理
			   if(($td['status'] != 2 && $td['status'] != 7) || $td['seller'] != $_username) message($L['trade_msg_deny']);
			//if($DT['trade'] && $td['status'] == 2) exit(include DT_ROOT.'/api/trade/'.$DT['trade'].'/update.inc.php');
			if($submit) {
				$send_type = trim(dhtmlspecialchars($send_type));
				if(strlen($send_type) > 2 && strlen($send_no) < 5) message($L['msg_express_no']);
				if(strlen($send_no) > 4 && strlen($send_type) < 3) message($L['msg_express_type']);
				if($send_no && !preg_match("/^[a-z0-9_\-]{4,}$/i", $send_no)) message($L['msg_express_no_error']);
				is_date($send_time) or message($L['msg_express_date_error']);
				$status = $td['status'] == 7 ? 7 : 3;
				$db->query("UPDATE {$table} SET status=$status,updatetime=$DT_TIME,send_type='$send_type',send_no='$send_no',send_time='$send_time',send_chil='$childusername',sendc_time=$DT_TIME WHERE order_mb_id=$order_mb_id");

				$touser = $td['buyer'];
				$title = lang($L['trade_message_t3'], array($order_mb_id));
				$url = $memberurl.'trade.php?action=order&itemid='.$itemid;
				$content = lang($L['trade_message_c3'], array($myurl, $_username, $timenow, $url));
				$content = ob_template('messager', 'mail');
				send_message($touser, $title, $content);
			
				//send sms
				if($DT['sms'] && $_sms && $touser && isset($sendsms)) {
					$touser = userinfo($touser);
					if($touser['mobile']) {  
						$word='';
						$message='';
						if($sms_word_select=='1'){         //使用自定义短信内容
							$message=$dingzhi_sms_word;
						}else{            //使用默认内容
							$message = lang('sms->ord_send', array($itemid, $send_type, $send_no, $send_time));
						}
						$message = strip_sms($message);
						$word = word_count($message);
						$sms_num = ceil($word/$DT['sms_len']);
						if($sms_num <= $_sms) {
							$sms_code = send_sms($touser['mobile'], $message, $word);
							if(strpos($sms_code, $DT['sms_ok']) !== false) {
								$tmp = explode('/', $sms_code);
								if(is_numeric($tmp[1])) $sms_num = $tmp[1];
								if($sms_num) sms_add($_username, -$sms_num);
								if($sms_num) sms_record($_username, -$sms_num, $_username, $L['trade_sms_send'], $itemid);
							}
						}
						
					}
				}
				//send sms
				
				//更新商品数据 限货到付款的商品        //20151015版升级包
				if($td['cod']) {
					if($td['mid'] == 16) {
						$db->query("UPDATE {$DT_PRE}mall SET orders=orders+1,sales=sales+$td[number],amount=amount-$td[number] WHERE itemid=$mallid");
					} else {
						$db->query("UPDATE ".get_table($td['mid'])." SET amount=amount-$td[number] WHERE itemid=$mallid");
					}
				}
				message($L['trade_send_success'], $forward, 3);
			} else {
				$head_title = $L['trade_send_title'];
				$send_types = explode('|', trim($MOD['send_types']));
				$send_time = timetodate($DT_TIME, 3);
				$dingzhi_sms_word='';           //获取定制短信模板
				if(check_dingzhi_member($_username)){
					$sms=$db->get_one("select sms_word from {$db->pre}member_dingzhi where username='$_username'");
					$dingzhi_sms_word=$sms['sms_word'];
				}
			}
		break;
		case 'cod_success'://货到付款，确认完成
			if($td['status'] != 7 || !$td['cod'] || !$td['send_time'] || $td['seller'] != $_username) message($L['trade_msg_deny']);
			$db->query("UPDATE {$table} SET status=4,updatetime=$DT_TIME WHERE order_mb_id=$order_mb_id");
			//交易成功
			message($L['trade_success'], $forward, 3);
			
		break;
		case 'add_time'://增加确认收货时间
			if($DT['trade']) exit(include DT_ROOT.'/api/trade/'.$DT['trade'].'/update.inc.php');
			if($td['status'] != 3 || $td['seller'] != $_username) message($L['trade_msg_deny']);
			if($submit) {
				$add_time = intval($add_time);
				$add_time > 0 or message($L['trade_addtime_null']);
				$add_time = $td['add_time'] + $add_time;
				$db->query("UPDATE {$table} SET add_time='$add_time' WHERE order_mb_id=$order_mb_id");
				message($L['trade_addtime_success'], $forward);
			} else {
				$head_title = $L['trade_addtime_title'];
			}
		break;
		case 'receive_goods'://确认收货
			//if($DT['trade']) exit(include DT_ROOT.'/api/trade/'.$DT['trade'].'/update.inc.php');
			$gone = $DT_TIME - $td['updatetime'];
			if($td['status'] != 3 || $td['buyer'] != $_username || $gone > ($MOD['trade_day']*86400 + $td['add_time']*3600)) message($L['trade_msg_deny']);
			//交易成功
			$money = $td['amount'] + $td['fee'];
			$mall_order_pay_type=$db->get_one("select pay_type from {$table} where order_mb_id=$order_mb_id");
			if($mall_order_pay_type['pay_type']=='0'){           //线上付款的方式才对卖家增加资金，和扣买家冻结资金
				money_lock($_username, -$money);
				money_record($_username, -$money, $L['in_site'], 'system', $L['trade_record_pay'], $L['trade_order_id'].$itemid);
				money_add($td['seller'], $money);
				money_record($td['seller'], $money, $L['in_site'], 'system', $L['trade_record_pay'], $L['trade_order_id'].$itemid);
			}
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
			$db->query("UPDATE {$table} SET status=4,updatetime=$DT_TIME WHERE order_mb_id=$order_mb_id");
			//更新商品数据
			if($td['mid'] == 16) {
				$db->query("UPDATE {$DT_PRE}mall SET orders=orders+1,sales=sales+$td[number],amount=amount-$td[number] WHERE itemid=$mallid");
			} else {
				$db->query("UPDATE ".get_table($td['mid'])." SET amount=amount-$td[number] WHERE itemid=$mallid");
			}

			$touser = $td['seller'];
			$title = lang($L['trade_message_t4'], array($order_mb_id));
			$url = $memberurl.'trade.php?itemid='.$itemid;
			$content = lang($L['trade_message_c4'], array($myurl, $_username, $timenow, $url));
			$content = ob_template('messager', 'mail');
			send_message($touser, $title, $content);

			message($L['trade_success'], $forward, 3);//交易成功
		break;
		case 'get_pay'://买家确认超时 卖家申请直接付款
			if($DT['trade']) exit(include DT_ROOT.'/api/trade/'.$DT['trade'].'/update.inc.php');
			$gone = $DT_TIME - $td['updatetime'];
			if($td['status'] != 3 || $td['seller'] != $_username || $gone < ($MOD['trade_day']*86400 + $td['add_time']*3600)) message($L['trade_msg_deny']);
			//交易成功
			$money = $td['amount'] + $td['fee'];
			money_add($td['seller'], $money);
			money_record($td['seller'], $money, $L['in_site'], 'system', $L['trade_record_pay'], lang($L['trade_buyer_timeout'], array($itemid)));
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
			$db->query("UPDATE {$table} SET status=4,updatetime=$DT_TIME WHERE order_mb_id=$order_mb_id");
			message($L['trade_success'], $forward, 3);
		break;
		case 'comment'://交易评价
			if($td['mid'] != 16) message($L['trade_msg_deny_comment']);
			if($submit) {
				$star = intval($star);
				in_array($star, array(1, 2, 3)) or $star = 3;
				$content = dhtmlspecialchars($content);
			}
			if($_username == $td['seller']) {
				if($td['buyer_star']) message($L['trade_msg_comment_again']);
				if($submit) {
					$db->query("UPDATE {$table} SET buyer_star=$star WHERE itemid=$itemid");
					$s = 'b'.$star;
					$db->query("UPDATE {$DT_PRE}mall_comment SET buyer_star=$star,buyer_comment='$content',buyer_ctime=$DT_TIME WHERE itemid=$itemid");
					$db->query("UPDATE {$DT_PRE}mall_stat SET bcomment=bcomment+1,`$s`=`$s`+1 WHERE mallid=$mallid");
					message($L['trade_msg_comment_success'], $forward);
				}
			} else if($_username == $td['buyer']) {
				if($td['seller_star']) message($L['trade_msg_comment_again']);
				if($submit) {
					$db->query("UPDATE {$DT_PRE}mall SET comments=comments+1 WHERE itemid=$mallid");
					$db->query("UPDATE {$table} SET seller_star=$star WHERE itemid=$itemid");
					$s = 's'.$star;
					$db->query("UPDATE {$DT_PRE}mall_comment SET seller_star=$star,seller_comment='$content',seller_ctime=$DT_TIME WHERE itemid=$itemid");
					$db->query("UPDATE {$DT_PRE}mall_stat SET scomment=scomment+1,`$s`=`$s`+1 WHERE mallid=$mallid");
					message($L['trade_msg_comment_success'], $forward);
				}
			}
		break;
		case 'comment_detail'://评价详情
			if($td['mid'] != 16) message($L['trade_msg_deny_comment']);
			$cm = $db->get_one("SELECT * FROM {$DT_PRE}mall_comment WHERE itemid=$itemid");
			if($submit) {
				$content = dhtmlspecialchars($content);
				$content or message($L['trade_msg_empty_explain']);
				if($_username == $td['seller']) {
					if($cm['buyer_reply']) message($L['trade_msg_explain_again']);
					$db->query("UPDATE {$DT_PRE}mall_comment SET buyer_reply='$content',buyer_rtime=$DT_TIME WHERE itemid=$itemid");
				} else {
					if($cm['seller_reply']) message($L['trade_msg_explain_again']);
					$db->query("UPDATE {$DT_PRE}mall_comment SET seller_reply='$content',seller_rtime=$DT_TIME WHERE itemid=$itemid");
				}
				dmsg($L['trade_msg_explain_success'], '?action='.$action.'&step='.$step.'&itemid='.$itemid);
			}
		break;
		case 'close'://关闭交易
			if($_username == $td['seller']) {
				if($td['status'] == 0) {
					$db->query("UPDATE {$table} SET status=9,updatetime=$DT_TIME WHERE order_mb_id=$order_mb_id");
					dmsg($L['trade_close_success'], $forward);
				} else if($td['status'] == 1) {
					$db->query("UPDATE {$table} SET status=9,updatetime=$DT_TIME WHERE order_mb_id=$order_mb_id");
					dmsg($L['trade_close_success'], $forward);
				} else if($td['status'] == 2) {
					$money = $td['amount'] + $td['fee'];
					$db->query("UPDATE {$DT_PRE}member SET money=money+$money,locking=locking-$money WHERE username='$td[buyer]'");
					$db->query("UPDATE {$table} SET status=9,updatetime=$DT_TIME WHERE order_mb_id=$order_mb_id");
					dmsg($L['trade_close_success'], $forward);
				} else if($td['status'] == 8) {
					$db->query("DELETE FROM {$table} WHERE order_mb_id=$order_mb_id");
					dmsg($L['trade_delete_success'], $forward);
				} else { 
					message($L['trade_msg_deny']);
				}
				message($L['trade_close_success'], $forward);
			} else if($_username == $td['buyer']) {
				if($td['status'] == 0) {
					$db->query("UPDATE {$table} SET status=8,updatetime=$DT_TIME WHERE order_mb_id=$order_mb_id");
					dmsg($L['trade_close_success'], $forward);
				} else if($td['status'] == 1) {
					$db->query("UPDATE {$table} SET status=8,updatetime=$DT_TIME WHERE order_mb_id=$order_mb_id");
					dmsg($L['trade_close_success'], $forward);
				} else if($td['status'] == 9) {
					$db->query("DELETE FROM {$table} WHERE order_mb_id=$order_mb_id");
					dmsg($L['trade_delete_success'], $forward);
				} else {
					message($L['trade_msg_deny']);
				}
			}
		break;
		case 'payment':   //交易凭证
		//var_dump("update {$table} set payment='$thumb' where itemid=$itemid");
			$db->query("update {$table} set payment='$thumb' where order_mb_id=$order_mb_id");
			dmsg('支付凭证上传成功',$forward);
		break;
		case 'invoice':       //处理发票选项
			if($invoice!='1'){
				$invoice='2';
			}
			$invoice_title=isset($invoice_title)?$invoice_title:'';
			$db->query("update {$table} set invoice='$invoice' where order_mb_id=$order_mb_id");
			dmsg('发票选项处理成功',$forward);
		break;
	}
} else if($action == 'bind') {
	$DT['trade'] or message($L['trade_msg_secured_close']);
	$member = $db->get_one("SELECT trade,vtrade FROM {$DT_PRE}member WHERE userid=$_userid");
	if($submit) {
		if($member['trade'] && $member['vtrade']) message($L['trade_msg_bind_edit']);
		if($trade) {
			if($DT['trade'] == 'alipay' && !is_email($trade) && !is_mobile($trade)) message($DT['trade_nm'].'帐号格式不正确');
			$r = $db->get_one("SELECT userid FROM {$DT_PRE}member WHERE trade='$trade' AND vtrade=1");
			if($r) message($L['trade_msg_bind_exists']);
		} else {
			$trade = '';
		}
		$db->query("UPDATE {$DT_PRE}member SET trade='$trade',vtrade=0 WHERE userid=$_userid");
		dmsg($L['trade_msg_bind_success'], '?action=bind');
	} else {
		if(!$member['trade']) $member['vtrade'] = 0;
		$head_title = lang($L['trade_bind_title'], array($DT['trade_nm']));
	}
} else if($action == 'muti') {//批量付款
	if($submit) {
		($itemid && is_array($itemid)) or message($L['trade_msg_muti_choose']);
		is_payword($_username, $password) or message($L['error_payword']);
		$itemids = implode(',', $itemid);
		$condition = "buyer='$_username' AND status=1 AND itemid IN ($itemids)";
		$result = $db->query("SELECT * FROM {$table} WHERE $condition ORDER BY itemid DESC LIMIT 50");
		while($td = $db->fetch_array($result)) {
			$itemid = $td['itemid'];
			$money = $td['amount'] + $td['fee'];
			if($_money < $money) break;
			$seller = userinfo($td['seller']);
			money_add($_username, -$money);
			money_record($_username, -$money, $L['in_site'], 'system', $L['trade_pay_order_title'], $L['trade_order_id'].':'.$itemid);
			$db->query("UPDATE {$table} SET status=2,updatetime=$DT_TIME WHERE itemid=$itemid");
			$_money = $_money - $money;

			$touser = $td['seller'];
			$title = lang($L['trade_message_t2'], array($order_mb_id));
			$url = $memberurl.'trade.php?itemid='.$itemid;
			$content = lang($L['trade_message_c2'], array($myurl, $_username, $timenow, $url));
			$content = ob_template('messager', 'mail');
			send_message($touser, $title, $content);			
			//send sms
			if($DT['sms'] && $_sms && $touser && isset($sendsms)) {
				$touser = userinfo($touser);
				if($touser['mobile']) {
					$message = lang('sms->ord_pay', array($order_mb_id, $money));
					$message = strip_sms($message);
					$word = word_count($message);
					$sms_num = ceil($word/$DT['sms_len']);
					if($sms_num <= $_sms) {
						$sms_code = send_sms($touser['mobile'], $message, $word);
						if(strpos($sms_code, $DT['sms_ok']) !== false) {
							$tmp = explode('/', $sms_code);
							if(is_numeric($tmp[1])) $sms_num = $tmp[1];
							if($sms_num) sms_add($_username, -$sms_num);
							if($sms_num) sms_record($_username, -$sms_num, $_username, $L['trade_sms_pay'], $itemid);
						}
					}
				}
			}
			//send sms
			//更新商品数据
			if($td['mid'] == 16) {
				$db->query("UPDATE {$DT_PRE}mall SET orders=orders+1,sales=sales+$td[number],amount=amount-$td[number] WHERE itemid=$mallid");
			} else {
				$db->query("UPDATE ".get_table($td['mid'])." SET amount=amount-$td[number] WHERE itemid=$mallid");
			}
		}
		message($L['trade_pay_order_success'], '?action=order&status=2', 5);
	} else {
		$ids = isset($ids) ? explode(',', $ids) : array();
		if($ids) $ids = array_map('intval', $ids);
		$condition = "buyer='$_username' AND status=1";
		if($ids) $condition .= " AND itemid IN (".implode(',', $ids).")";
		$lists = array();
		$result = $db->query("SELECT * FROM {$table} WHERE $condition ORDER BY itemid DESC LIMIT 50");
		while($r = $db->fetch_array($result)) {
			$r['addtime'] = timetodate($r['addtime'], 5);
			$r['linkurl'] = DT_PATH.'api/redirect.php?mid='.$r['mid'].'&itemid='.$r['mallid'];
			$r['dstatus'] = $_status[$r['status']];
			$r['money'] = $r['amount'] + $r['fee'];
			$r['money'] = number_format($r['money'], 2, '.', '');
			$lists[] = $r;
		}
		$lists or message($L['trade_msg_muti_empty'], '?action=order', 5);
		$head_title = $L['trade_muti_title'];
	}
} else if($action == 'express') {//我的快递
	$sfields = $L['express_sfields'];
	$dfields = array('title', 'title', 'send_type ', 'send_no');
	isset($fields) && isset($dfields[$fields]) or $fields = 0;
	$status = isset($status) && isset($dsend_status[$status]) ? intval($status) : '';
	$type = isset($type) ? intval($type) : 0;
	$fields_select = dselect($sfields, 'fields', '', $fields);
	$status_select = dselect($dsend_status, 'status', $L['status'], $status, '', 1, '', 1);
	$condition = "send_no<>''";
	if($type == 2) {
		$condition .= " AND buyer='$_username'";
	} else if($type == 1) {
		$condition .= " AND seller='$_username'";
	} else {
		$condition .= " AND (buyer='$_username' OR seller='$_username')";
	}
	if($keyword) $condition .= " AND $dfields[$fields] LIKE '%$keyword%'";
	if($status !== '') $condition .= " AND send_status='$status'";
	$r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE $condition");
	$pages = pages($r['num'], $page, $pagesize);		
	$lists = array();
	$result = $db->query("SELECT * FROM {$table} WHERE $condition ORDER BY itemid DESC LIMIT $offset,$pagesize");
	while($r = $db->fetch_array($result)) {
		$r['addtime'] = timetodate($r['addtime'], 5);
		$r['updatetime'] = timetodate($r['updatetime'], 5);
		$r['dstatus'] = $_send_status[$r['send_status']];
		$lists[] = $r;
	}
	$head_title = $L['express_title'];
} else if($action == 'order') {
	$sfields = $L['trade_order_sfields'];
	$dfields = array('title', 'title ', 'amount', 'fee', 'fee_name', 'seller', 'send_type', 'send_no', 'note');
	isset($fields) && isset($dfields[$fields]) or $fields = 0;
	$mallid = isset($mallid) ? intval($mallid) : 0;
	$cod = isset($cod) ? intval($cod) : 0;
	$nav = isset($nav) ? intval($nav) : -1;
	(isset($seller) && check_name($seller)) or $seller = '';
	isset($fromtime) or $fromtime = '';
	isset($totime) or $totime = '';
	$status = isset($status) && isset($dstatus[$status]) ? intval($status) : '';
	$fields_select = dselect($sfields, 'fields', '', $fields);
	$status_select = dselect($dstatus, 'status', $L['status'], $status, '', 1, '', 1);
	$condition = "buyer='$_username'";
	if($keyword) $condition .= " AND $dfields[$fields] LIKE '%$keyword%'";
	if($fromtime) $condition .= " AND addtime>".(strtotime($fromtime.' 00:00:00'));
	if($totime) $condition .= " AND addtime<".(strtotime($totime.' 23:59:59'));
	if($status !== '') $condition .= " AND status='$status'";
	if($itemid) $condition .= " AND itemid='$itemid'";
	if($mallid) $condition .= " AND mallid=$mallid";
	if($seller) $condition .= " AND seller='$seller'";
	if($cod) $condition .= " AND cod=1";
	if(in_array($nav, array(0,1,2,3,5,6))) {
		$condition .= " AND status=$nav";
	} else if($nav == 4) {
		$condition .= " AND status=$nav AND seller_star=0";
	}
	$r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE $condition");
	$pages = pages($r['num'], $page, $pagesize);		
	$trades = array();
	#$result = $db->query("SELECT * FROM {$table} WHERE $condition ORDER BY itemid DESC LIMIT $offset,$pagesize");
	$result = $db->query("SELECT order_mb_id, seller,buyer,status,addtime,group_concat(itemid),note,payment,updatetime,add_time FROM {$table} WHERE $condition group by order_mb_id ORDER BY itemid DESC LIMIT $offset,$pagesize");
	$amount = $fee = $money = 0;
	while($r = $db->fetch_array($result)) {
		$r['gone'] = $DT_TIME - $r['updatetime'];
		if($r['status'] == 3) {
			$gone = $DT_TIME - $r['updatetime'];
			if($gone > ($MOD['trade_day']*86400 + $r['add_time']*3600)) {
				$r['lefttime'] = 0;
			} else {
				$r['lefttime'] = secondstodate($MOD['trade_day']*86400 + $r['add_time']*3600 - $gone);
			}
		}
		$r['addtime'] = str_replace(' ', ' ', timetodate($r['addtime'], 5));
		$r['updatetime'] = str_replace(' ', ' ', timetodate($r['updatetime'], 5));
		$username = $r['seller'];
		$b = $db->get_one("select * from {$mtable} where username = '$username'");
		$r['company']=$b['company'];
		$r['sitemid']= $r['group_concat(itemid)'];
		#$r['linkurl'] = DT_PATH.'api/redirect.php?mid='.$r['mid'].'&itemid='.$r['mallid'];
		$r['dstatus'] = $_status[$r['status']];
		$A['amount'] = $db->get_one("SELECT  sum(amount) FROM {$table} WHERE itemid in ($sitemid)");
		$B['fee'] = $db->get_one("SELECT  sum(fee) FROM {$table} WHERE itemid in ($sitemid)");
		$r['money'] = $A['amount'] + $B['fee'];
		$r['money'] = number_format($r['money'], 2, '.', '');
		#$amount += $r['amount'];
		#$fee += $r['fee'];
		$trades[] = $r;
	}
	$money = $amount + $fee;
	$money = number_format($money, 2, '.', '');
	$head_title = $L['trade_order_title'];
}else if($action=='dingzhi_sms'){                //修改定制用户自定义短信模板
	if(check_dingzhi_member($username)){
		$str_sql='update '.$db->pre."member_dingzhi set sms_word ='".$sms_word."' , sms_limit=".$sms_limit." where username='".$username."'";
		if($db->query($str_sql)){
			dmsg('更新成功','?');
		}else{
			dmsg('更新失败','?');
		}
	}
} else {
	$sfields = $L['trade_sfields'];
	$dfields = array('title', 'title ', 'amount', 'fee', 'fee_name', 'buyer', 'buyer_name', 'buyer_address', 'buyer_postcode', 'buyer_mobile', 'buyer_phone', 'send_type', 'send_no', 'note');
	$mallid = isset($mallid) ? intval($mallid) : 0;
	$cod = isset($cod) ? intval($cod) : 0;
	$nav = isset($nav) ? intval($nav) : -1;
	(isset($buyer) && check_name($buyer)) or $buyer = '';
	isset($fields) && isset($dfields[$fields]) or $fields = 0;
	isset($fromtime) or $fromtime = '';
	isset($totime) or $totime = '';
	$status = isset($status) && isset($dstatus[$status]) ? intval($status) : '';
	$fields_select = dselect($sfields, 'fields', '', $fields);
	$status_select = dselect($dstatus, 'status', $L['status'], $status, '', 1, '', 1);
	$condition = "seller='$_username'";
	if($keyword) $condition .= " AND $dfields[$fields] LIKE '%$keyword%'";
	if($fromtime) $condition .= " AND addtime>".(strtotime($fromtime.' 00:00:00'));
	if($totime) $condition .= " AND addtime<".(strtotime($totime.' 23:59:59'));
	if($status !== '') $condition .= " AND status='$status'";
	if($itemid) $condition .= " AND itemid=$itemid";
	if($mallid) $condition .= " AND mallid=$mallid";
	if($buyer) $condition .= " AND buyer='$buyer'";
       if($cod) $condition .= " AND cod=1";
       if(in_array($nav, array(0,1,2,3,5,6))) {
       		$condition .= " AND status=$nav";
       } else if($nav == 4) {
       		$condition .= " AND status=$nav AND buyer_star=0";
       }	
	
	if($_childusername!=''){               //子账号存在,判断子账号的地区权限
		$partid=$db->get_one("select partid from {$db->pre}member_child where username='$_childusername'");      //子账号地区权限
		if($partid['partid']!='0'){          //非全国地区，判断所在区域
			$part_childid=$db->get_one("select arrchildid from {$db->pre}area_partition where partid=".$partid['partid']);  //区域的所有城市id
			$part_arr=explode(',',$part_childid['arrchildid']);        //区域地区id数组
			$buyer_areaid_data=$db->query("select {$db->pre}member.username,{$db->pre}member.areaid from {$db->pre}member join {$db->pre}mall_order on {$db->pre}member.username={$db->pre}mall_order.buyer where {$db->pre}mall_order.seller='$_username'");
			$buyer_areaid=array();           //所有买家的用户名和对应地区id
			while($data=$db->fetch_array($buyer_areaid_data)){
				array_push($buyer_areaid,$data);
			}
			$buyer_arr=array();   //地区买家数组

			foreach($buyer_areaid as $v){
				if(in_array($v['areaid'],$part_arr)){
					array_push($buyer_arr,"'".$v['username']."'");
				}
			}
			if(count($buyer_arr)==0){
				$condition.=" AND buyer=''";                  //没有该区域的买家，不搜索出订单
			}else{
				$condition.=' AND buyer in ('.implode(',',$buyer_arr).')';         //搜索该地区的买家
			}
		}
	}
	
	$r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE $condition");
	$pages = pages($r['num'], $page, $pagesize);
	$orders = $r['num'];
	$trades = array();
	#$result = $db->query("SELECT * FROM {$table} WHERE $condition ORDER BY itemid DESC LIMIT $offset,$pagesize");
	$result = $db->query("SELECT order_mb_id, seller,buyer,status,addtime,group_concat(itemid),note,payment,updatetime,add_time,payment,invoice FROM {$table} WHERE $condition group by order_mb_id ORDER BY itemid DESC LIMIT $offset,$pagesize");
	$amount = $fee = $money = 0;
	while($r = $db->fetch_array($result)) {
		if($r['status'] == 3) {
			$gone = $DT_TIME - $r['updatetime'];
			if($gone > ($MOD['trade_day']*86400 + $r['add_time']*3600)) {
				$r['lefttime'] = 0;
			} else {
				$r['lefttime'] = secondstodate($MOD['trade_day']*86400 + $r['add_time']*3600 - $gone);
			}
		}
		$r['addtime'] = str_replace(' ', ' ', timetodate($r['addtime'], 5));
		$r['updatetime'] = str_replace(' ', ' ', timetodate($r['updatetime'], 5));
		$r['sitemid']= $r['group_concat(itemid)'];
		#$r['linkurl'] = DT_PATH.'api/redirect.php?mid='.$r['mid'].'&itemid='.$r['mallid'];
		$username = $r['buyer'];
		$b = $db->get_one("select * from {$mtable} where username = '$username'");
		$r['company']=$b['company'];
		$r['dstatus'] = $_status[$r['status']];
		$A['amount'] = $db->get_one("SELECT  sum(amount) FROM {$table} WHERE itemid in ($sitemid)");
		$B['fee'] = $db->get_one("SELECT  sum(fee) FROM {$table} WHERE itemid in ($sitemid)");
		$r['money'] = $A['amount'] + $B['fee'];
		$r['money'] = number_format($r['money'], 2, '.', '');
		#$amount += $r['amount'];
		#$fee += $r['fee'];
		$trades[] = $r;
	}
	$money = $amount + $fee;
	$money = number_format($money, 2, '.', '');
	$head_title = $L['trade_title'];
}
include template('trade', $module);
?>
