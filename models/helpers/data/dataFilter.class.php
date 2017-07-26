<?php

namespace models\helpers\data;

//数据过滤操作类
class dataFilter {
	
	/**
	* 过滤数组中空值的数据
	* @param array $data	待过滤数据数组
	* @param array $field	需要进行过滤的键值字段
	* @return array or bool
	*/
	public function filterEmptyData($data,$field = null){
		if(!is_array($data)) return false;
		$result = [];
		if(is_array($field)){
			foreach($field as $k =>$v){
				if(isset($data[$v]) && !empty($data[$v])){
					$result[$v] = $data[$v];
				}
			}
		}else{
			foreach($data as $k=>$v){
				if(!empty($v)) $result[$k] = $v;
			}
		}
		return $result;
	}
	
	/**
	* 验证数据是否为空值，非空值时可指定返回内容
	* @param  $data 需要过滤数据
	* @param  $value 可返回的指定数值
	* @return array
	*/
	public function checkEmpty($data,$value = null){
		if(empty($data)){
			return null;
		}else{
			if(empty($value)){
				return $data;
			}else{
				return $value;
			}
		}
		
	}

}
?>