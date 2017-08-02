<?php
class info{
	var $db;
	var $table;
	
	function info($name){
		global $db;
		$this->table=$db->pre.'sogex_info_'.$name;
		$this->db=$db;
	}
	
	function set($post){
		return true;
	}
	
	function get_one($itemid){
		return $this->db->get_one("select * from {$this->table}  where itemid = $itemid");
	}
	
	function get_list($condition, $order) {
		global $pages, $page, $pagesize, $offset, $pagesize;
		$pages = pages($this->db->count($this->table, $condition), $page, $pagesize);
		$lists = array();
		$result = $this->db->query("SELECT * FROM {$this->table} WHERE $condition ORDER BY $order LIMIT $offset,$pagesize");
		while($r = $this->db->fetch_array($result)) {
			$lists[] = $r;
		}
		return $lists;
	}
	
	function add($post){
		
		$data['addtime']=time();
		$data['updatetime']=time();
		$back=$this->db->query("insert into {$this->table} (title,keywords,description,website,website_url,url,type,level,star,thumb,addtime,updatetime,status) values ('".$data['title']."','".$data['keywords']."','".$data['description']."','".$data['website']."','".$data['website_url']."','".$data['url']."',".$data['type'].",".$data['level'].",".$data['star'].",'".$data['thumb']."',".$data['addtime'].",".$data['updatetime'].",".$data['status'].")");
		return $back;
	}
	
	function delete($itemid){
		$this->db->query("delete from {$this->table} where itemid = $itemid");
	}
	
	function update($post,$itemid){
		
		$data['updatetime']=time();
		$set_str = '';
		foreach($post as $k=>$v){
			$set_str .= $k . "= '$v',";
		}
		if(empty($set_str)){
			return false;
		}else{
			$set_str = substr($set_str,0,-1);
			return $this->db->query("update {$this->table} set $set_str where itemid = $itemid");
		}
	}
	
	function change($itemid,$status){
		return $this->db->query("update {$this->table} set status = $status where itemid = $itemid");
	}
}
?>
