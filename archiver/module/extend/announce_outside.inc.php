<?php 

defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
require DT_ROOT.'/include/post.func.php';
include template('announce_outside','extend');
$MOD['announce_enable'] or dheader(DT_PATH);
$TYPE = get_type('announce', 1);
$typeid = isset($typeid) ? intval($typeid) : 0;
$contactType = isset($contactType) ? intval($contactType) : 0;
if($submit){
	if($action == "save"){
			global $_username,$DT_TIME;
			$title = strip_tags(trim($title));
			$title = preg_replace("/&([a-z]{1,});/", '', $title);
			$content = strip_tags(trim($content));
			$content = preg_replace("/&([a-z]{1,});/", '', $content);
			$contact = strip_tags(trim($contact));
			$contact = preg_replace("/&([a-z]{1,});/", '', $contact);
			if($contactType == 0){
				if(preg_match("/\d/",$contact)){
					$contact = "<br/>QQ联系：<a href=\"http://wpa.qq.com/msgrd?v=3&uin=$contact&site=qq&menu=yes\" target=\"_blank\">$contact</a>";
				}else{
					$contact ="";
				}
			}
			if($contactType == 1){
				if(preg_match("/13[0-9]{9}|15[0|1|2|3|5|6|7|8|9]\d{8}|18[0|5|6|7|8|9]\d{8}/",$contact)){
					$contact = "<br/>手机号码：$contact";
				}else{
					$contact = "";
				}
			}
			if(preg_match("/^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/",$contact)){
				$contact = "<br/>电子邮箱地址：strip_tags($contact)";
			}
			$db->query("INSERT INTO tc_announce (itemid,typeid,areaid,level,title,style,content,hits,addtime,fromtime,totime,editor,edittime,islink,linkurl,listorder,template) VALUES ('','$typeid','0','0','$title','','$content$contact','0','$DT_TIME','0','0','$_username','$DT_TIME','0','','0','')");
			echo "<script>confirm('添加成功！须后台审核通过方可在首页显示！')</script>";
	}else{
		exit('Access Denied');
	}
}

?>