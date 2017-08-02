<?php 
defined('IN_DESTOON') or exit('Access Denied');
define('MD_ROOT', DT_ROOT.'/module/'.$module);
require DT_ROOT.'/include/module.func.php';
require MD_ROOT.'/global.func.php';
$table = $DT_PRE.$module;
$table_cart = $DT_PRE.$module.'_cart';
$table_data = $DT_PRE.$module.'_data';

global $AREA;
$AREA or $AREA = cache_read('area.php');
$AREA[0]['areaname'] = '全国';


$logo_title = '产品';
$logo_url = 'www.tecenet.com/chanpin/';
require DT_ROOT.'/include/tcdb.class.php';
$category_db = new tcdb('category');
$keyword_db = new tcdb('keyword');
$CAT = $category_db->field('catid,catdir,catname,parentid,arrchildid')->where(['moduleid'=>16])->order('listorder asc')->all();
$CATEGORY = [];		//所有分类
foreach($CAT as $t){
	$CATEGORY[$t['catid']] = $t['catname'];
}
$KE = $category_db->field('catid,catdir,catname,parentid,arrchildid')->where(['moduleid'=>12])->order('listorder asc')->all();
$KESHI = $first_keshi = [];
foreach($KE as $t){
	$KESHI[$t['catid']] = $t['catname'];
	if($t['parentid'] == 0) $first_keshi[$t['catid']] = $t['catname'];
}

$first_cat = $second_cat = [];	//第一级分类,第二级分类
$cat_arrchild ;		//当前子分类
foreach($CAT as $v){		//$CAT数据读于common.inc.php文件
	if($v['parentid'] == 0) $first_cat[$v['catid']] = $v;
	if(!empty($catid) && $v['parentid'] == $catid) $second_cat[$v['catid']] = $v;
	if(!empty($catid) && $v['catid'] == $catid){
		 $cat_arrchild = $v['arrchildid'];
		 $cat_parentid = $v['parentid'];
	}
}
if(empty($second_cat) && !empty($catid)){
	foreach($CAT as $v){
		if($cat_parentid == $v['parentid']) $second_cat[$v['catid']] = $v;
	}
}


?>