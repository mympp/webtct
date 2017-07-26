<?php

defined('DT_ADMIN') or exit('Access Denied');
include_once 'sogex_common.inc.php';
$menus = array (
	array('返回sogex管理','?file=sogex'),
	array('查看搜索记录','?file='.$file),
	array('查看搜索统计','?file='.$file.'&action=census'),
	array('查看用户反馈','?file='.$file.'&action=feekback'),
	array('查看客服电话点击','?file='.$file.'&action=tel_record')
);

$info_type = get_cache('info_type');
$info_type[0]['name'] = '全网'; 

$record = new record();

if($submit){
	switch($action){
		case 'delete':
			if($record->delete($post['itemid'])){
				dmsg('删除成功!','?file='.$file);
			}else{
				msg('删除失败');
			}
		break;
	}
}else{
	switch($action){
		case 'census':
			$num = isset($num)? $num : 10;
			$todate = isset($todate) ? strtotime($todate) : time();
			$todate_str = date('Ymd',$todate);
			$fromdate = isset($fromdate) ? strtotime($fromdate) : strtotime($todate_str);
			$type = isset($type) ? $type : ''; 
			$stype = isset($stype) ? $stype : 1 ;
			$page = isset($page) ? $page : 1;

			$lists = array();
			if($stype == '1') $lists = $record->get_hot_word($fromdate,$todate,$num,$type,$page);
			if($stype == '2') $lists = $record->get_least_word($fromdate,$todate,$num,$type,$page);
			
			$stodate = $todate;
			$sfromdate = $fromdate;
			$todate = date('Ymd',$todate);
			$fromdate = date('Ymd',$fromdate);
			include tpl('sogex_record_census');
		break;
		case 'feekback':
			global $db,$offset,$pagesize ;
			$page = isset($page) ? $page : 1;
			$offset = ($page - 1)*$pagesize;
			$feekback = $db->query("select * from {$db->pre}feekback where module = 'sogex' order by itemid desc limit $offset , $pagesize");
			$lists = array();
			while($r = $db->fetch_array($feekback)){
				$lists[] = $r;
			}
			$pages = pages($db->count($db->pre.'feekback'), $page, $pagesize);
			include tpl('sogex_record_feekback');
		break;
		case 'tel_record':
			$condition = '';
			$condition_arr = array();
			if($telephone) $condition_arr[] = "telephone = '$telephone' ";
			if($fromdate) $condition_arr[] = "addtime >= ".strtotime($fromdate).' ';
			if($todate) $condition_arr[] = "addtime <= ".strtotime($todate).' ';
			if(!empty($condition_arr)) $condition = 'where '.implode(' and ',$condition_arr);		//搜索条件数据拼接成搜索语句
			
			$page = isset($page) ? $page : 1;
			$lists = array();
			global $db,$pagesize,$offset,$pages;
			$offset = ($page - 1)*$pagesize;
			$tel_record = $db->query("select * from {$db->pre}tel_record $condition order by itemid desc limit $offset,$pagesize");
			while($r = $db->fetch_array($tel_record)){
				$lists[] = $r;
			}
			$count = $db->get_one("select count(*) as c from {$db->pre}tel_record $condition");
			$pages = pages($count['c'],$page,$pagesize);
			
			include tpl('sogex_record_tel_record');
		break;
		default:
			$condition = '' ;
			$condition_arr = array();
			if($type) $condition_arr[] = "type = $type"; 
			if($username) $condition_arr[] = "username = '$username'";
			if($fromtotal) $condition_arr[] = "total >= $fromtotal";
			if($tototal) $condition_arr[] = "total <= $tototal";
			if($fromdate) $condition_arr[] = "addtime >= ".strtotime($fromdate).' ';
			if($todate) $condition_arr[] = "addtime <= ".strtotime($todate).' ';
			$condition = implode(' and ',$condition_arr);		//搜索条件数据拼接成搜索语句
			$order = isset($order)? $order : 'addtime desc ' ;
			$lists = $record -> get_lists($condition,$order,15);
			include tpl($file);
	}
}



class record{
	
	var $db;
	public $table;
	public $itemid;
	
	function __construct(){
		global $db;
		$this->db = $db;
		$this->table = $db->pre.'sogex_record';
	}
	
	function delete($post){
		$delete_str = $post;
		if(is_array($post)){
			$delete_str = implode(',',$post);
		}
		return $this->db->query("delete from {$this->table} where itemid in ($delete_str)");
	}
	
	public function get_hot_word($fromdate,$todate,$num,$type = '',$page = 1){
		global $pages;
		$lists = array();
		$type_condition = '';
		$offset = ($page - 1)*$num;
		if(!empty($type)) $type_condition = ' and type = '.$type;
		$result = $this->db->query("select word,count(word) as census from {$this->table} where addtime >= $fromdate and addtime <= $todate $type_condition group by word order by census desc,itemid desc limit $offset , $num");
		while($r = $this->db->fetch_array($result)){
			$lists[] = $r;
		}
		$count = $this->db->get_one("select count(*) as c from (select word from {$this->table} where addtime >= $fromdate and addtime <= $todate $type_condition group by word) as b");
		$pages = pages($count['c'],$page,$num);
		return $lists;
	}
	
	public function get_least_word($fromdate,$todate,$num,$type= '',$page = 1){		//获取搜索量少的搜索词
		global $pages;
		$lists = array();
		$type_condition = '';
		$offset = ($page - 1)*$num;
		if(!empty($type)) $type_condition = ' and type = '.$type;
		$result = $this->db->query("select * from {$this->table} where addtime >= $fromdate and addtime <= $todate $type_condition group by word,type order by total asc ,itemid desc limit $offset , $num");
		while($r = $this->db->fetch_array($result)){
			$lists[] = $r;
		}
		$count = $this->db->get_one("select count(*) as c from (select word from {$this->table} where addtime >= $fromdate and addtime <= $todate $type_condition group by word,type) as a");
		$pages = pages($count['c'],$page,$num);
		return $lists;
	}
	
	public function get_lists($condition='',$order,$psize){
		global $pages, $page, $pagesize, $offset, $pagesize;
		if(empty($psize)){
			 $psize = $pagesize ;
		}else{
			$offset = ($page-1)*$psize;
		}
		$pages = pages($this->db->count($this->table, $condition), $page, $psize);
		$lists = array();
		if($condition != '') $condition = 'where '.$condition;
		$result = $this->db->query("SELECT * FROM {$this->table} $condition ORDER BY $order LIMIT $offset,$psize");
		while($r = $this->db->fetch_array($result)) {
			$lists[] = $r;
		}
		return $lists;
	}
}
?>