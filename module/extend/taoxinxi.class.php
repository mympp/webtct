<?php 
defined('IN_DESTOON') or exit('Access Denied');
class taoxinxi {
	var $itemid;
	var $db;
	var $table;
	var $fields;
	var $errmsg = errmsg;

    function taoxinxi() {
		global $db, $DT_PRE;
		$this->table = $DT_PRE.'taoxinxi';
		$this->db = &$db;
		$this->fields = array('typeid','areaid','content','addtime','username','ip','hits', 'linkurl','status','explorer','truename','reference','allowitemid');
    }

	function pass($post) {
		global $L;
		if(!is_array($post)) return false;
		if(!$post['typeid']) return $this->_($L['taoxinxi_pass_type']);
		if(!$post['title']) return $this->_($L['taoxinxi_pass_title']);
		if(isset($post['islink'])) {
			if(!$post['linkurl']) return $this->_($L['taoxinxi_pass_url']);
		} else {
			if(!$post['content']) return $this->_($L['taoxinxi_pass_content']);
		}
		return true;
	}

	function set($post) {
		global $MOD, $DT_TIME, $_username, $_userid;
		$post['addtime'] = (isset($post['addtime']) && $post['addtime']) ? strtotime($post['addtime']) : $DT_TIME;
		$post['content'] = addslashes(save_remote(save_local(stripslashes($post['content']))));
		clear_upload($post['content']);
		if($this->itemid) {
			$new = $post['content'];
			$r = $this->get_one();
			$old = $r['content'];
			delete_diff($new, $old);
		}
		return array_map("trim", $post);
	}

	function get_one() {
        return $this->db->get_one("SELECT * FROM {$this->table} WHERE itemid='$this->itemid'");
	}
	function get_user($username) {
		global $db, $DT_PRE;
		$sql="SELECT * FROM ".$DT_PRE."member WHERE username='$username'";
        return $this->db->get_one($sql);
	}
	function get_list($condition = '1', $pagesize, $order = 'addtime DESC',$addlist='') {
		global $MOD, $itemid, $pages, $page, $offset, $L, $sum,$pagenum, $pagesize;
		$lists = array();
					$r = $this->db->get_one("SELECT COUNT(*) AS num FROM {$this->table} WHERE $condition");
					$items = $r['num'];
					$pagenum=$items/$pagesize;
					$pagenum=ceil($pagenum);
					$offset=$items;
					if($items>$pagesize)$offset=$items-$pagesize;	
					if($addlist=='down')$offset=0;
					if($page){$offset = ($page-1)*$pagesize;$order = 'addtime DESC';}
			$pages = pages($items, $page, $pagesize);
		$sql="SELECT * FROM {$this->table} WHERE $condition ORDER BY $order LIMIT $offset,$pagesize";
		//echo $sql;
		$result = $this->db->query($sql);
		while($r = $this->db->fetch_array($result)) {
			$r['adddate'] = timetodate($r['addtime'], 5);
			$lists[] = $r;
		}
		return $lists;
	}



	function add($post) {
		global $DT, $MOD, $module,$_userid,$db, $DT_PRE,$_username;
		if($_userid){
				$sql="SELECT * FROM ".$DT_PRE."member WHERE userid=".$_userid;
				$member=$this->db->get_one($sql);
				if(!$post['areaid'])$post['areaid']=$member['areaid'];
				if(!$post['username'])$post['username']=$member['username'];
				if(!$post['truename'])$post['truename']=$member['truename'];
		}
		$post['content'] = htmlspecialchars(trim($post['content']));
		$post['content'] = nl2br($post['content']);
		if(!$post['content']){echo "<script>parent.nomessage();</script>"; exit;}
		$post = $this->set($post);
		$sqlk = $sqlv = '';
		foreach($post as $k=>$v) {
			if(in_array($k, $this->fields)) { $sqlk .= ','.$k; $sqlv .= ",'$v'"; }
		}
        $sqlk = substr($sqlk, 1);
        $sqlv = substr($sqlv, 1);
		$this->db->query("INSERT INTO {$this->table} ($sqlk) VALUES ($sqlv)");
		$itemid = $this->db->insert_id();
		if($post[allowitemid]){$this->db->query("UPDATE {$this->table} reference=reference+1 WHERE itemid=".$post[allowitemid]);}
		else{
			if($_userid){
				$amount=0.5;
					money_lock($member['username'], $amount);
					money_record($member['username'], $amount, '其他' , 'system', '线下充值汇款', '抢单ID:'.$itemid);
			}
		}
		return $itemid;
	}
	function lockip($ip){
		global $db, $DT_PRE;
		$ip = trim($ip);
		if(!preg_match("/^[0-9]{1,3}\.[0-9\*]{1,3}\.[0-9\*]{1,3}\.[0-9\*]{1,3}$/", $ip)) msg('IP地址或IP段格式错误');
		$totime = $todate ? strtotime($todate.' 00:00:00') : 0;
		$db->query("INSERT INTO {$DT_PRE}banip (ip,editor,addtime,totime) VALUES ('$ip','$_username','$DT_TIME','$totime')");
	}


/*=======  QQ群批量导入  over  =========*/
	function edit($post) {
		global $DT, $MOD, $module;
		$post = $this->set($post);
		$sql = '';
		foreach($post as $k=>$v) {
			if(in_array($k, $this->fields)) $sql .= ",$k='$v'";
		}
        $sql = substr($sql, 1);
	    $this->db->query("UPDATE {$this->table} SET $sql WHERE itemid=$this->itemid");
		return true;
	}

	function interest() {
		global $DT, $MOD, $module,$_userid,$_username,$db, $DT_PRE,$kw,$areaid,$day,$DT_TIME;
		$sql="SELECT  COUNT(*) AS num FROM ".$DT_PRE."alert WHERE word='".$kw."' and username='".$_username."'";
		$r= $this->db->query($sql);
		if(!$r['num']){
				$sql="SELECT * FROM ".$DT_PRE."member WHERE userid=".$_userid;
				$member=$this->db->get_one($sql);
				$email=$member['email'];
				$sql="INSERT INTO ".$DT_PRE."alert (mid,catid,areaid,email,username,addtime,word,status) VALUES (5,0,0,'$email','$_username',$DT_TIME,'$kw',2)";
				$this->db->query($sql);
		}
		return true;
	}

	function delete($itemid) {
		global $_groupid,$_userid,$_username;
			$r = $this->db->get_one("SELECT * FROM {$this->table} WHERE itemid=$itemid");
			if($_username==$r['username']||$_groupid==1){
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

	function html() {
		global $module;
		$result = $this->db->query("SELECT * FROM {$this->table} WHERE islink=0");
		while($r = $this->db->fetch_array($result)) {
			$itemid = $r['itemid'];
			tohtml('taoxinxi', $module, "itemid=$itemid");
		}
		return true;
	}


	function _($e) {
		$this->errmsg = $e;
		return false;
	}
}
?>