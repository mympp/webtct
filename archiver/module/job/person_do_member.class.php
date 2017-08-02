<?php 
/*
* 何楷伟 QQ：335418588
* 2013-07-18
* person_do_member.tpl.php->person_do_member.inc.php->person_do_member.class.php
*/
defined('IN_DESTOON') or exit('Access Denied');
class person_do_member {
	var $moduleid;
	var $itemid;
	var $db;
	var $table;
	var $table_data;
	var $errmsg = errmsg;

    function person_do_member($moduleid) {
		global $db, $table, $table_data, $MOD;
		$this->moduleid = $moduleid;
		$this->table = $table;
		$this->table_data = $table_data;
		$this->db = &$db;
    }

	function get_member_list($condition ='admin = 0',$order = 'userid'){
		//此函数获取注册会员名单，用到该函数的文件有person_do_member.inc.php 、person_do_member.tpl.php
		global $pages,$page,$pagesize,$offset,$itmes,$MOD;
		$r = $this->db->get_one("SELECT COUNT(*) AS num FROM tc_member WHERE $condition");
		$items = $r['num'];
		$pages = pages($items,$page,$pagesize);
		$member_lists = array();
		$result = $this->db->query("SELECT * FROM tc_member WHERE $condition ORDER BY $order LIMIT $offset,$pagesize");
		while($r = $this->db->fetch_array($result)){
			$member_lists[] = $r;
		}
		return $member_lists;
	}

	function get_person_do_select_members(){
		//获取已选名义会员
		$r = $this->db->get_one("SELECT COUNT(*) AS num FROM tc_person_do_select_members");
		$items = $r['num'];
		return $items;
	}
}
?>