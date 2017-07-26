<?php
namespace models\helpers\data;

use models\helpers\data\tcdb;

class area{
	
	//获取地区信息
	public function getArea($areaid){
		global $dc;
		$cache_key = "helper_area_".$areaid;
		$data = $dc->get($cache_key);		//提取缓存
		if(empty($data)){
			$area = new tcdb('area');
			$data = $area->where(['areaid'=>$areaid])->one();
		}
		if(empty($data)){
			return false;
		}else{
			$dc->set($cache_key,$data,(3600*24));	//缓存数据
			return $data;
		}
	}
	
	//获取子地区信息
	public function getChildArea($areaid){
		global $dc;
		$cache_key = "helper_area_child_".$areaid;
		$data = $dc->get($cache_key);		//提取缓存
		if(empty($data)){
			$area = new tcdb('area');
			$data = $area->where(['parentid'=>$areaid])->all();
		}
		if(empty($data)){
			return false;
		}else{
			$dc->set($cache_key,$data,(3600*24));	//缓存数据
			return $data;
		}
	}
	
	//获取所有省份
	public function getMainArea(){
		global $dc;
		$cache_key = "helper_area_main";
		$data = $dc->get($cache_key);		//提取缓存
		if(empty($data)){
			$area = new tcdb('area');
			$data = $area->where(['parentid'=>0])->all();
		}
		if(empty($data)){
			return false;
		}else{
			$dc->set($cache_key,$data,(3600*24));	//缓存数据
			return $data;
		}
	}
	
	//获取兄弟地区
	public function getBroArea($areaid){
		$area = $this->getArea($areaid);
		if($area['parentid'] == 0){
			return $this->getMainArea();
		}elseif(isset($area['parentid'])){
			return $this->getChildArea($area['parentid']);
		}else{
			return false;
		}
	}
	
	//获取所有地区信息的json格式数据
	public function getJsonArea(){
		global $dc;
		$cache_key = "helper_area_json";
		//$data = $dc->get($cache_key);		//提取缓存
		if(empty($data)){
			$mainArea = $this->getMainArea();
			$data = [];
			foreach($mainArea as $k => $v){
				$r['name'] = $v['areaname'];
				$r['code'] = $v['areaid'];
				$r['sub'] = [];
				$childArea = $this->getChildArea($v['areaid']);
				if($childArea){
					$sub = [];
					foreach($childArea as $ck => $cv){
						$sub['name'] = $cv['areaname'];
						$sub['code'] = $cv['areaid'];
						array_push($r['sub'],$sub);
					}
				}else{
					$sub['name'] = $v['areaname'];
					$sub['code'] = $v['areaid'];
					$sub['sub'] = [];
					array_push($r['sub'],$sub);
				}
				array_push($data,$r);
			}
			$dc->set($cache_key,$data,(3600*24*10));
		}
		return json_encode($data,JSON_UNESCAPED_UNICODE);
	}
}

?>