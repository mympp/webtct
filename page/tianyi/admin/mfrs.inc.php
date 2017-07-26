<?php
/*
	[Destoon B2B System] Copyright (c) 2008-2015 www.destoon.com
	This is NOT a freeware, use is subject to license.txt
*/
defined('DT_ADMIN') or exit('Access Denied');
$menus = array (
		array('产地添加', '?file='.$file.'&action=add'),
		array('产地管理', '?file='.$file),
		array('更新缓存', '?file='.$file.'&action=cache'),
);
$AREA = cache_read('mfrs.php');
$areaid = isset($areaid) ? intval($areaid) : 0;
$do = new area($areaid);

$parentid = isset($parentid) ? intval($parentid) : 0;
$table = $DT_PRE.'mfrs';
$this_forward = '?file='.$file;
switch($action) {
	case 'add':
		if($submit) {
			if(!$mfrs['mfrsname']) msg('地区名不能为空');
			$mfrs['mfrsname'] = trim($mfrs['mfrsname']);
			if(strpos($mfrs['mfrsname'], "\n") === false) {
				$do->add($mfrs);
			} else {
				$mfrsname = explode("\n", $mfrs['mfrsname']);
				foreach($mfrsname as $mfrsname) {
					$mfrsname = trim($mfrsname);
					if(!$mfrsname) continue;
					$mfrs['mfrsname'] = $mfrsname;
					$do->add($mfrs);
				}
			}
			dmsg('添加成功', $this_forward);
		} else {
			include tpl('mfrs_add');
		}
		break;
	case 'delete':
		if($id) $ids = $id;
		$do->delete($ids);
		dmsg('删除成功', $this_forward);
		break;
	case 'update':
		if(!$mfrs || !is_array($mfrs)) msg();
		$do->update($mfrs);
		dmsg('更新成功', $this_forward);
		break;
	default:
		$DAREA = array();
		$result = $db->query("SELECT * FROM {$table} ORDER BY id");
		while($r = $db->fetch_array($result)) {
			$DAREA[$r['id']] = $r;
		}
		include tpl('mfrs');
		break;
}

class area {
	var $areaid;
	var $area = array();
	var $db;
	var $table;

	function area($areaid = 0)	{
		global $db, $DT_PRE, $AREA;
		$this->areaid = $areaid;
		$this->area = $AREA;
		$this->table = $DT_PRE.'mfrs';
		$this->db = &$db;
	}

	function add($mfrs)	{
		if(!is_array($mfrs)) return false;
		$sql1 = $sql2 = $s = '';
		foreach($mfrs as $key=>$value) {
			$sql1 .= $s.$key;
			$sql2 .= $s."'".$value."'";
			$s = ',';
		}
		$this->db->query("INSERT INTO {$this->table} ($sql1) VALUES($sql2)");
		$this->areaid = $this->db->insert_id();
		$this->db->query("UPDATE {$this->table} SET listorder='$this->areaid' WHERE id=$this->areaid");
		return true;
	}

	function delete($ids) {
		if(is_array($ids)) {
			$delid=implode(',',$ids);
			$this->db->query("DELETE FROM {$this->table} WHERE id IN ($delid)");
		} else {
			$id = $ids;
			if(isset($id)) {
				$this->db->query("DELETE FROM {$this->table} WHERE id = $id");
			}
		}
		return true;
	}


	function update($mfrs) {
		if(!is_array($mfrs)) return false;
		foreach($mfrs as $k=>$v) {
			if(!$v['mfrsname']) continue;
			$v['listorder'] = intval($v['listorder']);
			$this->db->query("UPDATE {$this->table} SET mfrsname='$v[mfrsname]',listorder='$v[listorder]' WHERE id=$k");
		}
		cache_area();
		return true;
	}
}
?>