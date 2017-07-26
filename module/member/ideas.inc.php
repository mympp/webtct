<?php 
defined('IN_DESTOON') or exit('Access Denied');
login();
require DT_ROOT.'/module/'.$module.'/common.inc.php';
require DT_ROOT.'/include/post.func.php';
require DT_ROOT.'/include/ideas.class.php';
$MG['spread'] or dalert(lang('message->without_permission_and_upgrade'), 'goback');
include load('extend.lang');
$ideas =new ideas();

                //统计数目
                $count=$db->get_one("select count(*) as c from {$db->pre}sogex_ideas where userid = $_userid and status = 3");
                $nums[3]=$count['c'];
                $count=$db->get_one("select count(*) as c from {$db->pre}sogex_ideas where userid = $_userid and status = 2");
                $nums[2]=$count['c'];

if($submit){
	switch($action){
		case 'add':
			$post['status']=2;
			$post['addtime']=time();
			$post['userid']=$_userid;
			if($ideas->add($post)){
				dmsg('申请成功!请等待管理员审核');
			}else{
				msg('申请失败');
			}
		break;
		case 'edit':
			$ideas->ideaid=$itemid;
			$post['updatetime']=time();
			$post['status']=2;
			$ideas->edit($post);
			dmsg('修改完成!请等待管理员审核');	
		break;
	}	
}else{
	switch($action){
		case 'edit':
			$ideas->ideaid=$itemid;
			$ideas_data=$ideas->get_one();
			extract($ideas_data);
		break;
		case 'delete':
			$ideas->ideaid = $itemid;
			$post['status'] = 1;
			if($ideas->edit($post)){
				dmsg('删除完成');
			}else{
				msg('删除失败');
			}
		break;
		case 'wildcard':
				include template($action,$module);
				exit;
		break;
		default:
			$status=isset($status) ? $status : 3;
			$lists=$ideas->get_list("userid = $_userid and status = $status");

	}
		include template('ideas', $module);
}
?>
