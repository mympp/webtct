<?php 
defined('IN_DESTOON') or exit('Access Denied');
class person_do_comtem {
	var $moduleid;
	var $itemid;
	var $db;
	var $table;
	var $errmsg = errmsg;

    function person_do_comtem($moduleid){
		global $db, $table, $table_data, $MOD;
		$this->moduleid = $moduleid;
		$this->table = $table;
		$this->db = &$db;
    }
	
	function gat_comtem_lists(){
		global $page,$pages,$pagesize,$items,$offset;
		$r = $this->db->get_one("SELECT COUNT(*) AS num FROM tc_person_do_comment_templates");
		$items = $r['num'];
		$pages = pages($items,$page,$pagesize);
		$comtem_list = array();
		$result = $this->db->query("SELECT * FROM tc_person_do_comment_templates"); //ORDER BY com_id DSCE LIMIT $offset,$pagesize
		while($r = $this->db->fetch_array($result)){
			$comtem_list[] = $r;
		}
		return $comtem_list;
	}

	function add_comment_templates($post){
		global $DT_TIME;
		$this->db->query("INSERT INTO tc_person_do_comment_templates (com_id,tem_class,title,content,addtime) VALUES ('','$post[tem_class]','$post[title]','$post[content]','$DT_TIME')");
		return true;
	}

	function delete_comment_templates($com_id){
		$this->db->query("DELETE FROM tc_person_do_comment_templates WHERE com_id = '$com_id'");
		return true;
	}
}
?>