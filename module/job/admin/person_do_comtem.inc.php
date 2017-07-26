<?php
defined('IN_DESTOON') or exit('Access Denied');
require MD_ROOT.'/person_do_comtem.class.php';
$do = new person_do_comtem($moduleid);


switch($action){
	case 'add':
		if($submit){
			$do->add_comment_templates($post);
			dmsg('添加成功', '?moduleid='.$moduleid.'&file=person_do_comtem');//'&file=person_do_comtem'
		}
		if($submit_keep){
			$do->add_comment_templates($post);
			dmsg('添加成功', '?moduleid='.$moduleid.'&file=person_do_comtem&action=add');//'&file=person_do_comtem'
		}
		include tpl('person_do_comtem_add',$module);
	break;
	case 'edit':
		
	break;
	case 'delete':
		$do->delete_comment_templates($com_id);
		dmsg('删除成功！',$forward);
	break;
	default:
		$comtem_lists = $do->gat_comtem_lists();
		include tpl('person_do_comtem',$module);
	break;
}

?>