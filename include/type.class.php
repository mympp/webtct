<?php
/*
	[Destoon B2B System] Copyright (c) 2008-2015 www.destoon.com
	This is NOT a freeware, use is subject to license.txt

#修改信息#
#何楷伟
#2013-06-20
#文件涉及网店商品分类，网店商品分类涉及文件与数据库：
		文件：
		module\member\type.inc.php
		template\tcxiu17\member\type.htm
		template\tcxiu17\homepage\mall.htm
		数据库：
		type表添加parentid字段，其用意是将typeid字段存为自己的父类，父类的默认parentid值为‘0’。

#本文件更变有：
		#增加function get_big_list() 获取parentid为‘0’的父类；
		#增加function get_little_list() 获取parentid不为‘0’的子类；
		#function add() 修改了添加语句，判断是添加父类（newClass）还是子类（newSonClass）;
		#function delete(),添加判断如果删除的是父类，将其所属子类也删除;

#module\member\type.inc.php文件更变有：
		#实例化类文件type.class.php的get_big_list函数（$bigtypes = $do->get_big_list()）和get_little_list函数（$littletypes = $do->get_little_list()）

#template\tcxiu17\member\type.htm文件更变有：
		#循环出$bigtypes和$littletypes
		#判断parentid与typeid相等的列;
		#以及更变HTML代码与JS代码;

#template\tcxiu17\homepage\mall.htm文件更变有：
		#新增标签$ltags查询子类（parentid = typeid(父类ID)）;
*/
defined('IN_DESTOON') or exit('Access Denied');
class dtype {
	var $item;
	var $db;
	var $table;
	var $cache = 0;

	function dtype() {
		global $db;
		$this->db = &$db;
		$this->table = $this->db->pre.'type';
	}

	function get_big_list() {//TC添加
		$lists = array();
		$result = $this->db->query("SELECT * FROM {$this->table} WHERE item='$this->item' AND parentid='0' ORDER BY listorder ASC,typeid DESC");
		while($r = $this->db->fetch_array($result)){
			$lists[] = $r;
		}
		return $lists;
	}

	function get_little_list(){//TC添加
		$lists = array();
			$result = $this->db->query("SELECT * FROM {$this->table} WHERE item='$this->item' AND parentid !='0' ORDER BY listorder ASC,typeid DESC");
		while($r = $this->db->fetch_array($result)){
			$lists[] = $r;
		}
		return $lists;
	}

	function get_list() {
		$lists = array();
		$result = $this->db->query("SELECT * FROM {$this->table} WHERE item='$this->item' ORDER BY listorder ASC,typeid DESC ");
		while($r = $this->db->fetch_array($result)) {
			$lists[$r['typeid']] = $r;
		}
		return $lists;
	}

	function update($post) {
		$this->add($post[0]);
		unset($post[0]);
		foreach($post as $k=>$v) {
			if(isset($v['delete'])) {
				$this->delete($k);
				unset($post[$k]);
			}
		}
		$this->edit($post);
		if($this->cache) cache_type($this->item);
		return true;
	}

	function add($post) {//TC添修函数、V5.0升级V6.0修改函数
		global $TYPE;//V5.0升级V6.0添加
		$post['typename'] = dhtmlspecialchars(trim(strip_tags($post['typename'])));
		if(strlen($post['typename']) < 2) return false;
		$post['listorder'] = intval($post['listorder']);
		$post['parentid'] = intval($post['parentid']);//V5.0升级V6.0添加
		if($post['parentid'] && !isset($TYPE[$post['parentid']])) $post['parentid'] = 0;//V5.0升级V6.0添加
		$post['style'] = dhtmlspecialchars($post['style']);

		if($post['newAdd'] == "newClass")//TC添加
		$this->db->query("INSERT INTO {$this->table} (listorder,typename,style,item,cache,parentid) VALUES('$post[listorder]','$post[typename]','$post[style]','$this->item','$this->cache',0)");
		else
		$this->db->query("INSERT INTO {$this->table} (listorder,typename,style,item,cache,parentid) VALUES('$post[listorder]','$post[typename]','$post[style]','$this->item','$this->cache','$post[parentid]')");
	}

	function edit($post) {//V5.0升级V6.0修改函数
		global $TYPE;
		foreach($post as $k=>$v) {
			$v['typename'] = dhtmlspecialchars(trim(strip_tags($v['typename'])));
			if(strlen($v['typename']) < 2) continue;
			$v['listorder'] = intval($v['listorder']);
			$v['parentid'] = intval($v['parentid']);
			if($v['parentid'] == $k) continue;
			if($v['parentid'] && !isset($TYPE[$v['parentid']])) continue;
			$v['style'] = dhtmlspecialchars($v['style']);
			$k = intval($k);
			$this->db->query("UPDATE {$this->table} SET listorder='$v[listorder]',typename='$v[typename]',style='$v[style]',parentid='$v[parentid]' WHERE typeid='$k' AND item='$this->item'");
		}
	}

	function delete($typeid) {
		$typeid = intval($typeid);
		$this->db->query("DELETE FROM {$this->table} WHERE typeid=$typeid AND item='$this->item'");
		if($this->cache) cache_type($this->item);
		if($parentid = $typeid){//TC添加
			$this->db->query("DELETE FROM {$this->table} WHERE parentid=$typeid AND item='$this->item'");
			if($this->cache) cache_type($this->item);
		}
	}

	function parent_option($TYPE) {//V5.0升级V6.0添加函数
		$s = '';
		foreach($TYPE as $v) {
			if($v['parentid'] == 0) $s .= '<option value="'.$v['typeid'].'">'.$v['typename'].'</option>';
		}
		return $s;
	}
}
?>