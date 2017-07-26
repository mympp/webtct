<?php

defined('DT_ADMIN') or exit('Access Denied');
require_once 'sogex_common.inc.php';

$menus = array (
	array('返回sogex管理首页','?file=sogex'),
	array('添加信息','?file='.$file.'&action=add'),
    array('已启用信息', '?file='.$file),
    array('待审核信息', '?file='.$file.'&status=2'),
    array('回收站','?file='.$file.'&status=4'),
	array('数据分类','?file=sogex_info_type'),
);

$info=new info();
$condition='';
$status = isset($status)?$status:'3';
$submit=isset($_GET['submit'])?$_GET['submit']:$submit;

$info_type = get_cache('info_type');

if($submit){
	switch($action){
		case 'add':
			$back=$info->add($post);
			if($back){
				dmsg('信息添加成功!','?file='.$file);
			}else{
				msg('信息添加失败!');
			}
		break;
		case 'edit':
			if(isset($infoid)){
				if($info->update($post,$infoid)){
					dmsg('信息修改成功!','?file='.$file);
				}else{
					msg('信息修改失败');
				}
			}
		break;
		case 'revoke':        //撤下信息
			$infoid_arr=$post['infoid'];
			if(!empty($infoid_arr)){
				foreach($infoid_arr as $k=>$v){
					$info->change($v,4);
				}
			}
			dmsg('信息撤下完成','?file='.$file);
		break;
		case 'delete':
			$infoid_arr=$post['infoid'];
			if(!empty($infoid_arr)){
				foreach($infoid_arr as $k=>$v){
					$info->delete($v);
				}
			}
			if(isset($infoid)){
				$info->delete($infoid);
			}
			dmsg('删除完成!','?file='.$file);
		break;
		case 'check':
			$infoid=$post['infoid'];
			if(!empty($infoid)){
				foreach($infoid as $k=>$v){
					$info->change($v,3);
				}
			}
			if($downpic){                //开启内容图片下载
				downpic($infoid,DT_ROOT.'/file/search/',DT_PATH.'file/search/');
			}
				dmsg('审核完成!','?file='.$file);
		break;
		case 'batch_check':
			$each_num=isset($each_num)?$each_num:100;
			$each_num=intval($each_num)<100?100:$each_num;
			$time_interval=isset($time_interval)?$time_interval:10;	
			$time_interval=intval($time_interval)<10?10:$time_interval;	
			//标题或内容为空到信息放到回收站
			$db->query("update {$info->table} set status = 1 where title = '' and status = 2");

			$i=isset($i)?$i:1;
			$count=$db->get_one("select count(*) as c from {$info->table} where status = 2");
			while(intval($count['c'])>0){
				$info_data=$db->query("select * from {$info->table} where status = 2 order by addtime desc,infoid desc limit 0 , $each_num");
				while($r=$db->fetch_array($info_data)){
					if($downpic && $r['thumb']!=''){downpic(array($r['infoid']),DT_ROOT.'/file/search/',DT_PATH.'file/search/');}
					$info->change($r['infoid'],3);
				}
				sleep($time_interval);
				msg('完成审核'.intval($each_num)*$i.'条信息','?submit=1&file='.$file.'&action='.$action.'&each_num='.$each_num.'&time_interval='.$time_interval.'&i='.($i+1));
			}
			msg('批量审核完成');
		break;
		case 'search':
			if(empty($_POST['keyword'])) msg('请输入查找内容');
			$status = empty($status)? 3:$status;
			$keyword = $_POST['keyword'];
			$condition = "title like '%$keyword%' ";
			$condition .= "and status = $status ";
			if(!empty($type)) $condition .= "and type = $type ";
			$lists = $info->get_list($condition,'addtime desc',$psize);
			include tpl($file);
		break;
	}
	
}else{
	switch($action){
		case 'add':
			include tpl('sogex_info_edit');
		break;
		case 'edit':
			$info_data=$info->get_one($infoid);
			extract($info_data);
			include tpl('sogex_info_edit');
		break;
		default:
			$order='addtime desc';
			if($status == 3 ||$status == ''){
				$condition.='status = 3 ';
			}elseif($status==4||$status==1){		//信息未通过或已撤销
				$condition.='status = 1 or status = 4 ';
			}else{
				$condition.='status = '.$status.' ';
			}
			$lists=$info->get_list($condition,$order);
			include tpl('sogex_info');	
	}
}

function downpic($infoid,$picdir,$picpath){	//图片下载方法
	$info=new info();
	$i=1;
	if(!is_dir($picdir)){
		mkdir($picdir);
	}
	foreach($infoid as $k=>$v){
		$info_data=$info->get_one($v);
		if($info_data['thumb']){
			if(strstr($info_data['thumb'],$filepath)){continue;}         //图片地址已为服务器地址，不进行下载
			$path_url=pathinfo($info_data['thumb']);
			$filedir=$picdir.date('Y-m-d-H-i-s',time()).'-'.$i.'.'.$path_url['extension'];
			$filepath=$picpath.date('Y-m-d-H-i-s',time()).'-'.$i.'.'.$path_url['extension'];
			$ch = curl_init();
    			curl_setopt($ch, CURLOPT_URL, $info_data['thumb']);
    			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    			$temp = curl_exec($ch);
			$p=file_put_contents($filedir,$temp);
			if($p && !curl_error($ch)) {
				global $db;
		    		$db->query("update {$db->pre}sogex_info set thumb = '$filepath' where infoid = $v");
			}
			$i++;
		}
	}
}

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
	
	function get_list($condition, $order,$psize='') {
		global $pages, $page, $pagesize, $offset, $pagesize;
		if(empty($psize)) $psize = $pagesize;
		$pages = pages($this->db->count($this->table, $condition), $page, $psize);
		$lists = array();
		$result = $this->db->query("SELECT * FROM {$this->table} WHERE $condition ORDER BY $order LIMIT $offset,$psize");
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
		$this->db->query("insert into {$this->db->pre}sogex_info_data (infoid,content) values (".$this->db->insert_id().",'".$data['content']."')");
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
