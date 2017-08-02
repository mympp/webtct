<?php 
defined('IN_DESTOON') or exit('Access Denied');
class announce {
	var $itemid;
	var $db;
	var $table;
	var $fields;
	var $errmsg = errmsg;

    function announce() {
		global $db, $DT_PRE;
		$this->table = $DT_PRE.'announce';
		$this->db = &$db;
		$this->fields = array('typeid','areaid','level', 'title','style','content','addtime','fromtime','totime','editor','edittime','template', 'islink', 'linkurl');
    }

	function pass($post) {
		global $L;
		if(!is_array($post)) return false;
		if(!$post['typeid']) return $this->_($L['announce_pass_type']);
		if(!$post['title']) return $this->_($L['announce_pass_title']);
		if(isset($post['islink'])) {
			if(!$post['linkurl']) return $this->_($L['announce_pass_url']);
		} else {
			if(!$post['content']) return $this->_($L['announce_pass_content']);
		}
		return true;
	}

	function set($post) {
		global $MOD, $DT_TIME, $_username, $_userid;
		$post['islink'] = isset($post['islink']) ? 1 : 0;
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
		return array_map("trim", $post);
	}

	function get_one() {
        return $this->db->get_one("SELECT * FROM {$this->table} WHERE itemid='$this->itemid'");
	}

	function get_list($condition = '1', $order = 'listorder DESC,addtime DESC') {
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
			$r['title'] = set_style($r['title'], $r['style']);
			$r['adddate'] = timetodate($r['addtime'], 5);
			$r['editdate'] = timetodate($r['edittime'], 5);
			$r['fromdate'] = $r['fromtime'] ? timetodate($r['fromtime'], 3) : $L['timeless'];
			$r['todate'] = $r['totime'] ? timetodate($r['totime'], 3) : $L['timeless'];
			$r['typename'] = $TYPE[$r['typeid']]['typename'];
			$r['typeurl'] = $MOD['announce_url'].list_url($r['typeid']);
			$lists[] = $r;
		}
		return $lists;
	}

	function add($post) {
		global $DT, $MOD, $module;
		$post = $this->set($post);
		$sqlk = $sqlv = '';
		foreach($post as $k=>$v) {
			if(in_array($k, $this->fields)) { $sqlk .= ','.$k; $sqlv .= ",'$v'"; }
		}
        $sqlk = substr($sqlk, 1);
        $sqlv = substr($sqlv, 1);
		$this->db->query("INSERT INTO {$this->table} ($sqlk) VALUES ($sqlv)");
		$this->itemid = $this->db->insert_id();
		if(!$post['islink']) {
			$linkurl = $this->linkurl($this->itemid);
			$this->db->query("UPDATE {$this->table} SET linkurl='$linkurl' WHERE itemid=$this->itemid");
		}
		return $this->itemid;
	}
/*=======  QQȺ��������  =========*/
	function check_daoru($post){
		$strcon = array();
		$key = array();
		$value = array();
		$result = array();
		$content_0 = trim($post["content"]);
		$content_1 = str_replace("\r\n","",$content_0);
		$content_1 = str_replace(".com>",".com)",$content_1);
		preg_match_all("/(201.*?\\))/",$content_1,$match);
		$match = $match[0];
		foreach($match as $k=>$v){
			$content_1 = str_replace("$v","\r\n$v\r\n",$content_1);
		}
		$strcon = explode("\r\n",$content_1); 
		foreach($strcon as $k=>$v){
			if(!$v){
				unset($strcon[$k]);
			}
		}
		foreach($strcon as $k=>$v){
			if(preg_match("/(201.*?\\))/",$v)){
				$key[] = htmlspecialchars($v);
			}else{
				$value[] = $v;
			}
		}
		$result = array_combine($key,$value);
		$content_len = $post["content_len"]*3;
		foreach($result as $k=>$v){
			if($v == "[����]" || $v == "[ͼƬ]" || strlen($v) <= $content_len){
				unset($result[$k]);
			}
		}
		return $result;
	}

	function add_daoru($post,$contents){
		global $DT_TIME, $DT_IP, $_username;
		foreach($contents as $k=>$v){
			if(preg_match("/\\[(.*?)\\]/",$v)){
				$v = str_replace("[ͼƬ]","",$v);
				$v = str_replace("[����]","",$v);
			}
			$explode_announce = explode(",",$v);
			if(preg_match("/\\(+\d+\\)/",$explode_announce[0])){
				preg_match_all("/\\(+\d+\\)/",$explode_announce[0],$match);
				$qq_num = $match[0][0];
				$link_to_qq = str_replace("(","<br/>QQ��ϵ��<a href=\"http://wpa.qq.com/msgrd?v=3&uin=",$qq_num);
				$link_to_qq = str_replace(")","&site=qq&menu=yes\" target=\"_blanke\">$qq_num</a>",$link_to_qq);
				$this->db->query("INSERT INTO tc_announce (itemid,typeid,areaid,title,style,content,hits,addtime,fromtime,totime,editor,edittime,islink,linkurl,listorder,template) VALUES ('','$post[typeid]','0','$explode_announce[0]','','$explode_announce[1]$link_to_qq','0','$DT_TIME','0','0','$_username','$DT_TIME','0','','0','')");
			}else{
				$this->db->query("INSERT INTO tc_announce (itemid,typeid,areaid,level,title,style,content,hits,addtime,fromtime,totime,editor,edittime,islink,linkurl,listorder,template) VALUES ('','$post[typeid]','0','0','$explode_announce[0]','','$explode_announce[1]','0','$DT_TIME','0','0','$_username','$DT_TIME','0','','0','')");
			}
		}
	}

	function set_type($itemid,$post){
		$itemids = is_array($itemid) ? implode(',', $itemid) : $itemid;
		$this->db->query("UPDATE {$this->table} SET typeid=$post[typeid] WHERE itemid IN ($itemids)");
	}
/*=======  QQȺ��������  over  =========*/
	function edit($post) {
		global $DT, $MOD, $module;
		$post = $this->set($post);
		$sql = '';
		foreach($post as $k=>$v) {
			if(in_array($k, $this->fields)) $sql .= ",$k='$v'";
		}
        $sql = substr($sql, 1);
	    $this->db->query("UPDATE {$this->table} SET $sql WHERE itemid=$this->itemid");
		if(!$post['islink']) {
			$linkurl = $this->linkurl($this->itemid);
			$this->db->query("UPDATE {$this->table} SET linkurl='$linkurl' WHERE itemid=$this->itemid");
		}
		return true;
	}

	function linkurl($itemid) {
		global $MOD;
		$linkurl = show_url($itemid);
		return $MOD['announce_url'].$linkurl;
	}

	function delete($itemid, $all = true) {
		global $DT;
		if(is_array($itemid)) {
			foreach($itemid as $v) { 
				$this->delete($v, $all); 
			}
		} else {
			$this->itemid = $itemid;
			$r = $this->get_one();
			if($all) {
				$userid = get_user($r['editor']);
				if($r['content']) delete_local($r['content'], $userid);
				$this->db->query("DELETE FROM {$this->table} WHERE itemid=$itemid");
				$fileurl = DT_ROOT.'/announce/'.$itemid.'.'.$DT['file_ext'];
				if(is_file($fileurl)) unlink($fileurl);
			}
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