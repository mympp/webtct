<?php
/*
date:2015-9-1
who:chentao
what:定制功能后台管理
where:
relation:
*/
defined('IN_DESTOON') or exit('Access Denied');
$menus = array (
    array('定制会员', '?moduleid='.$moduleid.'&file='.$file.'&action=memberlist'),
    array('定制功能',"?moduleid=$moduleid&file=$file&action=functionlist"),
);
if($action==''){
	$action='memberlist';
}
if($action=='memberlist'){        //定制会员列表
	$result=$db->query("select * from {$DT_PRE}member_dingzhi");
	$lists=array();
	while($v=$db->fetch_array($result)){
		array_push($lists,$v);
	}
	$functionlists=array();
	$result=$db->query("select * from {$DT_PRE}order_function");
	while($v=$db->fetch_array($result)){
		array_push($functionlists,$v);
	}
	include tpl('dingzhi', $module);
}else if($action=="addmember"){       //添加定制会员
	$str_power= implode('|',$power);
	$str_power='|'.$str_power.'|';
	$sql_str="insert into {$DT_PRE}member_dingzhi (username,action,addtime) values ('$username','$str_power','".time()."')";
	if($db->query($sql_str)){
		msg('添加成功');
	}else{
		msg('添加失败');
	}
}else if($action=="functionlist"){        //定制功能列表
	$result=$db->query("select * from {$DT_PRE}order_function");
	$lists=array();
	while($v=$db->fetch_array($result)){
		array_push($lists,$v);
	}
	include tpl('dingzhi', $module);
}else if($action=='addfunction'){          //添加定制功能
	$sql_str="insert into {$DT_PRE}order_function (name,title,introduce) values('$name','$title','$introduce')";
	if($db->query($sql_str)){
		msg('添加成功');
	}else{
		msg('添加失败');
	}
}else if($action=='deletemember'){          //删除定制会员
	if($itemid==''){
		msg('没有用户账号');
	}else{
		$sql_str="delete from {$DT_PRE}member_dingzhi where itemid='$itemid'";
		if($db->query($sql_str)===false){
			msg('删除失败');
		}else{
			msg('删除成功','?moduleid='.$moduleid.'&file=dingzhi');
		}
	}
}else if($action=='editmember'){                 //修改定制会员
	if($submit){
		$str_power= implode('|',$power);
		$str_power='|'.$str_power.'|';
		$sql_str="update {$DT_PRE}member_dingzhi set action='$str_power' where itemid=$itemid";
		if($db->query($sql_str)==='false'){
			msg('修改失败');
		}else{
			msg('修改成功');
		}
	}else{
		$functionlists=array();         //所有功能
		$result=$db->query("select * from {$DT_PRE}order_function");
		while($v=$db->fetch_array($result)){
			array_push($functionlists,$v);
		}
		$member=$db->get_one("select * from {$DT_PRE}member_dingzhi where itemid=$itemid");     //定制会员信息
		include tpl('dingzhi_edit',$module);
	}
}else if($action=='deletefunction'){             //删除定制功能
	if($itemid==''){
		msg('参数不全');
	}else{
		$sql_str="delete from {$DT_PRE}order_function where itemid='$itemid'";
		if($db->query($sql_str)===false){
			msg('删除失败');
		}else{
			msg('删除成功','?moduleid='.$moduleid.'&file=dingzhi&action=functionlist');
		}
	}
}else if($action=='editfunction'){                           //修改定制功能
	if($submit){
		$sql_str="update {$DT_PRE}order_function set name='$name',title='$title',introduce='$introduce' where itemid=$itemid";
		if($db->query($sql_str)===false){
			msg('修改失败');
		}else{
			msg('修改成功','?moduleid='.$moduleid.'&file=dingzhi&action=functionlist');
		}
	}else{
		$function=$db->get_one("select * from {$DT_PRE}order_function where itemid = '$itemid'");
		include tpl('dingzhi_edit',$module);
	}
}
?>