<?php 
use models\helpers\view\internalLink;
use models\helpers\data\tcdb;
use models\helpers\widget\redirect\pc_to_wap;

defined('IN_DESTOON') or exit('Access Denied');

$itemid or dheader($MOD['linkurl']);
if(!check_group($_groupid, $MOD['group_show'])) include load('403.inc');
require DT_ROOT.'/module/'.$module.'/common.inc.php';

$wapurl = pc_to_wap::forword('gongxiang/show-'.$itemid.'.html');

$item = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid");
if($item && $item['status'] > 2) {
	if($MOD['show_html'] && is_file(DT_ROOT.'/'.$MOD['moduledir'].'/'.$item['linkurl'])) d301($MOD['linkurl'].$item['linkurl']);
	extract($item);
} else {
	include load('404.inc');
}
$CATE = get_cat($catid);
if(!check_group($_groupid, $CATE['group_show'])) include load('403.inc');
$content_table = content_table($moduleid, $itemid, $MOD['split'], $table_data);
$t = $db->get_one("SELECT content FROM {$content_table} WHERE itemid=$itemid");
$content = $t['content'];
if($lazy) $content = img_lazy($content);
if($MOD['keylink']) $content = keylink($content, $moduleid);

$CP = $MOD['cat_property'] && $CATE['property'];
if($CP) {
	require DT_ROOT.'/include/property.func.php';
	$options = property_option($catid);
	$values = property_value($moduleid, $itemid);
}

$adddate = timetodate($addtime, 5);
$editdate = timetodate($edittime, 5);
$linkurl = $MOD['linkurl'].$linkurl;
$maincat = get_maincat(0, $moduleid);
$auth = encrypt("$itemid");
$update = '';
$fee = get_fee($item['fee'], $MOD['fee_view']);
if(check_group($_groupid, $MOD['group_contact'])) {
	if($fee) {
		$user_status = 4;
		$destoon_task = "moduleid=$moduleid&html=show&itemid=$itemid";
		$description = '';
	} else {
		$user_status = 3;
	}
} else {
	$user_status = $_userid ? 1 : 0;
	if($_username && $item['username'] == $_username) $user_status = 3;
}

include DT_ROOT.'/file/config/filetype.inc.php';
include DT_ROOT.'/file/config/mirror.inc.php';

$down_db = new tcdb('down_15');
$owner_count = $down_db->where(['username'=>$username,'status'=>3])->count('c');
$count = $down_db->where(['status'=>3])->count('c');		//统计用户上传的数量
$down_db->where(['itemid'=>$itemid])->edit(['hits'=>($hits+1)]);	//增加阅读数
$seo_file = 'show';
include DT_ROOT.'/include/seo.inc.php';
$template = 'show';
if($MOD['template_show']) $template = $MOD['template_show'];
if($CAT['show_template']) $template = $CAT['show_template'];
if($item['template']) $template = $item['template'];

$internalLink = new internalLink();
$internalLink->setModule(['mall','article','company']);
$iLink = $internalLink->build($catid,$areaid,[
	'mall' => ['name'=>'产品','titleName' => '产品'],
	'article' => ['name' => '资讯','titleName' => '资讯','closeArea' => true],
	'company' => ['name'=>'企业','url'=>['typeid'=>0],'titleName'=>'企业'],
]);

include template($template, $module);
?>