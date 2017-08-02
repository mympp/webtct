<?php
defined('IN_DESTOON') or exit('Access Denied');
require_once DT_ROOT.'/include/tcdb.class.php';

function getBuyCategory(){
	global $dc;
	$CAT = $dc->get('buy_category');
	if(empty($category)){
		$category_db = new tcdb('category');
		$CAT = $category_db->field('catid,catdir,catname,parentid,arrchildid')->where(['moduleid'=>6])->order('listorder asc')->all();
		$dc->set('buy_category',$CAT,(3600*24));
	}
	return $CAT;
}

function getNewBuyMsg(){
	global $dc;
	$messages = $dc->get('buy_index_new_message');
	if(empty($messages)){
		$buy_db = new tcdb('buy_6');
		$messages = $buy_db->field('itemid,title,linkurl,catid,areaid,hits,addtime')->where(['status'=>3])->order('itemid desc')->limit(0,15)->select();
		$dc->set('buy_index_new_message',$messages,(3600*24));
	}
	return $messages;
}

function getRecommendCompany(){
	global $dc;
	$companys = $dc->get('buy_recommend_companys');
	if(empty($companys)){
		$company_db = new tcdb('company');
		$companys = $company_db->field('company,thumb,linkurl')->where(['groupid'=>7])->order('pnum desc')->limit(0,10)->select();
		$dc->set('buy_recommend_companys',$companys,(3600*24));
	}
	return $companys;
}
?>