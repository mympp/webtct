<?php 
//2015-12-18  周创杰 增加模板目录路径判断(homepage文件夹下面的文件夹也为合法路径)——28行
defined('IN_DESTOON') or exit('Access Denied');
class style {
	var $itemid;
	var $db;
	var $table;
	var $fields;
	var $errmsg = errmsg;

    function style() {
		global $db, $DT_PRE;
		$this->table = $DT_PRE.'style';
		$this->db = &$db;
		$this->fields = array('typeid','title','skin','m_skin','template','author','groupid','fee','currency','hits', 'addtime','editor','edittime');
    }

	function pass($post) {
		global $CFG, $MODULE, $L;
		if(!is_array($post)) return false;
		if(!$post['title']) return $this->_($L['style_pass_title']);
		if(!$post['skin']) return $this->_($L['style_pass_skin']);
		if(!preg_match("/^[a-z0-9\-_]+$/i", $post['skin'])) return $this->_($L['style_pass_skin_match']);
		if(!is_file(DT_ROOT.'/'.$MODULE[4]['moduledir'].'/skin/'.$post['skin'].'/style.css')) return $this->_($L['style_pass_css']);
		if(!$post['template']) return $this->_($L['style_pass_template']);
		if(!preg_match("/^[a-z0-9\-_]+$/i", $post['template']));//return $this->_($L['style_pass_template_match']);
		//增加合法路径判断
		if(!is_file(DT_ROOT.'/template/'.$CFG['template'].'/'.$post['template'].'/side_search.htm')&&!is_file(DT_ROOT.'/template/'.$CFG['template'].'/homepage/'.'/'.$post['template'].'/header.htm')) return $this->_($L['style_pass_dir']);
		//if(!is_file(DT_ROOT.'/template/'.$CFG['template'].'/'.$post['template'].'/side_search.htm')) return $this->_($L['style_pass_dir']);
		if(!isset($post['groupid'])) return $this->_($L['style_pass_groupid']);
		return true;
	}

	function set($post) {
		global $MOD, $DT_TIME, $_username, $_userid;
		$post['addtime'] = (isset($post['addtime']) && $post['addtime']) ? strtotime($post['addtime']) : $DT_TIME;
		$post['edittime'] = $DT_TIME;
		$post['editor'] = $_username;		
		$post['groupid'] = (isset($post['groupid']) && $post['groupid']) ? ','.implode(',', $post['groupid']).',' : '';
		$post['fee'] = dround($post['fee']);
		return array_map("trim", $post);
	}

	function get_one($condition = '') {
        return $this->db->get_one("SELECT * FROM {$this->table} WHERE itemid='$this->itemid' $condition");
	}

	function get_list($condition = '1', $order = 'listorder DESC, itemid DESC') {
		global $MODULE, $MOD, $pages, $page, $pagesize, $offset, $sum;
		$UA = strtoupper($_SERVER['HTTP_USER_AGENT']);
		$UA = strpos($UA, 'WINDOWS NT');
		if($page > 1 && $sum) {
			$items = $sum;
		} else {
			$r = $this->db->get_one("SELECT COUNT(*) AS num FROM {$this->table} WHERE $condition");
			$items = $r['num'];
		}
		$pages = pages($items, $page, $pagesize);
		if($items < 1) return array();
		$GROUP = cache_read('group.php');
		$lists = array();
		$result = $this->db->query("SELECT * FROM {$this->table} WHERE $condition ORDER BY $order LIMIT $offset,$pagesize");
		while($r = $this->db->fetch_array($result)) {
			$r['adddate'] = timetodate($r['addtime'], 5);
			$groupid = explode(',', substr($r['groupid'], 1, -1));
			$group = array();
			foreach($groupid as $gid) {
				$group[] = $GROUP[$gid]['groupname'];
			}
			$r['group'] = implode('<br/>', $group);
			if ($UA == false) 
				$r['thumb'] = $MODULE[4]['linkurl'].'/skin/'.$r['skin'].'/wap/thumb.png';
			else
				$r['thumb'] = is_file(DT_ROOT.'/'.$MODULE[4]['moduledir'].'/skin/'.$r['skin'].'/thumb.gif') ? $MODULE[4]['linkurl'].'skin/'.$r['skin'].'/thumb.gif' : $MODULE[4]['linkurl'].'image/nothumb.gif';
			$lists[] = $r;
		}
		return $lists;
	}

	function add($post) {
		global $MODULE;
		$post = $this->set($post);
		$sqlk = $sqlv = $post['m_skin'] = '';
		if(is_dir(DT_ROOT.'/'.$MODULE[4]['moduledir'].'/skin/'.$post['skin'].'/wap/')) $post['m_skin'] = $post['skin'];
		foreach($post as $k=>$v) {
			if(in_array($k, $this->fields)) { $sqlk .= ','.$k; $sqlv .= ",'$v'"; }
		}
        $sqlk = substr($sqlk, 1);
        $sqlv = substr($sqlv, 1);
		$this->db->query("INSERT INTO {$this->table} ($sqlk) VALUES ($sqlv)");
		return $this->itemid;
	}

	function edit($post) {
		global $MODULE;
		$post = $this->set($post);
		$sql = '';
		if(is_dir(DT_ROOT.'/'.$MODULE[4]['moduledir'].'/skin/'.$post['skin'].'/wap/')) $post['m_skin'] = $post['skin'];
		foreach($post as $k=>$v) {
			if(in_array($k, $this->fields)) $sql .= ",$k='$v'";
		}
        $sql = substr($sql, 1);
	    $this->db->query("UPDATE {$this->table} SET $sql WHERE itemid=$this->itemid");
		return true;
	}

	function delete($itemid, $all = true) {
		if(is_array($itemid)) {
			foreach($itemid as $v) { $this->delete($v); }
		} else {
			$r = $this->db->get_one("SELECT * FROM {$this->table} WHERE itemid=$itemid");
			$this->db->query("UPDATE {$this->db->pre}company SET skin='',template='' WHERE skin='".$r['skin']."' AND template='".$r['template']."'");
			$this->db->query("DELETE FROM {$this->table} WHERE itemid=$itemid");
		}
	}

	function order($listorder) {
		if(!is_array($listorder)) return false;
		foreach($listorder as $k=>$v) {
			$k = intval($k);
			$v = intval($v);
			$this->db->query("UPDATE {$this->table} SET listorder=$v WHERE itemid=$k");
		}
		return true;
	}

	function _($e) {
		$this->errmsg = $e;
		return false;
	}
}
?>