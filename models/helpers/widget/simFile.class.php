<?php

namespace models\helpers\widget;

class simFile {
	
	//获取目录下的一级子目录
	public function getSubDir($dirname){
		
		$files = scandir($dirname);
		$result = [];
		foreach($files as $k => $v){
			if(is_dir($dirname.'/'.$v) && $v != '.' && $v != '..'){
				array_push($result,$v);
			}
		}
		return $result;
	}
	
	//创建文件夹
	public function createDir($path,$name){
		if(is_dir($path.'/'.$name)){
			return false;
		}else{
			return @mkdir($path.'/'.$name);
		}
	}
}

?>