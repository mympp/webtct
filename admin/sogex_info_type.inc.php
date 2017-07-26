<?php

defined('DT_ADMIN') or exit('Access Denied');

$tablename = 'sogex_info_type';
$menus = array (
	array('返回sogex管理首页','?file=sogex'),
	array('添加信息','?file=sogex_info&action=add'),
    	array('已启用信息', '?file=sogex_info'),
    	array('待审核信息', '?file=sogex_info&status=2'),
    	array('回收站','?file=sogex_info&status=4'),
	array('数据分类','?file='.$file),
);

if($submit){
	switch($action){
		case 'add':
			if(empty($name) || empty($catname)) msg('参数错误');
			if($db->get_one("select * from {$db->pre}$tablename where name = '$name'")) msg('分类名已存在');
			if($db->get_one("select * from {$db->pre}$tablename where catname = '$catname'")) msg('分类英文名已存在');
			$max_catid = $db->get_one("select max(catid) as m from {$db->pre}$tablename");
			$new_catid = intval($max_catid['m'])+1;
			$db->query("insert into {$db->pre}$tablename (catid,name,catname) values ($new_catid,'$name','$catname')");
			dmsg("分类添加成功",'?file='.$file);
		break;
		case 'delete':
			$tid = $type['tid'];
			$tid_str = '';
			foreach($tid as $v){
				$tid_str .= $v.',';
			}
			$tid_str = substr($tid_str,0,-1);
			$db->query("delete from {$db->pre}$tablename where tid in ($tid_str)");
			dmsg('分类删除成功','?file='.$file);
		break;
		case 'update':
			$tid = $type['tid'];
			
			foreach($tid as $v){
				$db->query("update {$db->pre}$tablename set name = '".$type[$v]['name']."' , catname = '".$type[$v]['catname']."' where tid = $v");
			}
			dmsg('分类修改成功','?file='.$file);
		break;
	}
}else{
	global $db;
	$lists = array();
	$result = $db->query("SELECT * FROM {$db->pre}$tablename");
	while($r = $db->fetch_array($result)) {
		$lists[] = $r;
	}
}
include tpl($file);
?>
