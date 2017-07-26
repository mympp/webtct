<?php
defined('IN_DESTOON') or exit('Access Denied');
class ideas{
	var $ideaid;
	var $db;
	var $table;
	var $fields;
	var $errmsg = errmsg;

    function ideas() {
		global $db;
		$this->table = $db->pre.'sogex_ideas';
		$this->db = &$db;
		$this->fields = array('ideaid','name','default_name','url','description','default_description','userid','addtime','updatetime','score','thumb','status');
    }

	function pass($post) {
		global $_userid, $L;
		if(!is_array($post)) return false;
		return true;
	}

	function set($post) {
		$post = dhtmlspecialchars($post);
		return array_map("trim", $post);
	}

	function get_one($condition = '') {
        return $this->db->get_one("SELECT * FROM {$this->table} WHERE ideaid=$this->ideaid $condition");
	}

	function get_list($condition = '', $order = 'ideaid DESC') {
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
			$lists[] = $r;
		}
		return $lists;
	}

	function add($post) {
		$post = $this->set($post);
		$post['default_name']=$this->wildcard($post['name']);
		$post['default_description']=$this->wildcard($post['description']);
		$sqlk = $sqlv = '';
		foreach($post as $k=>$v) {
			if(in_array($k, $this->fields)) { $sqlk .= ','.$k; $sqlv .= ",'$v'"; }
		}
        $sqlk = substr($sqlk, 1);
        $sqlv = substr($sqlv, 1);
		return $this->db->query("INSERT INTO {$this->table} ($sqlk) VALUES ($sqlv)");
	}

	function edit($post) {
		$post = $this->set($post);
		$post['default_name']=$this->wildcard($post['name']);
		$post['default_description']=$this->wildcard($post['description']);
		$sql = '';
		foreach($post as $k=>$v) {
			if(in_array($k, $this->fields)) $sql .= ",$k='$v'";
		}
        $sql = substr($sql, 1);
	    $this->db->query("UPDATE {$this->table} SET $sql WHERE ideaid=$this->ideaid");
		return true;
	}

	function delete($itemid) {
		$itemids = is_array($itemid) ? implode(',', $itemid) : $itemid;
		return $this->db->query("DELETE FROM {$this->table} WHERE ideaid IN ($itemids)");
	}
	
	function wildcard($str){           //带通配符字符串转换为默认字符串
		$str = str_replace('{','<my_left_bracket>',$str);
		$str = str_replace('}','<my_right_bracket>',$str);
		$str = str_replace(':<my_left_bracket>','{',$str);
		$str = str_replace(':<my_right_bracket>','}',$str);
		$str = str_replace('<my_left_bracket>','',$str);
		$str = str_replace('<my_right_bracket>','',$str);
		return $str;
	}

	function _($e) {
		$this->errmsg = $e;
		return false;
	}
}
?>
