<?php
defined('IN_DESTOON') or exit('Access Denied');
$menus = array (
	array('字账号组添加', '?moduleid='.$moduleid.'&file='.$file.'&action=add'),
      array('字账号管理', '?moduleid='.$moduleid.'&file='.$file),
);
$do = new child;
if(isset($itemid)) $do->itemid = $itemid;
if(isset($username)) $do->username = $username;
if(isset($parentusername)) $do->parentusername = intval($parentusername);
$this_forward = '?moduleid='.$moduleid.'&file='.$file;
switch($action) {
	case 'add':
		if($submit) {
			if($do->pass($post)) {
				$name=$post[kw];
				$r = $db->get_one("SELECT* FROM {$DT_PRE}member WHERE username='$name'");
				$userid = $r['userid'];
				if($post['username'] && $db->get_one("SELECT username FROM {$DT_PRE}member_child WHERE userid=$userid  AND username='$post[username]'")) {message('该子账号已经存在');}
				$username= $post['kw'];
				$post['userid'] = $userid;
				$post['addtime'] = $DT_TIME;
				$post['password'] =md5(md5($post['password'])) ;
				$do->add($post);
				dmsg('添加子账号成功', $forward);
			} else {
				message($do->errmsg);
			}
		} else {
			$parentusername = isset($parentusername) ?  trim($parentusername) : '';
			$username = isset($username) ? trim($username) : '';
			$truename = $modules = $actions = $mobile = $password = '';
		}
		include tpl('child_edit', $module);
		break;
	case 'list':
		$userid or msg();
		$child = array();
		$result = $db->query("SELECT * FROM `{$DT_PRE}member_child` WHERE `userid`='$userid' ORDER BY `itemid` DESC LIMIT 0,10");
		while($r = $db->fetch_array($result)) {
		    $child[] = $r;
		}
		include tpl('child_list', $module);
	break;
	case 'edit':
		$do->itemid = $itemid;
		if($submit) {
			if($do->pass($post)) {
				if($post['password']){
					$post['password'] =md5(md5($post['password']));
				}else{
					$r = $db->get_one("SELECT* FROM {$DT_PRE}member_child WHERE itemid='$itemid'");
					$password= $r['password'];
					$post['password']=$password;
				}

				$do->edit($post);
				dmsg('子账号修改成功', $forward);
			} else {
				message($do->errmsg);
			}
		}
		$result = $db->query("SELECT * FROM `{$DT_PRE}member_child`  WHERE `userid`='$userid'  ORDER BY `itemid` DESC LIMIT 0,10");
		while($d = $db->fetch_array($result)) { 
	   		$child[] = $d;
	    }
		$r = $db->get_one("SELECT * FROM `{$DT_PRE}member_child` WHERE `itemid`='$itemid'");
		include tpl('child_edit', $module);
	break;
	case 'delete':
		$itemid or message('请选择删除的子账号');
		$do->itemid = $itemid;
		$r = $do->get_one();
		//if(!$r || $r['userid'] != $_userid) message();
		$do->delete($itemid);
		dmsg('账号删除成功', $forward);
	break;

	default:
		$sfields = array('按条件', '公司名', '会员名');
		$dfields = array('username', 'company', 'username');
		$fields_select = dselect($sfields, 'fields', '', $fields);
		$condition = '1';
		if($keyword) $condition .= " AND $dfields[$fields]='$kw'";
		$r = $db->get_one("SELECT* FROM {$DT_PRE}member WHERE $condition");
		$_userid = $r['userid'];
		if($_userid >1 ){
		$child = array();
		$result = $db->query("select `{$DT_PRE}member`.userid, `{$DT_PRE}member`.username, `{$DT_PRE}member`.company, count(`{$DT_PRE}member_child`.userid) as point from `{$DT_PRE}member`,`{$DT_PRE}member_child` where `{$DT_PRE}member_child`.userid=`{$DT_PRE}member`.userid and `{$DT_PRE}member_child`.userid=$_userid");
		while($r = $db->fetch_array($result)) {
			$child[] = $r;
		}
		}else {
			$r = $db->get_one("select userid,count(DISTINCT userid) as num from {$DT_PRE}member_child");
			$items = $r['num'];
			$pages = pages($items, $page, $pagesize);		
			$child = array();
			$result = $db->query("select `{$DT_PRE}member`.userid, `{$DT_PRE}member`.username, `{$DT_PRE}member`.company, count(`{$DT_PRE}member_child`.userid) as point from `{$DT_PRE}member`,`{$DT_PRE}member_child` where `{$DT_PRE}member_child`.userid=`{$DT_PRE}member`.userid group by `{$DT_PRE}member_child`.userid DESC LIMIT $offset,$pagesize");
			while($r = $db->fetch_array($result)) {
				$child[] = $r;
			}
		}
	include tpl('child', $module);
	break;
}
class child {
	var $itemid;
	var $db;
	var $table;
	var $fields;
	var $errmsg = errmsg;

    function child() {
		global $db;
		$this->table = $db->pre.'member_child';
		$this->db = &$db;
		$this->fields = array('userid','username','password','truename','parentusername','mobile','systems','modules','addtime');
    }

	function pass($post) {
		global $_userid, $L;
		if(!is_array($post)) return false;
		if(!$post['truename']) return $this->_('请填写真实姓名');
		return true;
	}

	function set($post) {
		if($post['mobile'] && !is_numeric($post['mobile'])) $post['mobile'] = '';
		$post = dhtmlspecialchars($post);

		return array_map("trim", $post);

	}

	function get_one($condition = '') {
        return $this->db->get_one("SELECT * FROM {$this->table} WHERE itemid=$this->itemid $condition");
	}

	function get_list($condition = 'itemid>0', $order = 'itemid DESC') {
		global $TYPE, $pages, $page, $pagesize, $offset, $L, $sum;
		if($page > 1 && $sum) {
			$items = $sum;
		} else {
			$r = $this->db->get_one("SELECT COUNT(*) AS num FROM {$this->table} WHERE $condition");
			$items = $r['num'];
		}
		$pages = pages($items, $page, $pagesize);
		$lists = array();
		$result = $this->db->query("SELECT * FROM {$this->table} WHERE $condition ORDER BY $order LIMIT $offset,$pagesize");
		while($r = $this->db->fetch_array($result)) {
			$r['adddate'] = timetodate($r['addtime'], 5);
			$lists[] = $r;
		}
		return $lists;
	}

	function add($post) {
		$post = $this->set($post);
		$sqlk = $sqlv = '';
		foreach($post as $k=>$v) {
			if(in_array($k, $this->fields)) { $sqlk .= ','.$k; $sqlv .= ",'$v'"; }
		}
        $sqlk = substr($sqlk, 1);
        $sqlv = substr($sqlv, 1);
		$this->db->query("INSERT INTO {$this->table} ($sqlk) VALUES ($sqlv)");
		return $this->itemid;
	}

	function edit($post) {
		$post = $this->set($post);
		$sql = '';
		foreach($post as $k=>$v) {
			if(in_array($k, $this->fields)) $sql .= ",$k='$v'";
		}
        $sql = substr($sql, 1);
	    $this->db->query("UPDATE {$this->table} SET $sql WHERE itemid=$this->itemid");
		return true;
	}

	function delete($itemid) {
		$itemids = is_array($itemid) ? implode(',', $itemid) : $itemid;
		$this->db->query("DELETE FROM {$this->table} WHERE itemid IN ($itemids)");
	}
	function count($userid) {
		$userids = is_array($userid) ? implode(',', $userid) : $userid;
		$this->db->query("DELETE FROM {$this->table} WHERE userid IN ($userids)");
	}
	function _($e) {
		$this->errmsg = $e;
		return false;
	}
}
?>