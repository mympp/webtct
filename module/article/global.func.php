<?php
defined('IN_DESTOON') or exit('Access Denied');
require_once DT_ROOT.'/include/tcdb.class.php';

/**
* 获取一个月内容所有分类下的点击最高资讯
* @return
*/
function getArticleTop(){
	global $dc;
	$news = $dc->get('article_index_top');
	if(empty($news)){
		$article = new tcdb('article_21');
		$month_ago = time() - (3600*24*30);
		//测试使用
		//$news = $article->field('itemid,title,introduce,linkurl,thumb')->where(['thumb'=>''],'<>')->where(['status'=>3])->order('hits desc')->limit(0,18)->select();
		//真实使用
		$news = $article->field('itemid,title,introduce,linkurl,thumb')->where(['thumb'=>''],'<>')->where(['status'=>3,'level'=>1])->where(['addtime'=>$month_ago],'>')->order('itemid desc')->limit(0,10)->select();
		$dc->set('article_index_top',$news,(3600*24));	//缓存有效时间为一天
	}
	return $news;
}

function getNewArticle($catid , $pagesize = 10){
	global $dc;
	$news = $dc->get('article_index_floor_cat'.$catid);
	if(empty($news)){
		$article = new tcdb('article_21');
		$news = $article->field('itemid,title,introduce,linkurl,thumb,addtime')->where(['thumb'=>''],'<>')->where(['status'=>3,'catid'=>$catid])->order('itemid desc')->limit(0,$pagesize)->select();
		$dc->set('article_index_floor_cat'.$catid,$news,(3600*24));
	}
	return $news;
}

//获取热点资讯
function getTopHitsArticle($catid = '',$days = 7){
	global $dc;
	$news = $dc->get('article_hit_cat'.$catid.'_day_'.$days);
	if(empty($news)){
		$time_age = intval($days) * (3600*24);
		$time_limit = time()- $time_age;
		$article = new tcdb('article_21');
		$condition['status'] = 3;
		if(!empty($catid)) $condition['catid'] = $catid;
		//测试用数据
		//$news = $article->field('itemid,title,linkurl')->where($condition)->order('hits desc')->limit(0,8)->select();
		//实际用数据
		$news = $article->field('itemid,title,linkurl')->where($condition)->order('hits desc')->where(['addtime'=>$time_limit],'>')->limit(0,8)->select();
		$dc->set('article_hit_cat'.$catid.'_day_'.$days,$news,(3600*24));
	}
	return $news;
}

//获取推荐信息
function getRecommendArticles(){
	global $dc;
	$news = $dc->get('article_recommend');
	if(empty($news)){
		$article = new tcdb('article_21');
		$news = $article->field('itemid,title,thumb,linkurl')->where(['status'=>3,'level'=>1])->where(['thumb'=>''],'<>')->order('itemid desc')->limit(0,5)->select();
		$dc->set('article_recommend',$news,(3600*24));
	}
	return $news;
}

?>