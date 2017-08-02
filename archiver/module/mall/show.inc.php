<?php 
defined('IN_DESTOON') or exit('Access Denied');
$itemid or dheader($MOD['linkurl']);
if(!check_group($_groupid, $MOD['group_show'])) include load('403.inc');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
$item = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid");
if($item['groupid'] == 2) include load('404.inc');
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
if($MOD['keylink']) $content = keylink($content, $moduleid);
$CP = $MOD['cat_property'] && $CAT['property'];
if($CP) {
	require DT_ROOT.'/include/property.func.php';
	$options = property_option($catid);
	$values = property_value($moduleid, $itemid);
}
$RL = $relate_id ? get_relate($item) : array();
$P1 = get_nv($n1, $v1);
$P2 = get_nv($n2, $v2);
$P3 = get_nv($n3, $v3);
if($step) {
	extract(unserialize($step));
} else {
	$a1 = 1;
	$p1 = $item['price'];
	$a2 = $a3 = $p2 = $p3 = '';
}
$unit or $unit = $L['unit'];
$adddate = timetodate($addtime, 3);
$editdate = timetodate($edittime, 3);
$linkurl = $MOD['linkurl'].$linkurl;
$thumbs = get_albums($item);
$albums =  get_albums($item, 0);		//修改产品详细页展示图片为thumb中缀的图片
$amount = number_format($amount, 0, '.', '');
$fee = get_fee($item['fee'], $MOD['fee_view']);
$update = '';
if(check_group($_groupid, $MOD['group_contact'])) {
	if($fee) {
		$user_status = 4;
		$destoon_task = "moduleid=$moduleid&html=show&itemid=$itemid";
	} else {
		$user_status = 3;
		$member = $item['username'] ? userinfo($item['username']) : array();
		if($member&&$member['groupid']>5) {
			$update_user = update_user($member, $item);
			if($update_user) $db->query("UPDATE {$table} SET ".substr($update_user, 1)." WHERE username='$username'");
		}
	}
} else {
	$user_status = $_userid ? 1 : 0;
	if($_username && $item['username'] == $_username) {
		$member = userinfo($item['username']);
		$user_status = 3;
	}
}
include DT_ROOT.'/include/update.inc.php';

/**
* 新版详细页增加内容
*/

$mall_db = new tcdb('mall');
$item = $mall_db->field('kcatids')->where(['itemid'=>$itemid])->one();		//补充查询产品信息
//相关科室数据
if(!empty($item['kcatids'])){
	$kcatids = substr($item['kcatids'],0,-1);
	$keshis = $category_db->field('catid,catname')->where(['moduleid'=>12])->where(['catid'=>$kcatids],'in')->all();
	foreach($keshis as $k => $v){
		$KESHI[$v['catid']] = $v['catname']; 
	}
}
//企业信息
$company_db = new tcdb('company');
$company = $company_db->field('mode,linkurl,telephone,mail,company')->where(['username'=>$username])->one();
//相关产品信息
//$malldata=getRelevant(array('status'=>3,'moduleid'=>16),array(1,9,9),'title,thumb,linkurl,username',$title.' '.area_pos($areaid, ' '),'mall',true);
//相关求购信息
//$selldata=getRelevant(array('status'=>3,'moduleid'=>5),array(1,10,10),'title,linkurl,addtime,areaid',$title.' '.area_pos($areaid,' '),'sell_5');
//相关搜索词
$keyword_data_db = new tcdb('keyword_data');
$simword = $keyword_data_db->field('itemid,word')->order('itemid asc')->limit(rand(0,90),10)->select();
//猜你喜欢产品
$likemall = $mall_db->field('title,thumb,linkurl,kcatids,company,username')->where(['status'=>3,'catid'=>$catid])->where(['thumb'=>''],'<>')->order('itemid desc')->limit(0,6)->select();

$seo_file = 'show';
include DT_ROOT.'/include/seo.inc.php';
if($EXT['mobile_enable']) $head_mobile = $EXT['mobile_url'].mobileurl($moduleid, 0, $itemid, $page);
$template = $item['template'] ? $item['template'] : ($CAT['show_template'] ? $CAT['show_template'] : 'show');
include template($template, $module);

function getRelevant($condition,$limit,$selected,$keyword,$tablename,$search_mysql=false){
	//$condition为搜索条件数组格式,$limit为三个值到数组控制匹配数量，$selected返回数据到字段，$keyword搜索匹配到关键字,$tablename搜索到表名称不带前缀
	global $db;
	$sphinx=new SphinxClient();
	$sphinx->setServer('121.14.195.22',9312);
	$sphinx->setArrayResult(true);
	$sphinx->setMatchMode(SPH_MATCH_ANY);
	foreach($condition as $k=>$v){
		$sphinx->setFilter($k,array($v));
	}
	if(!$search_mysql){
		$sphinx->setSelect($selected);
	}else{
		$sphinx->setSelect('itemid');
	}
	$sphinx->setLimits($limit[0],$limit[1],$limit[2]);   //取匹配商品的第2到9个，第1个多为当前页面商品
	$spresult=$sphinx->query($keyword,"data");
	$spdata=$spresult['matches'];
	if(!$search_mysql){
		$backdata=array();
		foreach($spdata as $k=>$v){
			array_push($backdata,$v['attrs']);
		}

		return $backdata;
	}
	$id_str='';
	foreach($spdata as $k=>$v){
		$id_str.=$v['attrs']['itemid'].',';
	}
	$id_str=substr($id_str,0,-1);
	$mysql_result=$db->query("select $selected from {$db->pre}$tablename where itemid in ($id_str)");
	$backdata=array();
	while($m=mysql_fetch_array($mysql_result,MYSQL_ASSOC)){
		array_push($backdata,$m);
	}
	return $backdata;
}

?>
