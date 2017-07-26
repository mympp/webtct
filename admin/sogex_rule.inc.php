<?php
/*
who:chentao
date:2016/3/21
what:新增搜索管理
where:新增文件
*/

defined('DT_ADMIN') or exit('Access Denied');
include_once 'sogex_common.inc.php';
$menus = array (
	array('返回sogex管理','?file=sogex'),
	array('添加规则','?file='.$file.'&action=add'),
    array('规则列表','?file='.$file),
);

$web_message=new web_message();
$web_lists=$web_message->get_list("mid <> ''",'addtime');           //获取来源网站数组
$info_type =new info_type();
$info_lists=$info_type->get_list();
$info_type_arr=array();                                //数据类型数组
foreach($info_lists as $k=>$v){
	$info_type_arr[$v['catid']]['name']=$v['name'];
}
$rule_type_arr=array('针对单一分类单一词','针对单一分类所有词','针对所有分类单一词','针对所有分类所有词');

$rule=new web_rule();
if($submit){
	switch($action){
		case 'add':
			if($rule->add($post)){
				dmsg('规则添加成功','?file='.$file);
			}else{
				msg('规则添加失败','?file='.$file);
			}
		break;
		case 'delete':
			if($post['ruleid']){
				$ruleid=$post['ruleid'];
				foreach($ruleid as $k=>$v){
					$rule->delete($v);
				}
			}
			dmsg('规则删除完成!','?file='.$file);
		break;
		case 'edit':
			if($rule->update($ruleid,$post)){
				dmsg('规则修改完成!','?file='.$file);
			}else{
				msg('规则修改失败!');
			}
			
		break;
	}
}else{
	switch($action){
		case 'add':
			include tpl($file.'_edit');
		break;
		case 'delete':
			if($ruleid){
				$rule->delete($ruleid);
			}
			dmsg('规则删除完成!','?file='.$file);
		break;
		case 'edit':
			$result=$rule->get_one('ruleid = '.$ruleid);
			extract($result);
			include tpl($file.'_edit');
		break;
		default:
			$order= 'addtime desc ';
			$condition= "ruleid <> ''";
			$lists=$rule->get_list($condition,$order);
			include tpl($file);
	}
}

class web_rule{
	
	var $db;
	var $table;
	
	function web_rule(){
		global $db;
		$this->db=$db;
		$this->table=$db->pre.'sogex_rule';
	}
	
	function set($post){
		$check_field=array('web_url','web_name','infotype','keyword','type','infotype','level','score','status','addtime');
		$back=array();
		foreach($post as $k=>$v){
			if(in_array($k,$check_field)){
				$back[$k]=$v;	
			}
		}
		return $back;
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
		$data=$this->set($post);
		extract($data);
		$addtime=time();
		return $this->db->query("insert into {$this->table} (level,web_url,web_name,keyword,type,infotype,score,addtime,status) values ($level,'$web_url','$web_name','$keyword',$type,$infotype,$score,$addtime,3)");
	}
	
	function delete($ruleid){
		return $this->db->query("delete from {$this->table} where ruleid = $ruleid");
	}
	
	function get_one($condition){
		return $this->db->get_one("select * from {$this->table} where $condition");
	}
	
	function update($ruleid,$post){
		$data=$this->set($post);
		extract($data);
		return $this->db->query("update {$this->table} set level=$level,web_url='$web_url',web_name='$web_name',keyword='$keyword',type=$type,infotype=$infotype,score=$score where ruleid = $ruleid");
	}
}
?>