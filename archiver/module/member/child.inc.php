<?php 
/*
date:2015-9-1
who:chentao
what:添加子帐号时判断是否添加定制功能
where:行24-42，72-89
relation:
*/
defined('IN_DESTOON') or exit('Access Denied');
login();
require DT_ROOT.'/module/'.$module.'/common.inc.php';
require DT_ROOT.'/include/post.func.php';
require MD_ROOT.'/child.class.php';
$do = new child();
switch($action) {
	case 'add':
		if($submit) {
			if($do->pass($post)) {
				if($post['username'] && $db->get_one("SELECT username FROM {$DT_PRE}member_child WHERE userid=$_userid  AND username='$post[username]'")) {message('该子账号已经存在');}
				$post['userid'] = $_userid;
				$post['addtime'] = $DT_TIME;
				$post['password'] =md5(md5($post['password'])) ;
				
				if(check_dingzhi_member($_username,'child')){         //用户开启定制功能
					$member_dingzhi=$db->get_one("select * from {$DT_PRE}member_dingzhi where username='$_username'");
					if(count($dingzhi_power)!=0){         //限制子用户定制功能
						$child_action=$member_dingzhi['action'];
						foreach($dingzhi_power as $k=>$v){
							if(strpos($child_action,'|'.$v.'|')===false){
								
							}else{
								$child_action=str_replace('|'.$v.'|','|',$child_action);        //从父功能中截去限制功能
							}
						}
						$child_username=$post['username'];
						$db->query("insert into {$db->pre}member_dingzhi (username,action,addtime,ischild,parentname,sms_word,sms_limit) values ('$child_username','$child_action','$DT_TIME','1','$_username','',0)");
					}else{                    //全权授予子账号定制功能
						$child_action=$member_dingzhi['action'];
						$child_username=$post['username'];
						$db->query("insert into {$db->pre}member_dingzhi (username,action,addtime,ischild,parentname,sms_word,sms_limit) values ('$child_username','$child_action','$DT_TIME','1','$_username','',0)");
					}
				}
				
				$do->add($post);
				dmsg('添加子账号成功', 'child.php');
			} else {
				message($do->errmsg);
			}
		} else {
			$parentusername = isset($parentusername) ?  trim($parentusername) : '';
			$username = isset($username) ? trim($username) : '';
			$truename = $modules = $actions = $mobile = $password = '';
			$head_title = '会员管理-子账号添加成功';
		}
		break;
	case 'edit':
		$itemid or message();
		$do->itemid = $itemid;
		$r = $do->get_one();
		if(!$r || $r['userid'] != $_userid) message();
		if($submit) {
			if($do->pass($post)) {
				//if($post['password']){$post['password'] =md5(md5($post['password']));}else{$post['password']='';}
			if($post['password']){
					$post['password'] =md5(md5($post['password']));
				}else{
					$r = $db->get_one("SELECT* FROM {$DT_PRE}member_child WHERE itemid='$itemid'");
					$password= $r['password'];
					$post['password']=$password;
				}
				
				if(check_dingzhi_member($_username,'child')){         //用户开启定制功能
					$member_dingzhi=$db->get_one("select * from {$DT_PRE}member_dingzhi where username='$_username'");
					if($dingzhi_power){         //限制子用户定制功能
						$child_action=$member_dingzhi['action'];
						foreach($dingzhi_power as $k=>$v){
							if(strpos($child_action,'|'.$v.'|')===false){
								
							}else{
								$child_action=str_replace('|'.$v.'|','|',$child_action);        //从父功能中截去限制功能
							}
						}
						$child_username=$post['username'];
						$db->query("update {$DT_PRE}member_dingzhi set action='$child_action' where username='$child_username'");
					}else{                    //全权授予子账号定制功能
						$child_action=$member_dingzhi['action'];
						$child_username=$post['username'];
						$db->query("update {$DT_PRE}member_dingzhi set action='$child_action' where username='$child_username'");
					}
				}
				
				$do->edit($post);
				dmsg('子账号修改成功', $forward);
			} else {
				message($do->errmsg);
			}
		} else {
			extract($r);
			$head_title = '会员管理-子账号修改成功';
		}
	break;
	case 'delete':
		$itemid or message('请选择删除的子账号');
		$do->itemid = $itemid;
		$r = $do->get_one();
		if(!$r || $r['userid'] != $_userid) message();
		$do->delete($itemid);
		dmsg('账号删除成功', $forward);
	break;
	case 'my':
		$from = isset($from) ? $from : '';
		$condition = "userid=$_userid";
		$dfields = array('userid','username','password','truename','parentusername','mobile','systems','modules','addtime');
		$r = $db->get_one("SELECT COUNT(*) AS num FROM {$DT_PRE}member_child WHERE $condition");
		$pages = pages($r['num'], $page, $pagesize);		
		$lists = array();
		$result = $db->query("SELECT * FROM {$DT_PRE}member_child WHERE $condition ORDER BY listorder DESC,itemid DESC LIMIT $offset,$pagesize");
		while($r = $db->fetch_array($result)) {
			$lists[] = $r;
		}
		$head_title = '会员管理-子账号管理';
	break;
	default:
		$condition = "userid=$_userid";
		$lists = $do->get_list($condition);
		if(count($lists)%2 == 1) $lists[] = array();//Fix Cells
		if($MG['friend_limit']) {
			$r = $db->get_one("SELECT COUNT(*) AS num FROM {$DT_PRE}member_child WHERE userid=$_userid");
			$limit_used = $r['num'];
		}
		$head_title = '会员管理-子账号管理';
}
include template('child', $module);
?>