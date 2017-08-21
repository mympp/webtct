<?php

namespace models\helpers\widget;

class simFile {
	
	//获取目录下的一级目录
	public function getSubDir($dirname){
		$files = scandir($dirname);
		$result = [];
		foreach($files as $k => $v){
			if(is_dir($dirname.'\\'.$v) && $v != '.' && $v != '..'){
				array_push($result,$v);
			}
		}
		return $result;
	}
}

?>