<?php
defined('DT_ADMIN') or exit('Access Denied');
require MD_ROOT.'/guestbook.class.php';

$do = new guestbook();
global $db;
$menus = array (
	array('添加留言','?moduleid='.$moduleid.'&file='.$file.'&action=add'),
    array('留言列表', '?moduleid='.$moduleid.'&file='.$file),
    array('模块首页', $EXT[$file.'_url'], ' target="_blank"'),
    array('模块设置', '?moduleid='.$moduleid.'&file=setting#'.$file),
);
if($_catids || $_areaids) require DT_ROOT.'/admin/admin_check.inc.php';
if(in_array($action, array('', 'check'))) {
	$sfields = array('按条件', '留言标题', '会员名', '联系人', '联系电话', '电子邮件', 'QQ', '阿里旺旺', 'MSN','Skype','留言IP', '留言内容', '回复内容');
	$dfields = array('title','title','username','truename','telephone','email','qq','ali','msn','skype','ip','content','reply');
	$sorder  = array('结果排序方式', '留言时间降序', '留言时间升序', '回复时间降序', '回复时间升序');
	$dorder  = array('itemid DESC', 'addtime DESC', 'addtime ASC', 'edittime DESC', 'edittime ASC');

	isset($fields) && isset($dfields[$fields]) or $fields = 0;
	isset($order) && isset($dorder[$order]) or $order = 0;

	$fields_select = dselect($sfields, 'fields', '', $fields);
	$order_select  = dselect($sorder, 'order', '', $order);

	$condition = '1';
	if($_areaids) $condition .= " AND areaid IN (".$_areaids.")";//CITY
	if($keyword) $condition .= " AND $dfields[$fields] LIKE '%$keyword%'";
	if($areaid) $condition .= ($ARE['child']) ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$areaid";
}
switch($action) {
	case 'edit':
		$itemid or msg();
		$do->itemid = $itemid;
		if($submit) {
			if($do->pass($post)) {
				$do->edit($post);
				dmsg('修改成功', $forward);
			} else {
				msg($do->errmsg);
			}
		} else {
			extract($do->get_one());
			$addtime = timetodate($addtime);
			include tpl('guestbook_edit', $module);
		}
	break;
	case 'add':
		if($submit){
			$post['addtime'] = strtotime($post['addtime']);
			$post['edittime'] = strtotime($post['edittime']);
			$post['editor'] = $_username;
			$post['status'] = 3;
			if($do->pass($post)){
				$do->add($post);
				$itemid = mysql_insert_id();
				$db->query("update {$db->pre}guestbook set username = '".$post['username']."',addtime = ".$post['addtime'].",edittime = ".$post['edittime']." , ip = '".$post['ip']."',reply = '".$post['reply']."' where itemid = $itemid");
				dmsg('添加成功', '?moduleid='.$moduleid.'&file='.$file);
			}else{
				msg($do->errmsg);
			}
		}else{
			if($rand){		//随机抓取一个用户信息
				$member_count = $db->get_one("select count(*) as c from {$db->pre}member ");
				$rand_num = rand(1,(int)$member_count['c']);
				$member = $db->get_one("select * from {$db->pre}member order by userid limit $rand_num,1");
				$member['ip'] = rand_ip();
			}
			include tpl('guestbook_add',$module);
		}
	break;
	case 'check':
		$itemid or msg('请选择留言');
		$do->check($itemid, $status);
		dmsg('设置成功', $forward);
	break;
	case 'delete':
		$itemid or msg('请选择留言');
		$do->delete($itemid);
		dmsg('删除成功', $forward);
	break;
	default:
		$lists = $do->get_list($condition, $dorder[$order]);
		include tpl('guestbook', $module);
	break;
}

function rand_ip(){
  $ip_long = array(
  array('607649792', '608174079'), //36.56.0.0-36.63.255.255
  array('975044608', '977272831'), //58.30.0.0-58.63.255.255
  array('999751680', '999784447'), //59.151.0.0-59.151.127.255
  array('1019346944', '1019478015'), //60.194.0.0-60.195.255.255
  array('1038614528', '1039007743'), //61.232.0.0-61.237.255.255
  array('1783627776', '1784676351'), //106.80.0.0-106.95.255.255
  array('1947009024', '1947074559'), //116.13.0.0-116.13.255.255
  array('1987051520', '1988034559'), //118.112.0.0-118.126.255.255
  array('2035023872', '2035154943'), //121.76.0.0-121.77.255.255
  array('2078801920', '2079064063'), //123.232.0.0-123.235.255.255
  array('-1950089216', '-1948778497'), //139.196.0.0-139.215.255.255
  array('-1425539072', '-1425014785'), //171.8.0.0-171.15.255.255
  array('-1236271104', '-1235419137'), //182.80.0.0-182.92.255.255
  array('-770113536', '-768606209'), //210.25.0.0-210.47.255.255
  array('-569376768', '-564133889'), //222.16.0.0-222.95.255.255
  );
  $rand_key = mt_rand(0, 14);
  $huoduan_ip= long2ip(mt_rand($ip_long[$rand_key][0], $ip_long[$rand_key][1]));
  return $huoduan_ip;
 }
?>