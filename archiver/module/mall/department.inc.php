<?php 
defined('IN_DESTOON') or exit('Access Denied');
//$itemid or dheader($MOD['linkurl']);
require DT_ROOT.'/module/'.$module.'/common.inc.php';
require_once DT_ROOT.'/module/'.$module.'/mall.class.php';

if(empty($itemid)) header('Location:'.DT_PATH.'chanpin');
$category = get_cat($itemid);
if($category === false) header('Location:'.DT_PATH.'chanpin');

global $db,$offset,$pagesize;
$page = isset($page) ? $page : 1;
$do = new mall();
$pagesize = 30;
$offset = ($page-1)*$pagesize;
$catid = $itemid;
$category = get_cat($catid);

//获取所有科室分类
$result = $db->query("select catname,catid from {$db->pre}category where parentid = 0 and moduleid = 12");
$arrchildid = array();
while($r = $db->fetch_array($result)){
	$arrchildid[] = $r;
}


$malls = $do->get_list("status = 3 and kcatids like '%$catid%'");
$items = $db->get_one("select count(*) as c from {$db->pre}mall where status = 3 and kcatids like '%$catid%'");
$pages = pages($items['c'], $page, $pagesize);
$showpage = 1;

include template('department', $module);
?>
