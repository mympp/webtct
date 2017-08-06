<?php 
use models\helpers\view\internalLink;
defined('IN_DESTOON') or exit('Access Denied');
require_once DT_ROOT.'/models/autoload.php';
//if($DT_BOT || $_POST) dhttp(403);

/**
* 新版搜索列表页面
*/
$stypes = [0=>'医疗器械','整机','配件','耗材'];

if(!empty($areaid)){
	$selector['areaid'] = $areaid;
	$area = new tcdb('area');
	$childarea = $area->field('child,parentid,arrchildid,areaname')->where(['areaid'=>$areaid])->one();
	$inCondition['areaid'] = $childarea['arrchildid'];
}

$page = isset($page) ? $page : 1;
$start = ($page - 1)*$pagesize;

//搜索结果
$mall_db = new tcdb('mall');
$condition['status'] = 3;
$mall_db->where($condition)->where($inCondition,'in')->likeWhere($likeCondition);
$condition_str = str_replace('where','',$mall_db->condition);
$malls = $mall_db->field('itemid,title,company,linkurl,thumb,catid,areaid,kcatids,username')->order('itemid desc')->limit($start,$pagesize)->select();
$items = $mall_db->where($condition_str)->count('c');

//推荐产品
$rmalls = $mall_db->field('itemid,thumb,title,kcatids,linkurl,company,username')->where(['status'=>3])->where($rinCondition,'in')->order('hits desc')->limit(0,6)->select();
//猜你喜欢关键词
$keyword_data_db = new tcdb('keyword_data');
if($action != 'keyword'){
	$rand = rand(0,90);
	$lkeyword = $keyword_data_db->field('itemid,word')->order('itemid asc')->limit($rand,10)->select();
}else{
	$lkeyword = $keyword_data_db->field('itemid,word')->where(['itemid'=>$kwid],'>')->order('itemid asc')->limit(0,10)->select();
}

//最新产品
$nmalls = $mall_db->field('thumb,title,linkurl,company,username')->where(['status'=>3])->order('itemid desc')->limit(0,6)->select();
//推荐供应商
$company_db = new tcdb('company');
$rcompanys = $company_db->field('linkurl,company,thumb')->where(['groupid'=>7])->order('pnum desc')->limit(0,6)->select();

$internalLink = new internalLink();
$internalLink->setModule(['mall','keshi','sell']);
$iLink = $internalLink->build($catid,$areaid,[
	'mall' => ['name'=>'产品','titleName' => '产品'],
	'keshi' => ['name' => '医疗器械','titleName' => '科室'],
	'sell' => ['name'=>'供应','url'=>['typeid'=>0],'titleName'=>'供应'],
]);

$seo_file = 'list';
include DT_ROOT.'/include/seo.inc.php';
include template($template, $module);

function mall_cat_rewrite($selector){
	if(count($selector) == 1 && !empty($selector['catid'])){
		global $first_cat,$second_cat;
		if(!empty($first_cat[$selector['catid']])) return $first_cat[$selector['catid']]['catdir'].'/';
		if(!empty($second_cat[$selector['catid']])) return $second_cat[$selector['catid']]['catdir'].'/';
	}else{
		return mall_rewrite($selector);
	}
}

function link_rewrite($selector){
	global $action;
	if($action == 'search'){
		return mall_cat_rewrite($selector);
	}elseif($action == 'keshi'){
		return keshi_rewrite($selector);
	}
}
?>
