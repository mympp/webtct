<?php 
defined('IN_DESTOON') or exit('Access Denied');
class vote {
	var $itemid;
	var $db;
	var $table;
	var $table_record;
	var $fields;
	var $errmsg = errmsg;

    function vote() {
		global $db, $DT_PRE;
		$this->table = $DT_PRE.'vote';
		$this->table_record = $DT_PRE.'vote_record';
		$this->db = &$db;
		$this->fields = array('typeid','areaid', 'title','style','level','linkto','content','groupid','verify','addtime','fromtime','totime','editor','edittime','template_vote','template', 'vote_min', 'vote_max', 'linkurl', 'choose', 's', 'v', 'p', 'e', 'v_show','j','x','j_explain','thumb','status');
    }    

	function pass($post) {
		global $L;
		if(!is_array($post)) return false;
		if(!$post['typeid']) return $this->_($L['vote_pass_type']);
		if(!$post['title']) return $this->_($L['vote_pass_title']);
		return true;
	}

	function set($post) {
		global $MOD, $DT_TIME, $_username, $_userid;
		$post['addtime'] = (isset($post['addtime']) && $post['addtime']) ? strtotime($post['addtime']) : $DT_TIME;
		$post['edittime'] = $DT_TIME;
		$post['editor'] = $_username;
		$post['content'] = addslashes(save_remote(save_local(stripslashes($post['content']))));
		clear_upload($post['content']);
		if($this->itemid) {
			$new = $post['content'];
			$r = $this->get_one();
			$old = $r['content'];
			delete_diff($new, $old);
		}
		if($post['fromtime']) $post['fromtime'] = strtotime($post['fromtime'].' 0:0:0');
		if($post['totime']) $post['totime'] = strtotime($post['totime'].' 23:59:59');
		$post['groupid'] = implode(',', $post['groupid']);
		$post['verify'] = intval($post['verify']);
		return array_map("trim", $post);
	}

	function get_one() {
        return $this->db->get_one("SELECT * FROM {$this->table} WHERE itemid='$this->itemid'");
	}

	function get_list($condition = '1', $order = 'addtime DESC') {
		global $MOD, $TYPE, $pages, $page, $pagesize, $offset, $L, $sum;
		if($page > 1 && $sum) {
			$items = $sum;
		} else {
			$r = $this->db->get_one("SELECT COUNT(*) AS num FROM {$this->table} WHERE $condition");
			$items = $r['num'];
		}
		$pages = pages($items, $page, $pagesize);		
		if($items < 1) return array();
		$lists = array();
		$result = $this->db->query("SELECT * FROM {$this->table} WHERE $condition ORDER BY $order LIMIT $offset,$pagesize");
		while($r = $this->db->fetch_array($result)) {
			$r['alt'] = $r['title'];
			$r['title'] = set_style($r['title'], $r['style']);
			$r['adddate'] = timetodate($r['addtime'], 5);
			$r['editdate'] = timetodate($r['edittime'], 5);
			$r['fromdate'] = $r['fromtime'] ? timetodate($r['fromtime'], 3) : $L['timeless'];
			$r['todate'] = $r['totime'] ? timetodate($r['totime'], 3) : $L['timeless'];
			$r['typename'] = $TYPE[$r['typeid']]['typename'];
			$r['typeurl'] = $MOD['vote_url'].rewrite('index.php?typeid='.$r['typeid']);
			$lists[] = $r;			
		}
		return $lists;
	}

	function get_list_record($condition = '1', $order = 'rid DESC') {
		global $MOD, $TYPE, $pages, $page, $pagesize, $offset, $sum;
		if($page > 1 && $sum) {
			$items = $sum;
		} else {
			$r = $this->db->get_one("SELECT COUNT(*) AS num FROM {$this->table_record} WHERE $condition");
			$items = $r['num'];
		}
		$pages = pages($items, $page, $pagesize);
		if($items < 1) return array();
		$lists = array();
		$result = $this->db->query("SELECT * FROM {$this->table_record} WHERE $condition ORDER BY $order LIMIT $offset,$pagesize");
		while($r = $this->db->fetch_array($result)) {
			$r['votedate'] = timetodate($r['votetime'], 6);
			$lists[] = $r;
		}
		return $lists;
	}

	function add($post) {
		global $DT, $MOD, $module;
		$post = $this->set($post);
		$sqlk = $sqlv = $s = $p = $e = $vv = $j = $x ='';
		$s_arr =array();
		$p_arr =array();
		$e_arr =array();
		$j_arr =array("j1","j2","j3");
		$x_arr =array("x1","x2","x3");		
		for ($i=1; $i <= $post['s_num']; $i++) { 
			$s_arr[$i] = "s".$i;
			$p_arr[$i] = "p".$i;
			$e_arr[$i] = "e".$i;
		}
		foreach($post as $k=>$v) {
			if(in_array($k, $this->fields)) { $sqlk .= ','.$k; $sqlv .= ",'$v'"; }
			if(in_array($k, $s_arr)) {$s .= ",$v";$vv .= ",0";}									  
			if(in_array($k, $p_arr)) $p .= ",$v";
			if(in_array($k, $e_arr)) $e .= ",$v";
			if(in_array($k, $j_arr)) $j .= ",$v";
			if(in_array($k, $x_arr)) $x .= ",$v";
		}
		$e = substr($e, 1);
		$s = substr($s, 1);
        $p = substr($p, 1);  
        $vv = substr($vv, 1);
        $j = substr($j, 1);
        $x = substr($x, 1);        
		$sqlv .= ",'$s','$p','$e','$vv','$j','$x'";
		$sqlk .=",s,p,e,v,j,x";
        $sqlk = substr($sqlk, 1);
        $sqlv = substr($sqlv, 1);     
		$this->db->query("INSERT INTO {$this->table} ($sqlk) VALUES ($sqlv)");
		$this->itemid = $this->db->insert_id();
		if(!$post['islink']) {
			$linkurl = $this->linkurl($this->itemid);	
			$this->db->query("UPDATE {$this->table} SET linkurl='$linkurl' WHERE itemid=$this->itemid");
			tohtml('vote', $module, "itemid=$this->itemid");		
		}
		return $this->itemid;
	}

	function edit($post) {
		global $DT, $MOD, $module;
		$post = $this->set($post);
		$sql = $s = $p = $e = $j = $x ='';
		$vv = $post['vv'];
		$v_num = count(explode(',', $vv));
		$s_arr = array();
		$p_arr = array();
		$e_arr = array();
		$j_arr =array("j1","j2","j3");
		$x_arr =array("x1","x2","x3");	
		if ($post['s_num']>$v_num) {
			for ($i=0; $i < ($post['s_num']-$v_num); $i++) { 
				$vv .= ",0";
			}
		}
		for ($i=1; $i <= $post['s_num']; $i++) { 
			$s_arr[$i] = "s".$i;
			$p_arr[$i] = "p".$i;
			$e_arr[$i] = "e".$i;
		}
		foreach($post as $k=>$v) {
			if(in_array($k, $this->fields)) $sql .= ",$k='$v'";
			if(in_array($k, $s_arr)) $s .= ",$v";
			if(in_array($k, $p_arr)) $p .= ",$v";
			if(in_array($k, $e_arr)) $e .= ",$v";
			if(in_array($k, $j_arr)) $j .= ",$v";
			if(in_array($k, $x_arr)) $x .= ",$v";
		}
		$e = substr($e, 1);
		$s = substr($s, 1);
        $p = substr($p, 1);
        $j = substr($j, 1);
        $x = substr($x, 1);
        $sql = substr($sql.",e='$e',s='$s',p='$p',v='$vv',j='$j',x='$x'", 1);
	    $this->db->query("UPDATE {$this->table} SET $sql WHERE itemid=$this->itemid");
		if(!$post['islink']) {
		$linkurl = $this->linkurl($this->itemid);
		$this->db->query("UPDATE {$this->table} SET linkurl='$linkurl' WHERE itemid=$this->itemid");
		tohtml('vote', $module, "itemid=$this->itemid");
		}
		return true;
	}

	function update() {
		$result = $this->db->query("SELECT * FROM {$this->table}");
		while($r = $this->db->fetch_array($result)) {
			$itemid = $r['itemid'];
			$linkurl = $this->linkurl($itemid);
			$this->db->query("UPDATE {$this->table} SET linkurl='$linkurl' WHERE itemid=$itemid");
		}
		return true;
	}	

	function linkurl($itemid) {
		global $MOD;
		$linkurl = rewrite('index.php?itemid='.$itemid);
		return $MOD['vote_url'].$linkurl;
	}

	function delete($itemid) {
		if(is_array($itemid)) {
			foreach($itemid as $v) { 
				$this->delete($v, $all); 
			}
		} else {
			$this->itemid = $itemid;
			$r = $this->get_one();
			$userid = get_user($r['editor']);
			if($r['content']) delete_local($r['content'], $userid);
			$this->db->query("DELETE FROM {$this->table} WHERE itemid=$itemid");
			$this->db->query("DELETE FROM {$this->table_record} WHERE itemid=$itemid");
			unlink(DT_CACHE.'/htm/vote_'.$r['itemid'].'.htm');
		}
	}

	function check($itemid, $status = 3) {//是否审核通过--吕保成--2015/12/30
		if(is_array($itemid)) {
			foreach($itemid as $v) { $this->check($v, $status); }
		} else {
			$this->db->query("UPDATE {$this->table} SET status=$status WHERE itemid=$itemid");			
			tohtml('vote', $module, "itemid=$this->itemid");
		}
	}

	function reject($itemid) {//拒绝审核通过--吕保成--2015/12/30
		if(is_array($itemid)) {
			foreach($itemid as $v) { $this->reject($v); }
		} else {
			$this->db->query("UPDATE {$this->table} SET status=1 WHERE itemid=$itemid");	
			return true;
		}
	}
	function level($itemid, $level) {
		$itemids = is_array($itemid) ? implode(',', $itemid) : $itemid;
		$this->db->query("UPDATE {$this->table} SET level=$level WHERE itemid IN ($itemids)");
	}

	function _($e) {
		$this->errmsg = $e;
		return false;
	}
}
?>