<?php
defined('DT_ADMIN') or exit('Access Denied');
$TYPE = get_type('announce', 1);
require MD_ROOT.'/announce.class.php';
$do = new announce();
$menus = array (
    array('添加公告', '?moduleid='.$moduleid.'&file='.$file.'&action=add'),
    array('公告列表', '?moduleid='.$moduleid.'&file='.$file),
    array('更新地址', '?moduleid='.$moduleid.'&file='.$file.'&action=html'),
    array('公告分类', 'javascript:Dwidget(\'?file=type&item='.$file.'\', \'公告分类\');'),
    array('模块首页', $EXT[$file.'_url'], ' target="_blank"'),
    array('模块设置', '?moduleid='.$moduleid.'&file=setting#'.$file),
);

if($_catids || $_areaids) require DT_ROOT.'/admin/admin_check.inc.php';

switch($action) {
	case 'add':
		if($submit) {
			if($do->pass($post)) {
				$do->add($post);
				dmsg('添加成功', '?moduleid='.$moduleid.'&file='.$file.'&action='.$action.'&typeid='.$post['typeid']);
			} else {
				msg($do->errmsg);
			}
			if($post["daoru"] == "daoru"){
				dmsg('daoru');
			}
		} else {
			foreach($do->fields as $v) {
				isset($$v) or $$v = '';
			}
			$addtime = timetodate($DT_TIME);
			$typeid = 0;
			$menuid = 0;
			include tpl('announce_edit', $module);
		}
	break;
	case 'check_daoru':
		if($submit){
			$result = $do->check_daoru($post);
			include tpl('person_do_announce_select',$module);
		}
	break;
	case 'add_daoru':
		if(is_array($contents)){
			if($post["typeid"] != 0){
				$do->add_daoru($post,$contents);
				dmsg("导入成功！请修改标题才可以生成页面！",'?moduleid='.$moduleid.'&file='.$file);
			}else{
				msg("请对信息选择分类！",'?moduleid='.$moduleid.'&file='.$file.'&action=add');
			}
		}else{
			msg("请选择要导入的对话信息，并且选择信息分类！",'?moduleid='.$moduleid.'&file='.$file.'&action=add');
		}
	break;
	case 'set_type':
		$itemid or msg('请选择公告');
		$typeid = intval($typeid);
		$do->set_type($itemid, $post);
		dmsg('信息分类设置成功', $forward);
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
			include tpl('announce_edit', $module);
		}
	break;
	case 'order':
		$do->order($listorder);
		dmsg('排序成功', $forward);
	break;
	case 'html':
		$all = (isset($all) && $all) ? 1 : 0;
		$one = (isset($one) && $one) ? 1 : 0;
		if(!isset($num)) {
			$num = 50;
		}
		if(!isset($fid)) {
			$r = $db->get_one("SELECT min(itemid) AS fid FROM {$DT_PRE}announce");
			$fid = $r['fid'] ? $r['fid'] : 0;
		}
		isset($sid) or $sid = $fid;
		if(!isset($tid)) {
			$r = $db->get_one("SELECT max(itemid) AS tid FROM {$DT_PRE}announce");
			$tid = $r['tid'] ? $r['tid'] : 0;
		}
		if($fid <= $tid) {
			$result = $db->query("SELECT itemid,linkurl,islink FROM {$DT_PRE}announce WHERE itemid>=$fid ORDER BY itemid LIMIT 0,$num");
			if($db->affected_rows($result)) {
				while($r = $db->fetch_array($result)) {
					$itemid = $r['itemid'];
					if(!$r['islink']) {
						$linkurl = $do->linkurl($itemid);
						if($linkurl != $r['linkurl']) $db->query("UPDATE {$DT_PRE}announce SET linkurl='$linkurl' WHERE itemid=$itemid");
					}
				}
				$itemid += 1;
			} else {
				$itemid = $fid + $num;
			}
		} else {
			if($all) dheader('?moduleid=3&file=webpage&action=html&all=1&one='.$one);
			dmsg('更新成功', "?moduleid=$moduleid&file=$file");
		}
		msg('ID从'.$fid.'至'.($itemid-1).'[公告]更新成功'.progress($sid, $fid, $tid), "?moduleid=$moduleid&file=$file&action=$action&sid=$sid&fid=$itemid&tid=$tid&num=$num&all=$all&one=$one");
	break;
	case 'delete':
		$itemid or msg('请选择公告');
		$do->delete($itemid);
		dmsg('删除成功', $forward);
	break;
	case 'level':
		$itemid or msg('请选择公告');
		$level = intval($level);
		$do->level($itemid, $level);
		dmsg('级别设置成功', $forward);
	break;
	default:
		$sorder  = array('审核情况降序','结果排序方式' , '添加时间升序', '浏览次数降序', '浏览次数升序', '开始时间降序', '开始时间升序', '到期时间降序', '到期时间升序');
		$dorder  = array('level ASC','listorder DESC', 'addtime DESC', 'addtime ASC', 'hits DESC', 'hits ASC', 'fromtime DESC', 'fromtime ASC', 'totime DESC', 'totime ASC');
		isset($order) && isset($dorder[$order]) or $order = 0;
		isset($typeid) or $typeid = 0;
		$level = isset($level) ? intval($level) : 0;
		$type_select = type_select('announce', 1, 'typeid', '请选择分类', $typeid);
		$order_select  = dselect($sorder, 'order', '', $order);
		$level_select = level_select('level', '级别', $level);
		$condition = '1';
		if($_areaids) $condition .= " AND areaid IN (".$_areaids.")";//CITY
		if($keyword) $condition .= " AND title LIKE '%$keyword%' OR content LIKE '%$keyword%'";
		if($typeid) $condition .= " AND typeid IN (".type_child($typeid, $TYPE).")";
		if($level) $condition .= " AND level=$level";
		if($areaid) $condition .= ($ARE['child']) ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$areaid";
		$lists = $do->get_list($condition, $dorder[$order]);
		include tpl('announce', $module);
	break;
}
?>