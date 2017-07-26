<?php
namespace models\module;

class baseModule implements moduleInterface{
		
	public $moduleid;
	public $modulename;
	public $linkurl;
	
	public function searchRewrite($selector){}
	
	//创建子类对象
	final static public function moduleInstance($module_name){
		$file_path = __DIR__.'/'.$module_name.'Module.class.php';	//子类文件名
		if(is_file($file_path)){
			require_once $file_path;
			$object_name = 'models\module\\'.$module_name.'Module';
			return new $object_name();	//动态创建对象
		}else{
			throw new Exception ('could not found object '.$module_name.'Module');
			return null;
		}
	}
}

interface moduleInterface{
	public function searchRewrite($selector);	//地址重写接口
}
?>