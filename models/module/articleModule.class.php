<?php
namespace models\module;

use models\module\baseModule;
use models\helpers\data\tcdb;

//资讯模块模型类，封装业务逻辑操作
class articleModule extends baseModule{
	
	function __construct(){
		global $MODULE;
		$this->moduleid = 21;
		$this->modulename = $MODULE[$this->moduleid]['name'];
		$this->linkurl = $MODULE[$this->moduleid]['linkurl'];
	}
	
	//资讯模块伪静态地址重写
	public function searchRewrite($selector){
		if(isset($selector['kw'])){
			return 'search.php?'.http_build_query($selector);
		}else{
			global $dc;
			$article_cat = $dc->get('article_all_cat');
			if(empty($article_cat)){
				$category = new tcdb('category');
				$cat = $category->field('catid,catname,catdir,parentid')->where(['moduleid'=>$this->moduleid])->all();
				foreach($cat as $k=>$v){
					$article_cat[$v['catid']] = $v;
				}
				$dc->set('article_all_cat',$article_cat,(3600*24*7));
			}	
			$catdir = $article_cat[$selector['catid']]['catdir'];
			$page = isset($selector['page']) ? $selector['page'].'.html' : '';
			return $catdir.'/'.$page;
		}
	}
}


?>