<?php
namespace models\helpers\view;

use models\helpers\data\category;
use models\helpers\data\area;
use models\module\baseModule;
use models\helpers\adt\cartesianProduct;

//内部链接推荐
class internalLink{
	
	private $module;
	private $extend;
	private $catid_key = true;
	private $area_key = true;
	
	/**
	* 设置要推荐的模块
	* @param array $module，栗子 ['mall','buy','sell']
	* @return bool
	*/
	public function setModule($module){
		
		if(is_array($module)){
			$this->module = $module;
			return true;
		}else{
			return false;
		}
	}
	
	//获取推荐分类
	private function getLinkCategory($catid,$moduleid,$num = false){
		$cateData = [];
		
		if($num !== false && $num == 0) return [];
		
		$category = new category();
		$check = $category->checkCatidInModule($catid,$moduleid);
		if(empty($catid) || !$check){		//不提供分类id，或分类id与当前模块不一致时获取该模块下的主分类
			$cateData = $category->getMainCate($moduleid);
		}else{
			$cateData = $category->getChildCate($catid);	//优先取子分类
			if(empty($cateData)){	$cateData = $category->getBroCate($catid);}		//取兄弟分类
		}
		
		$result = [];
		foreach($cateData as $v){
			array_push($result,['catid'=>$v['catid']]);
		}
		
		shuffle($result);
		if($num !== false && is_numeric($num)){
			return array_slice($result,0,$num);
		}else{
			return $result;
		}
	}
	
	//获取推荐地区
	private function getLinkArea($areaid,$num = false){
		if($num !== false && $num == 0) return [];
		
		$area = new area();
		if(empty($areaid)){
			$areaData = $area->getMainArea();
		}else{
			$areaData = $area->getChildArea($areaid);
			if(empty($areaData)) $areaData = $area->getBroArea($areaid);
		}
		
		$result = [];
		foreach($areaData as $v){
			array_push($result,['areaid'=>$v['areaid']]);
		}
		
		shuffle($result);
		if($num !== false && is_numeric($num)){
			return array_slice($result,0,$num);
		}else{
			return $result;
		}
	}

	
	//根据分类id和地区id进行推荐板块书写
	public function build($catid = 0,$areaid = 0,$extend = null){
		if(empty($this->module)) return false;

		$this->extend = $extend;
		$dataLimitNum = 5;	//每组取5个内容 
		shuffle($this->module);		//打乱显示顺序
		
		$templateData = [];
		$templateData['modulename'] = [];
		$templateData['data'] = [];
		
		$cartesian = new cartesianProduct();
		
		foreach($this->module as $v){
			if(isset($extend[$v]['closeArea']) && isset($extend[$v]['closeCate'])) continue;
			
			$data = [];
			$m = str_replace(array(1,2,3),'',$v);
			$module = baseModule::moduleInstance($m);
			if(isset($extend[$v]['titleName'])){
				array_push($templateData['modulename'],$extend[$v]['titleName']);
			}else{
				array_push($templateData['modulename'],$module->modulename);
			}
			
			if(empty($module)) continue;	
			
			$cat_num = isset($extend[$v]['closeArea']) ? 
						($dataLimitNum*$dataLimitNum) : ( isset($extend[$v]['closeCate']) ? 0 : $dataLimitNum);
			$area_num = isset($extend[$v]['closeCate']) ? 
						($dataLimitNum*$dataLimitNum) : (isset($extend[$v]['closeArea']) ? 0 : $dataLimitNum);
			
			$cateData = $this->getLinkCategory($catid,$module->moduleid,$cat_num);
			$areaData = $this->getLinkArea($areaid,$area_num);
			
			$build = [];
			if(!empty($cateData)) array_push($build,$cateData);
			if(!empty($areaData)) array_push($build,$areaData);
			$cartesianArr = $cartesian->build($build);

			foreach($cartesianArr as $v1){
				$url = isset($extend[$v]['url']) ? $extend[$v]['url'] : [];
				foreach($v1 as $v2){
					foreach($v2 as $k3=>$v3){
						$url[$k3] = $v3;
					}
				}
				array_push($data,$url);
			}
			array_push($templateData['data'],$data);
		}

		return $this->template($templateData);
	}
	
	//显示模板
	private function template($data){
		$back = '<div class="channel-class-wrap"><div class="channel-class box-center">';
		$back .= '<ul class="channel-class-hd">';
		
		foreach($data['modulename'] as $k => $v){
			$current = $k == 0 ? 'class="current"' : '';
			$back .= "<li $current>$v</li>";
		}
		$back .= '</ul>';
		$back .= '<div class="channel-class-bd">';
		
		foreach($data['data'] as $k => $v){
			$display = $k == 0 ? '' : 'style="display:none;"';
			$back .= "<div $display>";
			$m = str_replace(array(1,2,3),'',$this->module[$k]);
			$module = baseModule::moduleInstance($m);
			foreach($v as $num => $s){
				if($num > 20) break;
				$url = $module->linkurl.$module->searchRewrite($s);
				$area = new area();
				$category = new category();
				$areaname = $area->getArea($s['areaid']);
				$catename = $category->getCate($s['catid']);
				$mname = isset($this->extend[$this->module[$k]]['name']) ? $this->extend[$this->module[$k]]['name'] : $module->modulename;
				$title = $areaname['areaname'].$catename['catname'].$mname;
				$back .= "<a class=\"channel-class-item text-overflow\" href=\"$url\" target=\"_blank\" title=\"$title\">$title</a>";
			}
			$back .= '</div>';
		}
		
		$back .= '</div>';
		$back .= '</div>';
		$back .= '</div>';
		return $back;
	}
	
}
?>