<?php
namespace models\helpers\view;

use models\helpers\data\category;
use models\helpers\data\area;
use models\module\baseModule;

//内部链接推荐
class internalLink{
	
	private $module;
	private $extend;
	
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
	
	//根据分类id和地区id进行推荐板块书写
	public function build($catid = 0,$areaid = 0,$extend = null){
		if(empty($this->module)) return false;

		$this->extend = $extend;
		$dataLimitNum = 5;	//每组最多去5个内容 
		shuffle($this->module);		//打乱显示顺序
		$category = new category();
		$area = new area();
		
		$templateData = [];
		$templateData['modulename'] = [];
		$templateData['data'] = [];
		
		foreach($this->module as $v){
			$data = [];
			$m = str_replace('1','',$v);
			$module = baseModule::moduleInstance($m);
			if(isset($extend[$v]['name'])){
				array_push($templateData['modulename'],$extend[$v]['name']);
			}else{
				array_push($templateData['modulename'],$module->modulename);
			}
			
			
			if(empty($module)) continue;	
			
			$cateData = [];
			$check = $category->checkCatidInModule($catid,$module->moduleid);
			if(empty($catid) || !$check){		//不提供分类id，或分类id与当前模块不一致时获取该模块下的主分类
				$cateData = $category->getMainCate($module->moduleid);
			}else{
				$cateData = $category->getChildCate($catid);		//优先取子分类
				if(empty($cateData))	$cateData = $category->getBroCate($catid);		//取兄弟分类
			}
			shuffle($cateData);

			$areaData = [];
			if(empty($areaid)){
				$areaData = $area->getMainArea();
			}else{
				$areaData = $area->getChildArea($areaid);
				if(empty($areaData)) $areaData = $area->getBroArea($areaid);
			}
			shuffle($areaData);
			
			$i = 0;
			$j = 0;
			foreach($cateData as $c){
				$j = 0;
				foreach($areaData as $a){
					$url = isset($extend[$v]['url']) ? $extend[$v]['url'] : [];
					$url['catid'] = $c['catid'];
					$url['areaid'] = $a['areaid'];
					array_push($data,$url);
					if(($dataLimitNum - 2) < $j++) break;
				}
				if(($dataLimitNum - 2) < $i++) break;
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
			$m = str_replace('1','',$this->module[$k]);
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