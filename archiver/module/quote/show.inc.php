<?php
/*
who:chentao
when:2015-10-26
where:行72-85 (12-7改77-90)
what:项目器械分类，合作方式，所处阶段的定义
relation:
续
date:2015-12-7
who：chentao
what:修改字段值获取的方式
where:行78-97
*/ 
defined('IN_DESTOON') or exit('Access Denied');
$itemid or dheader($MOD['linkurl']);
if(!check_group($_groupid, $MOD['group_show'])) include load('403.inc');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
$item = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid");
if($item && $item['status'] > 2) {
	if($MOD['show_html'] && is_file(DT_ROOT.'/'.$MOD['moduledir'].'/'.$item['linkurl'])) d301($MOD['linkurl'].$item['linkurl']);
	extract($item);
} else {
	include load('404.inc');
}
$CAT = get_cat($catid);
if(!check_group($_groupid, $CAT['group_show'])) include load('403.inc');
$content_table = content_table($moduleid, $itemid, $MOD['split'], $table_data);
$t = $db->get_one("SELECT content FROM {$content_table} WHERE itemid=$itemid");
$content = $t['content'];
if($lazy) $content = img_lazy($content);
$CP = $MOD['cat_property'] && $CAT['property'];
if($CP) {
	require DT_ROOT.'/include/property.func.php';
	$options = property_option($catid);
	$values = property_value($moduleid, $itemid);
}
$adddate = timetodate($addtime, 3);
$editdate = timetodate($edittime, 3);
$linkurl = $MOD['linkurl'].$linkurl;
$update = '';
$fee = get_fee($item['fee'], $MOD['fee_view']);
if($fee) {
	$user_status = 4;
	$destoon_task = "moduleid=$moduleid&html=show&itemid=$itemid";
	$description = get_description($content, $MOD['pre_view']);
} else {
	$user_status = 3;
}
$pages = '';
if(strpos($content, '<hr class="de-pagebreak" />') !== false) {
	$content = explode('<hr class="de-pagebreak" />', $content);
	$total = count($content);
	$pages = pages($total, $page, 1, $MOD['linkurl'].itemurl($item, '{destoon_page}'));
	if($pages) $pages = substr($pages, 0, strpos($pages, '<cite>'));
	$content = $content[$page-1];
}
if($MOD['keylink']) $content = keylink($content, $moduleid);
include DT_ROOT.'/include/update.inc.php';
$seo_file = 'show';
include DT_ROOT.'/include/seo.inc.php';
if($EXT['mobile_enable']) $head_mobile = $EXT['mobile_url'].mobileurl($moduleid, 0, $itemid, $page);
if($item['template']){
	$template=$item['template'];
}else{           //未指定模板，判断所在分类
	if($catid==$project_catid){
		$template='show-project';
	}else if($catid==$clinic_catid){
		$template='show-clinic';
	}else{
		$parent=$db->get_one("select parentid from {$db->pre}category where catid=$catid");
		if($parent['parentid']==$project_catid){
			$template='show-project';
		}else if($parent['parentid']==$clinic_catid){
			$template='show-clinic';
		}
	}
}
$level_arr=array();
$level_arr[1]='研发阶段';
$level_arr[2]='完成小试';
$level_arr[3]='完成中试';
$level_arr[4]='完成临床试验';
$level_arr[5]='可量产';
$level_arr[6]='已量产';

function get_field_value($table_name,$field_name,$value){               //从表名、字段名和字段值获得字段值对应的文字
	global $db;
	$cat=$db->get_one("select option_value from {$db->pre}fields where tb='".$table_name."' and name='".$field_name."'");
	$row=explode('*',trim($cat['option_value']));
	foreach($row as $r){
		$cole=explode('|',trim($r));
		if($cole[0]==$value){
			return $cole[1];
		}
	}
	return '';
}
include template('show', $module);
?>
