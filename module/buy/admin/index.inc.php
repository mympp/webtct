<?php
defined('DT_ADMIN') or exit('Access Denied');
require MD_ROOT.'/buy.class.php';
$do = new buy($moduleid);
$menus = array (
    array('添加'.$MOD['name'], '?moduleid='.$moduleid.'&action=add'),
    array($MOD['name'].'列表', '?moduleid='.$moduleid),
    array('审核'.$MOD['name'], '?moduleid='.$moduleid.'&action=check'),
    array('过期'.$MOD['name'], '?moduleid='.$moduleid.'&action=expire'),
    array('未通过'.$MOD['name'], '?moduleid='.$moduleid.'&action=reject'),
    array('回收站', '?moduleid='.$moduleid.'&action=recycle'),
    array('移动分类', '?moduleid='.$moduleid.'&action=move'),
);

if(in_array($action, array('add', 'edit'))) {
	$FD = cache_read('fields-'.substr($table, strlen($DT_PRE)).'.php');
	if($FD) require DT_ROOT.'/include/fields.func.php';
	isset($post_fields) or $post_fields = array();
	$CP = $MOD['cat_property'];
	if($CP) require DT_ROOT.'/include/property.func.php';
	isset($post_ppt) or $post_ppt = array();
}

if($_catids || $_areaids) require DT_ROOT.'/admin/admin_check.inc.php';

if(in_array($action, array('', 'check', 'expire', 'reject', 'recycle'))) {
	$sfields = array('模糊', '标题', '产品名称', '需求数量', '价格要求', '包装要求', '简介', '公司名', '联系人', '联系电话', '联系地址', '电子邮件', '联系MSN', '联系QQ', '会员名', '编辑', 'IP', '参数名1', '参数名2', '参数名3', '参数值1', '参数值2', '参数值3', '文件路径', '内容模板');
	$dfields = array('keyword', 'title', 'tag', 'amount', 'price', 'pack', 'introduce', 'company', 'truename', 'telephone', 'address', 'email', 'msn', 'qq','username', 'editor', 'ip', 'n1', 'n2', 'n3', 'v1', 'v2', 'v3', 'filepath', 'template');
	$sorder  = array('结果排序方式', '更新时间降序', '更新时间升序', '添加时间降序', '添加时间升序', '浏览次数降序', '浏览次数升序', '信息ID降序', '信息ID升序');
	$dorder  = array($MOD['order'], 'edittime DESC', 'edittime ASC', 'addtime DESC', 'addtime ASC', 'hits DESC', 'hits ASC', 'itemid DESC', 'itemid ASC');

	$level = isset($level) ? intval($level) : 0;
	$typeid = isset($typeid) ? ($typeid === '' ? -1 : intval($typeid)) : -1;
	isset($fields) && isset($dfields[$fields]) or $fields = 0;
	isset($order) && isset($dorder[$order]) or $order = 0;
	
	isset($datetype) && in_array($datetype, array('edittime', 'addtime', 'totime')) or $datetype = 'edittime';
	$fromdate = isset($fromdate) && is_date($fromdate) ? $fromdate : '';
	$fromtime = $fromdate ? strtotime($fromdate.' 0:0:0') : 0;
	$todate = isset($todate) && is_date($todate) ? $todate : '';
	$totime = $todate ? strtotime($todate.' 23:59:59') : 0;

	$areaid = isset($areaid) ? intval($areaid) : 0;
	$thumb = isset($thumb) ? intval($thumb) : 0;
	$guest = isset($guest) ? intval($guest) : 0;
	$itemid or $itemid = '';
	$minvip = isset($minvip) ? intval($minvip) : '';
	$minvip or $minvip = '';
	$maxvip = isset($maxvip) ? intval($maxvip) : '';
	$maxvip or $maxvip = '';

	$fields_select = dselect($sfields, 'fields', '', $fields);
	$type_select = dselect($TYPE, 'typeid', $MOD['name'].'类型', $typeid);
	$level_select = level_select('level', '级别', $level, 'all');
	$order_select  = dselect($sorder, 'order', '', $order);

	$condition = '';
	if($_childs) $condition .= " AND catid IN (".$_childs.")";//CATE
	if($_areaids) $condition .= " AND areaid IN (".$_areaids.")";//CITY
	if($keyword) $condition .= " AND $dfields[$fields] LIKE '%$keyword%'";
	if($catid) $condition .= ($CAT['child']) ? " AND catid IN (".$CAT['arrchildid'].")" : " AND catid=$catid";
	if($areaid) $condition .= ($AREA[$areaid]['child']) ? " AND areaid IN (".$AREA[$areaid]['arrchildid'].")" : " AND areaid=$areaid";
	if($typeid >=0 ) $condition .= " AND typeid=$typeid";
	if($level) $condition .= $level > 9 ? " AND level>0" : " AND level=$level";
	if($fromtime) $condition .= " AND `$datetype`>=$fromtime";
	if($totime) $condition .= " AND `$datetype`<=$totime";
	if($thumb) $condition .= " AND thumb<>''";
	if($guest) $condition .= " AND username=''";
	if($minvip) $condition .= " AND vip>=$minvip";
	if($maxvip) $condition .= " AND vip<=$maxvip";
	if($itemid) $condition .= " AND itemid=$itemid";

	$timetype = strpos($dorder[$order], 'add') !== false ? 'add' : '';
}
switch($action) {
	case 'add':
		if($submit) {
			if($do->pass($post)) {
				if($FD) fields_check($post_fields);
				if($CP) property_check($post_ppt);
				$do->add($post);
				if($FD) fields_update($post_fields, $table, $do->itemid);
				if($CP) property_update($post_ppt, $moduleid, $post['catid'], $do->itemid);
				if($MOD['show_html'] && $post['status'] > 2) $do->tohtml($do->itemid);
				dmsg('添加成功', '?moduleid='.$moduleid.'&action='.$action);
			} else {
				msg($do->errmsg);
			}
		} else {
			foreach($do->fields as $v) {
				isset($$v) or $$v = '';
			}
			$content = '';
			$status = 3;
			$addtime = timetodate($DT_TIME);
			$totime = '';
			$username = $_username;
			$typeid = 0;
			$item = array();
			$menuid = 0;
			isset($url) or $url = '';
			if($url) {
				$tmp = fetch_url($url);
				if($tmp) extract($tmp);
			}
			include tpl('edit', $module);
		}
	break;
	case 'edit':
		$itemid or msg();
		$do->itemid = $itemid;
		if($submit) {
			if($do->pass($post)) {
				if($FD) fields_check($post_fields);
				if($CP) property_check($post_ppt);
				if($FD) fields_update($post_fields, $table, $do->itemid);
				if($CP) property_update($post_ppt, $moduleid, $post['catid'], $do->itemid);
				$do->edit($post);
				dmsg('修改成功', $forward);
			} else {
				msg($do->errmsg);
			}
		} else {
			$item = $do->get_one();
			extract($item);
			$addtime = timetodate($addtime);
			$totime = $totime ? timetodate($totime, 3) : '';
			$menuon = array('5', '4', '2', '1', '3');
			$menuid = $menuon[$status];
			include tpl($action, $module);
		}
	break;
	case 'showsupply':
		$itemid or msg();
		$do->itemid = $itemid;
		if($submit) {
			if($do->pass($post)) {
				if($FD) fields_check($post_fields);
				if($CP) property_check($post_ppt);
				if($FD) fields_update($post_fields, $table, $do->itemid);
				if($CP) property_update($post_ppt, $moduleid, $post['catid'], $do->itemid);
				dmsg('修改成功', $forward);
			} else {
				msg($do->errmsg);
			}
		} else {
			$item = $do->get_one();
			extract($item);
			/*
			时间：2015-3-3 14:22:45
			地点：采购招标平台
			人物：李通
			事件：修改获取的数据条件。实现获取相对应的数据。 
			关联：
			*/
			$result = $db->query("SELECT * FROM {$DT_PRE}buy_supplyinfo_6 where buyitemid=".$itemid." ORDER BY itemid DESC LIMIT 0,100");
			while($r = $db->fetch_array($result)) {
				$lists[] = $r;
			}
			$addtime = timetodate($addtime);
			$totime = $totime ? timetodate($totime, 3) : '';
			$menuon = array('5', '4', '2', '1', '3');
			$menuid = $menuon[$status];
			$tname = '修改'.$MOD['name'];
			include tpl($action, $module);
		}
	break;

		/*
		时间：2015-3-3
		地点：采购招标平台
		人物：李通
		事件：增加招标相关内容修改页面展示
		关联：module/admin/template/editshowsupply.tpl.php
		*/
		#------start---------
	case 'editshowsupply':
		$itemid or msg();
		$do->itemid = $itemid;
		if($submit) {
			$itemid=$_POST[itemid];
			$buyitemid=$_POST[buyitemid];
			$selitemid=$_POST[selitemid];
			$title=$_POST[title];
			$fromuser=$_POST[fromuser];
			$touser=$_POST[touser];
			$isread=$_POST[isread];
			$agree=$_POST[agree];
			$status=$_POST[status];
			$addtime=strtotime($_POST[addtime]);
			$content=$_POST[content];
			$d = $db->get_one("SELECT * FROM {$DT_PRE}buy_6  WHERE itemid='$buyitemid'");
					$db->query("UPDATE `{$DT_PRE}buy_supplyinfo_6` SET `title`='$title',`fromuser`='$fromuser', `touser`='$touser',`isread`='$isread',`status`='$status',`agree`='$agree',`addtime`='$addtime',`content`='$content' WHERE itemid=".$itemid.""); 
						if($d[selitemid]==0&&$selitemid>0){
									$title=$d[title]."已确定最终中标结果";
									$content="<p>恭喜！会员".$fromuser."获得".$title."为指定供应商！最终结果点击以下链接查看:<br><a href='".$MODULE[6][linkurl].$d['linkurl']."' target='_blank'>".$d['title']."</a><br>";
									$userlist=getsqldata("fromuser","{$DT_PRE}buy_supplyinfo_6"," buyitemid=".$buyitemid." and agree=1",10);
										 foreach($userlist as $k => $v) {
											send_message($v['fromuser'],$title,$content, 4, $touser);
										 }
						}
			$db->query("UPDATE `{$DT_PRE}buy_6` SET `selitemid`='$selitemid' WHERE itemid=".$buyitemid); 
			if($status==0){  
				$db->query("delete  from {$DT_PRE}buy_supplyinfo_6 WHERE itemid=".$itemid);
							$db->query("UPDATE `{$DT_PRE}buy_6` SET  supplycount= supplycount-1 WHERE itemid=".$buyitemid." and supplycount>0"); 
									$db->query("UPDATE `{$DT_PRE}buy_6` SET  selitemid=0 WHERE itemid=".$buyitemid." and selitemid=".$itemid); 
				dmsg('删除成功', '?moduleid=6&file=index&action=showsupply&itemid='.$_POST[buyitemid]); 
			}
			dmsg('修改成功', $forward);
		}else {
			$v = $db->get_one("SELECT * FROM `{$DT_PRE}buy_supplyinfo_6` WHERE itemid=".$itemid."");
			$d = $db->get_one("SELECT * FROM {$DT_PRE}buy_6  WHERE itemid='$v[buyitemid]'");
			extract($d);
			$addtime = timetodate($addtime);
			$totime = $totime ? timetodate($totime, 3) : '';
			$menuon = array('5', '4', '2', '1', '3');
			$menuid = $menuon[$status];
			$tname = '修改'.$MOD['name'];
			include tpl($action, $module);
		}
	break;
		#---------END--------
#应标管理

	/*
		时间：2015-4-10
		地点：采购招标平台(应标管理)
		人物：李通
		事件：增加应标管理相关内容展示
		关联：module/admin/template/editshowsupply.tpl.php
	*/
#------------start-----------------
case 'talent':
		if($submit) {
			if($do->pass($post)) {
				if($FD) fields_check($post_fields);
				if($CP) property_check($post_ppt);
				if($FD) fields_update($post_fields, $table, $do->itemid);
				if($CP) property_update($post_ppt, $moduleid, $post['catid'], $do->itemid);
				dmsg('修改成功', $forward);
			} else {
				msg($do->errmsg);
			}
		} else {
			//$item = $do->get_one();
			//extract($item);
			/*
			时间：2015-3-3 14:22:45
			地点：采购招标平台
			人物：李通
			事件：修改获取的数据条件。实现获取相对应的数据。 
			关联：
			*/
		$sfields = array('按条件', '会员名','企业名');
		$dfields = array('username', 'username','company');
		$fields_select = dselect($sfields, 'fields', '', $fields);
		#if($keyword) $condition .= "$kw";
		if($keyword) $condition .= "$dfields[$fields] LIKE '%$kw%'";
		if($condition==''){
			$r = $db->get_one("select count(DISTINCT fromuser) as num from {$DT_PRE}buy_supplyinfo_6 ");
			$items = $r['num'];
			$pages = pages($items, $page, $pagesize);		
			$child = array();
			$result = $db->query("select `{$DT_PRE}member`.username, `{$DT_PRE}member`.company, count(`{$DT_PRE}buy_supplyinfo_6`.fromuser) as point from `{$DT_PRE}member`,`{$DT_PRE}buy_supplyinfo_6` where `{$DT_PRE}member`.username=`{$DT_PRE}buy_supplyinfo_6`.fromuser group by `{$DT_PRE}buy_supplyinfo_6`.fromuser DESC LIMIT $offset,$pagesize");
			while($r = $db->fetch_array($result)) {
				$lists[] = $r;
			}
		}else{
			#$result = $db->query("select `{$DT_PRE}member`.username, `{$DT_PRE}member`.company, count(`{$DT_PRE}buy_supplyinfo_6`.fromuser) as point from `{$DT_PRE}member`,`{$DT_PRE}buy_supplyinfo_6` where `{$DT_PRE}member`.username=`{$DT_PRE}buy_supplyinfo_6`.fromuser and `{$DT_PRE}member`.username='$condition' group by `{$DT_PRE}buy_supplyinfo_6`.fromuser");
			$result = $db->query("select `{$DT_PRE}member`.username, `{$DT_PRE}member`.company, count(`{$DT_PRE}buy_supplyinfo_6`.fromuser) as point from `{$DT_PRE}member`,`{$DT_PRE}buy_supplyinfo_6` where `{$DT_PRE}member`.username=`{$DT_PRE}buy_supplyinfo_6`.fromuser and `{$DT_PRE}member`.$condition group by `{$DT_PRE}buy_supplyinfo_6`.fromuser");
			while($r = $db->fetch_array($result)) {
				$lists[] = $r;
			}

		}
			$addtime = timetodate($addtime);
			$totime = $totime ? timetodate($totime, 3) : '';
			$menuon = array('5', '4', '2', '1', '3');
			$menuid = $menuon[$status];
			$tname = '修改'.$MOD['name'];
			include tpl('talent', $module);
		}
	break;
	case 'showtalent':
		$username or msg();
		$do->username = $username;
		if($submit) {
			if($do->pass($post)) {
				if($FD) fields_check($post_fields);
				if($CP) property_check($post_ppt);
				if($FD) fields_update($post_fields, $table, $do->itemid);
				if($CP) property_update($post_ppt, $moduleid, $post['catid'], $do->itemid);
				dmsg('修改成功', $forward);
			} else {
				msg($do->errmsg);
			}
		} else {
			//$username = $do->get_one();
			//extract($username);
			/*
			时间：2015-3-3 14:22:45
			地点：采购招标平台
			人物：李通
			事件：修改获取的数据条件。实现获取相对应的数据。 
			关联：
			*/
			$result = $db->query("SELECT * FROM {$DT_PRE}buy_supplyinfo_6 where fromuser='$username' ORDER BY itemid DESC LIMIT 0,100");
			while($r = $db->fetch_array($result)) {
				$itemid = $r['buyitemid'];
				$d = $db->get_one("SELECT * FROM {$DT_PRE}buy_6  WHERE itemid='$itemid'");
				$r['linkurl']=$MOD['linkurl'].$d['linkurl'];
				$r['bitemid']=$d['itemid'];
				$r['btitle']=$d['title'];
				$r['bselitemid']=$d['selitemid'];
				$r['puritemid'] =$d['puritemid'];
				$lists[] = $r;
			}
			$addtime = timetodate($addtime);
			$totime = $totime ? timetodate($totime, 3) : '';
			$menuon = array('5', '4', '2', '1', '3');
			$menuid = $menuon[$status];
			$tname = '修改'.$MOD['name'];
			include tpl('showtalent', $module);
		}
	break;


#---------------end----------------
/*
*地点：采购招标平台
*时间：2015年5月15日14:17:25
*人物：李通
*事件：增加采购后台管理，
*关联：/template/purchase.tpl.php
*/
#------------start-----------------
case 'purchase':
		if($submit) {
			if($do->pass($post)) {
				if($FD) fields_check($post_fields);
				if($CP) property_check($post_ppt);
				if($FD) fields_update($post_fields, $table, $do->itemid);
				if($CP) property_update($post_ppt, $moduleid, $post['catid'], $do->itemid);
				dmsg('修改成功', $forward);
			} else {
				msg($do->errmsg);
			}
		} else {
		$sfields = array('按条件', '会员名','企业名');
		$dfields = array('username', 'username','company');
		$fields_select = dselect($sfields, 'fields', '', $fields);
		if($keyword) $condition .= "$dfields[$fields] LIKE '%$kw%'";
		if($condition==''){
			$r = $db->get_one("select count(DISTINCT username) as num from {$DT_PRE}buy_pur_6 ");
			$items = $r['num'];
			$pages = pages($items, $page, $pagesize);		
			$child = array();
			$result = $db->query("select `{$DT_PRE}member`.username, `{$DT_PRE}member`.company, count(`{$DT_PRE}buy_pur_6`.username) as point from `{$DT_PRE}member`,`{$DT_PRE}buy_pur_6` where `{$DT_PRE}member`.username=`{$DT_PRE}buy_pur_6`.username group by `{$DT_PRE}buy_pur_6`.username DESC LIMIT $offset,$pagesize");
			while($r = $db->fetch_array($result)) {
				$lists[] = $r;
			}
		}else{
			$result = $db->query("select `{$DT_PRE}member`.username, `{$DT_PRE}member`.company, count(`{$DT_PRE}buy_supplyinfo_6`.fromuser) as point from `{$DT_PRE}member`,`{$DT_PRE}buy_supplyinfo_6` where `{$DT_PRE}member`.username=`{$DT_PRE}buy_supplyinfo_6`.fromuser and `{$DT_PRE}member`.$condition group by `{$DT_PRE}buy_supplyinfo_6`.fromuser");
			while($r = $db->fetch_array($result)) {
				$lists[] = $r;
			}
		}
			include tpl($action, $module);
		}
	break;
//获取从采购页面传过的值
//关联：./template/showpurchase.tpl.php
case 'showpurchase':
		$username or msg();
		$do->username = $username;
		if($submit) {
			if($do->pass($post)) {
				if($FD) fields_check($post_fields);
				if($CP) property_check($post_ppt);
				if($FD) fields_update($post_fields, $table, $do->itemid);
				if($CP) property_update($post_ppt, $moduleid, $post['catid'], $do->itemid);
				dmsg('修改成功', $forward);
			} else {
				msg($do->errmsg);
			}
		} else {
			$result = $db->query("SELECT * FROM {$DT_PRE}buy_pur_6 where username='$username' ORDER BY itemid DESC LIMIT 0,100");
			while($r = $db->fetch_array($result)) {
				$lists[] = $r;
			}
			$addtime = timetodate($addtime);
			$totime = $totime ? timetodate($totime, 3) : '';
			$menuon = array('5', '4', '2', '1', '3');
			$menuid = $menuon[$status];
			$tname = '修改'.$MOD['name'];
			include tpl('showpurchase', $module);
		}
	break;
//应标修改
case 'editpurchase':
		$itemid or msg();
		$do->itemid = $itemid;
		if($submit) {
			$content = $_POST[content];
			$status = $_POST[status];
			$title = $_POST[title];
			$touser = $_POST[touser];
			$company = $_POST[company];
			$username = $_POST[username];
			$buyer_name = $_POST[buyer_name];
			$buyer_address = $_POST[buyer_address];
			$buyer_postcode = $_POST[buyer_postcode];
			$buyer_mobile = $_POST[buyer_mobile];
			$buyer_phone = $_POST[buyer_phone];
			$buyer_receive= $_POST[buyer_receive];
			$note = $_POST[note];
			$db->query("UPDATE `{$DT_PRE}buy_pur_6` SET `title`='$title',`touser`='$touser', `company`='$company', `username`='$username', `buyer_name`='$buyer_name', `buyer_postcode`='$buyer_postcode',`buyer_mobile`='$buyer_mobile',`status`='$status',`buyer_phone`='$buyer_phone',`buyer_receive`='$buyer_receive' WHERE  itemid='$itemid'"); 
			$db->query("UPDATE `{$DT_PRE}buy_pur_6` SET `title`='$title' WHERE itemid='$itemid'");
				dmsg('修改成功', $forward);
			}else {
			$v = $db->get_one("SELECT * FROM `{$DT_PRE}buy_pur_6` WHERE itemid=".$itemid."");
			$r = $db->get_one("SELECT * FROM `{$DT_PRE}buy_pur_data_6` WHERE itemid=".$itemid."");
			$v['content']=$r['content'];
			$addtime = timetodate($addtime);
			$totime = $totime ? timetodate($totime, 3) : '';
			$menuon = array('5', '4', '2', '1', '3');
			$menuid = $menuon[$status];
			$tname = '修改'.$MOD['name'];
			include tpl($action, $module);
		}
	break;
#---------------end----------------

	case 'move':
		if($submit) {
			$fromids or msg('请填写来源ID');
			if($tocatid) {
				$db->query("UPDATE {$table} SET catid=$tocatid WHERE `{$fromtype}` IN ($fromids)");
				dmsg('移动成功', $forward);
			} else {
				msg('请选择目标分类');
			}
		} else {
			$itemid = $itemid ? implode(',', $itemid) : '';
			$menuid = 6;
			include tpl($action);
		}
	break;
	case 'update':
		is_array($itemid) or msg('请选择'.$MOD['name']);
		foreach($itemid as $v) {
			$do->update($v);
		}
		dmsg('更新成功', $forward);
	break;
	case 'tohtml':
		is_array($itemid) or msg('请选择'.$MOD['name']);
		foreach($itemid as $itemid) {
			tohtml('show', $module);
		}
		dmsg('生成成功', $forward);
	break;
	case 'delete':
		$itemid or msg('请选择'.$MOD['name']);
		isset($recycle) ? $do->recycle($itemid) : $do->delete($itemid);
		dmsg('删除成功', $forward);
	break;
	case 'restore':
		$itemid or msg('请选择'.$MOD['name']);
		$do->restore($itemid);
		dmsg('还原成功', $forward);
	break;
	case 'refresh':
		$itemid or msg('请选择'.$MOD['name']);
		$do->refresh($itemid);
		dmsg('刷新成功', $forward);
	break;
	case 'clear':
		$do->clear();
		dmsg('清空成功', $forward);
	break;
	case 'level':
		$itemid or msg('请选择'.$MOD['name']);
		$level = intval($level);
		$do->level($itemid, $level);
		dmsg('级别设置成功', $forward);
	break;
	case 'type':
		$itemid or msg('请选择'.$MOD['name']);
		$tid = intval($tid);
		array_key_exists($tid, $TYPE) or $tid = 0;
		$do->type($itemid, $tid);
		dmsg('类型设置成功', $forward);
	break;
	case 'recycle':
		$lists = $do->get_list('status=0'.$condition, $dorder[$order]);
		$menuid = 5;
		include tpl('index', $module);
	break;
	case 'reject':
		if($itemid && !$psize) {
			$do->reject($itemid);
			dmsg('拒绝成功', $forward);
		} else {
			$lists = $do->get_list('status=1'.$condition, $dorder[$order]);
			$menuid = 4;
			include tpl('index', $module);
		}
	break;
	case 'expire':
		if(isset($refresh)) {
			if(isset($extend)) {
				$days = isset($days) ? intval($days) : 0;
				$days or msg('请填写天数');
				$itemid or msg('请选择信息');
				foreach($itemid as $v) {
					$db->query("UPDATE {$table} SET totime=totime+$days*86400,status=3 WHERE itemid='$v' AND totime>0");
				}
				$do->expire();
				dmsg('延时成功', $forward);
			} else {
				$do->expire();
				dmsg('刷新成功', $forward);
			}
		} else {
			$lists = $do->get_list('status=4'.$condition);
			$menuid = 3;
			include tpl('index', $module);
		}
	break;
	case 'check':
		if($itemid && !$psize) {
			$do->check($itemid);
			dmsg('审核成功', $forward);
		} else {
			$lists = $do->get_list('status=2'.$condition, $dorder[$order]);
			$menuid = 2;
			include tpl('index', $module);
		}
	break;
	default:
		$lists = $do->get_list('status=3'.$condition, $dorder[$order]);
		$menuid = 1;
		include tpl('index', $module);
	break;
}
?>