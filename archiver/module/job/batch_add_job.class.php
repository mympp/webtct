<?php
/*
*
*
*何楷伟
*2013-11-06
*页面传递过来的是各个输入框的数组$title,$type,$catid,$minsalary,$maxsalary,$areaid,$address,$department,$pinpai,$xinghao,$content,$totime,$username,$sex,$telephone,$email
*因为每个数组的单元数都是相同的，并且一一对应，所以用单个foreach循环数组$title，然后用数组的键名$k获取其他数组对应的值$v。如：$content[$k];
*
*相关文件：
*  admin/batch_add_job.inc.php
*  admin/template/batch_add_job_tpl.php
*
*/
defined('IN_DESTOON') or exit('Access Denied');
class batch_add_job{
	var $moduleid;
	var $itemid;
	var $db;
	var $table;
	var $errmsg = errmsg;

    function batch_add_job($moduleid) {
		global $db, $table, $table_data, $MOD;
		$this->moduleid = $moduleid;
		$this->table = $table;
		$this->db = &$db;
    }

	function add($leibei,$diziid,$title,$department,$minsalary,$maxsalary,$fenlei,$address,$pinpai,$xinghao,$content,$tobe,$post){
		global $DT_TIME,$DT_IP;
		$totime = 0;

		$new_catid = array();
		foreach($leibei as $k=>$v){
			$new_catid[] = intval($v);
		}

		$new_areaid = array();
		foreach($diziid as $k=>$v){
			$new_areaid[] = intval($v);
		}

		$new_department = array();
		foreach($department as $k=>$v){
			$v = $v?$v:"";
			$new_department[] = $v;
		}

		$new_pinpai = array();
		foreach($pinpai as $k=>$v){
			$v = $v?$v:"";
			$new_pinpai[] = $v;
		}

		$new_xinghao = array();
		foreach($xinghao as $k=>$v){
			$v = $v?$v:"";
			$new_xinghao[] = $v;
		}

		$keywords = array();
		foreach($title as $k=>$v){
			$keywords[] = $v.",".$new_pinpai[$k].",".$new_xinghao[$k];
		}

		$introduces = array();
		foreach($content as $k=>$v){
			$introduces[] = substr($v,60);
		}

		$row_com = $this->db->get_one("SELECT * FROM tc_company WHERE username = '$post[username]'");
		$row_mem = $this->db->get_one("SELECT * FROM tc_member WHERE username = '$post[username]'");
		$telephone = $row_com["telephone"]?$row_com["telephone"]:"";
		$mobile = $row_mem["mobile"]?$row_mem["mobile"]:"";
		$email = $row_mem["email"]?$row_mem["email"]:"";
		$sex = $row_mem["gender"];

		foreach($title as $k=>$v){
			$dt_time = $DT_TIME+86400*rand(0,-3)+2345*rand(0,7);
			$date = timetodate($dt_time, 3);
			$hits = rand(5,57);
			if($v != NULL){
				$this->db->query("INSERT INTO tc_job(catid,areaid,level,title,fee,introduce,keyword,department,total,minsalary,maxsalary,type,gender,marriage,education,minage,maxage,experience,status,hits,username,truename,telephone,mobile,address,email,sex,totime,editor,addtime,adddate,edittime,editdate,ip,template,company,tobe,pinpai,xinghao,validated) VALUES ('$new_catid[$k]','$new_areaid[$k]',0,'$v',0,'$introduces[$k]','$keywords[$k]','$new_department[$k]',0,'$minsalary[$k]','$maxsalary[$k]','$fenlei[$k]','$sex',0,0,18,0,0,3,'$hits','$post[username]','$post[truename]','$telephone','$mobile','$address[$k]','$email','$sex','$totime','$post[username]','$dt_time','$date','$dt_time','$date','$DT_IP',0,'$new_department[$k]','$tobe[$k]','$new_pinpai[$k]','$new_xinghao[$k]',1)");
				$itemid = $this->db->insert_id();
				$this->db->query("UPDATE tc_job SET linkurl = 'show-htm-itemid-$itemid.html' WHERE itemid = '$itemid'");
				$this->db->query("INSERT INTO tc_job_data(itemid,content) VALUES ('$itemid','$content[$k]')");
				$this->tohtml($itemid, $catid['$k']);
			}
		}
	}

	function tohtml($itemid = 0, $catid = 0) {
		global $module, $MOD;
		if($MOD['show_html'] && $itemid) tohtml('show', $module, "itemid=$itemid");
	}

}

?>