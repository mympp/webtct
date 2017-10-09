<?php 
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
require DT_ROOT.'/include/post.func.php';
$AREA or $AREA = cache_read('area.php');
$TYPE = get_type('taoxinxi', 1);
require MD_ROOT.'/taoxinxi.class.php';
$do = new taoxinxi();
$order = isset($order) ? intval($order) : 0;
$day = isset($day) ? intval($day) : 0;
$getpageto = isset($getpageto) ? intval($getpageto) : 0;
$pagesize = isset($pagesize) ? intval($pagesize) : 20;
$condition = '';
$table=$DT_PRE.'taoxinxi';
if($day) $fromdate = timetodate($DT_TIME-$day*86400, 'Ymd');
$fromdate = isset($fromdate) && is_date($fromdate) ? $fromdate : '';
$fromtime = $fromdate ? strtotime($fromdate.' 0:0:0') : 0;
$todate = isset($todate) && is_date($todate) ? $todate : '';
$totime = $todate ? strtotime($todate.' 23:59:59') : 0;
if(strpos($kw,'输入'))$kw='';
$dorder  = array('itemid asc', 'addtime asc', 'hits asc', 'reference asc');
$orders=$dorder[$order];

if($kw&&$interest){
	 $do->interest($kw);
}

if($action=='show'&&$itemid){
	$do->itemid = $itemid;
	$item = $do->get_one();
	$db->query("UPDATE {$table} SET hits=hits+1 WHERE itemid=$itemid");
	$item or dheader(DT_PATH);
	extract($item);
	$adddate = timetodate($addtime, 3);
	$template = $item['template'] ? $item['template'] : 'taoxinxi';
} 

if($action=='delete'&&$itemid){
	 echo "<script>parent.document.getElementById('message".$itemid."').innerHTML='删除成功！';</script>";
	 $do->delete($itemid);
	 exit;
}

if($action=='addsave'){
			if($MG['add_limit']) {
				$last = $db->get_one("SELECT addtime FROM {$table} WHERE ip='$post[ip]' ORDER BY itemid DESC");
				if($last && $DT_TIME - $last['addtime'] < $MG['add_limit']){
				echo "<script>alert('发布时间过快，请间隔".$MG['add_limit']."后发布！');</script>";
				exit;
				}
			}
	 $itemid=$do->add($post);
	if($forward){
		if($post[allowitemid]){
			dheader('index.php?action=show&itemid='.$post[allowitemid]);
			}else{
			dheader('index.php?action=show&itemid='.$itemid);
		}
		EXIT;
	}else{
	$do->itemid = $itemid;
	$item = $do->get_one();
	extract($item);
	}
}

if($action=='lockip'){
	$d= $db->get_one("SELECT ip FROM {$table} WHERE itemid=$itemid ORDER BY itemid DESC");
	echo "<script>alert('".$d['ip']."已经被封锁！');</script>";
	 $do->lockip($d['ip']);
	dheader('index.php?action=delete&itemid='.$itemid);
	exit;
}

if($action=='updatelist'){
	$condition = ' status>0 '; 
	if($kw) $condition .= " AND ( content LIKE '%$kw%' )";
	if($areaid) $condition .= ($AREA[$areaid]['child']) ? " AND areaid IN (".$AREA[$areaid]['arrchildid'].")" : " AND areaid=$areaid";
	$condition .= 'and itemid>'.$itemid; 
	$lists = $do->get_list($condition,$pagesize, $orders,'down');
}

if($action=='storylist'){

	$condition = ' status>0 '; 
	if($fromtime) $condition .= " AND addtime>=$fromtime";
	if($totime) $condition .= " AND addtime<=$totime";
	if($typeid) $condition .= " AND typeid=$typeid";
	if($kw) $condition .= " AND ( content LIKE '%$kw%' )";
	if($areaid) $condition .= ($AREA[$areaid]['child']) ? " AND areaid IN (".$AREA[$areaid]['arrchildid'].")" : " AND areaid=$areaid";
	$condition .= 'and itemid<'.$itemid; 
	$lists = $do->get_list($condition,$pagesize, $orders,'up');
}
if($action=='showuser'){
		$member= $do->get_user($username);
}

if($action=='list'||!$action){

	if($islink=='')  $islink=9; else $islink=$_GET['islink'];
	$head_title = $head_keywords = $head_description = $L['taoxinxi_title'];
	$condition = ' status>0 and (allowitemid<1 OR allowitemid is null )'; 
	if($fromtime) $condition .= " AND addtime>=$fromtime";
	if($totime) $condition .= " AND addtime<=$totime";
	if($typeid) $condition .= " AND typeid=$typeid";
	if($kw) $condition .= " AND ( content LIKE '%$kw%' )";
	if($areaid) $condition .= ($AREA[$areaid]['child']) ? " AND areaid IN (".$AREA[$areaid]['arrchildid'].")" : " AND areaid=$areaid";
	$lists = $do->get_list($condition,$pagesize, $orders);
}

if($wap){
	include template('taoxinxi2', 'touch');
	//include template('taoxinxi', 'touch');
}else{
	include template('taoxinxi', $module);
}
?>