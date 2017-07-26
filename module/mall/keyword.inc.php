<?php 
defined('IN_DESTOON') or exit('Access Denied');
//$itemid or dheader($MOD['linkurl']);
require DT_ROOT.'/module/'.$module.'/common.inc.php';
require_once DT_ROOT.'/module/'.$module.'/mall.class.php';

if(empty($itemid)) header('Location:'.DT_PATH.'chanpin');
$word = $db->get_one("select * from {$db->pre}keyword where itemid = $itemid");
$word_data = $db->get_one("select * from {$db->pre}keyword_data where itemid = $itemid");

global $db,$offset,$pagesize;
$page = isset($page) ? $page : 1;
$do = new mall();
$pagesize = 15;
$offset = ($page-1)*$pagesize;

$keyword = $word['word'];
$content = $word_data['content'];

$condition = "status = 3 and title like '%$keyword%'";
if($areaid){
	$area_childid = $db->get_one("select arrchildid from {$db->pre}area where areaid = $areaid");
	$condition .= " and areaid in ('".$area_childid['arrchildid']."')";
}
$items = $db->get_one("select count(*) as c from {$db->pre}mall where $condition");
$pages = pages($items['c'], $page, $pagesize);
$showpage = 1;


$malls = $do->get_list($condition);

include template('keyword', $module);
?>
