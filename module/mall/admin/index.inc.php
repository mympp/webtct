<?php

/*
********************************************************************
*time: 2014-03-24
*who: tcdahe
*对产品批量分配科室kcatids
*修改：
*	添加 case move_keshis
*	添加 $keshi 选定 $condition
*
*关联文件：
*	\module\mall\admin\template\move.tpl.php
*	\module\mall\admin\template\index.tpl.php
*
*********************************************************************
*time:2014-09-11
*who:tcdahe
*后台产品更改到指定会员
*
*添加：switch case条件=>change_member
*
*关联文件：
*	module\mall\admin\template\index.tpl.php
*
********************************************************************
*时间：2015-6-9 13:51:50
*李通
*对产品新增（进口&&国产）搜索条件
*修改:增加
*	if($expcate == 1) $condition .= " AND expcate = '0'";
*	if($expcate == 2) $condition .= " AND expcate = '1'";
*关联到：
*		module\mall\admin\template\index.tpl.php
*/


defined('DT_ADMIN') or exit('Access Denied');
require MD_ROOT.'/mall.class.php';
$do = new mall($moduleid);
$menus = array (
    array('添加商品', '?moduleid='.$moduleid.'&action=add'),
    array('商品列表', '?moduleid='.$moduleid),
    array('审核商品', '?moduleid='.$moduleid.'&action=check'),
    array('下架商品', '?moduleid='.$moduleid.'&action=expire'),
    array('未通过商品', '?moduleid='.$moduleid.'&action=reject'),
    array('回收站', '?moduleid='.$moduleid.'&action=recycle'),
    array('移动分类', '?moduleid='.$moduleid.'&action=move'),
    array('证书审核', '?moduleid='.$moduleid.'&file=validate'),
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
	$sfields = array('模糊',  '商品名称', '商品品牌',  '简介', '计量单位', '关联名称', '公司名', '联系人', '联系电话', '联系地址', '电子邮件', '联系MSN', '联系QQ', '会员名', '编辑', 'IP', '属性名1', '属性名2', '属性名3', '属性值1', '属性值2', '属性值3', '快递1', '快递2', '快递3', '文件路径', '内容模板');
	$dfields = array('keyword', 'title', 'brand', 'introduce', 'unit', 'relate_name', 'company', 'truename', 'telephone', 'address', 'email', 'msn', 'qq','username', 'editor', 'ip', 'n1', 'n2', 'n3', 'v1', 'v2', 'v3', 'express_name_1', 'express_name_2', 'express_name_3', 'filepath', 'template');
	$sorder  = array('结果排序方式', '更新时间降序', '更新时间升序', '添加时间降序', '添加时间升序', VIP.'级别降序', VIP.'级别升序', '商品单价降序', '商品单价升序', '订单数量降序', '订单数量升序', '销售数量降序', '销售数量升序', '库存总量降序', '库存总量升序', '评论次数降序', '评论次数升序', '浏览人气降序', '浏览人气升序', '信息ID降序', '信息ID升序');
	$dorder  = array($MOD['order'], 'edittime DESC', 'edittime ASC', 'addtime DESC', 'addtime ASC', 'vip DESC', 'vip ASC', 'price DESC', 'price DESC', 'orders DESC', 'orders ASC', 'sales DESC', 'sales ASC', 'amount DESC', 'amount ASC', 'comments DESC', 'comments ASC', 'hits DESC', 'hits ASC', 'itemid DESC', 'itemid ASC');

	$level = isset($level) ? intval($level) : 0;
	isset($fields) && isset($dfields[$fields]) or $fields = 0;
	isset($order) && isset($dorder[$order]) or $order = 0;
	$elite = isset($elite) ? intval($elite) : 0;
	$cod = isset($cod) ? intval($cod) : 0;
	$mp = isset($mp) ? intval($mp) : 0;
	$rl = isset($rl) ? intval($rl) : 0;
	$price = isset($price) ? intval($price) : 0;

	isset($datetype) && in_array($datetype, array('edittime', 'addtime')) or $datetype = 'edittime';
	$fromdate = isset($fromdate) && is_date($fromdate) ? $fromdate : '';
	$fromtime = $fromdate ? strtotime($fromdate.' 0:0:0') : 0;
	$todate = isset($todate) && is_date($todate) ? $todate : '';
	$totime = $todate ? strtotime($todate.' 23:59:59') : 0;
	
	$minprice = isset($minprice) ? dround($minprice) : '';
	$minprice or $minprice = '';
	$maxprice = isset($maxprice) ? dround($maxprice) : '';
	$maxprice or $maxprice = '';
	$minorders = isset($minorders) ? intval($minorders) : '';
	$minorders or $minorders = '';
	$maxorders = isset($maxorders) ? intval($maxorders) : '';
	$maxorders or $maxorders = '';
	$minsales = isset($minsales) ? intval($minsales) : '';
	$minsales or $minsales = '';
	$maxsales = isset($maxsales) ? intval($maxsales) : '';
	$maxsales or $maxsales = '';
	$minamount = isset($minamount) ? intval($minamount) : '';
	$minamount or $minamount = '';
	$maxamount = isset($maxamount) ? intval($maxamount) : '';
	$maxamount or $maxamount = '';
	$mincomments = isset($mincomments) ? intval($mincomments) : '';
	$mincomments or $mincomments = '';
	$maxcomments = isset($maxcomments) ? intval($maxcomments) : '';
	$maxcomments or $maxcomments = '';
	$minvip = isset($minvip) ? intval($minvip) : '';
	$minvip or $minvip = '';
	$maxvip = isset($maxvip) ? intval($maxvip) : '';
	$maxvip or $maxvip = '';
	$itemid or $itemid = '';

	$fields_select = dselect($sfields, 'fields', '', $fields);
	$level_select = level_select('level', '级别', $level, 'all');
	$order_select  = dselect($sorder, 'order', '', $order);

	$condition = '';
	if($_childs) $condition .= " AND catid IN (".$_childs.")";//CATE
	if($_areaids) $condition .= " AND areaid IN (".$_areaids.")";//CITY
	if($keyword) $condition .= " AND $dfields[$fields] LIKE '%$keyword%'";
	if($catid) $condition .= ($CAT['child']) ? " AND catid IN (".$CAT['arrchildid'].")" : " AND catid=$catid";
	if($areaid) $condition .= ($ARE['child']) ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$areaid";

	if($level) $condition .= $level > 9 ? " AND level>0" : " AND level=$level";
	if($elite) $condition .= " AND elite>0";
	if($cod) $condition .= " AND cod>0";
	if($mp) $condition .= " AND step LIKE '%Y%'";
	if($rl) $condition .= " AND relate_id<>''";
	if($price) $condition .= " AND price>0";
	if($minprice)  $condition .= " AND price>=$minprice";
	if($maxprice)  $condition .= " AND price<=$maxprice";
	if($minorders)  $condition .= " AND orders>=$minorders";
	if($maxorders)  $condition .= " AND orders<=$maxorders";
	if($minsales)  $condition .= " AND sales>=$minsales";
	if($maxsales)  $condition .= " AND sales<=$maxsales";
	if($minamount)  $condition .= " AND amount>=$minamount";
	if($maxamount)  $condition .= " AND amount<=$maxamount";
	if($mincomments)  $condition .= " AND comments>=$mincomments";
	if($maxcomments)  $condition .= " AND comments<=$maxcomments";
	if($minvip)  $condition .= " AND vip>=$minvip";
	if($maxvip)  $condition .= " AND vip<=$maxvip";
	if($fromtime) $condition .= " AND `$datetype`>=$fromtime";
	if($totime) $condition .= " AND `$datetype`<=$totime";
	if($itemid) $condition .= " AND itemid=$itemid";
	if($keshi == 1) $condition .= " AND kcatids != ''";
	if($keshi == 2) $condition .= " AND kcatids = ''";
	if($expcate == 1) $condition .= " AND expcate = '0'";
	if($expcate == 2) $condition .= " AND expcate = '1'";
	if($nocatid == 1) $condition .= " AND catid in(1485)";
	if($yjtem) $condition .=" AND template = 'show-ej'";
	if($kcatids) $condition .=" AND kcatids like '%$kcatids%'";
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
			$a1 = 1;
			$a2 = $a3 = $p1 = $p2 = $p3 = '';
			$unit = '件';
			$boc = 1;
			$content = '';
			$status = 3;
			$addtime = timetodate($DT_TIME);
			$username = $_username;
			$item = array();
			isset($url) or $url = '';
			if($url) {
				$tmp = fetch_url($url);
				if($tmp) extract($tmp);
			}
			$EXP = array();
			$result = $db->query("SELECT * FROM {$DT_PRE}mall_express WHERE username='$username' AND parentid=0 ORDER BY listorder ASC,itemid ASC LIMIT 100");
			while($r = $db->fetch_array($result)) {
				$EXP[] = $r;
			}
			$menuid = 0;
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
			if($step) {
				extract(unserialize($step));
				$a2 > 0 or $a2 = '';
				$a3 > 0 or $a3 = '';
				$p2 > 0 or $p2 = '';
				$p3 > 0 or $p3 = '';
			} else {
				$a1 = 1;
				$p1 = $item['price'];
				$a2 = $a3 = $p2 = $p3 = '';
			}
			$unit or $unit = '件';
			$addtime = timetodate($addtime);
			$EXP = array();
			$result = $db->query("SELECT * FROM {$DT_PRE}mall_express WHERE username='$username' AND parentid=0 ORDER BY listorder ASC,itemid ASC LIMIT 100");
			while($r = $db->fetch_array($result)) {
				$EXP[] = $r;
			}
			$menuon = array('5', '4', '2', '1', '3');
			$menuid = $menuon[$status];
			include tpl($action, $module);
		}
	break;
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
			$menuid = 5;
			include tpl($action);
		}
	break;

	case 'move_keshi':
		if($submit){
			$fromids or msg('请填写要分科室的产品ID');
			if($xingshi == 'addto'){
				if($tokeshi){
					$explode_fromids = explode(",",$fromids);
					echo $fromids;
					foreach($explode_fromids as $v=>$k){
						$db->query("UPDATE {$DT_PRE}mall SET kcatids = concat(kcatids,'$tokeshi',',') WHERE itemid = '$k'");
					}
					dmsg('科室追加成功',$forward);
				}else{
					msg('请选择目标科室');
				}
			}
			if($xingshi == 'replace'){
				if($tokeshi){
					$explode_fromids = explode(",",$fromids);
					echo $fromids;
					foreach($explode_fromids as $v=>$k){
						$db->query("UPDATE {$DT_PRE}mall SET kcatids = ',$tokeshi,' WHERE itemid = '$k'");
					}
					dmsg('科室替换成功',$forward);
				}else{
					msg("请选择目标科室");
				}
			}
		}
	break;

	case 'update':
		is_array($itemid) or msg('请选择商品');
		foreach($itemid as $v) {
			$do->update($v);
		}
		dmsg('更新成功', $forward);
	break;

	case 'change_member':
		is_array($itemid) or msg('请选择商品');
		if($to_member['0']==null) msg('请填写更改到会员名');
		$check_to_member = $db->get_one("SELECT * FROM {$DT_PRE}member WHERE username = '$to_member[0]'");
		is_array($check_to_member) or msg('亲，您填写的更改到会员名不存在，请亲查核后再更改！');
		foreach($itemid as $k=>$v){
			$db->query("UPDATE {$DT_PRE}mall SET username = '$check_to_member[username]' WHERE itemid = '$v'");
		}
		dmsg('点击成功',$forward);
	break;

	case 'tohtml':
		is_array($itemid) or msg('请选择商品');
		foreach($itemid as $itemid) {
			tohtml('show', $module);
		}
		dmsg('生成成功', $forward);
	break;
	case 'delete':
		$itemid or msg('请选择商品');
		isset($recycle) ? $do->recycle($itemid) : $do->delete($itemid);
		dmsg('删除成功', $forward);
	break;
	case 'restore':
		$itemid or msg('请选择商品');
		$do->restore($itemid);
		dmsg('还原成功', $forward);
	break;
	case 'refresh':
		$itemid or msg('请选择商品');
		$do->refresh($itemid);
		dmsg('刷新成功', $forward);
	break;
	case 'clear':
		$do->clear();
		dmsg('清空成功', $forward);
	break;
	case 'level':
		$itemid or msg('请选择商品');
		$level = intval($level);
		$do->level($itemid, $level);
		dmsg('级别设置成功', $forward);
	break;
	case 'type':
		$itemid or msg('请选择商品');
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
			$do->reject($itemid,$reason);
			dmsg('拒绝成功', $forward);
		} else {
			$lists = $do->get_list('status=1'.$condition, $dorder[$order]);
			$menuid = 4;
			include tpl('index', $module);
		}
	break;
	case 'expire':
		$lists = $do->get_list('status=4'.$condition);
		$menuid = 3;
		include tpl('index', $module);
	break;
	case 'unsale':
		$itemid or msg('请选择商品');
		$do->unsale($itemid);
		dmsg('下架成功', $forward);
	break;
	case 'onsale':
		$itemid or msg('请选择商品');
		$do->onsale($itemid);
		dmsg('上架成功', $forward);
	break;
	case 'relate_del':
		$itemid or msg('请选择商品');
		$do->itemid = $itemid;
		$M = $do->get_one();
		($M && $M['status'] == 3) or msg('请选择商品');
		$id = isset($id) ? intval($id) : 0;
		$id or msg('请选择移除商品');
		$do->itemid = $id;
		$A = $do->get_one();
		$do->relate_del($M, $A);
		dmsg('移除成功', '?moduleid='.$moduleid.'&file='.$file.'&itemid='.$itemid.'&action=relate');
	break;
	case 'relate_add':
		$relate_name = isset($relate_name) ? dhtmlspecialchars(trim($relate_name)) : '';
		$relate_name or msg('请填写关联名称');
		$itemid or msg('请选择商品');
		$do->itemid = $itemid;
		$M = $do->get_one();
		($M && $M['status'] == 3) or msg('请选择商品');
		$id = isset($id) ? intval($id) : 0;
		$id or msg('请选择关联商品');
		$do->itemid = $id;
		$A = $do->get_one();
		($A && $A['status'] == 3 && $A['username'] == $M['username']) or msg('请选择关联商品');
		if($itemid == $id) msg('选择的商品已经存在');
		$do->relate_add($M, $A, $relate_name);
		dmsg('新增成功', '?moduleid='.$moduleid.'&file='.$file.'&itemid='.$itemid.'&action=relate');
	break;
	case 'relate':
		$itemid or msg('请选择商品');
		$do->itemid = $itemid;
		$M = $do->get_one();
		($M && $M['status'] == 3) or msg('请选择商品');
		if($submit) {
			$relate_name = isset($relate_name) ? dhtmlspecialchars(trim($relate_name)) : '';
			$relate_name or msg('请填写关联名称');
			$do->relate($M, $post, $relate_name);
			dmsg('更新成功', '?moduleid='.$moduleid.'&file='.$file.'&itemid='.$itemid.'&action=relate');
		} else {
			$lists = $do->relate_list($M);
			include tpl('relate', $module);
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
	case 'download':
		$file_dir=DT_ROOT.'/file/mall/';
		$file_name.='.csv';
		if(is_file($file_dir.$file_name)){
			header("Content-Type: application/force-download");
   			header("Content-Disposition: attachment; filename=".basename($file_name));
  			readfile($file_dir.$file_name);
   			exit;
		}else {
			echo "文件不存在";
		}
	break;
	default:
		$lists = $do->get_list('status=3'.$condition, $dorder[$order]);
		$menuid = 1;
		include tpl('index', $module);
	break;
}
?>