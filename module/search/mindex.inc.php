<?php 
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
require DT_ROOT.'/include/ideas.class.php';
global $db;
global $pages, $page, $pagesize, $offset, $pagesize;

$ideas = new ideas();
$hot_news = get_cache('hot_news');
include template('mindex', $module);

class info{
	var $db;
	var $table;
	var $data_table;
	
	function info(){
		global $db;
		$this->table=$db->pre.'sogex_info';
		$this->data_table=$db->pre.'sogex_info_data';
		$this->db=$db;
	}
	
	function set($post){
		$check_field=array('title','keywords','description','website','website_url','url','type','level','star','thumb','areaid','tags','addtime','updatetime','label1','label2','label3','status','content');
		$back=array();
		foreach($post as $k=>$v){
			if(in_array($k,$check_field)){
				$back[$k]=$v;	
			}
		}
		return $back;
	}
	
	function get_one($infoid){
		return $this->db->get_one("select * from {$this->table} as i join {$this->data_table} as idata on idata.infoid = i.infoid where i.infoid = $infoid");
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
		$data = $this->set($post);
		$data['addtime']=time();
		$data['updatetime']=time();
		$back=$this->db->query("insert into {$this->table} (title,keywords,description,website,website_url,url,type,level,star,thumb,areaid,tags,addtime,updatetime,label1,label2,label3,status) values ('".$data['title']."','".$data['keywords']."','".$data['description']."','".$data['website']."','".$data['website_url']."','".$data['url']."',".$data['type'].",".$data['level'].",".$data['star'].",'".$data['thumb']."',".$data['areaid'].",'".$data['tags']."',".$data['addtime'].",".$data['updatetime'].",'".$data['label1']."','".$data['label2']."','".$data['label3']."',".$data['status'].")");
		$this->db->query("insert into {$this->db->pre}web_info_data (infoid,content) values (".$this->db->insert_id().",'".$data['content']."')");
		return $back;
	}
	
	function delete($infoid){
		$this->db->query("delete from {$this->table} where infoid = $infoid");
		$this->db->query("delete from {$this->data_table} where infoid = $infoid");
	}
	
	function update($post,$infoid){
		$data=$this->set($post);
		$data['updatetime']=time();
		extract($data);
		$back=$this->db->query("update {$this->table} set title='$title',keywords='$keywords',description='$description',website='$website',website_url='$website_url',type=$type,url='$url',level='$level',star='$star',thumb='$thumb',areaid=$areaid,tags='$tags',updatetime='$updatetime',label1='$label1',label2='$label2',label3='$label3',status=$status where infoid = $infoid");
		$this->db->query("update {$this->data_table} set content='$content' where infoid = $infoid");
		return true;
	}
	
	function change($infoid,$status){
		$this->db->query("update {$this->table} set status = $status where infoid = $infoid");
	}
}
?>
