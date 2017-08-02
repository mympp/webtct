<?php
/*
who:chentao
when:2015-10-26
where:新增
what:信息资讯模块的信息列表和信息内容功能
relation:/template/tc/quote/

who:chentao
when:2016-2-23
where:见--/2016/2/23/chentao/--标签
what：增加新闻列表把子分类的新闻也搜索出来
*/
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
if($itemid){
	$item=$db->get_one("select * from {$db->pre}article_21 a ,{$db->pre}article_data_21 b where a.itemid=b.itemid and a.itemid =$itemid");
	if($item && $item['status'] > 2) {
	if($item['islink']) dheader($item['linkurl']);
	if($MOD['show_html'] && is_file(DT_ROOT.'/'.$MOD['moduledir'].'/'.$item['linkurl'])) d301($MOD['linkurl'].$item['linkurl']);
		extract($item);
	} else {
		include load('404.inc');
	}
	$CAT = get_cat($catid);
if($lazy) $content = img_lazy($content);
$CP = $MOD['cat_property'] && $CAT['property'];
if($CP) {
	require DT_ROOT.'/include/property.func.php';
	$options = property_option($catid);
	$values = property_value($moduleid, $itemid);
}
$adddate = timetodate($addtime, 3);
$editdate = timetodate($edittime, 3);
if($voteid) $voteid = explode(' ', $voteid);
if($fromurl) $fromurl = fix_link($fromurl);
$linkurl = $MOD['linkurl'].$linkurl;
$titles = array();
if($subtitle) {
	$titles = explode("\n", $subtitle);
	$titles = array_map('trim', $titles);
}
$subtitle = isset($titles[$page-1]) ? $titles[$page-1] : '';
$keytags = $tag ? explode(' ', $tag) : array();
$update = '';
$fee = get_fee($item['fee'], $MOD['fee_view']);
if($fee) {
	$user_status = 4;
	$destoon_task = "moduleid=$moduleid&html=show&itemid=$itemid&page=$page";
	$description = get_description($content, $MOD['pre_view']);
} else {
	$user_status = 3;
}
$pages = '';
$subtitles = count($titles);
if(strpos($content, '[pagebreak]') !== false) {
	$content = explode('[pagebreak]', $content);
	$total = count($content);
	$pages = showpages($item, $total, $page);
	$content = $content[$page-1];
	if($total < $subtitles) $subtitles = $total;
}
if($MOD['keylink']) $content = keylink($content, $moduleid);
include DT_ROOT.'/include/update.inc.php';
$seo_file = 'show';
include DT_ROOT.'/include/seo.inc.php';
if($EXT['wap_enable']) $head_mobile = $EXT['wap_url'].'index.php?moduleid='.$moduleid.'&itemid='.$itemid.($page > 1 ? '&page='.$page : '');
if($subtitle) $seo_title = $subtitle.$seo_delimiter.$seo_title;
$template = 'show';
if($MOD['template_show']) $template = $MOD['template_show'];
if($CAT['show_template']) $template = $CAT['show_template'];
if($item['template']) $template = $item['template'];
	include template('news','quote');
}else{
	$catid=$catid?$catid:$news_xiangmu_catid;
	$catname=$db->get_one("select catname,arrchildid from {$db->pre}category where catid=".$catid);            //--2016/2/23/chentao--,添加搜索arrchildid
	$condition=" catid in (".$catname['arrchildid'].")";                                        //--2016/2/23/chentao--,修改搜索条件
	$pagesize=10;
	$page=$page?$page:1;
	$items = $db->count($db->pre.'article_21', $condition, $DT['cache_search']);
	$pages = pages($items, $page, $pagesize);
	$showpage=1;
	$offset = ($page-1)*$pagesize;
	$result=$db->query("select * from {$db->pre}article_21 where $condition order by addtime desc limit {$offset},{$pagesize}");
	$tags=array();
	while($r = $db->fetch_array($result)){
		$tags[]=$r;
	}
	include template('list-news','quote');
}

?>