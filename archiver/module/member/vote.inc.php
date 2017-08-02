<?php
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
if($_groupid<=5&&$_groupid != 1){
	dheader('member');
}
$TYPE = get_type('vote', 1);
$MOD['vote_url'] = DT_PATH.'vote/';
require DT_ROOT.'/module/extend/vote.class.php';
$do = new vote();
if($_catids || $_areaids) require DT_ROOT.'/admin/admin_check.inc.php';
$nums = array();
for($i = 1; $i <= 3; $i++) {
	$r = $db->get_one("SELECT COUNT(*) AS num FROM {$DT_PRE}vote WHERE editor='$_username' AND status=$i");
	$nums[$i] = $r['num'];
}
switch($action) {
	case 'add':
		if($submit) {			
			if($do->pass($post)) {				
				$do->add($post);
				dmsg('添加成功', $forward);
			} else {
				dmsg($do->errmsg);
			}
		} else {
			foreach($do->fields as $v) {
				isset($$v) or $$v = '';
			}
			$status = 2;
			$vote_min = 1;
			$s_num = $vote_max = 3;
			$addtime = timetodate($DT_TIME);
			include template('vote_edit', $module);
		}
	break;
	case 'edit':
		$itemid or dmsg();
		$do->itemid = $itemid;
		if($submit) {			
			if($do->pass($post)) {
				$do->edit($post);
				dmsg('修改成功', $forward);
			} else {
				dmsg($do->errmsg);
			}
		} else {
			extract($do->get_one());
			$addtime = timetodate($addtime);
			$fromtime = $fromtime ? timetodate($fromtime, 3) : '';
			$totime = $totime ? timetodate($totime, 3) : '';
			$e_arr = explode(',', $e);
			$s_arr = explode(',', $s);
			$p_arr = explode(',', $p);
			$j_arr = explode(',', $j);
			$x_arr = explode(',', $x);
			$s_num = count($s_arr);
			$vv = $v;
			include template('vote_edit', $module);
		}
	break;
	case 'update':
		$do->update();
		dmsg('更新成功', $forward);
	break;
	case 'html':
		$all = (isset($all) && $all) ? 1 : 0;
		$one = (isset($one) && $one) ? 1 : 0;
		if(!isset($num)) {
			$num = 50;
		}
		if(!isset($fid)) {
			$r = $db->get_one("SELECT min(itemid) AS fid FROM {$DT_PRE}vote");
			$fid = $r['fid'] ? $r['fid'] : 0;
		}
		isset($sid) or $sid = $fid;
		if(!isset($tid)) {
			$r = $db->get_one("SELECT max(itemid) AS tid FROM {$DT_PRE}vote");
			$tid = $r['tid'] ? $r['tid'] : 0;
		}
		if($fid <= $tid) {
			$result = $db->query("SELECT itemid FROM {$DT_PRE}vote WHERE itemid>=$fid ORDER BY itemid LIMIT 0,$num");
			if($db->affected_rows($result)) {
				while($r = $db->fetch_array($result)) {
					$itemid = $r['itemid'];
					tohtml('vote', $module);
				}
				$itemid += 1;
			} else {
				$itemid = $fid + $num;
			}
		} else {
			if($all) dheader('?moduleid=3&file=html&action=html&all=1&one='.$one);
			dmsg('生成成功', "?moduleid=$moduleid&file=$file");
		}
		dmsg('ID从'.$fid.'至'.($itemid-1).'[投票]生成成功'.progress($sid, $fid, $tid), "?moduleid=$moduleid&file=$file&action=$action&sid=$sid&fid=$itemid&tid=$tid&num=$num&all=$all&one=$one");
	break;
	case 'delete':
		$itemid or dmsg('请选择投票');
		$do->delete($itemid);
		dmsg('删除成功', $forward);
	break;
	case 'level':
		$itemid or dmsg('请选择投票');
		$level = intval($level);
		$do->level($itemid, $level);
		dmsg('级别设置成功', $forward);
	break;
	case 'record':
		$itemid or dmsg();
		$do->itemid = $itemid;
		$item = $do->get_one();
		extract($item);
		$votes = array();
		$s_arr = explode(',', $s);
		foreach ($s_arr as $k => $v) {
			$votes[$k+1] = $v;
		}

		$condition = "itemid=$itemid";
		if($keyword) $condition .= " AND (ip LIKE '%$keyword%' OR username LIKE '%$keyword%')";
		$lists = $do->get_list_record($condition);
		include template('vote_record', $module);
	break;
	default:				
		$sorder  = array('结果排序方式', '添加时间降序', '添加时间升序', '投票次数降序', '投票次数升序', '浏览次数降序', '浏览次数升序', '开始时间降序', '开始时间升序', '到期时间降序', '到期时间升序');
		$dorder  = array('itemid DESC', 'addtime DESC', 'addtime ASC', 'votes DESC', 'votes ASC', 'hits DESC', 'hits ASC', 'fromtime DESC', 'fromtime ASC', 'totime DESC', 'totime ASC');
		isset($order) && isset($dorder[$order]) or $order = 0;
		isset($typeid) or $typeid = 0;
		$type_select = type_select('vote', 1, 'typeid', '请选择分类', $typeid);
		$order_select  = dselect($sorder, 'order', '', $order);
		$condition = '1';		
		if($_username) $condition .= " AND editor='$_username'";
		if($_areaids) $condition .= " AND areaid IN (".$_areaids.")";//CITY
		if($keyword) $condition .= " AND title LIKE '%$keyword%'";
		if($typeid) $condition .= " AND typeid=$typeid";
		if($status) $condition .= " AND status=$status"; else $condition .= " AND status=3";
		if($areaid) $condition .= ($ARE['child']) ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$areaid";
		$lists = $do->get_list($condition, $dorder[$order]);			
		include template('vote', $module);		
	break;
}
?>