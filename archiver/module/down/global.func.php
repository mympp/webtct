<?php
defined('IN_DESTOON') or exit('Access Denied');
function ext_select($name, $value, $extend = '', $title = '') {
	include DT_ROOT.'/file/config/filetype.inc.php';
	if(!$value && !$title) $value = 'oth';
	$select = '<select name="'.$name.'" '.$extend.'>';
	if($title) $select .= '<option value=""'.('' == $value ? ' selected' : '').'>'.$title.'</option>';
	foreach($FILETYPE as $k=>$v) {
		$select .= '<option value="'.$k.'"'.($k == $value ? ' selected' : '').'>'.$v.'</option>';
	}
	$select .= '</select>';
	return $select;
}

function unit_select($name, $value, $extend = '') {
	$UNIT = array('K', 'M', 'G', 'T');
	$value or $value = 'M';
	$select = '<select name="'.$name.'" '.$extend.'>';
	foreach($UNIT as $k=>$v) {
		$select .= '<option value="'.$v.'"'.($v == $value ? ' selected' : '').'>'.$v.'</option>';
	}
	$select .= '</select>';
	return $select;
}

//新版地址重写
function down_rewrite($selector){
	if(!empty($selector['kw']) || !empty($selector['order']))	return 'search.php?'.http_build_query($selector);
	$catid = empty($selector['catid']) ? '0' : $selector['catid'];
	$fileext = empty($selector['fileext']) ? '' : '-'.$selector['fileext'];
	$page = empty($selector['page']) ? '-1' : '-'.$selector['page'];
	if($page == '-1' && empty($fileext)) $page = '';
	return 'so-'.$catid.$page.$fileext.'.html';
}

//分类数据
function getDownCategory(){
	global $dc;
	$CAT = $dc->get('down_category');
	if(empty($category)){
		$category_db = new tcdb('category');
		$CAT = $category_db->field('catid,catdir,catname,parentid,arrchildid')->where(['moduleid'=>15,'parentid'=>0])->order('listorder asc')->all();
		$dc->set('down_category',$CAT,(3600*24));
	}
	return $CAT;
}

//最新共享信息
function getNewDownMsg($catid = 0 ,$pagesize = 6){
	global $dc;
	//$downs = $dc->get('down_new_message_catid'.$catid.'_page_'.$pagesize);
	if(empty($downs)){
		$down_db = new tcdb('down_15');
		if(!empty($catid)) $cat_condition['catid'] = $catid; 
		$downs = $down_db->field('itemid,username,addtime,title,linkurl,thumb,downtype,dprice,djifen,fileext')->where(['status'=>3])->where($cat_condition)->order('itemid desc')->limit(0,$pagesize)->select();
		$dc->set('down_new_message_catid'.$catid.'_page_'.$pagesize,$downs,(3600*12));
	}
	return $downs;
}

//热门共享信息
function getHotDownMsg(){
	global $dc;
	$downs = $dc->get('down_hot_message');
	if(empty($downs)){
		//$month_age = time() - (3600*24*30);		//实际用数据
		$month_age = 1;			//测试用数据
		$down_db = new tcdb('down_15');
		$downs = $down_db->field('itemid,title,addtime,hits,download,linkurl')->where(['status'=>3])->where(['addtime'=>$month_age],'>')->order('hits desc')->limit(0,8)->select();
		$dc->set('down_hot_message',$downs,(3600*24));
	}
	return $downs;
}

//推荐共享信息
function getRecommendDownMsg(){
	global $dc;
	$downs = $dc->get('down_recommend_message');
	if(empty($downs)){
		$down_db = new tcdb('down_15');
		$downs = $down_db->field('itemid,title,addtime,hits,download,linkurl')->where(['status'=>3])->order('level asc,itemid desc')->limit(0,8)->select();
		$dc->set('down_recommend_message',$downs,(3600*24));
	}
	return $downs;
}

function getUserDownMsg($username){
	$down_db = new tcdb('down_15');
	return $down_db->where(['username'=>$username,'status'=>3])->limit(0,5)->select();
}
?>