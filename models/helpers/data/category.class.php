<?php
namespace models\helpers\data;

use models\helpers\data\tcdb;

//处理分类信息
class category{
	
	//获取模块下主分类
	public function getMainCate($moduleid){
		global $dc,$CFG;
		$cache_key = "helper_category_main_".$moduleid;
		$data = $dc->get($cache_key);		//提取缓存
		
		if(empty($data)){
			$category = new tcdb('category');
			$data = $category->where(['moduleid'=>$moduleid,'parentid'=>0])->all();
		}
		if(empty($data)){
			return false;
		}else{
			$dc->set($cache_key,$data,(3600*12));	//缓存数据
			return $data;
		}
	}
	
	//获取子分类
	public function getChildCate($catid){
		global $dc;
		$cache_key = "helper_category_child_".$catid;
		$data = $dc->get($cache_key);		//提取缓存
		if(empty($data)){
			$category = new tcdb('category');
			$data = $category->where(['parentid'=>$catid])->all();
		}
		if(empty($data)){
			return false;
		}else{
			$dc->set($cache_key,$data,(3600*12));	//缓存数据
			return $data;
		}
	}
	
	//获取分类信息
	public function getCate($catid){
		global $dc;
		$cache_key = "helper_category_".$catid;
		$data = $dc->get($cache_key);		//提取缓存
		if(empty($data)){
			$category = new tcdb('category');
			$data = $category->where(['catid'=>$catid])->one();
		}
		if(empty($data)){
			return false;
		}else{
			$dc->set($cache_key,$data,(3600*12));	//缓存数据
			return $data;
		}
	}
	
	//获取兄弟分类
	public function getBroCate($catid){
		$cate = $this->getCate($catid);
		if(!empty($cate['parentid'])){
			return $this->getChildCate($cate['parentid']);
		}elseif($cate['parentid'] == 0){
			return $this->getMainCate($cate['moduleid']);
		}else{
			return false;
		}
	}
	
	//检查catid是否在该module下
	public function checkCatidInModule($catid,$moduleid){
		$category = new tcdb('category');
		$data = $category->where(['catid'=>$catid,'moduleid'=>$moduleid])->one();
		if(empty($data)){
			return false;
		}else{
			return true;
		}
	}
	
}
?>