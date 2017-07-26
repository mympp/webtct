<?php
defined('DT_ADMIN') or exit('Access Denied');
require MD_ROOT.'/spread.class.php';
$do = new spread();
$menus = array (
	array('返回sogex管理','?file=sogex'),
    array('添加排名', '?moduleid='.$moduleid.'&file='.$file.'&action=add'),
    array('排名列表(包月)', '?moduleid='.$moduleid.'&file='.$file.'&stype=1'),
    array('排名列表(单条)', '?moduleid='.$moduleid.'&file='.$file.'&stype=2'),
    array('排名审核(包月)', '?moduleid='.$moduleid.'&file='.$file.'&action=check&stype=1'),
    array('排名审核(单条)', '?moduleid='.$moduleid.'&file='.$file.'&action=check&stype=2'),
    //array('起价设置', '?moduleid='.$moduleid.'&file='.$file.'&action=price'),
    //array('生成排名', '?moduleid='.$moduleid.'&file='.$file.'&action=html'),
    //array('模块首页', $EXT[$file.'_url'], ' target="_blank"'),
    array('模块设置', '?moduleid='.$moduleid.'&file=setting#'.$file),
);
if(in_array($action, array('', 'check'))) {
	$sfields = array('关键词', '会员名', '公司名', '信息ID', '价格');
	$dfields = array('word', 'username', 'company', 'tid', 'price');
	$sorder  = array('结果排序方式', '价格降序', '价格升序', '添加时间降序', '添加时间升序', '开始时间降序', '开始时间升序', '到期时间降序', '到期时间升序');
	$dorder  = array('itemid DESC', 'price DESC', 'price ASC', 'addtime DESC', 'addtime ASC', 'fromtime DESC', 'fromtime ASC', 'totime DESC', 'totime ASC');
	isset($fields) && isset($dfields[$fields]) or $fields = 0;
	isset($order) && isset($dorder[$order]) or $order = 0;
	isset($fromtime) or $fromtime = '';
	isset($totime) or $totime = '';
	isset($type) or $type = 0;
	isset($stype) or $stype = 1;

	$fields_select = dselect($sfields, 'fields', '', $fields);
	$order_select  = dselect($sorder, 'order', '', $order);
	$condition = '';
	if($keyword) $condition .= in_array($dfields[$fields], array('tid', 'price')) ? " AND $dfields[$fields]='$kw'" : " AND $dfields[$fields] LIKE '%$keyword%'";
	if($mid) $condition .= " AND mid=$mid";
	$times = array('fromtime', 'fromtime', 'totime', 'addtime');
	$time = $times[$type];
	if($fromtime) $condition .= " AND $time>=".(strtotime($fromtime.' 00:00:00'));
	if($totime) $condition .= " AND $time<=".(strtotime($totime.' 23:59:59'));
}

//信息类型
$info_type_data=$db->query("select * from {$db->pre}sogex_info_type");
$info_type=array();
while($v=$db->fetch_array($info_type_data)){
	$info_type[$v['catid']]=$v;
}
$currency = $EXT['spread_currency'];


switch($action) {
	case 'add':
		if($submit) {
			if($do->pass($post)) {
				require_once DT_ROOT.'/include/ideas.class.php';
				$ideas = new ideas();
				$idea = $ideas->get_one('ideaid = '.$post['tid']);
				if($post['stype'] == '1'){
					$post['total'] = $post['price']+intval($idea['score']);		//包月类型排名评分:出价加上创意评分
					//包月类型强制赋值least为1，spend为0，确保符合least 大于 spend					
					$post['least'] = 1;	
					$post['spend'] = 0;
				}else{
					$post['total'] = $post['spend'];		//单条类型以每次点击扣费为评分
				}
				$do->add($post);
				dmsg('添加成功', '?moduleid='.$moduleid.'&file='.$file.'&action='.$action.'&typeid='.$post['typeid']);
			} else {
				msg($do->errmsg);
			}
		} else {
			foreach($do->fields as $v) {
				isset($$v) or $$v = '';
			}
			$status = 3;
			$mid = 99;
			$fromtime = timetodate($DT_TIME, 3);
			$menuid = 1;
			$currency = $MOD['spread_currency'];
			include tpl('spread_edit', $module);
		}
	break;
	case 'edit':
		$itemid or msg();
		$do->itemid = $itemid;
		if($submit) {
			if($do->pass($post)) {
				$do->edit($post);
				dmsg('修改成功', $forward);
			} else {
				msg($do->errmsg);
			}
		} else {
			extract($do->get_one());
			$addtime = timetodate($addtime);
			$fromtime = $fromtime ? timetodate($fromtime, 3) : '';
			$totime = $totime ? timetodate($totime, 3) : '';
			$menuid = 1;
			include tpl('spread_edit', $module);
		}
	break;
	case 'html':
		$all = (isset($all) && $all) ? 1 : 0;
		$one = (isset($one) && $one) ? 1 : 0;
		if(!isset($num)) {
			$num = 50;
			$globs = glob(DT_CACHE.'/htm/*.htm');
			foreach($globs as $v) {
				if(substr(basename($v), 0, 1) == 'm') {
					@unlink($v);
				}
			}
		}
		if(!isset($fid)) {
			$r = $db->get_one("SELECT min(itemid) AS fid FROM {$DT_PRE}spread WHERE totime>$DT_TIME");
			$fid = $r['fid'] ? $r['fid'] : 0;
		}
		isset($sid) or $sid = $fid;
		if(!isset($tid)) {
			$r = $db->get_one("SELECT max(itemid) AS tid FROM {$DT_PRE}spread WHERE totime>$DT_TIME");
			$tid = $r['tid'] ? $r['tid'] : 0;
		}
		if($fid <= $tid) {
			$result = $db->query("SELECT itemid,mid FROM {$DT_PRE}spread WHERE totime>$DT_TIME AND itemid>=$fid ORDER BY itemid LIMIT 0,$num");
			if($db->affected_rows($result)) {
				while($r = $db->fetch_array($result)) {
					$itemid = $r['itemid'];
					$MOD = cache_read('module-'.$r['mid'].'.php');
					tohtml('spread', $module);
				}
				$itemid += 1;
			} else {
				$itemid = $fid + $num;
			}
		} else {
			if($all) dheader('?moduleid=3&file=ad&action=html&all=1&one='.$one);
			dmsg('生成成功', "?moduleid=$moduleid&file=$file");
		}
		msg('ID从'.$fid.'至'.($itemid-1).'[排名推广]生成成功'.progress($sid, $fid, $tid), "?moduleid=$moduleid&file=$file&action=$action&sid=$sid&fid=$itemid&tid=$tid&num=$num&all=$all&one=$one");
	break;
	case 'price':
		if($submit) {
			$do->price_update($post);
			dmsg('更新成功', '?moduleid='.$moduleid.'&file='.$file.'&action='.$action.'&page='.$page);
		} else {
			$condition = 1;
			if($mid) $condition = "moduleid=$mid";
			$lists = $do->get_price_list($condition);
			include tpl('spread_price', $module);
		}
	break;
	case 'delete':
		$itemid or msg('请选择排名');
		$do->delete($itemid);
		dmsg('删除成功', $forward);
	break;
	case 'level':
		$itemid or msg('请选择排名');
		$level = intval($level);
		$do->level($itemid, $level);
		dmsg('级别设置成功', $forward);
	break;
	case 'check':
		if($itemid) {
			$status = $status == 3 ? 3 : 2;
			$note = $post['note'];
			$do->check($itemid, $status);
			if($note != ''){	//填写到了备注，对排名填写备注
				$id_str	= implode(',',$itemid);		//处理id字符串
				$db->query("update {$do->table} set note = '$note' where itemid in ($id_str)");
			}
			dmsg($status == 3 ? '审核成功' : '取消成功', $forward);
		} else {
			$lists = $do->get_list('status=2 and stype='.$stype.' '.$condition, $dorder[$order]);
			$menuid = $stype == 1 ? 4 : 5;
			include tpl('spread', $module);
		}
	break;
	case 'reject':		//拒绝排名
		$do->check($itemid,1);
		$note = $post['note'];
		if($note != ''){	//填写有备注，对排名填写备注
			$id_str	= implode(',',$itemid);		//处理id字符串
			$db->query("update {$do->table} set note = '$note' where itemid in ($id_str)");
		}
		
		//拒绝排名后，返还用户的购买费用
		if(is_array($itemid)){
			foreach($itemid as $v){
				$do->itemid = $v;
				$spread = $do->get_one();
				if($spread['stype'] == 1){	//计算返还数目
					$amount = $spread['price'];
				}else{
					$amount = $spread['least'];
				}
				if($currency == 'money') { //返还用户数目并进行记录
					money_add($spread['username'], $amount);
					money_record($spread['username'], $amount, $L['in_site'], 'system', $MODULE[$mid]['name'].$L['spread_title'], $spread['word'].'('.$L['spread_infoid'].$spread['itemid'].')');
				} else {
					credit_add($spread['username'], $amount);
					credit_record($spread['username'], $amount, 'system', $MODULE[$mid]['name'].$L['spread_title'], $spread['word'].'(ID:'.$spread['itemid'].')');
				}
			}
		}
		dmsg('成功拒绝排名',$forward);
	break;
	case 'search_ideas':
		require_once DT_ROOT.'/include/ideas.class.php';
		$ideas = new ideas();
		if(isset($id)){			//按id查找创意
			require_once DT_ROOT.'/module/search/common.func.php';	//引入通配符处理方法
			$ideas->ideaid = $id;
			$idea = $ideas ->get_one();
			include tpl('search_ideas',$module);
		}elseif(isset($username)){		//按用户名超找创意
			$userid = $db->get_one("select userid as uid from {$db->pre}member where username = '$username'");
			$lists = $ideas->get_list("userid = ".$userid['uid']." and status = 3");
			include tpl('search_ideas',$module);
		}
				
	break;
	default:
		$lists = $do->get_list('status=3 and stype='.$stype.' '.$condition, $dorder[$order]);
		$menuid = intval($stype)+1;
		include tpl('spread', $module);
	break;
}
?>
