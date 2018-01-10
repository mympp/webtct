<?php 
use models\helpers\view\internalLink;
defined('IN_DESTOON') or exit('Access Denied');
require_once DT_ROOT.'/models/autoload.php';

//if($DT_BOT || $_POST) dhttp(403);
require DT_ROOT.'/module/'.$module.'/common.inc.php';
if(!check_group($_groupid, $MOD['group_search'])) include load('403.inc');
require DT_ROOT.'/include/post.func.php';
require DT_ROOT.'/include/tcdb.class.php';
include load('search.lang');
$MS = cache_read('module-2.php');
$modes = explode('|', '不限|'.$MS['com_mode']);
$types = explode('|', '不限|'.$MS['com_type']);

if(!$areaid && $cityid && strpos($DT_URL, 'areaid') === false) {
	$areaid = $cityid;
	$ARE = $AREA[$cityid];
}

$selector = [];	//存储提交过来的搜索参数
if(isset($catid) && !empty($catid)) $selector['catid'] = $catid;
if(isset($type) && !empty($type)) $selector['type'] = $type;
if(isset($areaid) && !empty($areaid)) $selector['areaid'] = $areaid;
if(isset($mode) && !empty($mode)) $selector['mode'] = $mode;
if(isset($vip) && !empty($vip)) $selector['vip'] = $vip;
if(isset($kw) && !empty($kw)) $selector['kw'] = $kw;

if($DT_QST) {
	if($kw) {
		if(strlen($kw) < $DT['min_kw'] || strlen($kw) > $DT['max_kw']) message(lang($L['word_limit'], array($DT['min_kw'], $DT['max_kw'])), $MOD['linkurl'].'search.php');
		if($DT['search_limit'] && $page == 1) {
			if(($DT_TIME - $DT['search_limit']) < get_cookie('last_search')) message(lang($L['time_limit'], array($DT['search_limit'])), $MOD['linkurl'].'search.php');
			set_cookie('last_search', $DT_TIME);
		}
 	}
}
$showpage = 1;
$seo_file = 'search';

//获取企业第一级分类
$category = new tcdb('category');
$company_cat = $category->field('catid,catname,style,item')->where(['moduleid'=>4,'parentid'=>0])->all();
//整理企业分类
$CAT = [];
foreach($company_cat as $k=>$v){
	$CAT[$v['catid']] = $v['catname'];
}
$CAT[0] = '医疗器械';

//搜索查询内容
$pagesize = 10;
$page = isset($page)? $page : 1;
$start = ($page - 1)*$pagesize;
$company = new tcdb('company');
$condition = $likeCondition = $inCondition = $gtCondition = $neqCondition =[];
$condition['closeshop'] = 0;
$neqCondition['business'] = '';
$neqCondition['catids'] = '';
$gtCondition['groupid'] = 5;
if(!empty($catid)) $likeCondition['catid'] = $catid;
if(!empty($areaid)){
	$area = new tcdb('area');
	$childarea = $area->field('child,parentid,arrchildid,areaname')->where(['areaid'=>$areaid])->one();
	$inCondition['areaid'] = $childarea['arrchildid'];
}
if(!empty($mode)) $likeCondition['mode'] = $modes[$mode];
if(!empty($type)) $condition['type'] = $types[$type];
if(!empty($vip)) $gtCondition['vip'] = 0;
if(!empty($kw)) $likeCondition['keyword'] = $kw;
$company->where($condition)->where($inCondition,'in')->where($gtCondition,'>')->where($neqCondition,'<>')->likeWhere($likeCondition);
$condition_str = $company->condition;
$lists = $company->limit($start,$pagesize)->order('vip desc,userid desc')->select();
$items = $company->field('count(*) as c')->where(str_replace('where','',$condition_str))->one();


$seo_file = 'list';			//使用后台设置列表seo信息作为seo内容
$modes[0] = '公司';			//seo参数
include DT_ROOT.'/include/seo.inc.php';
$modes[0] = '不限';

$internalLink = new internalLink();
$internalLink->setModule(['mall','sell','sell1']);
$iLink = $internalLink->build($catid,$areaid,[
	'mall' => ['name'=>'产品','titleName' => '产品'],
	'sell' => ['name' => '求购','titleName' => '求购','url'=>['typeid'=>1]],
	'sell1' => ['name'=>'供应','url'=>['typeid'=>0],'titleName'=>'供应'],
]);

include template('search', $module);


?>