<?php

function select_info_type($name,$id='',$checked='',$onchange='',$height='',$width=''){
	$lists=get_cache('info_type');
	$back_str='<select name="'.$name.'" id="'.$id.'" onchange="'.$onchange.'" style="height:'.$height.';width:'.$width.'">';
	$check=$checked==''?'selected="selected"':'';
	$back_str.='<option '.$check.' value="0"></option>';
	foreach($lists as $k=>$v){
		$check=$checked==$v['catid']?'selected="selected"':'';
		$back_str.='<option '.$check.' value="'.$v['catid'].'">'.$v['name'].'</option>';
	}
	$back_str.='</select>';
	return $back_str;
}

function select_website($name,$id='',$checked='',$onchange='',$height='',$width=''){
	$web_message=new web_message();
	$lists=$web_message->get_list("mid <> ''",'addtime');
	$back_str='<select name="'.$name.'" id="'.$id.'" size="2" onchange="'.$onchange.'" style="height:'.$height.';width:'.$width.'">';
	foreach($lists as $k=>$v){
		$check=$checked==$v['mid']?'selected="selected"':'';
		$back_str.='<option '.$check.' value="'.$v['mid'].'">'.$v['name'].'</option>';
	}
	$back_str.='</select>';
	return $back_str;
}

function get_cache($name){
	$dir = 'sogex';
	$back = cache_read($name.'.php',$dir);
	if(!$back) { set_cache($name); }else{ return $back; }
	return cache_read($name.'.php',$dir);
}

function set_cache($name,$string){
	$dir = 'sogex';
	switch($name){
		case 'info_type':
			$info_type = new info_type();
			$lists = $info_type -> get_list();

			$write = array();
			foreach($lists as $k=>$v){
				$write[$v['catid']] = $v;
			}
			return cache_write($name.'.php',$write,$dir);
		break;
		case 'website_rule':
			global $db;
			$website_setting_data = $db->query("select * from {$db->pre}setting where item = 'sogex_website'");
			$write = array();
			while($v= $db->fetch_array($website_setting_data)){
				$write[$v['item_key']] = $v['item_value'];
			}
			return cache_write($name.'.php',$write,$dir);
		break;
		default:
			return false;
	}
	
}

class info_type{
	var $db;
	var $table;
	
	function info_type(){
		global $db;
		$this->db=$db;
		$this->table=$db->pre.'sogex_info_type';
	}
	
	function get_list(){
		$result=$this->db->query("select * from {$this->table}");
		$lists=array();
		while($r=$this->db->fetch_array($result)){
			$lists[]=$r;
		}
		return $lists;
	}
}

	
class web_message{

	var $db;
	var $table;
	public $mid ;

	function web_message(){
		global $db;
		$this->db=$db;
		$this->table=$db->pre.'sogex_message';
	}
	
	function set($post){
		$check_field=array('name','url','type','traffic_forecast','keywords_num','ipavg','pvavg','baidu_site','tc_site','star','addtime','updatetime');
		$back=array();
		foreach($post as $k=>$v){
			if(in_array($k,$check_field)){
				$back[$k]=$v;	
			}
		}
		return $back;
	}
	
	function get_one($condition = '') {
        return $this->db->get_one("SELECT * FROM {$this->table} WHERE mid=$this->mid $condition");
	}
	
	function add($post){
		$data=$this->set($post);
		$sqlk = '(';
		$sqlv = '(';
		foreach($data as $k=>$v){
			$sqlk .= $k.',';
			$sqlv .= "'$v',";
		}
		$sqlk = substr($sqlk,0,-1);
		$sqlv = substr($sqlv,0,-1);
		$sqlk .= ')';
		$sqlv .= ')';
		
		return $this->db->query("insert into {$this->table} $sqlk values $sqlv");
	}
	
	function edit($post){
		$data = $this->set($post);
		$sqlv = '';
		foreach($data as $k => $v){
			$sqlv .= $k."='".$v."',";
		}
		$sqlv = substr($sqlv,0,-1);
		return $this->db->query("update {$this->table} set $sqlv where mid = {$this->mid}");
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
	
	function delete($mid){
		$mid_str = '';
		if(is_array($mid)){
			$mid_str = implode(',',$mid);
		}else{
			$mid_str = $mid;
		}
		return $this->db->query("delete from {$this->table} where mid in ($mid_str)");
	}
}
