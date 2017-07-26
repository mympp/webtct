<?php
defined('IN_DESTOON') or exit('Access Denied');
require MD_ROOT.'/person_do_member.class.php';
$do = new person_do_member($moduleid);

if(in_array($action, array('', 'person_do_member'))) {
	$sfields = array( '会员名称', '公司');
	$dfields = array( 'username','company');
	$sgender = array('性别', '先生' , '女士');
	$group_select = group_select('groupid', '会员组', $groupid);//group_select()位置include/post.func.php 作用：传全局变量$GROUP及会员组下拉框$group_select
	$gender_select = dselect($sgender, 'gender', '', $gender);
	$fields_select = dselect($sfields, 'fields', '', $fields);
	$condition = '';
	if($groupid) $condition .= " AND groupid=$groupid";
	if($keyword) $condition .= " AND $dfields[$fields] LIKE '%$keyword%'";
}

switch($action){
	default:
		$lists = $do->get_member_list('admin=0'.$condition);
		$items = $do->get_person_do_select_members();
		include tpl('person_do_member',$module);
	break;
}
?>