<?php

defined('DT_ADMIN') or exit('Access Denied');
$menus = array (
	array('返回sogex管理首页','?file=sogex'),
	array('添加创意','?file='.$file.'&action=add'),
    array('已启用创意', '?file='.$file),
    array('待审核创意', '?file='.$file.'&status=2'),
    array('回收站','?file='.$file.'&status=1')
);

include DT_ROOT.'/include/ideas.class.php';
$ideas=new ideas();

if($submit){
	switch($action){
		case 'add':
			$userid=$db->get_one("select userid from {$db->pre}member where username = '$username'");
			if(!$userid) msg('该会员名不存在!');
			$post['userid']=$userid['userid'];
			$post['addtime']=time();
			if($ideas->add($post)){
				dmsg('创意添加成功','?file='.$file);
			}else{
				msg('创意添加失败');
			}
		break;
		case 'edit':
			$userid=$db->get_one("select userid from {$db->pre}member where username = '$username'");
			if(!$userid) msg('该会员名不存在!');
			$post['userid']=$userid['userid'];
			$post['updatetime']=time();
			$ideas->ideaid=$itemid;
			if($ideas->edit($post)){
				dmsg('创意修改成功','?file='.$file);
			}else{
				msg('创意修改失败');
			}
		break;
		case 'revoke':
			$ideas_arr=$post['ideaid'];
			
			if(!empty($ideas_arr)){
				foreach($ideas_arr as $k=>$v){
					$data['status']=1;
					$data['updatetime']=time();
					$ideas->ideaid=$v;
					$ideas->edit($data);
				}
			}
			dmsg('创意撤下完成','?file='.$file);
		break;
		case 'delete':
			$idea_arr=$post['ideaid'];
			$ideas->delete($idea_arr);
			dmsg('创意删除完成','?file='.$file);
		break;
		case 'check':
			$ideas_arr=$post['ideaid'];
			if(!empty($ideas_arr)){
				foreach($ideas_arr as $k=>$v){
					$data['score']=$post['score'][$v];
					if($post['score'][$v]=='' || !is_numeric($post['score'][$v])) $data['score'] = '0';      //填写为空或非数字，默认为0
					$data['status']=3;
					$data['updatetime']=time();
					$ideas->ideaid=$v;
					$ideas->edit($data);
				}
			}
			dmsg('创意审核完成','?file='.$file);
		break;
	}
}else{
	switch($action){
		case 'add':
			include tpl($file.'_edit');
		break;
		case 'edit':
			$ideas->ideaid=$itemid;
			$idea_data=$ideas->get_one();
			extract($idea_data);
			include tpl($file.'_edit');
		break;
		default:
			$status = isset($status)?$status:3;
			$lists=$ideas->get_list("status = $status",'addtime desc');
		include tpl($file);
	}
}

?>
