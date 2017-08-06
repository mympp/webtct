<?php
namespace models\helpers\adt;

//笛卡尔乘积
class cartesianProduct{
	
	/**
	* 根据多维数组内容，搭建笛卡尔乘积数组
	* @param 多维数组 $arr
	* @return array
	*/
	function build($arr){
		if(empty($arr)) return $arr;
		
		if(count($arr) == 1){	//当前数组只有一个元素时，将数组值拆分为数组返回
			$back = [];
			foreach($arr as $k=>$v){
				
				foreach($v as $kk => $vv){
					$back[] = array($vv);
				}
			}
			return $back;
		}else{
			//当数组元素个数超过1时
			$key = array_keys($arr);
			$key_first = $key[0];
			$arr_first = $arr[$key_first];	//提取第一个元素
			unset($arr[$key_first]);		//移去第一个元素
			$cartesian = $this->build($arr);		//获取剩余数组的笛卡尔乘积组合

			if(empty($cartesian)) return $arr_first;
			if(empty($arr_first)) return $cartesian;

			$back = [];	//返回数组
			foreach($arr_first as $k => $v){
				foreach($cartesian as $ck => $cv){
					$c = $cv;
					array_unshift($c,$v);
					$back[] = $c;
				}
			}
			return $back;
		}
	}
}
?>