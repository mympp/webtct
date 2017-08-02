<?php 
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
$MG['buy_limit'] > -1 or dalert(lang('message->without_permission_and_upgrade'), 'goback');
require DT_ROOT.'/include/post.func.php';
include load($module.'.lang');
include load('my.lang');
require MD_ROOT.'/buy.class.php';
$do = new buy($moduleid);

if(in_array($action, array('add', 'edit'))) {
	$FD = cache_read('fields-'.substr($table, strlen($DT_PRE)).'.php');
	if($FD) require DT_ROOT.'/include/fields.func.php';
	isset($post_fields) or $post_fields = array();
	$CP = $MOD['cat_property'];
	if($CP) require DT_ROOT.'/include/property.func.php';
	isset($post_ppt) or $post_ppt = array();
}

$sql = $_userid ? "username='$_username'" : "ip='$DT_IP'";
$limit_used = $limit_free = $need_password = $need_captcha = $need_question = $fee_add = 0;
if(in_array($action, array('', 'add'))) {
	$r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE $sql AND status>1");
	$limit_used = $r['num'];
	$limit_free = $MG['buy_limit'] > $limit_used ? $MG['buy_limit'] - $limit_used : 0;
}
if(check_group($_groupid, $MOD['group_refresh'])) $MOD['credit_refresh'] = 0;

switch($action) {
	case 'add':
		if($MG['buy_limit'] && $limit_used >= $MG['buy_limit']) dalert(lang($L['info_limit'], array($MG[$MOD['module'].'_limit'], $limit_used)), $_userid ? $MODULE[2]['linkurl'].$DT['file_my'].'?mid='.$mid : $MODULE[2]['linkurl'].$DT['file_my']);
		if($MG['day_limit']) {
			$today = $today_endtime - 86400;
			$r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE $sql AND addtime>$today");
			if($r && $r['num'] >= $MG['day_limit']) dalert(lang($L['day_limit'], array($MG['day_limit'])), $_userid ? $MODULE[2]['linkurl'].$DT['file_my'].'?mid='.$mid : $MODULE[2]['linkurl'].$DT['file_my']);
		}

		if($MG['buy_free_limit'] >= 0) {
			$fee_add = ($MOD['fee_add'] && (!$MOD['fee_mode'] || !$MG['fee_mode']) && $limit_used >= $MG['buy_free_limit'] && $_userid) ? dround($MOD['fee_add']) : 0;
		} else {
			$fee_add = 0;
		}
		$fee_currency = $MOD['fee_currency'];
		$fee_unit = $fee_currency == 'money' ? $DT['money_unit'] : $DT['credit_unit'];
		$need_password = $fee_add && $fee_currency == 'money';
		$need_captcha = $MOD['captcha_add'] == 2 ? $MG['captcha'] : $MOD['captcha_add'];
		$need_question = $MOD['question_add'] == 2 ? $MG['question'] : $MOD['question_add'];
		$could_color = check_group($_groupid, $MOD['group_color']) && $MOD['credit_color'] && $_userid;

		if($submit) {
			if($fee_add && $fee_add > ($fee_currency == 'money' ? $_money : $_credit)) dalert($L['balance_lack']);
			if($need_password && !is_payword($_username, $password)) dalert($L['error_payword']);

			if(!$_userid) {
				if(strlen($post['company']) < 4) dalert($L['type_company']);
				if($AREA) {
					if(!isset($AREA[$post['areaid']])) dalert($L['type_area']);
				} else {
					if(!$post['areaid']) dalert($L['type_area']);
				}
				if(strlen($post['truename']) < 4) dalert($L['type_truename']);
				if(strlen($post['mobile']) < 7) dalert($L['type_mobile']);
			}

			if($MG['add_limit']) {
				$last = $db->get_one("SELECT addtime FROM {$table} WHERE $sql ORDER BY itemid DESC");
				if($last && $DT_TIME - $last['addtime'] < $MG['add_limit']) dalert(lang($L['add_limit'], array($MG['add_limit'])));
			}
			$msg = captcha($captcha, $need_captcha, true);
			if($msg) dalert($msg);
			$msg = question($answer, $need_question, true);
			if($msg) dalert($msg);
			
			if($do->pass($post)) {
				$CAT = get_cat($post['catid']);
				if(!$CAT || !check_group($_groupid, $CAT['group_add'])) dalert(lang($L['group_add'], array($CAT['catname'])));
				$post['addtime'] = $post['level'] = $post['fee'] = 0;
				$post['style'] = $post['template'] = $post['note'] = $post['filepath'] = '';
				if(!$IMVIP && $MG['uploadpt']) $post['thumb1'] = $post['thumb2'] = '';
				$need_check =  $MOD['check_add'] == 2 ? $MG['check'] : $MOD['check_add'];
				$post['status'] = get_status(3, $need_check);
				$post['hits'] = 0;
				$post['username'] = $_username;
				if($FD) fields_check($post_fields);
				if($CP) property_check($post_ppt);
				$do->add($post);
				$itemid=$do->itemid;
				if($post_fields['specialid']){
					$linkurl=$MODULE[$moduleid][linkurl].'show.php?itemid='.$itemid;
					$introduce= addslashes(get_intro($post['content'], $MOD['introduce_length']));
					$sqk="INSERT INTO {$DT_PRE}special_item (specialid,title,introduce,addtime,edittime,username,thumb,linkurl) VALUES (".$post_fields['specialid'].",'".$post['title']."','".$introduce."','".$DT_TIME."','".$DT_TIME."','".$_username."','".$post['thumb']."','".$linkurl."')";
					$db->query($sqk);
				}


				//切割录入采购表
				if($post_fields['productmax']){
					for($i=0;$i<=$post_fields['productmax'];$i++){
						if($_POST['product'][$i]){
							if($_POST['trcount'][$i]>0){
								$db->query("INSERT INTO {$DT_PRE}buy_option_6 (listorder,title,parentid,buyitemid,buytitle,options) VALUES (".$_POST['prolistorder'][$i].",'".$_POST['product'][$i]."',0,".$itemid.",'".$post['title']."','')");
								$parentid = $db->insert_id();
								for($t=0;$t<=$_POST['trcount'][$i];$t++){
										if($_POST['needget'][$i][$t]){
											$db->query("INSERT INTO {$DT_PRE}buy_option_6 (listorder,title,parentid,buyitemid,buytitle,options) VALUES (".$_POST['listorder'][$i][$t].",'".$_POST['needget'][$i][$t]."',".$parentid.",".$itemid.",'".$post['title']."','".$_POST['needinfo'][$i][$t]."')");
											}
								}
							}
						}
					}
				}
				//切割录入采购表


				//添加招标选择“指定合作供应商”——>发送邀请函通知供应商
				if(!empty($message['messtitle']) && !empty($message['messcontent']) && !empty($message['touser'])){
					$touser  = str_replace(',',' ',$message['touser']);
					$touser  = rtrim(ltrim($touser));
					$title   = dhtmlspecialchars(trim($message['messtitle']));
					$content = dsafe(addslashes(save_remote(save_local(stripslashes($message['messcontent'])))));
					$content .= $content."<br/><a href='".$MODULE[$moduleid][linkurl].'show.php?itemid='.$itemid."'>".$title."</a>";
					$tousers = $fineUser = array();
					$tousers = explode(' ',$touser);
					if(stristr($tousers['0'],'tcfri_') || stristr($tousers['1'],'tcfri_')){
						if(stristr($tousers['0'],"tcfri_")){
							$fineUser[0] = str_replace('tcfri_','',$tousers[0]);
						}
						if(stristr($tousers['1'],"tcfri_")){
							$fineUser[1] = str_replace('tcfri_','',$tousers[1]);
						}
						foreach($fineUser as $k=>$v){
							$friends = $db->query("SELECT * FROM {$DT_PRE}friend where typeid = '$v'");
							if($friends){
								while($r = $db->fetch_array($friends)){
									if(!in_array($r['username'],$tousers)){
										$tousers[] = $r['username'];
									}
								}
								$tousers[$k]='';
								$tousers = array_filter($tousers);
							}
						}
					}
					$mesStatus = $post['status'] == 3 ? $post['status'] : 1 ;
					foreach($tousers as $k=>$v){
						$db->query("INSERT INTO {$DT_PRE}message (title,content,fromuser,touser,addtime,ip,status,groupids) VALUES ('$title','$content','$_username','$v','$DT_TIME','$DT_IP','$mesStatus','$itemid')");
						if($mesStatus == 3){
							$this->db->query("UPDATE {$DT_PRE}member SET message=message+1 WHERE username='$v'");
						}
					}
					
				}
				//添加招标选择“指定合作供应商”——>发送邀请函通知供应商
				if($FD) fields_update($post_fields, $table, $do->itemid);
				if($CP) property_update($post_ppt, $moduleid, $post['catid'], $do->itemid);
				if($could_color && $color && $_credit > $MOD['credit_color']) {
					$post['style'] = $color;
					credit_add($_username, -$MOD['credit_color']);
					credit_record($_username, -$MOD['credit_color'], 'system', $L['title_color'], '['.$MOD['name'].']'.$post['title']);
				}
				if($MOD['show_html'] && $post['status'] > 2) $do->tohtml($do->itemid);

				if($fee_add) {
					if($fee_currency == 'money') {
						money_add($_username, -$fee_add);
						money_record($_username, -$fee_add, $L['in_site'], 'system', lang($L['credit_record_add'], array($MOD['name'])), 'ID:'.$do->itemid);
					} else {
						credit_add($_username, -$fee_add);
						credit_record($_username, -$fee_add, 'system', lang($L['credit_record_add'], array($MOD['name'])), 'ID:'.$do->itemid);
					}
				}
				
				$msg = $post['status'] == 2 ? $L['success_check'] : $L['success_add'];
				$js = '';
				if(isset($post['sync_sina']) && $post['sync_sina']) $js .= sync_weibo('sina', $moduleid, $do->itemid);
				if(isset($post['sync_qq']) && $post['sync_qq']) $js .= sync_weibo('qq', $moduleid, $do->itemid);
				if($_userid) {
					set_cookie('dmsg', $msg);
					$forward = $MODULE[2]['linkurl'].$DT['file_my'].'?mid='.$mid.'&status='.$post['status'];
					$msg = '';
				} else {
					$forward = $MODULE[2]['linkurl'].$DT['file_my'].'?mid='.$mid.'&action=add';
				}
				$js .= 'window.onload=function(){parent.window.location="'.$forward.'";}';
				dalert($msg, '', $js);
			} else {
				dalert($do->errmsg, '', ($need_captcha ? reload_captcha() : '').($need_question ? reload_question() : ''));
			}
		} else {
			if($itemid) {
				$MG['copy'] && $_userid or dalert(lang('message->without_permission_and_upgrade'), 'goback');
				$do->itemid = $itemid;
				$item = $do->get_one();
				if(!$item || $item['username'] != $_username) message();
				extract($item);
				$thumb = $thumb1 = $thumb2 = '';
				$totime = $totime > $DT_TIME ? timetodate($totime, 3) : '';
			} else {
				foreach($do->fields as $v) {
					$$v = '';
				}
				$content = '';
				$catid = 0;
				$totime = '';
				$typeid = 0;
			}
			$item = array();
		}
	break;




	case 'puradd'://添加采购内容
		$r = $db->get_one("SELECT COUNT(*) AS num FROM {$DT_PRE}buy_pur_6 WHERE username='$_username' AND buyitemid=".$post['buyitemid']);
		if($r['num']>0){
			dalert('已经有同条招标的采购数据存在，无法再添加！', $forward);exit;
		}
		$sqlk = $sqlv = '';
		$post['username']=$_username;
		$u=userinfo($_username);
		$post['telephone']=$u['telephone'];
		$post['company']=$u['company'];
		$post['truename']=$u['truename'];
		$post['mobile']=$u['mobile'];
		$post['email']=$u['email'];
		$post['address']=$u['address'];
		$post['msn']=$u['msn'];
		$post['qq']=$u['qq'];
		$post['ali']=$u['ali'];
		$post['skype']=$u['skype'];
			foreach($post as $k=>$v) {
				if($k!='content'){$sqlk .= ','.$k; $sqlv .= ",'$v'"; }
			}
		$post['addtime'] = $DT_TIME;
				$sqlk = substr($sqlk, 1);
				$sqlv = substr($sqlv, 1);
				$db->query("INSERT INTO  {$DT_PRE}buy_pur_6 ($sqlk) VALUES ($sqlv)");
				$puritemid = $db->insert_id();
				$db->query("INSERT INTO {$DT_PRE}buy_pur_data_6 (itemid,content) VALUES ('$puritemid', '$post[content]')");
				//状态信息通知
				$db->query("update {$DT_PRE}buy_6 SET puritemid=$puritemid,step=2 WHERE itemid=".$post['buyitemid']);
				$title=$post['title'].'采购清单！';
				$content='天成医疗网会员：'.$post['username'].'针对'.$title.'-对您下达详细采购清单！请及时响应！<br><div  class="addsupply"><a href="purchase.php">进入管理收到的采购订单</a></div>';
				send_message($post['touser'],$title,$content, 4, $_username);
				//状态信息通知
		dalert('添加采购列表信息成功','', 'parent.window.location="'.$forward.'"');

	break;

	case 'puredit':	//修改采购内容
	    $itemid=intval($_REQUEST[itemid]);$buyitemid=intval($_REQUEST[buyitemid]);
		$p = $db->get_one("SELECT * FROM {$DT_PRE}buy_pur_6 a,{$DT_PRE}buy_pur_data_6 c WHERE a.itemid=c.itemid and a.itemid=$itemid and a.username='$_username' ");
		if(!$p){
		dalert('无任何该条采购数据存在', $forward);exit;
		}
		else
		{
		$item = $db->get_one("SELECT * FROM {$DT_PRE}buy_6 WHERE username='$_username' AND itemid=".$buyitemid);
		}
							if($submit) {
												$r = $db->get_one("SELECT * FROM {$DT_PRE}buy_pur_6 WHERE username='$_username' AND itemid=".$itemid);
													if(!$r){
													dalert('无任何该条采购数据存在', $forward);exit;
													}
														$sqlk = $sqlv = '';
														$post['username']=$_username;
														$u=userinfo($_username);
														$post['telephone']=$u['telephone'];
														$post['company']=$u['company'];
														$post['truename']=$u['truename'];
														$post['mobile']=$u['mobile'];
														$post['email']=$u['email'];
														$post['address']=$u['address'];
														$post['msn']=$u['msn'];
														$post['qq']=$u['qq'];
														$post['ali']=$u['ali'];
														$post['skype']=$u['skype'];
														foreach($post as $k=>$v) {
															if($k!='content'){$sql .= ",$k='$v'";}
														}
														$post['edittime'] = $DT_TIME;
												$db->query("update {$DT_PRE}buy_pur_6  SET $sql WHERE itemid=$itemid");
												if($post[content])$db->query("update {$DT_PRE}buy_pur_data_6  SET content='$post[content]' WHERE itemid=$itemid");
												if($post['status']==4){
												$db->query("update {$DT_PRE}buy_6 SET step=4 WHERE itemid=".$post['buyitemid']);//流程结束
													$title=$post['title'].'采购招标流程结束！';
													$content='天成医疗网会员：'.$post['username'].'的采购发货已经收到，采购招标流程结束！<br><div  class="addsupply"><a href="purchase.php">点击进入查看采购订单状态</a></div>';
													send_message($r['touser'],$title,$content, 4, $_username);
													dalert('确认收货，招标流程结束！','', 'parent.window.location="'.$forward.'"');
												}//流程结束
												else{
												dalert('修改采购列表信息成功','', 'parent.window.location="'.$forward.'"');}
							}
							else
							{
												extract($item);
												$totime = $totime ? timetodate($totime, 3) : '';
							}
	break;

	case 'pur':
		$itemid or message();
		$do->itemid = $itemid;
		$item = $do->get_one();
		if(!$item || $item['username'] != $_username) message();
		if($MG['edit_limit'] < 0) message($L['edit_refuse']);
		if($MG['edit_limit'] && $DT_TIME - $item['addtime'] > $MG['edit_limit']*86400) message(lang($L['edit_limit'], array($MG['edit_limit'])));
		extract($item);
		$totime = $totime ? timetodate($totime, 3) : '';
	break;
	case 'purlist':
		$condition = "username='$_username'";
		$condition .= " AND status>0";
	$lists = $do->get_purlist($condition, $MOD['order']);
	//print_r($lists);
	break;
	case 'purdel':
		$db->query("DELETE FROM {$DT_PRE}buy_pur_6 WHERE username='$_username' and itemid=$itemid and status<3");
		$db->query("DELETE FROM {$DT_PRE}buy_pur_data_6 WHERE username='$_username' and itemid=$itemid and status<3");
		$db->query("update {$DT_PRE}buy_6 SET puritemid=0 WHERE username='$_username' and step<2 and itemid=".$_GET['buyitemid']);
		dmsg('删除采购信息成功', $forward);
	break;


	case 'edit':
		$itemid or message();
		$do->itemid = $itemid;
		$item = $do->get_one();
		if(!$item || $item['username'] != $_username) message();
		if($MG['edit_limit'] < 0) message($L['edit_refuse']);
		if($MG['edit_limit'] && $DT_TIME - $item['addtime'] > $MG['edit_limit']*86400) message(lang($L['edit_limit'], array($MG['edit_limit'])));
		if($submit) {
			if($do->pass($post)) {
				$CAT = get_cat($post['catid']);
				if(!$CAT || !check_group($_groupid, $CAT['group_add'])) dalert(lang($L['group_add'], array($CAT['catname'])));
				$post['addtime'] = timetodate($item['addtime']);
				$post['level'] = $item['level'];
				$post['fee'] = $item['fee'];
				$post['style'] = addslashes($item['style']);
				$post['template'] = addslashes($item['template']);
				$post['filepath'] = addslashes($item['filepath']);
				$post['note'] = addslashes($item['note']);
					if(!$IMVIP && $MG['uploadpt']) {
						$post['thumb1'] = $item['thumb1'];
						$post['thumb2'] = $item['thumb2'];
					}
				$need_check =  $MOD['check_add'] == 2 ? $MG['check'] : $MOD['check_add'];
				$post['status'] = get_status($item['status'], $need_check);
				$post['hits'] = $item['hits'];
				$post['username'] = $_username;
					if($item['selitemid']==0&&$post_fields['selitemid']){
						//确定应标结果，并将结果告知所有应标人员
						$title=$item['title']."已确定最终结果";
						$r = $db->get_one("SELECT * FROM  {$DT_PRE}buy_supplyinfo_6 WHERE itemid=".$post_fields['selitemid']);
						$content="<p>恭喜！会员".$r['fromuser']."获得".$item['title']."为指定供应商！最终结果点击以下链接查看:<br><a href='".$MODULE[6][linkurl].$item['linkurl']."' target='_blank'>".$item['title']."</a><br>";
						$userlist=getsqldata("fromuser","{$DT_PRE}buy_supplyinfo_6"," buyitemid=".$item['itemid']." and agree=1",10);
							 foreach($userlist as $k => $v) {
								send_message($v['fromuser'],$title,$content, 4, $_username);
							 }
						$post['step'] =1;
					}//确定应标结果，并将结果告知所有应标人员
				if(!$supply){$post['status'] = get_status($item['status'], $need_check);//应标管理后不需审核
				}else{$L['success_edit']='应标管理选定成功!';}
				if($post_fields['purchase']==1){//确定采购流程，如果是线上采购则跳转到线上采购流程
				$r = $db->get_one("SELECT COUNT(*) AS num FROM {$DT_PRE}address WHERE username='$_username'");
				   if($r['num']){
					 $forward=$MODULE[2][linkurl].'my.php?mid='.$mid.'&action=pur&itemid='.$itemid;
				   }else{
					 $forward=$MODULE[2][linkurl].'address.php?action=add&mid=6&itemid='.$itemid;$L['success_edit']='应标管理选定成功,请补充线下收货地址！!';
				   }
				}
				if($FD) fields_check($post_fields);
				if($CP) property_check($post_ppt);
				if($FD) fields_update($post_fields, $table, $do->itemid);
				if($CP) property_update($post_ppt, $moduleid, $post['catid'], $do->itemid);
				$do->edit($post);
				set_cookie('dmsg', $L['success_edit']);
				dalert('', '', 'parent.window.location="'.$forward.'"');
			} else {
				dalert($do->errmsg);
			}
		} else {
			extract($item);
			$totime = $totime ? timetodate($totime, 3) : '';
		}
	break;
	case 'delete':
		$MG['delete'] or message();
		$itemid or message();
		$itemids = is_array($itemid) ? $itemid : array($itemid);
		foreach($itemids as $itemid) {
			$do->itemid = $itemid;
			$item = $db->get_one("SELECT username FROM {$table} WHERE itemid=$itemid");
			
			if(!$item || $item['username'] != $_username) message();
				
			$do->recycle($itemid);
		}
		dmsg($L['success_delete'], $forward);
	break;
	case 'refresh':
		$MG['refresh_limit'] > -1 or dalert(lang('message->without_permission_and_upgrade'), 'goback');
		$do->_update($_username);
		$itemid or message($L['select_info']);
		$itemids = $itemid;
		$s = $f = 0;
		foreach($itemids as $itemid) {
			$do->itemid = $itemid;
			$item = $db->get_one("SELECT username,edittime FROM {$table} WHERE itemid=$itemid");
			$could_refresh = $item && $item['username'] == $_username;
			if($could_refresh && $MG['refresh_limit'] && $DT_TIME - $item['edittime'] < $MG['refresh_limit']) $could_refresh = false;
			if($could_refresh && $MOD['credit_refresh'] && $MOD['credit_refresh'] > $_credit) $could_refresh = false;
			if($could_refresh) {
				$do->refresh($itemid);
				$s++;
				if($MOD['credit_refresh']) $_credit = $_credit - $MOD['credit_refresh'];
			} else {
				$f++;
			}			
		}
		if($MOD['credit_refresh'] && $s) {
			$credit = $s*$MOD['credit_refresh'];
			credit_add($_username, -$credit);
			credit_record($_username, -$credit, 'system', lang($L['credit_record_refresh'], array($MOD['name'])), lang($L['refresh_total'], array($s)));
		}
		$msg = lang($L['refresh_success'], array($s));
		if($f) $msg = $msg.' '.lang($L['refresh_fail'], array($f));
		dmsg($msg, $forward);
	break;
	default:
		$status = isset($status) ? intval($status) : 3;
		in_array($status, array(1, 2, 3, 4)) or $status = 3;
		$condition = "username='$_username'";
		$condition .= " AND status=$status";
		$typeid = isset($typeid) ? ($typeid === '' ? -1 : intval($typeid)) : -1;
		if($keyword) $condition .= " AND keyword LIKE '%$keyword%'";
		if($catid) $condition .= ($CAT['child']) ? " AND catid IN (".$CAT['arrchildid'].")" : " AND catid=$catid";
		if($typeid >=0 ) $condition .= " AND typeid=$typeid";
		$timetype = strpos($MOD['order'], 'add') !== false ? 'add' : '';
		$lists = $do->get_list($condition, $MOD['order']);
	break;
}

if($_userid) {
	$nums = array();
	for($i = 1; $i < 5; $i++) {
		$r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE username='$_username' AND status=$i");
		$nums[$i] = $r['num'];
	}
	$r = $db->get_one("SELECT COUNT(*) AS num FROM {$DT_PRE}buy_pur_6 WHERE username='$_username' AND status>0");
	$nums[5] = $r['num'];
}
$head_title = lang($L['module_manage'], array($MOD['name']));
include template($MOD['template_my'] ? $MOD['template_my'] : 'my_'.$module, 'member');
?>