<?php 
defined('IN_DESTOON') or exit('Access Denied');
login();
require DT_ROOT.'/module/'.$module.'/common.inc.php';
require DT_ROOT.'/include/post.func.php';
require MD_ROOT.'/type_daili.class.php';
$do = new type_daili();
if($submit) {
	switch($action){
		case 'add':
			if($post['title']!=''&$post['discount']!=''){
				$post['addtime']=time();
				if($do->add($post)){
					//var_dump($post);
					dmsg('添加成功', 'type_daili.php');
				}else{
					dmsg($do->errmsg);
				}
			}else{
				dmsg('不可添加空值');
			}
			break;
		case 'edit':
			foreach($post as $k=>$v){
				if($k=='0'||$k==0){
					continue;
				}else{
					if($v['delete']){
						//$v['itemid']=$k;
						$do->delete($k);
					}else{
						if($v['title']!=''&&$v['discount']!=''){
							$do->itemid=$k;
							$do->edit($v);
						}			
					}
				}
			}
			dmsg('更新成功','type_daili.php');
		break;
	}
}else{
	include template('type_daili',$module);
}
?>